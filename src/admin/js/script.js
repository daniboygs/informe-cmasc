$(document).ready(function(){ 
    console.log(sections);

    checkSession({
        success: {
            function: loadSection,
            attr: 'entered_folders'
        },
        failed: {
            function: redirectTo,
            attr: '../../index.html'
        },
        location: '../../service/check_session.php'
    });

    getRecordsByMonth('entered_folders');

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
        //loadDefaultValuesBySection(section);
        if(section != 'capture_period'){
            console.log('search month');
            getRecordsByMonth(section);
            switch(section){
                case 'entered_folders_super':
                    loadDefaultValuesBySection(section);
                    /*loadCatalogsBySection({
                        section: section,
                        template_file: 'templates/elements/select.php',
                        service_location: 'service/catalogs/'
                    });*/
                    loadCatalogsBySection({
                        section: section,
                        template_file: {
                            select: 'templates/elements/select.php',
                            multiselect: 'templates/elements/multiselect.php'
                        },
                        service_location: 'service/catalogs/'
                    });
                    setMultiselectActionsBySection(section);
                    break;
                default:
                    break;
            }
            
        }
        else{
            $('#records-section').html('');
            getActivePeriod();
            getInegiActivePeriod();
        }
        

    });
}

function loadCatalogsBySection(attr){

    console.log('loaaaaaaaaaaaaaaad sec cat: ', attr);

    for(field in sections[attr.section].fields){

        if(sections[attr.section].fields[field].catalog != null){

            console.log('load type template: ', attr.template_file[sections[attr.section].fields[field].type]);

            if(sections[attr.section].fields[field].catalog.data != null){
                loadSelect({
                    template_file: attr.template_file[sections[attr.section].fields[field].type],
                    element_attr: {
                        element_id: sections[attr.section].fields[field].id,
                        element_placeholder: sections[attr.section].fields[field].placeholder,
                        element_event_listener: sections[attr.section].fields[field].event_listener,
                        elements: sections[attr.section].fields[field].catalog.data
                    },
                    select_type: sections[attr.section].fields[field].type
                });
            }
            else{
                getCatalog({
                    service_file: attr.service_location+sections[attr.section].fields[field].catalog.service_file,
                    template_file: attr.template_file[sections[attr.section].fields[field].type],
                    element_attr: {
                        element_id: sections[attr.section].fields[field].id,
                        element_placeholder: sections[attr.section].fields[field].placeholder,
                        element_event_listener: sections[attr.section].fields[field].event_listener
                    },
                    section: attr.section,
                    field: field,
                    select_type: sections[attr.section].fields[field].type
                });
            }
        }
    }
}

/*function loadCatalogsBySection(attr){

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
}*/

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
                            //today.setHours(today.getHours()+6); 
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

/*function validateSection(section){

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
}*/

