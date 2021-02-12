<?php

session_start(); 
    $permissions = array(
        '1' => array(
            'framebar' => array(
                'agreements' => array(
                    'id' => 'agreements-nav-div',
                    'name' => 'agreements',
                    'class' => 'active',
                    'label' => 'ACUERDOS CELEBRADOS'
                ),
                'recieved_folders' => array(
                    'id' => 'recieved-folders-nav-div',
                    'name' => 'recieved_folders',
                    'class' => '',
                    'label' => 'CARPETAS RECIBIDAS'
                ),
                'folders_to_investigation' => array(
                    'id' => 'folders-to-investigation-nav-div',
                    'name' => 'folders_to_investigation',
                    'class' => '',
                    'label' => 'CARPETAS ENVIADAS A INVESTIGACIÓN'
                ),
                'people_served' => array(
                    'id' => 'people-served-nav-div',
                    'name' => 'people_served',
                    'class' => '',
                    'label' => 'PERSONAS ATENDIDAS'
                ),
                'processing_folders' => array(
                    'id' => 'processing-folders-nav-div',
                    'name' => 'processing_folders',
                    'class' => '',
                    'label' => 'CARPETAS DE TRÁMITE'
                ),
                'folders_to_validation' => array(
                    'id' => 'folders-to-validation-nav-div',
                    'name' => 'folders_to_validation',
                    'class' => '',
                    'label' => 'CARPETAS ENVIADAS A VALIDACIÓN'
                ),
                'entered_folders' => array(
                    'id' => 'entered-folders-nav-div',
                    'name' => 'entered_folders',
                    'class' => '',
                    'label' => 'CARPETAS INGRESADAS'
                ),
                'entered_folders_capture' => array(
                    'id' => 'entered-folders-capture-nav-div',
                    'name' => 'entered_folders_capture',
                    'class' => '',
                    'label' => 'CARPETAS INGRESADAS (CAPTURA)'
                )
            )
        ),
        '2' => array(
            'framebar' => array(
                'agreements' => array(
                    'id' => 'agreements-nav-div',
                    'name' => 'agreements',
                    'class' => 'active',
                    'label' => 'ACUERDOS CELEBRADOS'
                ),
                'recieved_folders' => array(
                    'id' => 'recieved-folders-nav-div',
                    'name' => 'recieved_folders',
                    'class' => '',
                    'label' => 'CARPETAS RECIBIDAS'
                ),
                'folders_to_investigation' => array(
                    'id' => 'folders-to-investigation-nav-div',
                    'name' => 'folders_to_investigation',
                    'class' => '',
                    'label' => 'CARPETAS ENVIADAS A INVESTIGACIÓN'
                ),
                'people_served' => array(
                    'id' => 'people-served-nav-div',
                    'name' => 'people_served',
                    'class' => '',
                    'label' => 'PERSONAS ATENDIDAS'
                ),
                'processing_folders' => array(
                    'id' => 'processing-folders-nav-div',
                    'name' => 'processing_folders',
                    'class' => '',
                    'label' => 'CARPETAS DE TRÁMITE'
                ),
                'folders_to_validation' => array(
                    'id' => 'folders-to-validation-nav-div',
                    'name' => 'folders_to_validation',
                    'class' => '',
                    'label' => 'CARPETAS ENVIADAS A VALIDACIÓN'
                ),
                'entered_folders_super' => array(
                    'id' => 'entered-folders-nav-div',
                    'name' => 'entered_folders_super',
                    'class' => '',
                    'label' => 'CARPETAS INGRESADAS'
                )
            )
        ),
        '3' => array(
            'framebar' => array(
                'agreements' => array(
                    'id' => 'agreements-nav-div',
                    'name' => 'agreements',
                    'class' => 'active',
                    'label' => 'ACUERDOS CELEBRADOS'
                ),
                'recieved_folders' => array(
                    'id' => 'recieved-folders-nav-div',
                    'name' => 'recieved_folders',
                    'class' => '',
                    'label' => 'CARPETAS RECIBIDAS'
                ),
                'folders_to_investigation' => array(
                    'id' => 'folders-to-investigation-nav-div',
                    'name' => 'folders_to_investigation',
                    'class' => '',
                    'label' => 'CARPETAS ENVIADAS A INVESTIGACIÓN'
                ),
                'people_served' => array(
                    'id' => 'people-served-nav-div',
                    'name' => 'people_served',
                    'class' => '',
                    'label' => 'PERSONAS ATENDIDAS'
                ),
                'processing_folders' => array(
                    'id' => 'processing-folders-nav-div',
                    'name' => 'processing_folders',
                    'class' => '',
                    'label' => 'CARPETAS DE TRÁMITE'
                ),
                'folders_to_validation' => array(
                    'id' => 'folders-to-validation-nav-div',
                    'name' => 'folders_to_validation',
                    'class' => '',
                    'label' => 'CARPETAS ENVIADAS A VALIDACIÓN'
                ),
                'entered_folders' => array(
                    'id' => 'entered-folders-nav-div',
                    'name' => 'entered_folders',
                    'class' => '',
                    'label' => 'CARPETAS INGRESADAS'
                )
            )
        ),
        '404' => array(
            'framebar' => array(
                '404' => array(
                    'id' => '404',
                    'name' => '404',
                    'class' => 'active',
                    'label' => 'Usuario sin permisos'
                )
            )
        )
    );
	
	if(isset($_SESSION['user_data']) && isset($permissions[$_SESSION['user_data']['type']])){
		echo json_encode(
			array(
				'state' => 'success',
				'data' => false,
				'type' => $_SESSION['user_data']['type'],
                'permissions' => $permissions[$_SESSION['user_data']['type']]
			),
			JSON_FORCE_OBJECT
		);
	}
	else{
		echo json_encode(
			array(
				'state' => 'failed',
				'data' => false,
				'type' => false
			),
			JSON_FORCE_OBJECT
		);
	}
?>