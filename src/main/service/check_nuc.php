<?php
session_start();
include('../../../service/connection.php');
$conn = $connections['sigi']['conn'];
$db = $connections['sigi']['db'];

$nuc = $_POST['nuc'];

if($conn){
    $sql = "SELECT 
                    dbo.caso.cNumeroGeneralCaso AS 'nuc',
                    NE.cNumeroExpediente  AS 'expediente',
                    Expediente.dFechaCreacion AS 'fecha',
                    uie.cNombreUIE as 'unidad',
                    CONCAT(FN.cNombreFuncionario,' ',FN.cApellidoPaternoFuncionario,' ',FN.cApellidoMaternoFuncionario) AS 'funcionario',
                    
                    Valor.cValor as 'Estatus',
                
                    CASE   
                    WHEN   dbo.CatDiscriminante.catDistrito_id=1 THEN 'Apatzingán'   
                    WHEN   dbo.CatDiscriminante.catDistrito_id=2 THEN 'Lázaro Cárdenas'   
                    WHEN   dbo.CatDiscriminante.catDistrito_id=3 THEN 'Morelia'   
                    WHEN   dbo.CatDiscriminante.catDistrito_id=4 THEN 'Uruapan'  
                    WHEN   dbo.CatDiscriminante.catDistrito_id=5 THEN 'Zamora'   
                    WHEN   dbo.CatDiscriminante.catDistrito_id=6 THEN 'Zitácuaro'   
                    WHEN   dbo.CatDiscriminante.catDistrito_id=7 THEN 'La Piedad'    
                    END	as 'fiscalia'					
                FROM  
                dbo.caso 
                left join dbo.Expediente ON Expediente.Caso_id = dbo.Caso.Caso_id	
                left join NumeroExpediente NE on NE.Expediente_id= Expediente.Expediente_id              
                left join dbo.Hecho on dbo.Expediente.Expediente_id = DBO.Hecho.Expediente_id				
                inner join dbo.CatDiscriminante on Expediente.catDiscriminante_id = dbo.CatDiscriminante.CatDiscriminante_id
                inner join dbo.Valor on NE.Estatus_val = dbo.Valor.Valor_id
                INNER JOIN (SELECT expediente_id, max(actividad_id) as actividad_id from Actividad group by expediente_id) A ON dbo.Expediente.Expediente_id = A.Expediente_id
                INNER JOIN DBO.ACTIVIDAD A2 ON A2.actividad_id = A.actividad_id
                INNER JOIN dbo.Valor v2 ON A2.TipoActividad_val =v2.valor_id			
                left join dbo.CATUIEspecializada on Expediente.CatUIE_id=dbo.CATUIEspecializada.CatUIE_id
                INNER join Funcionario FN on NE.iClaveFuncionario = FN.iClaveFuncionario
                inner join dbo.CatDiscriminante cd on FN.catDiscriminante_id = cd.CatDiscriminante_id
                left join dbo.CATUIEspecializada uie on FN.CATUIE_id =uie.CatUIE_id			
                where 
                NE.NumeroExpediente_id in
                (select min(NumeroExpediente_id) 
                from NumeroExpediente where dbo.NumeroExpediente.JerarquiaOrganizacional_id in(10,44) group by Expediente_id)			
                and dbo.caso.cNumeroGeneralCaso='$nuc'";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $result = sqlsrv_query( $conn, $sql , $params, $options );

    $row_count = sqlsrv_num_rows( $result );

    $json = '';
    $return = array();

    if($row_count != 0){
        while( $row = sqlsrv_fetch_array( $result) ) {
            $json = json_encode($row);
        }
        
        $json = json_decode($json, true);
            
        $return = array(
            'state' => 'success',
            'data' => array(
                'id' => null,
                'nuc' => $json['nuc']
            )
        );
        
    }
    else{
        $return = array(
            'state' => 'not_found',
            'data' => null
        );
    }

    echo json_encode($return, JSON_FORCE_OBJECT);

    sqlsrv_close($conn);
}
else{
    $return = array(
        'state' => 'fail',
        'data' => null
    );

    echo json_encode($return, JSON_FORCE_OBJECT);
}

?>