function validateSection(section){


    console.log('si entre a validar');
    /*setLoader({
        add: true
    });*/

    let fields = sections[section].fields;
    let data = {};
    let compleated = true;
    let multiselect = false;

    for(field in fields){
        //console.log('fields', fields[field]);
        if(document.getElementById(fields[field].id)){

            if(fields[field].type != 'multiselect'){

                if(fields[field].required && document.getElementById(fields[field].id).value == ''){
                    compleated = false;
                }
    
                data = {
                    ...data,
                    [fields[field].name]: document.getElementById(fields[field].id).value
                }
            }
            else{
                console.log('multisaeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
                if(handle_data.current_multiselect[fields[field].name]){
                    if(handle_data.current_multiselect[fields[field].name] != null){
                        if(handle_data.current_multiselect[fields[field].name].length <= 0){
                            compleated = false;
                            console.log(' no we obvio');
                        }
                    }
                    else{
                        compleated = false;
                    }
                }
                else{
                    compleated = false;
                }
            }
        }
        else{
            compleated = false;
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
        /*setLoader({
            add: false
        });*/

        Swal.fire('Campos faltantes', 'Tiene que completar los campos faltantes', 'warning');
    }
}

function spetialValidationBySection(attr){
    switch(attr.section){
        case 'agreements':
            console.log('agg');
            checkActivePeriod({
                element_id: 'agreement-date',
                section: 1,
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
                section: 1,
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
                section: 1,
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
                section: 1,
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
                section: 1,
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
                    section: 1,
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
            //resetSection(attr.section);
            loadDefaultValuesBySection(attr.section);
            //getRecordsByMonth(attr.section);

            if(response.data.id != null){
                saveMultiselectFieldsBySection({
                    id: response.data.id,
                    section: attr.section 
                });
            }
            
            console.log('chido chido', response);
            console.log('chido lo', response.state);
        }
        else{

            Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');

            console.log('not chido', response);
            console.log('chido no lo', response.state);
        }
	}).fail(function (jqXHR, textStatus) {
        Swal.fire('Error', 'Ha ocurrido un error inesperado del servidor, Favor de nofificar a DPE.', 'error');

        setLoader({
            add: false
        });
    });
}

function resetSection(section){
    let fields = sections[section].fields;

    for(field in fields){
        if(document.getElementById(fields[field].id)){

            document.getElementById(fields[field].id).value = "";
        }
    }

    resetMultiselect();

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
            Swal.fire('NUC no valido', 'El NUC debe contar con 13 digitos', 'warning');
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
    //date.setHours(date.getHours()+6); 

    if(sections[section].records_by_month_file != null){

        setStaticLoader({
            section_id: 'records-section',
            class: 'static-loader'
        });

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
            console.log(section+'_table.php');
            drawRecordsTable({
                data: response,
                file: 'templates/tables/'+section+'_table.php',
                element_id: 'records-section'
            });
        });
    }
}

function drawRecordsTable(attr){

    if(attr.data != null){
        $.ajax({
            url: attr.file,
            type: 'POST',
            dataType: "html",
            data: {
                data: JSON.stringify(attr.data)
            },
            cache: false
        }).done(function(response){
            $('#'+attr.element_id).html(response);
        });
    }
    else{
        loadDashboardAlert({
            template_file: 'templates/elements/dashboard_alert.php',
            element_id: attr.element_id,
            element_attr: {
                attr: {
                    type: 'secondary',
                    message: 'No hay registros!'
                }
            } 
        });
    }


	/*console.log('draw_t', attr.file);
	$.ajax({
		url: 'templates/tables/'+attr.file,
		type: 'POST',
		dataType: "html",
		data: {
			data: JSON.stringify(attr.data)
		},
		cache: false
	}).done(function(response){
		$('#records-section').html(response);
	});*/
}

function searchSection(section){

    console.log('search?', section+'-nuc');

    //let date = new Date();
    
    let attr = {};
    let validated = false;

    switch(section){
        case 'processing_folders':
            if(document.getElementById('search-initial-date') && document.getElementById('search-finish-date')){
                attr = {
                    processing_folders_initial_date: document.getElementById('search-initial-date').value,
                    processing_folders_finish_date: document.getElementById('search-finish-date').value
                }
                validated = true;
            }
            break;
        default:
            console.log('defa');
            if(document.getElementById('search-nuc') && document.getElementById('search-month')){
                console.log('exis');
                if(document.getElementById('search-nuc').value == '' && document.getElementById('search-month').value == ''){
                    console.log('vaci');
                    Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
                }
                else{
                    
                    date = document.getElementById('search-month').value;
                    d = new Date(date+'-01');
                    d.setHours(d.getHours()+6); 
                    attr = {
                        nuc: document.getElementById('search-nuc').value,
                        month: (d.getMonth()+1),
                        year: d.getFullYear()
                        //month: document.getElementById('search-month').value
                    }
                    if(document.getElementById('search-month').value == ''){
                        attr.month = '';
                        attr.year = '';
                    }
                    validated = true;
                }
                
                
            }
            break;
    }

    if(validated){
        console.log(sections[section].search_file, attr);
        $.ajax({
            url:'service/'+sections[section].search_file,
            type:'POST',
            dataType: "json",
            data: attr,
            cache:false
        }).done(function(response){
            console.log(response);
            test = response;
            drawRecordsTable({
                data: response,
                file: 'templates/tables/'+section+'_table.php',
                element_id: 'records-section'
            });
        });
    }
    else{
        //Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');
    }

	
}

