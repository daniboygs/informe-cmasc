$(document).ready(function(){ 
    console.log(sections);

    checkSession({
        success: {
            function: checkPermissions,
            attr: {
                success: {
                    function: loadSection,
                    attr: 'agreements'
                },
                failed: {
                    function: redirectTo,
                    attr: '../../index.html'
                },
                location: '../../service/check_permissions.php'
            }
        },
        failed: {
            function: redirectTo,
            attr: '../../index.html'
        },
        location: '../../service/check_session.php'
    });

    

    getRecordsByMonth('agreements');

    //loadSection('agreements');

    
	
});

var test = "";

function loadSection(section){
    console.log(section);
    if(!sections[section].active){
        loadForm(section);
    }
}

function loadForm(section){
    console.log('load?');
    $.ajax({
        url:'forms/'+sections[section].form_file,
        type:'POST',
        contentType:false,
        processData:false,
        cache:false
    }).done(function(response){

        console.log('lo hiciste?', sections[section].form_file);
        $(".title").html(sections[section].title);
        $("#content").html(response);
        activeSection(section);
        loadDefaultValuesBySection(section);
        getRecordsByMonth(section);
        loadCatalogsBySection({
            section: section,
            template_file: 'templates/elements/select.php',
            service_location: 'service/catalogs/'
        });

    });
}

function loadCatalogsBySection(attr){

    for(field in sections[attr.section].fields){

        if(sections[attr.section].fields[field].catalog != null){

            if(sections[attr.section].fields[field].catalog.data != null){
                loadSelect({
                    template_file: attr.template_file,
                    element_attr: {
                        element_id: sections[attr.section].fields[field].id,
                        element_placeholder: sections[attr.section].fields[field].placeholder,
                        element_event_listener: sections[attr.section].fields[field].event_listener,
                        elements: sections[attr.section].fields[field].catalog.data
                    }
                });
            }
            else{
                getCatalog({
                    service_file: attr.service_location+sections[attr.section].fields[field].catalog.service_file,
                    template_file: attr.template_file,
                    element_attr: {
                        element_id: sections[attr.section].fields[field].id,
                        element_placeholder: sections[attr.section].fields[field].placeholder,
                        element_event_listener: sections[attr.section].fields[field].event_listener
                    },
                    section: attr.section,
                    field: field
                });
            }
        }
    }
}

function loadFramebar(attr){
    console.log('load? frame', attr.data);
    $.ajax({
        url:'templates/elements/framebar.php',
        type: 'POST',
		dataType: "html",
		data: {
			data: attr.data
		},
		cache: false
    }).done(function(response){

        console.log('lo hiciste? frame', attr);
        $('#framebar').html(response);

    });
}

function checkPermissions(attr){
    $.ajax({
		url: attr.location,
        type: 'POST',
        dataType : 'json',
		cache: false
	}).done(function(response){

        if(response.state == 'success'){
            if(attr.success.function != null)
                attr.success.function(attr.success.attr);

            loadFramebar({
                data: response.permissions.framebar
            });
            
        }
        else{
            if(attr.failed.function != null)
                attr.failed.function(attr.failed.attr);
        }

	});
}

function activeSection(section){

    for(element in sections){
        console.log(sections[element]);
        sections[element].active = false;
        $('#'+sections[element].navigation_element_id).removeClass('active');
    }

    sections[section].active = true;
    $('#'+sections[section].navigation_element_id).addClass('active');

}

function loadDefaultValuesBySection(section){
    let fields = sections[section].fields;

    for(field in fields){
        if(document.getElementById(fields[field].id)){

            if(fields[field].default != null){

                switch(fields[field].type){
                    case "date":
                        if(fields[field].default == "today"){
                            let today = new Date();
                            today.setHours(today.getHours()+6); 
                            console.log('tod', today);
                            document.getElementById(fields[field].id).valueAsDate = today;
                        }
                        break;
                    default:
                        document.getElementById(fields[field].id).value = fields[field].default;
                }
            }
        }
    }
}

function validateSection(section){

    let fields = sections[section].fields;
    let data = {};
    let compleated = true;


    for(field in fields){
        if(document.getElementById(fields[field].id)){

            if(fields[field].required && document.getElementById(fields[field].id).value == ''){
                compleated = false;
            }

            data = {
                ...data,
                [fields[field].name]: document.getElementById(fields[field].id).value
            }
        }
    }

    if(compleated){
        spetialValidationBySection({
            section: section,
            data: data
        });
        //saveSection(section, data);
        console.log('guardando: ', data);
    }
    else{
        //alert('No has completado la sección');
        Swal.fire('Campos faltantes', 'Tiene que completar los campos faltantes', 'warning');
    }
}

