$(document).ready(function(){ 

    checkSession({
        success: {
            function: redirectTo,
            attr: 'src/main/main.html'
        },
        failed: {
            function: null,
            attr: null
        },
        location: 'service/check_session.php'
    });
    
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
                    redirectTo('src/main/main.html');
                    console.log('data: ', data);
                }
                else{
                    /*blurt({
                        'title' : 'Usuario incorrecto', 
                        'text' : 'Usuario o contraseña incorrecto', 
                        'type' : 'error'
                    });*/
                    alert("Usuario incorrecto");
                }
            }
            else{
                /*blurt({
                    'title' : 'Falla de conexión', 
                    'text' : 'Ha fallado la conexión, porfavor intente de nuevo en unos momentos', 
                    'type' : 'error'
                });*/
                alert("Ha fallado la conexión, porfavor intente de nuevo en unos momentos");
            }
			
		});  
        
        return false;
    }
	
});