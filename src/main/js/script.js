$(document).ready(function(){ 

    loadForm('agreements');

    
	
});

function loadForm(section){

    $.ajax({
        url:'forms/'+sections[section].form_file,
        type:'POST',
        contentType:false,
        processData:false,
        cache:false
    }).done(function(response){
        //document.getElementById('principal-imputed-panel').style.display = 'none';
        $(".title").html(sections[section].title);
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

function validateSection(section){

    let fields = sections[section].fields;
    let data = {};
    let compleated = true;


    for(field in fields){
        if(document.getElementById(fields[field].id)){

            if(fields[field].required && document.getElementById(fields[field].id) == ''){
                compleated = false;
            }

            data = {
                ...data,
                [fields[field].name]: document.getElementById(fields[field].id).value
            }
        }
    }

    if(compleated){
        //saveSection(section);
        console.log('guardando: ', data);
    }
    else{
        alert('No has completado la sección');
    }
}

function saveSection(section, data){
    $.ajax({
		url: 'service/'+sections[section].create_file,
		type: 'POST',
		data: {
			...data
		},
		cache: false
	}).done(function(response){

	});
}

function resetSection(section){
    let fields = sections[section].fields;

    for(field in fields){
        if(document.getElementById(fields[field].id)){

            document.getElementById(fields[field].id).value = "";
        }
    }
}