function spetialValidationBySection(attr){
    switch(attr.section){
        case 'agreements':
            console.log('agg');
            checkActivePeriod({
                element_id: 'agreement-date',
                function: checkNuc,
                attr: {
                    element_id: 'agreement-nuc',
                    function: saveSection,
                    attr: {
                        section: attr.section,
                        data: attr.data
                    }
                }
            });
            break;
        case 'folders_to_investigation':
            checkActivePeriod({
                element_id: 'folders-to-investigation-date',
                function: checkNuc,
                attr: {
                    element_id: 'folders-to-investigation-nuc',
                    function: saveSection,
                    attr: {
                        section: attr.section,
                        data: attr.data
                    }
                }
            });
            break;
        case 'folders_to_validation':
            checkActivePeriod({
                element_id: 'folders-to-validation-date',
                function: checkNuc,
                attr: {
                    element_id: 'folders-to-validation-nuc',
                    function: saveSection,
                    attr: {
                        section: attr.section,
                        data: attr.data
                    }
                }
            });
            break;
        case 'people_served':
            checkActivePeriod({
                element_id: 'people-served-date',
                function: checkNuc,
                attr: {
                    element_id: 'people-served-nuc',
                    function: saveSection,
                    attr: {
                        section: attr.section,
                        data: attr.data
                    }
                }
            });
            break;
        case 'recieved_folders':
            checkActivePeriod({
                element_id: 'recieved-folders-date',
                function: checkNuc,
                attr: {
                    element_id: 'recieved-folders-nuc',
                    function: saveSection,
                    attr: {
                        section: attr.section,
                        data: attr.data
                    }
                }
            });
            break;
        case 'entered_folders':
                checkActivePeriod({
                    element_id: 'entered-folders-date',
                    function: checkNuc,
                    attr: {
                        element_id: 'entered-folders-nuc',
                        function: saveSection,
                        attr: {
                            section: attr.section,
                            data: attr.data
                        }
                    }
                });
                break;
        default:
            console.log('defa');
            saveSection({
                section: attr.section,
                data: attr.data
            });
            break;
    }
}