function deleteRecord(section, id){

    Swal.fire({
        title: 'Estas seguro?',
        text: 'El registro sera eliminado de forma permanente!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url:'service/delete_'+section+'.php',
                type:'POST',
                dataType: "json",
                data: {
                    id: id
                },
                cache:false
            }).done(function(response){
                Swal.fire('Correcto', 'Registro eliminado correctamente', 'success');
                getRecordsByMonth(section);
            });
        }
    });

    //let date = new Date();

    /*if(document.getElementById(section+'-nuc')){
        $.ajax({
            url:'service/'+sections[section].search_file,
            type:'POST',
            dataType: "json",
            data: {
                nuc: document.getElementById(section+'-nuc')
            },
            cache:false
        }).done(function(response){
            console.log(response);
            test = response;
            drawRecordsTable(response);
        });
    }
    else{
        Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');
    }*/

	
}

function tableToExcel(){
    var uri = 'data:application/vnd.ms-excel;base64,'
      , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta cha' + 'rset="UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
      , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
      , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    
      
  
    table = document.getElementsByClassName('data-table')[0];
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx));
    
}

function getActivePeriod(){

    console.log('active? o q?');

	$.ajax({
		url:'service/get_active_period.php',
		type:'POST',
        dataType: "json",
        data: {
            section: 1
        },
	}).done(function(response){
        console.log('res de active',response);

        let period = response;

        let initial_date = new Date(period.initial_us_date);

        initial_date.setHours(initial_date.getHours()+6);

        document.getElementById('capture-period-initial-date').valueAsDate = initial_date;

        let finish_date = new Date(period.finish_us_date);

        finish_date.setHours(finish_date.getHours()+6);

        document.getElementById('capture-period-finish-date').valueAsDate = finish_date;

        document.getElementById('capture-period-daily').checked = period.daily;

        if(period.daily){
            $('#capture-period-label').html('Periodo de captura: Diaria');
            document.getElementById('capture-period-initial-date').disabled = true;
            document.getElementById('capture-period-finish-date').disabled = true;
        }
        else{
            $('#capture-period-label').html('Periodo de captura: '+response.initial_date+' al '+response.finish_date+'');
        }
        
	});
}

