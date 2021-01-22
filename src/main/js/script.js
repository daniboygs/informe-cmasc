$(document).ready(function(){ 

    loadForm('agreements');

    function loadForm(section){

        $.ajax({
            url:'forms/'+sections[section].form_file,
            type:'POST',
            contentType:false,
            processData:false,
            cache:false
        }).done(function(response){
            //document.getElementById('principal-imputed-panel').style.display = 'none';
            $("#content").html( response );
            /*getAllCatalogsDataByImputedSection(section);
            setTimeout(
                function(){
                    loadImputedDataBySection(section);
                    loadUnlockConditionsByImputedSection(section);
                }, 1000
            );*/
    
        });
    
    }
	
});