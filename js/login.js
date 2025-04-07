$(document).ready(function(){ 

    /*checkSession({
        success: {
            function: redirectTo,
            attr: {
                admin: 'src/main/main.php',
            }
        },
        failed: {
            function: null,
            attr: null
        },
        location: 'service/check_session.php'
    });*/
    
    jQuery('#login-form').submit(login);
    
    function login(){

        $.ajax({  
            type: "POST",  
            url: "service/login.php", 
            dataType : 'json', 
            data: {
                auth: JSON.stringify({
                    username: $("#user").val(),
                    password: $("#pass").val()
                })
            },
        }).done(function(response){

            if(response.state != "fail"){

                if(response.data){
                    setSessionVariables('user', response.data);
                    //showLoading(true);

                    switch(response.data.type){
                        case 1:
                            redirectTo('src/admin/admin.php');
                            break;
                        case 2:
                            redirectTo('src/main/main.php');
                            break;
                        case 4:
                            redirectTo('src/admin/admin.php');
                            break;
                        case 5:
                            redirectTo('src/admin/admin.php');
                            break;
                        case 7:
                            redirectTo('src/admin/admin.php');
                            break;
                        default:
                            redirectTo('src/main/main.php');
                            break;
                    }
                    
                    
                    console.log('data: ', data);

                    Swal.fire('Bienvenido', '', 'success');
                }
                else{
                    /*blurt({
                        'title' : 'Usuario incorrecto', 
                        'text' : 'Usuario o contraseña incorrecto', 
                        'type' : 'error'
                    });*/
                    //alert("Usuario incorrecto");
                    Swal.fire('Usuario incorrecto', 'Intentelo de nuevo!', 'warning')
                }
            }
            else{
                /*blurt({
                    'title' : 'Falla de conexión', 
                    'text' : 'Ha fallado la conexión, porfavor intente de nuevo en unos momentos', 
                    'type' : 'error'
                });*/
                Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                //alert("Ha fallado la conexión, porfavor intente de nuevo en unos momentos");
            }
			
		});  
        
        return false;
    }
	
});