function activatePeriod(){
    if(document.getElementById('capture-period-initial-date') && document.getElementById('capture-period-finish-date')){

        console.log('exis per');
        if((document.getElementById('capture-period-initial-date') != '' && document.getElementById('capture-period-finish-date') != '') || document.getElementById('capture-period-daily').checked){
            console.log('apenas voy per');
            $.ajax({  
                type: "POST",  
                url: "service/update_capture_period.php", 
                dataType : 'json', 
                data: {
                    initial_date: document.getElementById('capture-period-initial-date').value,
                    finish_date: document.getElementById('capture-period-finish-date').value,
                    daily: document.getElementById('capture-period-daily').checked
                },
            }).done(function(response){

                console.log('response? per');
        
                if(response.state != "fail"){

                    Swal.fire('Correcto', 'Se ha habilitado un nuevo periodo de captura', 'success');

                    getActivePeriod();
                            
                }
                else{
                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            Swal.fire('Campos incompletos', 'Debe llenar ambas fechas', 'warning');
        }
    }
    else{
    }
}

function onChangeDaily(){
    if(document.getElementById('capture-period-daily').checked){
        document.getElementById('capture-period-initial-date').disabled = true;
        document.getElementById('capture-period-finish-date').disabled = true;
    }
    else{
        document.getElementById('capture-period-initial-date').disabled = false;
        document.getElementById('capture-period-finish-date').disabled = false;
    }
}
function getCatalog(attr){

    if(attr.service_file != null){
        $.ajax({
            url: attr.service_file,
            dataType: "json",
            cache:false
        }).done(function(response){
    
            sections[attr.section].fields[attr.field].catalog.data = response;

            console.log('load select before: ', {
                template_file: attr.template_file,
                element_attr: {
                    ...attr.element_attr,
                    elements: response
                }
            });
    
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

function checkActivePeriod(attr){

    if(document.getElementById(attr.element_id)){
        console.log('active? o q?');

        $.ajax({
            url:'service/get_active_period.php',
            type:'POST',
            dataType: "json",
            data: {
                section: attr.section
            },
        }).done(function(response){
            console.log('res de active',response);

            let form_date = new Date(document.getElementById(attr.element_id).value);
            console.log('f_datre', form_date);
            form_date.setHours(form_date.getHours()+6);
            console.log('f_datre_af', form_date);
            let form_date_mx = form_date.toLocaleDateString("es-MX");
    
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
                today = today.toLocaleDateString("es-MX");

                if(form_date_mx != today){
                    console.log('daily noup: ', today);
                    console.log('daily noup form da: ', form_date);

                    /*setLoader({
                        add: false
                    });*/

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
                    /*setLoader({
                        add: false
                    });*/
    
                    Swal.fire('Fecha fuera de periodo de captura de captura', 'Ingrese una fecha de captura valida', 'warning');
                }
            }
    
    
        });
    }
    
}

function getInegiActivePeriod(){

    console.log('active? o q?');

	$.ajax({
		url:'service/get_active_period.php',
		type:'POST',
        dataType: "json",
        data: {
            section: 2
        },
	}).done(function(response){
        console.log('res de active',response);

        let period = response;

        let initial_date = new Date(period.initial_us_date);

        initial_date.setHours(initial_date.getHours()+6);

        document.getElementById('capture-inegi-period-initial-date').valueAsDate = initial_date;

        let finish_date = new Date(period.finish_us_date);

        finish_date.setHours(finish_date.getHours()+6);

        document.getElementById('capture-inegi-period-finish-date').valueAsDate = finish_date;

        document.getElementById('capture-inegi-period-daily').checked = period.daily;

        if(period.daily){
            $('#capture-inegi-period-label').html('Periodo de captura: Diaria');
            document.getElementById('capture-inegi-period-initial-date').disabled = true;
            document.getElementById('capture-inegi-period-finish-date').disabled = true;
        }
        else{
            $('#capture-inegi-period-label').html('Periodo de captura: '+response.initial_date+' al '+response.finish_date);
        }
        
	});
}

function activateInegiPeriod(){
    if(document.getElementById('capture-inegi-period-initial-date') && document.getElementById('capture-inegi-period-finish-date')){

        console.log('exis per');
        if((document.getElementById('capture-inegi-period-initial-date') != '' && document.getElementById('capture-inegi-period-finish-date') != '') || document.getElementById('capture-inegi-period-daily').checked){
            console.log('apenas voy per');
            $.ajax({  
                type: "POST",  
                url: "service/update_inegi_capture_period.php", 
                dataType : 'json', 
                data: {
                    initial_date: document.getElementById('capture-inegi-period-initial-date').value,
                    finish_date: document.getElementById('capture-inegi-period-finish-date').value,
                    daily: document.getElementById('capture-inegi-period-daily').checked
                },
            }).done(function(response){

                console.log('response? per');
        
                if(response.state != "fail"){

                    Swal.fire('Correcto', 'Se ha habilitado un nuevo periodo de captura', 'success');

                    getInegiActivePeriod();
                            
                }
                else{
                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            Swal.fire('Campos incompletos', 'Debe llenar ambas fechas', 'warning');
        }
    }
    else{
    }
}

function onChangeInegiDaily(){
    if(document.getElementById('capture-inegi-period-daily').checked){
        document.getElementById('capture-inegi-period-initial-date').disabled = true;
        document.getElementById('capture-inegi-period-finish-date').disabled = true;
    }
    else{
        document.getElementById('capture-inegi-period-initial-date').disabled = false;
        document.getElementById('capture-inegi-period-finish-date').disabled = false;
    }
}

function loadDashboardAlert(attr){
	$.ajax({
		url: attr.template_file,
		type:'POST',
		dataType: "html",
		data: attr.element_attr,
		cache:false
	}).done(function(response){
		$('#'+attr.element_id).html(response);
	});
}

function resetDashboardAlert(attr){
    if(document.getElementById(attr.element_id)){
        $('#'+attr.element_id).html('');
    }
}

function setStaticLoader(attr){
    $('#'+attr.section_id).html('<div class="'+attr.class+'">Cargando datos... </div>');
}