function saveSection(attr){
    $.ajax({
		url: 'service/'+sections[attr.section].create_file,
        type: 'POST',
        dataType : 'json', 
		data: {
			...attr.data
		},
		cache: false
	}).done(function(response){
        if(response.state == 'success'){
            
            Swal.fire('Correcto', 'Datos guardados correctamente', 'success');
            resetSection(attr.section);
            loadDefaultValuesBySection(attr.section);
            getRecordsByMonth(attr.section);
            
            console.log('chido chido', response);
            console.log('chido lo', response.state);
        }
        else{

            Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');

            console.log('not chido', response);
            console.log('chido no lo', response.state);
        }
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

function validateNumber(evt) {
    
	var theEvent = evt || window.event;
  
	if(theEvent.type === 'paste'){
		key = event.clipboardData.getData('text/plain');
    } 
    else{
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
    }
    
    var regex = /[0-9]|\./;
    
	if( !regex.test(key) ){
	    theEvent.returnValue = false;
    if(theEvent.preventDefault) 
        theEvent.preventDefault();
	}
}

function checkNuc(attr){

    console.log('checas: ', attr);

    /*if(document.getElementById(evt.srcElement.id)){
        if(document.getElementById(evt.srcElement.id).value.length == 13){

        }
    }*/

    if(document.getElementById(attr.element_id)){

        console.log('exis ');
        if(document.getElementById(attr.element_id).value.length == 13){
            console.log('apenas voy');
            $.ajax({  
                type: "POST",  
                url: "service/check_nuc.php", 
                dataType : 'json', 
                data: {
                    nuc: document.getElementById(attr.element_id).value
                },
            }).done(function(response){

                console.log('response?');
        
                if(response.state != "fail"){
        
                    if(response.data != null){

                        attr.function(attr.attr);

                        //Swal.fire('NUC verificado', 'NUC registrado con el delito de: '+response.data.crime, 'success');
                    }
                    else{
                        Swal.fire('NUC no encontrado', 'Verifique el NUC!', 'warning');
                    }
                }
                else{
                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            Swal.fire('NUC no valido', 'El NUC debe contar con 13 dígitos', 'warning');
        }
    }
    else{
    }


    /*$.ajax({  
        type: "POST",  
        url: "service/check_nuc.php", 
        dataType : 'json', 
        data: {
            nuc: document.getElementById(id)
        },
    }).done(function(response){

        if(response.state != "fail"){

            if(response.data != null){
                Swal.fire('Nuc verificado', 'Nuc registrado con el delito de: '+response.data.crime, 'success');
            }
            else{
                Swal.fire('Nuc no encontrado', 'Verifique el nuc!', 'warning')
            }
        }
        else{
            Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
        }
        
    });  
    
    return false;*/
}

function getRecordsByMonth(section){

    console.log('by moneh?', section);

    let date = new Date();
    date.setHours(date.getHours()+6); 

	$.ajax({
		url:'service/'+sections[section].records_by_month_file,
		type:'POST',
		dataType: "json",
		data: {
            month: (date.getMonth()+1),
            year: date.getFullYear()
		},
		cache:false
	}).done(function(response){
        console.log(response);
        test = response;
        drawRecordsTable({
            data: response,
            file: section+'_table.php'
        });
	});
}

function drawRecordsTable(attr){
	console.log('draw_t');
	$.ajax({
		url: 'templates/tables/'+attr.file,
		type: 'POST',
		dataType: "html",
		data: {
			data: attr.data
		},
		cache: false
	}).done(function(response){
		$('#records-section').html(response);
	});
}

function checkActivePeriod(attr){

    if(document.getElementById(attr.element_id)){
        console.log('active? o q?');

        $.ajax({
            url:'service/get_active_period.php',
            type:'POST',
            dataType: "json",
            data: {
                id: 0
            },
        }).done(function(response){
            console.log('res de active',response);

            let form_date = new Date(document.getElementById(attr.element_id).value);
            console.log('f_datre', form_date);
            form_date.setHours(form_date.getHours()+6);
            console.log('f_datre_af', form_date);
            //form_date = form_date.toLocaleDateString("es-MX");
    
            let initial_date = new Date(response.initial_us_date);
            console.log('i_date', initial_date);
            //initial_date.setHours(initial_date.getHours()+6);
            //initial_date = initial_date.toLocaleDateString("es-MX");
    
    
            let finish_date = new Date(response.finish_us_date);
            console.log('f_date', finish_date);
            finish_date.setHours(finish_date.getHours()+23);
            finish_date.setMinutes(finish_date.getMinutes(59));
            //finish_date = finish_date.toLocaleDateString("es-MX");


            if(response.daily){
                console.log('daily');

                let today = new Date();
                //today = today.toLocaleDateString("es-MX");

                if(form_date != today){
                    console.log('daily noup: ', today);
                    console.log('daily noup form da: ', form_date);
                    Swal.fire('Fecha fuera de periodo de captura de captura', 'Ingrese una fecha de captura valida', 'warning');
                }
                else{
                    console.log('daily yes');
                    attr.function(attr.attr);
                }

            }
            else{

                console.log('form_date: ', new Date(form_date));
                console.log('finish_date: ', new Date(finish_date));
                console.log('initial_date: ', new Date(initial_date));
                if(form_date <= finish_date && form_date >= initial_date){
                    console.log('yes');
    
                    attr.function(attr.attr);
    
    
                }
                else{
                    console.log('noup');
    
                    Swal.fire('Fecha fuera de periodo de captura de captura', 'Ingrese una fecha de captura valida', 'warning');
                }
            }
    
    
        });
    }
    
}

function getCatalog(attr){

    $.ajax({
        url: attr.service_file,
        dataType: "json",
        cache:false
    }).done(function(response){

        sections[attr.section].fields[attr.field].catalog.data = response;

        loadSelect({
            template_file: attr.template_file,
            element_attr: {
                ...attr.element_attr,
                elements: response
            }
        });

        console.log(response);

    });
}

function loadSelect(attr){
	$.ajax({
		url: attr.template_file,
		type:'POST',
		dataType: "html",
		data: attr.element_attr,
		cache:false
	}).done(function(response){
		$('#'+attr.element_attr.element_id+'-section').html(response);
	});
}