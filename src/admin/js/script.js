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
});

function loadSection(section){
    console.log(section);
    if(!sections[section].active){
        preloadValidation({
            section: section
        });
    }
}

function preloadValidation(attr){
    switch(attr.section){
        case 'rejected_folders':
            loadForm(attr.section);
            break;
        default:
            if(!handle_data.rejected_folders_has_changed){
                loadForm(attr.section);
            }
            else{
                Swal.fire({
                    title: 'Estas seguro?',
                    text: 'Los cambios realizados no se perderán si cambias de sección!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                  }).then((result) => {
                    if (result.value) {
                        handle_data.rejected_folders_has_changed = false;
                        loadForm(attr.section);
                    }
                  });
            }
            break;
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
            

            getSectionByMonth({
                section: section
            });

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
                case 'capture_period':
                    break;
                default:
                    loadDefaultValuesBySection(section);
                    break;
            }
            
        }
        else{
            $('#records-section').html('');
            getActivePeriod();
            getInegiActivePeriod();
            getEnteredFoldersActivePeriod();
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
                        else if(fields[field].default == "first_month_date"){
                            let date = new Date();
                            let firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                            document.getElementById(fields[field].id).valueAsDate = firstDay;
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


    console.log('si entre a validar: ', section);
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
                checkEnteredFoldersActivePeriod({
                    element_id: 'entered-folders-date',
                    section: 3,
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
        case 'entered_folders_super':
                checkActivePeriod({
                    element_id: 'entered-folders-date',
                    section: 3,
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
            //getSectionByMonth(attr.section);

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

                        attr.attr.data = {
                            ...attr.attr.data,
                            sigi_date: response.data.date.date
                        }

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

function drawRecordsTable(attr){

    if(attr.service_url != null){
            
        if(attr.post_data.data != null){

            attr.post_data.data = JSON.stringify(attr.post_data.data);
    
            $.ajax({
                url: attr.service_url,
                type: 'POST',
                dataType: 'html',
                data: attr.post_data,
                cache: false
            }).done(function(response){
    
                if(sections[attr.section].active){
                    $('#'+attr.element_id).html(response);
                }
                
                $('.data-table').DataTable(getDefaultDataTableConfig());
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
    }
    else{
        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
    }
}

function deleteRecord(section, id){

    switch(section){
        case 'agreements':
            deleteRecordBySection({
                section: section,
                id: id,
                url_service_file: 'service/delete_'+section+'.php',
                on_service_success: {
                    functions: [
                        {
                            function: deleteRecordNoConfirmation,
                            attr: {
                                section: null,
                                id: id,
                                url_service_file: 'service/inegi/delete_inegi_by_agreement_id.php',
                                on_service_success: {
                                    functions: [],
                                    success_message: 'Registros de acuerdo e INEGI eliminados correctamente'
                                }
                            }
                        },
                        {
                            function: getSectionByMonth,
                            attr: {
                                section: section
                            }
                        }
                    ],
                    success_message: null
                }
            });
            break;
        case 'recieved_folders':
            deleteRecordBySection({
                section: section,
                id: id,
                url_service_file: 'service/delete_'+section+'.php',
                on_service_success: {
                    functions: [
                        {
                            function: deleteRecordNoConfirmation,
                            attr: {
                                section: null,
                                id: id,
                                url_service_file: 'service/inegi/delete_inegi_by_recieved_folder_id.php',
                                on_service_success: {
                                    functions: [],
                                    success_message: 'Registros de carpeta recibida e INEGI eliminados correctamente'
                                }
                            }
                        },
                        {
                            function: getSectionByMonth,
                            attr: {
                                section: section
                            }
                        }
                    ],
                    success_message: null
                }
            });
            break;
        default:
            deleteRecordBySection({
                section: section,
                id: id,
                url_service_file: 'service/delete_'+section+'.php',
                on_service_success: {
                    functions: [
                        {
                            function: getSectionByMonth,
                            attr: {
                                section: section
                            }
                        }
                    ],
                    success_message: 'Registro eliminado correctamente'
                }
            });
    }
}

function deleteRecordBySection(attr){
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
                url: attr.url_service_file,
                type: 'POST',
                dataType: "json",
                data: {
                    id: attr.id
                },
                cache:false
            }).done(function(response){

                if(attr.on_service_success != undefined && attr.on_service_success != null){

                    for(func in attr.on_service_success.functions){
                        attr.on_service_success.functions[func].function(attr.on_service_success.functions[func].attr);
                    }

                    if(attr.on_service_success.success_message != null){
                        Swal.fire('Correcto', attr.success_message, 'success');
                    }
                }
                
            }).fail(function(){

                Swal.fire('Oops...', 'Ha ocurrido un error, no se ha podido eliminar el registro!', 'error');
        
            });
        }
    });
}

function deleteRecordNoConfirmation(attr){
    $.ajax({
        url: attr.url_service_file,
        type: 'POST',
        dataType: "json",
        data: {
            id: attr.id
        },
        cache:false
    }).done(function(response){

        if(attr.on_service_success != undefined && attr.on_service_success != null){

            for(func in attr.on_service_success.functions){
                attr.on_service_success.functions[func].function(attr.on_service_success.functions[func].attr);
            }

            if(attr.on_service_success.success_message != null){
                Swal.fire('Correcto', attr.success_message, 'success');
            }
        }
    }).fail(function(){

        Swal.fire('Oops...', 'Ha ocurrido un error, no se ha podido eliminar el registro de inegi!', 'error');

    });
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

function getNucsDate(attr){

    console.log('nucs date attr: ', attr);

	$.ajax({
		url:'service/get_nucs_date.php',
		type:'POST',
        dataType: "json",
        data: {
            nucs: getNucsFromRecords(attr)
        },
	}).done(function(response){
        attr.attr.nuc_dates = response.data

        attr.func(attr.attr);

	});
}

function getStaticNucsDate(){

    console.log('searching... ');

	$.ajax({
		url:'service/get_nucs_date.php',
		type:'POST',
        dataType: "json",
        data: null,
	}).done(function(response){
        
        console.log(response.data);

	});
}

function getLastNucs(){

    console.log('searching last nucs... ');

	$.ajax({
		url:'service/get_last_nucs.php',
		type:'POST',
        dataType: "json",
        data: null,
	}).done(function(response){
        
        console.log(response.data);

	});
}

function getNucsFromRecords(attr){

    console.log('attr de nucs',attr);

    let nucs = [];

	for(records in attr.attr.data){
        if(attr.section == 'agreements'){
            nucs.push(attr.attr.data[records]['agreement_nuc'].value);
        }
        else{
            nucs.push(attr.attr.data[records][attr.section+'_nuc'].value);
        }
    }

    return nucs;
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

function getEnteredFoldersActivePeriod(){

    console.log('active? o q?');

	$.ajax({
		url:'service/get_active_period.php',
		type:'POST',
        dataType: "json",
        data: {
            section: 3
        },
	}).done(function(response){
        console.log('res de active',response);

        let period = response;

        let initial_date = new Date(period.initial_us_date);

        initial_date.setHours(initial_date.getHours()+6);

        document.getElementById('capture-entered-folders-period-initial-date').valueAsDate = initial_date;

        let finish_date = new Date(period.finish_us_date);

        finish_date.setHours(finish_date.getHours()+6);

        document.getElementById('capture-entered-folders-period-finish-date').valueAsDate = finish_date;

        document.getElementById('capture-entered-folders-period-daily').checked = period.daily;

        if(period.daily){
            $('#capture-entered-folders-period-label').html('Periodo de captura: Diaria');
            document.getElementById('capture-entered-folders-period-initial-date').disabled = true;
            document.getElementById('capture-entered-folders-period-finish-date').disabled = true;
        }
        else{
            $('#capture-entered-folders-period-label').html('Periodo de captura: '+response.initial_date+' al '+response.finish_date);
        }
        
	});
}

function activateEnteredFoldersPeriod(){
    if(document.getElementById('capture-entered-folders-period-initial-date') && document.getElementById('capture-entered-folders-period-finish-date')){

        console.log('exis per');
        if((document.getElementById('capture-entered-folders-period-initial-date') != '' && document.getElementById('capture-entered-folders-period-finish-date') != '') || document.getElementById('capture-entered-folders-period-daily').checked){
            console.log('apenas voy per');
            $.ajax({  
                type: "POST",  
                url: "service/update_entered_folder_capture_period.php", 
                dataType : 'json', 
                data: {
                    initial_date: document.getElementById('capture-entered-folders-period-initial-date').value,
                    finish_date: document.getElementById('capture-entered-folders-period-finish-date').value,
                    daily: document.getElementById('capture-entered-folders-period-daily').checked
                },
            }).done(function(response){

                console.log('response? per');
        
                if(response.state != "fail"){

                    Swal.fire('Correcto', 'Se ha habilitado un nuevo periodo de captura', 'success');

                    getEnteredFoldersActivePeriod();
                            
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

function onChangeEnteredFoldersDaily(){
    if(document.getElementById('capture-entered-folders-period-daily').checked){
        document.getElementById('capture-entered-folders-period-initial-date').disabled = true;
        document.getElementById('capture-entered-folders-period-finish-date').disabled = true;
    }
    else{
        document.getElementById('capture-entered-folders-period-initial-date').disabled = false;
        document.getElementById('capture-entered-folders-period-finish-date').disabled = false;
    }
}

function checkEnteredFoldersActivePeriod(attr){

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

function checkNucDates(){

    $.ajax({  
        type: "POST",  
        url: "service/check_nuc_dates.php", 
        dataType : 'json', 
        data: {
            nuc: null
        },
    }).done(function(response){

        if(response.state != "fail"){

            if(response.data != null){

                console.log('nuc dates: ', response.data);
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

function hideRejectionReason(){
    if(document.getElementById('entered-folders-recieved-folder')){
        if(document.getElementById('entered-folders-recieved-folder').value == 1){
            document.getElementById("entered-folders-rejection-reason").selectedIndex = "0";
            document.getElementById('rejection-reason-row').style.display = 'none';
        }
        else{
            document.getElementById('rejection-reason-row').style.display = '';
            document.getElementById("entered-folders-rejection-reason").selectedIndex = "1";
        }
    }
}

function onChangeRejectionReason(){
    if(document.getElementById('entered-folders-rejection-reason')){
        if(document.getElementById('entered-folders-rejection-reason').value == '' && document.getElementById('entered-folders-recieved-folder').value != "1"){
            document.getElementById("entered-folders-rejection-reason").selectedIndex = "1";
        }
    }
}

function edithRejectedFolder(entered_folder_id){
    if(entered_folder_id != null && entered_folder_id != undefined && entered_folder_id != ''){

        getRejectedDataByEnteredFolder({
            file_location: 'service/get_rejected_folder_by_entered_folder.php',
            post_data: {
                entered_folder_id: entered_folder_id
            },
            success: {
                function: setModal,
                attr: {
                    file_location: 'templates/modals/edit_rejected_folders_modal.php',
                    element_modal_section_id: 'admin-default-modal-section',
                    post_data: {
                        entered_folder_id: entered_folder_id
                    },
                    success: {
                        function: showModal,
                        attr: {
                            show: true,
                            modal_id: 'large-modal'
                        }
                    },
                }
            }
        });
    }
}

function getRejectedDataByEnteredFolder(attr){

    if(attr.post_data != null){
        $.ajax({
            url: attr.file_location,
            type: 'POST',
            dataType: "JSON",
            data: attr.post_data,
            cache: false
        }).done(function(response){

            console.log('response de rejected: ', response);

            attr.success.attr.post_data = response;

            console.log('to modal: ', attr.success.attr);

            if(attr.success != undefined && attr.success != null){
                attr.success.function(attr.success.attr);
            }

        });
    }
}


function setModal(attr){

    console.log('set modal: ', attr);

    if(attr.post_data != null){
        $.ajax({
            url: attr.file_location,
            type: 'POST',
            dataType: "html",
            data: attr.post_data,
            cache: false
        }).done(function(response){

            $('#'+attr.element_modal_section_id).html(response);

            if(attr.success != undefined){
                attr.success.function(attr.success.attr);
            }

        });
    }
}

function showModal(attr){

    if(attr.modal_id != null && attr.show != null){

        if(attr.show){
            $('#'+attr.modal_id).modal('show');
        }
        else{
            $('#'+attr.modal_id).modal('hide');
        }
    }
}

function updateRejectedFolder(rejected_folder_id){

    if(rejected_folder_id != null && rejected_folder_id != undefined){

        if(document.getElementById('rejected_folio')){
            $.ajax({
                url: 'service/update_rejected_folder.php',
                type: 'POST',
                dataType: "JSON",
                data: {
                    rejected_folder_id: rejected_folder_id,
                    rejected_folio: document.getElementById('rejected_folio').value
                },
                cache: false
            }).done(function(response){

                showModal({
                    show: false,
                    modal_id: 'large-modal'
                });

                getSectionByMonth({
                    section: 'rejected_folders'
                });
    
                Swal.fire('Exito', 'Todo bien', 'warning');
    
            });
        }
        else{
            Swal.fire('Ups...', 'Ups...', 'warning');
        }
        
    }
}

function saveRejectedFolder(entered_folder_id){

    if(document.getElementById('rejected_folio')){
        $.ajax({
            url: 'service/create_rejected_folder.php',
            type: 'POST',
            dataType: "JSON",
            data: {
                entered_folder_id: entered_folder_id,
                rejected_folio: document.getElementById('rejected_folio').value
            },
            cache: false
        }).done(function(response){

            showModal({
                show: false,
                modal_id: 'large-modal'
            });

            getSectionByMonth({
                section: 'rejected_folders'
            });

            Swal.fire('Exito', 'Todo bien', 'warning');

        });
    }
    else{
        Swal.fire('Ups...', 'Ups...', 'warning');
    }
}

function generateRejectedPDFReport(attr){

    window.open('templates/pdf/rejected_folder_report.php');
}

function createPDF(entered_folder_id){

    if(entered_folder_id != null && entered_folder_id != undefined && entered_folder_id != ''){

        getRejectedDataByEnteredFolder({
            file_location: 'service/get_rejected_folder_by_entered_folder.php',
            post_data: {
                entered_folder_id: entered_folder_id
            },
            success: {
                function: setSessionVariables,
                attr: {
                    file_location: 'service/set_pdf_session_var.php',
                    post_data: {
                        entered_folder_id: entered_folder_id
                    },
                    success: {
                        function: generateRejectedPDFReport,
                        attr: null
                    },
                }
            }
        });
    }
}

function setSessionVariables(attr){

    console.log('im gonna set: ', attr);

    if(attr.file_location != null && attr.file_location != undefined){

        $.ajax({
            url: attr.file_location,
            type: 'POST',
            dataType: "JSON",
            data: attr.post_data,
            cache: false
        }).done(function(response){

            if(attr.success != undefined && attr.success != null){
                attr.success.function(attr.success.attr);
            }
        });
    }
}

function onchangeRejectedFolderRow(entered_folder_id){

    if(document.getElementById('rejected-folders-row-'+entered_folder_id)){
        $('#rejected-folders-row-'+entered_folder_id).removeClass('error-row');
        $('#rejected-folders-row-'+entered_folder_id).addClass('update-row');

        if(!handle_data.rejected_folders_has_changed){
            handle_data.rejected_folders_has_changed = true;

            //document.getElementById('rejected_folders_excel_btn').style.display = 'none';
            document.getElementById('rejected_folders_save_btn').style.display = '';

            loadDashboardAlert({
                template_file: 'templates/elements/dashboard_alert.php',
                element_id: 'rejected_folders_messaje',
                element_attr: {
                    attr: {
                        type: 'warning',
                        message: 'Cambios pendientes de guardar!'
                    }
                }
            });
        }
        else{
            //document.getElementById('rejected_folders_excel_btn').style.display = 'none';
            document.getElementById('rejected_folders_save_btn').style.display = '';
        }

        if(!handle_data.rejected_folders_changed_folders.includes(entered_folder_id)){
            handle_data.rejected_folders_changed_folders.push(entered_folder_id);
        }
    }
}

function validateRejectedData(){

    /*let rejected_folders_row_fields_id_prepositions = {
        folio: 'folio-',
        case: 'case-',
        admin_unity: 'admin-unity-',
        office: 'office-',
        record_number: 'record-number-'
    };*/

    let rejected_folders_row_fields_id_prepositions = {
        folio: 'folio-'
    };

    let completed_section = true;
    let completed_some_rows = false;
    let validated_values = [];
    let non_validated_rows = [];

    if(handle_data.rejected_folders_changed_folders.length != 0){

        for(entered_id in handle_data.rejected_folders_changed_folders){

            let validated_row = true;
            let temp_values = {};

            for(preposition in rejected_folders_row_fields_id_prepositions){

                if(document.getElementById(rejected_folders_row_fields_id_prepositions[preposition]+handle_data.rejected_folders_changed_folders[entered_id])){

                    let current_field_value = document.getElementById(rejected_folders_row_fields_id_prepositions[preposition]+handle_data.rejected_folders_changed_folders[entered_id]).value;
                    
                    if(current_field_value != ''){
                        temp_values = {
                            ...temp_values,
                            [preposition]: current_field_value
                        }
                    }
                    else{
                        validated_row = false;
                        completed_section = false;
                    }
                }
                else{
                    validated_row = false;
                    completed_section = false;
                }
            }

            if(validated_row){
                validated_values.push({
                    ...temp_values,
                    entered_folder_id: handle_data.rejected_folders_changed_folders[entered_id]
                });

                completed_some_rows = true;
            }
            else{
                non_validated_rows.push(handle_data.rejected_folders_changed_folders[entered_id]);
            }
        }
    }

    if(!completed_some_rows){
        paintRejectedRows({
            validated_rows: validated_values,
            non_validated_rows: non_validated_rows
        });

        Swal.fire('Atención!', 'No se completo ningun campo', 'warning');
    }
    else{
        saveRejectedFolderSection({
            file_location: 'service/create_rejected_folders_section.php',
            post_data: {
                data: JSON.stringify(validated_values)
            },
            success: {
                function: paintRejectedRows,
                attr: {
                    validated_rows: validated_values,
                    non_validated_rows: non_validated_rows
                }
            }
        });
    }
}

function saveRejectedFolderSection(attr){

    console.log('im going to save rejected', attr);

    if(attr.file_location != null && attr.post_data != null){
        $.ajax({
            url: attr.file_location,
            type: 'POST',
            dataType: "JSON",
            data: attr.post_data,
            cache: false
        }).done(function(response){

            if(attr.success != null && attr.success != undefined){
                
                attr.success.function(attr.success.attr);
            }

        });
    }
    else{
        Swal.fire('Ups...', 'Ah ocurrido algo inesperado', 'warning');
    }
}

function paintRejectedRows(attr){


    console.log('guarde y voy a pintar creo', attr);

    let validated_elements = [];

    if(attr.validated_rows.length > 0 && attr.non_validated_rows.length <= 0){

        for(validated in attr.validated_rows){
            if(document.getElementById('rejected-folders-row-'+attr.validated_rows[validated].entered_folder_id)){
                
                validated_elements.push(attr.validated_rows[validated].entered_folder_id);
                $('#rejected-folders-row-'+attr.validated_rows[validated].entered_folder_id).removeClass('update-row');
            }
        }

        if(validated_elements.length > 0){
            loadRejectedActionButtons({
                elements: validated_elements
            });
        }

        resetDashboardAlert({
            element_id: 'rejected_folders_messaje'
        });

        //document.getElementById('rejected_folders_excel_btn').style.display = '';
        document.getElementById('rejected_folders_save_btn').style.display = 'none';

        handle_data.rejected_folders_changed_folders = [];

        Swal.fire('Correcto', 'Se ha guardado correctamente', 'success');
    }
    else if(attr.non_validated_rows.length > 0){

        for(validated in attr.validated_rows){
            if(document.getElementById('rejected-folders-row-'+attr.validated_rows[validated].entered_folder_id)){

                validated_elements.push(attr.validated_rows[validated].entered_folder_id);
                $('#rejected-folders-row-'+attr.validated_rows[validated].entered_folder_id).removeClass('update-row');
            }
        }

        if(validated_elements.length > 0){
            loadRejectedActionButtons({
                elements: validated_elements
            });
        }

        for(non_validated in attr.non_validated_rows){
            if(document.getElementById('rejected-folders-row-'+attr.non_validated_rows[non_validated])){
                $('#rejected-folders-row-'+attr.non_validated_rows[non_validated]).removeClass('update-row');
                $('#rejected-folders-row-'+attr.non_validated_rows[non_validated]).addClass('error-row');
            }
        }

        handle_data.rejected_folders_changed_folders = removeArrayItems({
            items: handle_data.rejected_folders_changed_folders,
            remove_items: attr.non_validated_rows
        });

        Swal.fire('Atención', 'Uno o varios registros incompletos no se han guardado', 'warning');
    }
}

function removeArrayItems(attr){

    let new_array = [];

    for(item in attr.items){

        if(!attr.remove_items.includes(attr.items[item])){
            new_array.push(attr.items[item]);
        }
    }
    return new_array;
}

function loadRejectedActionButtons(attr){

    for(element in attr.elements){
        loadActionButton({
            template_file: 'templates/elements/action_button.php',
            element_id: 'action-btn-'+attr.elements[element],
            element_attr: {
                attr: {
                    type: 'outline-danger',
                    event_listener: 'onclick="createPDF('+attr.elements[element]+')"',
                    title: 'Generar PDF',
                    icon: 'file-pdf-o'
                }
            } 
        });
    }
}

function loadActionButton(attr){

	$.ajax({
		url: attr.template_file,
		type:'POST',
		dataType: "html",
		data: attr.element_attr,
		cache:false
	}).done(function(response){
        if(document.getElementById(attr.element_id)){
            $('#'+attr.element_id).html(response);
        }
	});
}

function resetActionButton(attr){
    if(document.getElementById(attr.element_id)){
        $('#'+attr.element_id).html('N/A');
    }
}

function generateExcelByCurrentRecords(){

    getCurrentRecords({
        file_location: 'service/get_rejected_folders_records_by_ids.php',
        post_data: {
            records: getArrayRecordsByReferenceKeyInJSON({
                records: handle_data.current_records_search_data,
                reference_key: 'entered_folders_id'
            })
        },
        success: {
            function: generateExcelByTemplate,
            attr: {
                template_file: 'templates/tables/default_table.php',
                post_data: null
            }
        }
    });


    /*getCurrentRecords({
        file_location: 'service/get_raw_data.php',
        post_data: {
            records: getArrayRecordsByReferenceKeyInJSON({
                records: handle_data.current_records_search_data,
                reference_key: 'entered_folders_id'
            })
        },
        success: {
            function: generateExcelByTemplate,
            attr: {
                template_file: 'templates/tables/default_table.php',
                post_data: null
            }
        }
    });*/
}

function getCurrentRecords(attr){

    console.log('current records',attr);

    /*if(attr.file_location != null && current_records.length > 0){*/
    if(attr.file_location != null){
        $.ajax({
            url: attr.file_location,
            type: 'POST',
            dataType: "JSON",
            data: attr.post_data,
            cache: false
        }).done(function(response){

            console.log(response);

            if(response != undefined){

                console.log('attr',attr);
                attr.success.attr.post_data = response;

                //handle_data.current_records_search_data = response;

                if(attr.success != undefined && attr.success != null){

                    console.log('voy a generar');
                    attr.success.function(attr.success.attr);
                }
            }
        });
    }
}

function generateExcelByTemplate(attr){
    

    console.log('trato de generar', attr);
    if(attr.template_file != null && attr.post_data != null){
        $.ajax({
            url: attr.template_file,
            type: 'POST',
            dataType: "html",
            data: {
                data: JSON.stringify(attr.post_data)
            },
            cache: false
        }).done(function(response){

            console.log('res de generar',response);

            if(response != undefined){

                console.log('genere', response);
                tableToExcelByTemplate({
                    html_template: response
                });
            }
        });
    }
}

function tableToExcelByTemplate(attr){

    let table_element = document.createElement('table');
    table_element.innerHTML = attr.html_template;

    /*let table_element_jq = $('<div></div>');
    table_element_jq.html(attr.html_template);*/

    var uri = 'data:application/vnd.ms-excel;base64,'
      , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta cha' + 'rset="UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
      , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
      , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    
      
  
    table = table_element;
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx));
    
}

function rejectedFoldersPDF(){
    
    getCurrentRecords({
        file_location: 'service/get_rejected_folders_records_by_ids.php',
        post_data: {
            records: getArrayRecordsByReferenceKeyInJSON({
                records: handle_data.current_records_search_data,
                reference_key: 'entered_folders_id'
            })
        },
        success: {
            function: generateGeneralRejectedPDFReport,
            attr: {
                template_file: 'templates/tables/default_table.php',
                post_data: null
            }
        }
    });
}

function getArrayRecordsByReferenceKeyInJSON(attr){

    console.log('array ref', attr);

    let array_records = [];

    if(attr.records != null){
        for(element in attr.records){
            array_records.push(attr.records[element][attr.reference_key].value);
        }
    }

    console.log('array ref ret', array_records);

    return array_records;
}

function generateGeneralRejectedPDFReport(attr){

    console.log('voy a generar pdf', attr);

    window.open('templates/pdf/rejected_folder_reports.php');
}

function getRecExcel(){

    let validated = false;
    let post_data = {};

    if(document.getElementById('search-initial-date') && document.getElementById('search-finish-date')){
        post_data = {
            initial_date: document.getElementById('search-initial-date').value,
            finish_date: document.getElementById('search-finish-date').value
        }
        if(document.getElementById('search-initial-date').value != '' && document.getElementById('search-finish-date').value != ''){
            validated = true;
        }
    }

    if(validated){

        handle_data.inegi_excel.data = [];
        handle_data.inegi_excel.count = 0;
    
        let service_files = [
            {
                service: 'service/inegi/get_general_records_by_month.php',
                name: 'Datos generales'
            },
            {
                service: 'service/inegi/get_crime_records_by_month.php',
                name: 'Delito'
            },
            {
                service: 'service/inegi/get_imputed_records_by_month.php',
                name: 'Imputado'
            },
            {
                service: 'service/inegi/get_victim_records_by_month.php',
                name: 'Víctima'
            },
            {
                service: 'service/inegi/get_masc_records_by_month.php',
                name: 'Datos generales del acuerdo'
            }
        ];
    
        for(element in service_files){
            getInegiRecords({
                file_location: service_files[element].service,
                name: service_files[element].name,
                post_data: post_data
            });
        }
    }
    else{
        Swal.fire('Error', 'Campos faltantes', 'error');
    }
}


function getInegiRecords(attr){

    /*if(attr.file_location != null && current_records.length > 0){*/
    if(attr.file_location != null){
        $.ajax({
            url: attr.file_location,
            type: 'POST',
            dataType: "JSON",
            data: attr.post_data,
            cache: false
        }).done(function(response){

            console.log(response);

            if(response != undefined){

                onServiceSuccess({
                    data: {
                        [attr.name]: response  
                    },
                    status: 'success'
                });
            }
            else{

                onServiceSuccess({
                    response: response,
                    status: 'fail'
                });
            }
        });
    }
}

function onServiceSuccess(attr){

    if(attr.status != 'fail'){

        handle_data.inegi_excel.count ++;

        handle_data.inegi_excel.data.push(attr.data);

        if(handle_data.inegi_excel.count >= 5){

            let d = new Date();
            
            createExcelReport({
                data: handle_data.inegi_excel.data,
                url_service_file: 'templates/excel/inegi.php',
                file_name: 'inegi-'+d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()
            });
        }
    }
}

function createExcelReport(attr) {

    if(attr.data != null){

        console.log('createeee', attr);
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: attr.url_service_file,
            data: {
                data: JSON.stringify(attr.data)
                //data: attr.data
            },
        }).done(function(data){
            console.log('good response');
            var $a = $("<a>");
            $a.attr("href",data.file);
            $("body").append($a);
            $a.attr("download", attr.file_name);
            $a[0].click();
            $a.remove();
            showLoading(false);
        });
    }

}

function getRecordsBySection(attr){

    if(attr.hasOwnProperty('section')){

        switch(attr.section){
            case 'inegi':
                getRecordCrimesBeforeGeneral(attr);
                break;
            case 'people_served':
                getRecordPeopleBeforeSection(attr);
                break;
            case 'rejected_folders':
                getSectionRecords(attr);
                break;
            case 'processing_folders':
                getSectionRecords(attr);
                break;
            default:
                getRecordCrimesBeforeSection(attr);
                break;
        }
    }
}

function getRecordPeopleBeforeSection(attr){

    attr = attr.search_form_elements != undefined ? attr : {
        ...attr,
        search_form_elements: getSearchFormElementsBySection({
            section: attr.section
        })
    }

    let validated_form_elements = attr.is_current_month != undefined ? attr.is_current_month : (validateElementsByIdContent({
        elements: attr.search_form_elements
    }) && attr.search_form_elements != null ? true : false);

    if(validated_form_elements){

        attr = attr.json_form_elements != undefined ? attr : {
            ...attr,
            json_form_elements: formJsonFromFormElements({
                elements: attr.search_form_elements
            })
        }
        
        let people_service_url = getSectionPeopleService({
            section: attr.section
        });

        let validated_form_content = attr.is_current_month != undefined ? 
        (attr.is_current_month != true ? validateFormBySection({
            section: attr.section,
            json_form_elements: attr.json_form_elements
        }) : true) : validateFormBySection({
            section: attr.section,
            json_form_elements: attr.json_form_elements
        });

        if(validated_form_content && people_service_url != null){

            attr = attr.post_data != undefined ? attr : {
                ...attr,
                post_data: {}
            }

            setStaticLoader({
                section_id: 'records-section',
                class: 'static-loader'
            });
            
            $.ajax({
                url: people_service_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    ...attr.json_form_elements,
                    ...attr.post_data
                },
                cache: false
            }).done(function(response){

                if(sections[attr.section].active){

                    if(response.state == 'success'){

                        attr.post_data = {
                            ...attr.post_data,
                            people_by_record_id: JSON.stringify(response.data.people_by_record)
                        }

                        getRecordCrimesBeforeSection(attr);
                    }
                    else{
                        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
                    }
                }
            }).fail(function(){
                Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
            });
        }
        else{
            Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
        }
    }
}

function getRecordCrimesBeforeSection(attr){

    attr = attr.search_form_elements != undefined ? attr : {
        ...attr,
        search_form_elements: getSearchFormElementsBySection({
            section: attr.section
        })
    }

    let validated_form_elements = attr.is_current_month != undefined ? attr.is_current_month : (validateElementsByIdContent({
        elements: attr.search_form_elements
    }) && attr.search_form_elements != null ? true : false);

    console.log('crimes before sec: ', attr);

    if(validated_form_elements){

        console.log('validated');

        attr = attr.json_form_elements != undefined ? attr : {
            ...attr,
            json_form_elements: formJsonFromFormElements({
                elements: attr.search_form_elements
            })
        }
        
        let section_crimes_service_url = getSectionCrimesService({
            section: attr.section
        });

        let validated_form_content = attr.is_current_month != undefined ? 
        (attr.is_current_month != true ? validateFormBySection({
            section: attr.section,
            json_form_elements: attr.json_form_elements
        }) : true) : validateFormBySection({
            section: attr.section,
            json_form_elements: attr.json_form_elements
        });

        if(validated_form_content && section_crimes_service_url != null){

            console.log('validate form sec: ', section_crimes_service_url);

            attr = attr.post_data != undefined ? attr : {
                ...attr,
                post_data: {}
            }

            setStaticLoader({
                section_id: 'records-section',
                class: 'static-loader'
            });
            
            $.ajax({
                url: section_crimes_service_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    ...attr.json_form_elements,
                    ...attr.post_data
                },
                cache: false
            }).done(function(response){

                console.log('crimes by seeeeec: ', response.data.crimes_by_record);

                if(sections[attr.section].active){

                    if(response.state == 'success'){

                        attr.post_data = {
                            ...attr.post_data,
                            crimes_by_record_id: JSON.stringify(response.data.crimes_by_record)
                        }

                        getSectionRecords(attr);
                    }
                    else{
                        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
                    }
                }
            }).fail(function(){
                Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
            });
        }
        else{
            Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
        }
    }
}

function getSectionRecords(attr){

    attr = !attr.hasOwnProperty('initial_interation') ? {
        ...attr,
        initial_interation: 1,
        finish_interation: 10
    } : attr;
    
    if(attr.initial_interation < attr.finish_interation){

        attr = attr.search_form_elements != undefined ? attr : {
            ...attr,
            search_form_elements: getSearchFormElementsBySection({
                section: attr.section
            })
        }
        
        let validated_form_elements = attr.is_current_month != undefined ? attr.is_current_month : (validateElementsByIdContent({
            elements: attr.search_form_elements
        }) && attr.search_form_elements != null ? true : false);

        if(validated_form_elements){
            
            attr = attr.json_form_elements != undefined ? attr : {
                ...attr,
                json_form_elements: formJsonFromFormElements({
                    elements: attr.search_form_elements
                })
            }

            let section_service_url = getSectionService({
                section: attr.section
            });
            
            let validated_form_content = attr.is_current_month != undefined ? 
            (attr.is_current_month != true ? validateFormBySection({
                section: attr.section,
                json_form_elements: attr.json_form_elements
            }) : true) : validateFormBySection({
                section: attr.section,
                json_form_elements: attr.json_form_elements
            });
            
            attr.post_data = !attr.hasOwnProperty('post_data') ? {
                ...attr.json_form_elements
            } : attr.post_data;

            if(validated_form_content && section_service_url != null && attr.post_data != null){

                attr = attr.post_data != undefined ? attr : {
                    ...attr,
                    post_data: {}
                }

                $.ajax({
                    url: section_service_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ...attr.json_form_elements,
                        ...attr.post_data
                    },
                    cache: false
                }).done(function(response){

                    if(sections[attr.section].active){

                        if(response.state == 'success'){

                            handle_data.current_records_search_data = response.data;

                            attr.post_data = {
                                ...attr.post_data,
                                ...attr.json_form_elements,
                                data: response.data
                            }
    
                            drawRecordsTable({
                                ...attr,
                                service_url: getSectionTableTemplateService({
                                    section: attr.section
                                }),
                                element_id: 'records-section'
                            });

                        }
                        else{
                            Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
                        }
                    }
                }).fail(function(){
        
                    attr.initial_interation++;
        
                    console.log('attr +iteration', attr);
        
                    getSectionRecords(attr);
                });
            }
        }
    }
    else{
        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
    }	
}

function getInegiPendingAgreementsByMonth(attr){

    let validated = false;
    let post_data = {};

    if(document.getElementById('search-initial-date') && document.getElementById('search-finish-date') && document.getElementById('search-nuc')){
        post_data = {
            nuc: document.getElementById('search-nuc').value,
            initial_date: document.getElementById('search-initial-date').value,
            finish_date: document.getElementById('search-finish-date').value
        }

        if(document.getElementById('search-nuc').value != '' || (document.getElementById('search-initial-date').value != '' && document.getElementById('search-finish-date').value != '')){
            validated = true;
        }
        else{
            Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
        }
    }

    if(validated){

        handle_data.inegi.current_search = 'pending';
    
        setStaticLoader({
            section_id: attr.section_id,
            class: 'static-loader'
        });
    
        $.ajax({
            url:'service/inegi/get_pending_inegi_by_month.php',
            type:'POST',
            dataType: "json",
            data: post_data,
            cache:false
        }).done(function(response){
    
            if(handle_data.inegi.current_search == 'pending'){
                drawRecordsTable({
                    section: 'inegi',
                    post_data: {
                        data: response
                    },
                    service_url: 'templates/tables/pending_agreements_table.php',
                    element_id: attr.section_id
                });
            }
        });
    }
}

function searchPendngInegi(){
    getInegiPendingAgreementsByMonth({
        section_id: 'records-section'
    });
}

function depureEnteredData(depured_data){

    let temp = depured_data;

    console.log(depured_data);

    for(element in depured_data){

        for(e in depured_data[element]){

            if(e == 'entered_folders_crime'){
                temp[element][e] = depured_data[element][e].value.listed_values;
            }
            else{
                temp[element][e] = depured_data[element][e].value;
            }
        }
    }

    return temp;
}

function onchangeFileNumber(){

    let fn = document.getElementById('entered-folders-type-file').value;

    if(document.getElementById('entered-folders-emission-date').value == ''){
        setDateField({
            set_date: 'today',
            element_id: 'entered-folders-emission-date'
        });
    }

    if(fn == 1 || fn == 2){

        document.getElementById('entered-folders-cause-number').value = '';

        document.getElementById('entered-folders-judge-name').value = '';

        document.getElementById('entered-folders-region').selectedIndex = 0;

        document.getElementById('entered-folders-judicialized-before-cmasc').value = '1';

        document.getElementById('criminal-cause').style.display = '';

    }
    else{
        document.getElementById('criminal-cause').style.display = 'none';

        document.getElementById('entered-folders-cause-number').value = 'null';

        document.getElementById('entered-folders-judge-name').value = 'null';

        document.getElementById('entered-folders-region').value = '1';

        document.getElementById('entered-folders-judicialized-before-cmasc').value = '1';
        
    }

}

function getGenericDataFromService(attr){

    console.log('attr de generic service: ', attr);

    $.ajax({
        url: attr.url_service_file,
        type: 'POST',
        dataType: "JSON",
        data: attr.post_data,
        cache: false
    }).done(function(response){ 

        if(attr.success != undefined && attr.success != null){

            for(func in attr.success.functions){

                if(attr.success.functions[func].attr != null && attr.success.functions[func].response_data != null){

                    attr.success.functions[func].attr = {
                        ...attr.success.functions[func].attr,
                        [attr.success.functions[func].response_data.attr_key]: response[attr.success.functions[func].response_data.response_key]
                    }

                }

                attr.success.functions[func].function(attr.success.functions[func].attr);
            }
        }
    });
}

function delegateFolder(entered_folder_id){

    console.log('edit entered_folder_id: ', entered_folder_id);

    if(entered_folder_id != null && entered_folder_id != undefined && entered_folder_id != ''){

        /*let array_catalogs = getNoLocArrayCatalogs();

        let array_fields = getNoLocArrayFields(); //checar

        let handle_data_temp_name = generateTempName();*/

        getGenericDataFromService({
            url_service_file: 'service/entered_folders/get_delegated_user_by_folder_id.php',
            post_data: {
                entered_folder_id: entered_folder_id
            },
            success: {
                functions: [
                    {
                        function: setModal,
                        attr: {
                            file_location: 'templates/modals/edit_delegated_folder_modal.php',
                            element_modal_section_id: 'delegated-default-modal-section',
                            post_data: null,
                            success: {
                                functions: [
                                    {
                                        function: showModal,
                                        attr: {
                                            show: true,
                                            modal_id: 'large-modal'
                                        }
                                    }/*,
                                    {
                                        function: loadCatalogsByArray,
                                        attr: {
                                            array_catalogs: array_catalogs
                                        }
                                    },
                                    {
                                        function: setObtainedDataByArrayFields,
                                        attr: {
                                            array_fields: array_fields,
                                            handle_data_temp_name: handle_data_temp_name
                                        }
                                    }*/
                                ]
                            },
                        },
                        response_data: {
                            attr_key: 'post_data',
                            response_key: 'data'
                        }
                    }
                ]
            }
        });
    }
}

function loadCatalogsByArray(attr){

    console.log('load_catalogs: ',attr);
                                            
    for(field in attr.array_catalogs){

        if(handle_data.catalogs.hasOwnProperty(attr.array_catalogs[field].handle_data_catalog_array_field_key)){

            if(handle_data.catalogs[attr.array_catalogs[field].handle_data_catalog_array_field_key] != null && handle_data.catalogs[attr.array_catalogs[field].handle_data_catalog_array_field_key] != undefined){
                
                attr.array_catalogs[field].element_attr.elements = handle_data.catalogs[attr.array_catalogs[field].handle_data_catalog_array_field_key];

                changeCatalogRequestStatus({
                    array_catalogs: [
                        attr.array_catalogs[field]
                    ],
                    status: 'loaded'
                });

                if(!attr.array_catalogs[field].element_attr.element_dependant){

                    loadSelect({
                        template_file: attr.array_catalogs[field].template_file,
                        element_attr: attr.array_catalogs[field].element_attr,
                        select_type: attr.array_catalogs[field].select_type,
                        section_id: attr.array_catalogs[field].section_id,
                        on_modal_inside: attr.array_catalogs[field].on_modal_inside,
                        modal_id: attr.array_catalogs[field].modal_id,
                        handle_data_element_select_key: attr.array_catalogs[field].handle_data_catalog_array_field_key
                    });
                }
            }
            else{

                changeCatalogRequestStatus({
                    array_catalogs: [
                        attr.array_catalogs[field]
                    ],
                    status: 'loading'
                });

                getCatalog({
                    service_file: attr.array_catalogs[field].service_file,
                    on_service_success: {
                        handle_data_catalog_array_field_key: attr.array_catalogs[field].handle_data_catalog_array_field_key,
                        functions: [
                            {
                                function: loadCatalogsByArray,
                                attr: {
                                    array_catalogs: [
                                        attr.array_catalogs[field]
                                    ]
                                }
                            }
                        ]
                    }
                });
            }
        }
        else{

            handle_data.catalogs = {
                ...handle_data.catalogs,
                [attr.array_catalogs[field].handle_data_catalog_array_field_key]: null
            }

            loadCatalogsByArray({
                array_catalogs: [
                    attr.array_catalogs[field]
                ]
            });
        }
    }
}

function formHTMLTableToExcel(attr){

    let url_excel_template = attr.url_excel_template != undefined ? attr.url_excel_template : getHTMLTableTemplate({
        section: attr.section
    });

    if(handle_data.current_records_search_data != null && url_excel_template != null){
        $.ajax({
            url: url_excel_template,
            type: 'POST',
            dataType: "html",
            data: {
                data: JSON.stringify(handle_data.current_records_search_data)
            },
            cache: false
        }).done(function(response){

            downloadExcel({
                table: response
            });
        });
    }
    else{
        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
    }
}

function downloadExcelSection(section){ //trash?

    let d = new Date();

    createExcelReport({
        data: handle_data.excel_data[section],
        url_service_file: 'templates/excel/'+section+'.php',
        file_name: section+'-'+d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()
    });
}

function getRecordCrimesBeforeGeneral(attr){

    attr = attr.search_form_elements != undefined ? attr : {
        ...attr,
        search_form_elements: getSearchFormElementsBySection({
            section: attr.section
        })
    }

    let validated_form_elements = attr.is_current_month != undefined ? attr.is_current_month : (validateElementsByIdContent({
        elements: attr.search_form_elements
    }) && attr.search_form_elements != null ? true : false);

    if(validated_form_elements){

        attr = attr.json_form_elements != undefined ? attr : {
            ...attr,
            json_form_elements: formJsonFromFormElements({
                elements: attr.search_form_elements
            })
        }

        attr.json_form_elements = attr.json_form_elements.inegi_search_op != undefined ? attr.json_form_elements : {
            ...attr.json_form_elements,
            inegi_search_op: 'default'
        }

        let inegi_before_service_url = getInegiCrimesBeforeService({
            search_op: attr.json_form_elements.inegi_search_op
        });

        let validated_form_content = attr.is_current_month != undefined ? 
        (attr.is_current_month != true ? validateFormBySection({
            section: attr.section,
            json_form_elements: attr.json_form_elements
        }) : true) : validateFormBySection({
            section: attr.section,
            json_form_elements: attr.json_form_elements
        });

        if(validated_form_content && inegi_before_service_url != null){

            attr = attr.post_data != undefined ? attr : {
                ...attr,
                post_data: {}
            }

            setStaticLoader({
                section_id: 'records-section',
                class: 'static-loader'
            });
            
            $.ajax({
                url: inegi_before_service_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    ...attr.json_form_elements,
                    ...attr.post_data
                },
                cache: false
            }).done(function(response){

                if(sections[attr.section].active){

                    if(response.state == 'success'){

                        attr.post_data = {
                            ...attr.post_data,
                            crimes_by_general_id: JSON.stringify(response.data.crimes_by_general_record)
                        }

                        inegi_getRecords(attr);

                    }
                    else{
                        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
                    }
                }
            }).fail(function(){
                Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
            });
        }
        else{
            Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
        }
    }
}

function validateFormBySection(attr){

    let validated = false;

    if(attr.json_form_elements != null){

        switch(attr.section){
        
            case 'processing_folders':
                if(checkJSONProperties({
                    json_data: attr.json_form_elements,
                    json_properties: [
                        'initial_date',
                        'finish_date'
                    ]
                })){
                    validated = (attr.json_form_elements['initial_date'] != '' && attr.json_form_elements['finish_date'] != '') ?
                    true : false;
                }
                break;
            default:
                if(checkJSONProperties({
                    json_data: attr.json_form_elements,
                    json_properties: [
                        'initial_date',
                        'finish_date',
                        'nuc'
                    ]
                })){
                    validated = (attr.json_form_elements['nuc'] != '' || 
                    (attr.json_form_elements['initial_date'] != '' && attr.json_form_elements['finish_date'] != '')) ?
                    true : false;
                }
        }
    }
    return validated;
}

function inegi_getRecords(attr){

    attr = !attr.hasOwnProperty('initial_interation') ? {
        ...attr,
        initial_interation: 1,
        finish_interation: 10
    } : attr;
    
    if(attr.initial_interation < attr.finish_interation){

        attr = attr.search_form_elements != undefined ? attr : {
            ...attr,
            search_form_elements: getSearchFormElementsBySection({
                section: attr.section
            })
        }
        
        let validated_form_elements = attr.is_current_month != undefined ? attr.is_current_month : (validateElementsByIdContent({
            elements: attr.search_form_elements
        }) && attr.search_form_elements != null ? true : false);

        if(validated_form_elements){
            
            attr = attr.json_form_elements != undefined ? attr : {
                ...attr,
                json_form_elements: formJsonFromFormElements({
                    elements: attr.search_form_elements
                })
            }

            attr.json_form_elements = attr.json_form_elements.inegi_search_op != undefined ? attr.json_form_elements : {
                ...attr.json_form_elements,
                inegi_search_op: 'default'
            }

            let inegi_service_url = getInegiSearchService({
                search_op: attr.json_form_elements.inegi_search_op
            });
            
            let validated_form_content = attr.is_current_month != undefined ? 
            (attr.is_current_month != true ? validateFormBySection({
                section: attr.section,
                json_form_elements: attr.json_form_elements
            }) : true) : validateFormBySection({
                section: attr.section,
                json_form_elements: attr.json_form_elements
            });
            
            attr.post_data = !attr.hasOwnProperty('post_data') ? {
                ...attr.json_form_elements
            } : attr.post_data;

            if(validated_form_content && inegi_service_url != null && attr.post_data != null){

                attr = attr.post_data != undefined ? attr : {
                    ...attr,
                    post_data: {}
                }

                $.ajax({
                    url: inegi_service_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ...attr.json_form_elements,
                        ...attr.post_data
                    },
                    cache: false
                }).done(function(response){

                    if(sections[attr.section].active){

                        if(response.state == 'success'){

                            handle_data.current_records_search_data = response.data;

                            attr.post_data = {
                                ...attr.post_data,
                                ...attr.json_form_elements,
                                data: response.data
                            }
    
                            drawRecordsTable({
                                ...attr,
                                service_url: getInegiTableTemplateService({
                                    search_op: attr.json_form_elements.inegi_search_op
                                }),
                                element_id: 'records-section'
                            });

                        }
                        else{
                            Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
                        }
                    }
                }).fail(function(){
        
                    attr.initial_interation++;
                    inegi_getRecords(attr);
                });
            }
        }
    }
    else{
        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
    }	
}


function getHiddenRecords(attr){

    console.log('inegi_getrec: ', attr);

    if(!attr.hasOwnProperty('initial_interation')){
        attr = {
            ...attr,
            initial_interation: 1,
            finish_interation: 10
        }
    }

    let inegi_service_url = 'service/get_hidden_records.php';

    if(attr.initial_interation < attr.finish_interation && inegi_service_url != null){

        $.ajax({
            url: inegi_service_url,
            type: 'POST',
            dataType: "json",
            data: attr.post_data,
            cache: false
        }).done(function(response){

            if(response.state == 'success'){

                let inegi_table_template_service_url = 'templates/tables/htmltoexcel/hidden_table.php';
                handle_data.current_records_search_data = response.data;
    
                formHTMLTableToExcel({
                    url_excel_template: inegi_table_template_service_url
                });
            }
            else{

                attr.initial_interation++;
                getHiddenRecords(attr);
            }

        }).fail(function(){

            attr.initial_interation++;
            getHiddenRecords(attr);
        });
    }
    else{
        Swal.fire(swal_messages.unexpected_dpe.title, swal_messages.unexpected_dpe.text, swal_messages.unexpected_dpe.type);
    }
}

function getSectionByMonth(attr){

    if(attr.hasOwnProperty('section')){

        getRecordsBySection({
            ...attr,
            json_form_elements: getCurrentMonthDateRange(),
            is_current_month: true
        });

    }
}