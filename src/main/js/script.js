$(document).ready(function(){ 
    console.log(sections);

    checkSession({
        success: {
            function: checkPermissions,
            attr: {
                success: {
                    functions: [
                        {
                            function: loadSection,
                            attr: 'recieved_folders'
                        }
                    ]
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

});

var test = "";

function loadSection(section){
    console.log(section);
    if(!sections[section].active){
        console.log('entre preload ', section);
        preloadValidation({
            section: section
        });
    }
}

function preloadValidation(attr){
    switch(attr.section){
        case 'inegi':
            loadForm({
                section: attr.section,
                success: {
                    functions: [
                        {
                            function: getInegiPendingAgreementsByMonth,
                            attr: {
                                section_id: 'inegi-pending-section'
                            }
                        },
                        {
                            function: activeSection,
                            attr: attr.section
                        },
                        {
                            function: changeInegiPanel,
                            attr: 'general'
                        },
                        {
                            function: getInegiRecordsByMonth,
                            attr: 'general'
                        }
                    ] 
                }
            });
            break;
        default:
            if(inegi.current.general_id == null){
                loadForm({
                    section: attr.section,
                    success: {
                        functions: [
                            {
                                function: resetInegi,
                                attr: null
                            },
                            {
                                function: activeSection,
                                attr: attr.section
                            },
                            {
                                function: loadDefaultValuesBySection,
                                attr: attr.section
                            },
                            {
                                function: getRecordsByMonth,
                                attr: attr.section
                            },
                            {
                                function: loadCatalogsBySection,
                                attr: {
                                    section: attr.section,
                                    template_file: {
                                        select: 'templates/elements/select.php',
                                        multiselect: 'templates/elements/multiselect.php'
                                    },
                                    service_location: 'service/catalogs/'
                                }
                            },
                            {
                                function: setMultiselectActionsBySection,
                                attr: attr.section
                            }
                        ] 
                    }
                });
            }
            else{
                Swal.fire({
                    title: 'Estas seguro?',
                    text: 'No será posible seguir capturando la información de la carpeta si cambias de sección!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                  }).then((result) => {
                    if (result.value) {
                        loadForm({
                            section: attr.section,
                            success: {
                                functions: [
                                    {
                                        function: resetInegi,
                                        attr: null
                                    },
                                    {
                                        function: activeSection,
                                        attr: attr.section
                                    },
                                    {
                                        function: loadDefaultValuesBySection,
                                        attr: attr.section
                                    },
                                    {
                                        function: getRecordsByMonth,
                                        attr: attr.section
                                    },
                                    {
                                        function: loadCatalogsBySection,
                                        attr: {
                                            section: attr.section,
                                            template_file: {
                                                select: 'templates/elements/select.php',
                                                multiselect: 'templates/elements/multiselect.php'
                                            },
                                            service_location: 'service/catalogs/'
                                        }
                                    }
                                ] 
                            }
                        });
                    // For more information about handling dismissals please visit
                    // https://sweetalert2.github.io/#handling-dismissals
                    }
                  });
            }
            
            break;
    }
    
}

function loadForm(attr){
    console.log('load? attr',attr);
    console.log('load? sections', sections);
    console.log('load? sec', attr.section);
    $.ajax({
        url:'forms/'+sections[attr.section].form_file,
        type:'POST',
        contentType:false,
        processData:false,
        cache:false
    }).done(function(response){

        console.log('lo hiciste?', sections[attr.section].form_file);
        $(".title").html(sections[attr.section].title);
        $("#content").html(response);
        /*activeSection(section);
        loadDefaultValuesBySection(section);
        getRecordsByMonth(section);
        loadCatalogsBySection({
            section: section,
            template_file: {
                select: 'templates/elements/select.php',
                multiselect: 'templates/elements/multiselect.php'
            },
            service_location: 'service/catalogs/'
        });*/

        for(func in attr.success.functions){
            attr.success.functions[func].function( attr.success.functions[func].attr);
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

            loadFramebar({
                data: response.permissions.framebar
            });

            for(func in attr.success.functions){
                attr.success.functions[func].function(attr.success.functions[func].attr);
            }
            
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
        addRemoveClassOnLateload({
            id: sections[element].navigation_element_id,
            class: 'active',
            add: false,
            counter: 1,
            iterations: 10,
            delay: 500
        });
    }

    sections[section].active = true;

    addRemoveClassOnLateload({
        id: sections[section].navigation_element_id,
        class: 'active',
        add: true,
        counter: 1,
        iterations: 10,
        delay: 500
    });
}

function loadDefaultValuesBySection(section){

    //handle_data.current_multiselect = {};

    let fields = sections[section].fields;

    for(field in fields){
        if(document.getElementById(fields[field].id)){

            if(fields[field].default != null){

                switch(fields[field].type){
                    case "date":
                        if(fields[field].default == "today"){
                            let today = new Date();
                            //today.setHours(today.getHours()+6); 
                            //today = today.toLocaleDateString("es-MX");
                            console.log('tod', today);
                            //document.getElementById(fields[field].id).valueAsDate = today;

                            var inp = document.getElementById(fields[field].id);

                            //var midnightUtcDate = inp.valueAsDate;

                            //inp.valueAsDate = new Date(midnightUtcDate.getUTCFullYear(), midnightUtcDate.getUTCMonth(), midnightUtcDate.getUTCDate());

                            var date1 = new Date();
date1 = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate()); // input expects requires year, month, day

//var input = document.createElement("input"); input.type = "date";

inp.valueAsDate = date1;
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

    setLoader({
        add: true
    });

    let fields = sections[section].fields;
    let data = {};
    let compleated = true;
    let multiselect = false;

    for(field in fields){
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
        setLoader({
            add: false
        });

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
                    current_section: attr.section,
                    element_id: 'agreement-nuc',
                    function: checkExistantRecievedFolder,
                    attr: {
                        element_id: 'agreement-nuc',
                        function: saveSection,
                        attr: {
                            section: attr.section,
                            data: attr.data,
                            success: {
                                functions: [
                                    {
                                        function: activeInegiForm,
                                        attr: {
                                            section: section
                                        },
                                        response: false
                                    },
                                    {
                                        function: resetDashboardAlert,
                                        attr: {
                                            element_id: 'dashboard-alert-section'
                                        },
                                        response: false
                                    }
                                ]
                            }    
                        }
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
                    current_section: attr.section,
                    element_id: 'folders-to-investigation-nuc',
                    function: checkExistantRecievedFolder,
                    attr: {
                        element_id: 'folders-to-investigation-nuc',
                        function: saveSection,
                        attr: {
                            section: attr.section,
                            data: attr.data
                        }
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
                    current_section: attr.section,
                    element_id: 'folders-to-validation-nuc',
                    function: checkExistantAgreement,
                    attr: {
                        element_id: 'folders-to-validation-nuc',
                        function: saveSection,
                        attr: {
                            section: attr.section,
                            data: attr.data
                        }
                    }
                }
            });
            break;
        case 'people_served':
            checkActivePeriod({
                element_id: 'people-served-date',
                section: 1,
                function: checkNuc,
                current_section: attr.section,
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
                    current_section: attr.section,
                    element_id: 'recieved-folders-nuc',
                    function: checkExistantEnteredFolder,
                    attr: {
                        element_id: 'recieved-folders-nuc',
                        function: saveSection,
                        attr: {
                            section: attr.section,
                            data: attr.data
                        }
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
                        current_section: attr.section,
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

    console.log('espero guarde: ', attr);

    $.ajax({
		url: 'service/'+sections[attr.section].create_file,
        type: 'POST',
        dataType : 'json', 
		data: {
			...attr.data
		},
		cache: false
	}).done(function(response){

        console.log('si wasd');


        if(response.state == 'success'){
            
            Swal.fire('Correcto', 'Datos guardados correctamente', 'success');
            
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

        setLoader({
            add: false
        });

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

function checkDuplicatedRecievedFolder(attr){

    if(document.getElementById(attr.element_id)){

        if(document.getElementById(attr.element_id).value.length == 13){
            
            $.ajax({  
                type: "POST",  
                url: "service/check_recieved_folder.php", 
                dataType : 'json', 
                data: {
                    nuc: document.getElementById(attr.element_id).value
                },
            }).done(function(response){

                if(response.state != "fail"){

                    if(response.data != null){
                        setLoader({
                            add: false
                        });

                        Swal.fire('NUC registrado!', 'El NUC que intenta capturar ya se encuentra registrado', 'warning');
                    }
                    else{
                        attr.function(attr.attr);
                    }
                }
                else{
                    setLoader({
                        add: false
                    });

                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            setLoader({
                add: false
            });

            Swal.fire('NUC no valido', 'El NUC debe contar con 13 dígitos', 'warning');
        }
    }
    else{
        setLoader({
            add: false
        });

        Swal.fire('Oops...', 'Ha ocurrido un error, intentelo de nuevo!', 'error');
    }
}

function checkExistantRecievedFolder(attr){

    if(document.getElementById(attr.element_id)){

        if(document.getElementById(attr.element_id).value.length == 13){
            
            $.ajax({  
                type: "POST",  
                url: "service/check_recieved_folder.php", 
                dataType : 'json', 
                data: {
                    nuc: document.getElementById(attr.element_id).value
                },
            }).done(function(response){

                if(response.state != "fail"){

                    if(response.data != null){
                        attr.function(attr.attr);
                    }
                    else{
                        setLoader({
                            add: false
                        });

                        Swal.fire('NUC no registrado en CARPETAS RECIBIDAS!', 'Verifique que el NUC ya haya sido capturado en CARPETAS RECIBIDAS para continuar', 'warning');
                    }
                }
                else{
                    setLoader({
                        add: false
                    });

                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            setLoader({
                add: false
            });

            Swal.fire('NUC no valido', 'El NUC debe contar con 13 dígitos', 'warning');
        }
    }
    else{
        setLoader({
            add: false
        });

        Swal.fire('Oops...', 'Ha ocurrido un error, intentelo de nuevo!', 'error');
    }
}

function checkExistantEnteredFolder(attr){

    console.log('check existant folder?: ', attr);

    if(document.getElementById(attr.element_id)){

        if(document.getElementById(attr.element_id).value.length == 13){
            
            $.ajax({  
                type: "POST",  
                url: "service/check_entered_folder.php", 
                dataType : 'json', 
                data: {
                    nuc: document.getElementById(attr.element_id).value
                },
            }).done(function(response){

                if(response.state != "fail"){

                    if(response.data != null){
                        attr.function(attr.attr);
                    }
                    else{
                        setLoader({
                            add: false
                        });

                        Swal.fire('NUC no registrado en CARPETAS INGRESADAS!', 'Verifique que el NUC ya haya sido capturado en CARPETAS INGRESADAS para continuar', 'warning');
                    }
                }
                else{
                    setLoader({
                        add: false
                    });

                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            setLoader({
                add: false
            });

            Swal.fire('NUC no valido', 'El NUC debe contar con 13 dígitos', 'warning');
        }
    }
    else{
        setLoader({
            add: false
        });

        Swal.fire('Oops...', 'Ha ocurrido un error, intentelo de nuevo!', 'error');
    }
}

function checkExistantAgreement(attr){

    if(document.getElementById(attr.element_id)){

        if(document.getElementById(attr.element_id).value.length == 13){
            
            $.ajax({  
                type: "POST",  
                url: "service/check_agreement.php", 
                dataType : 'json', 
                data: {
                    nuc: document.getElementById(attr.element_id).value
                },
            }).done(function(response){

                if(response.state != "fail"){

                    if(response.data != null){
                        attr.function(attr.attr);
                    }
                    else{
                        setLoader({
                            add: false
                        });

                        Swal.fire('NUC no registrado en ACUERDOS CELEBRADOS!', 'Verifique que el NUC ya haya sido capturado en ACUERDOS CELEBRADOS para continuar', 'warning');
                    }
                }
                else{
                    setLoader({
                        add: false
                    });

                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            setLoader({
                add: false
            });

            Swal.fire('NUC no valido', 'El NUC debe contar con 13 dígitos', 'warning');
        }
    }
    else{
        setLoader({
            add: false
        });

        Swal.fire('Oops...', 'Ha ocurrido un error, intentelo de nuevo!', 'error');
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

                        let some_sec = ['entered_folders', 'people_served'];

                        console.log('attr de check nuc: ', attr);

                        console.log('attr.attr de check nuc: ', attr.attr);

                        console.log('section de check nuc: ', attr.attr.section);

                        if(attr.attr.section == 'people_served' || attr.attr.section == 'entered_folders'){
                            attr.attr.data = {
                                ...attr.attr.data,
                                sigi_date: response.data.date.date
                            }
                        }
                        else{
                            if(attr.element_id != 'inegi-general-nuc'){
                                attr.attr.attr.data = {
                                    ...attr.attr.attr.data,
                                    sigi_date: response.data.date.date
                                }
                            }
                            
                        }

                        

                        console.log('voy a guardar sigi fecha: ', attr.attr);

                        attr.function(attr.attr);

                        //Swal.fire('NUC verificado', 'NUC registrado con el delito de: '+response.data.crime, 'success');
                    }
                    else{
                        setLoader({
                            add: false
                        });
                        
                        Swal.fire('NUC no encontrado', 'Verifique el NUC!', 'warning');
                    }
                }
                else{
                    setLoader({
                        add: false
                    });

                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                
            }); 
        }
        else{
            setLoader({
                add: false
            });

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
/* GOOD TRY
function getRecordsByMonth(section){

    console.log('by moneh?', section);

    let date = new Date();
    date.setHours(date.getHours()+6); 

    if(sections[section].records_by_month_file != null){
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
                data: response.data,
                file: 'templates/tables/records_by_month_table.php',
                headers: response.headers
            });
        });
    }

	
}

function drawRecordsTable(attr){
	console.log('draw_t');
	$.ajax({
		url: attr.file,
		type: 'POST',
		dataType: "html",
		data: {
			data: attr.data,
            headers: attr.headers
		},
		cache: false
	}).done(function(response){
		$('#records-section').html(response);
	});
}
*/

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
            console.log('res de month:', JSON.stringify(response));
            
            drawRecordsTable({
                section: section,
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
            console.log('sec inegi', attr.section);
            if(sections[attr.section].active){
                $('#'+attr.element_id).html(response);
            }
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

                console.log('tod bef: ', today);

                today = today.toLocaleDateString("es-MX");

                console.log('daily noup: ', today);
                console.log('daily noup form da: ', form_date_mx);

                if(form_date_mx != today){
                    //console.log('daily noup: ', today);
                    //console.log('daily noup form da: ', form_date_mx);

                    setLoader({
                        add: false
                    });

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
                    setLoader({
                        add: false
                    });
    
                    Swal.fire('Fecha fuera de periodo de captura de captura', 'Ingrese una fecha de captura valida', 'warning');
                }
            }
    
    
        });
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

function setValueOnLateLoad(attr){

	if(attr.counter <= attr.iterations){
		setTimeout(
			function(){
				if(document.getElementById(attr.id)){
					if(attr.value == null){
						attr.value = 0;
					}
					switch(attr.type){

						default:

							document.getElementById(attr.id).value = attr.value;
					}

                    if(attr.success != null){
                        for(func in attr.success.functions){
                            attr.success.functions[func].function(attr.success.functions[func].attr);
                        }
                    }

				}
				else{
					attr.counter++;
					setValueOnLateLoad(attr);
				}
			}, attr.delay
		);
	}
}

function disableInput(attr){
    if(document.getElementById(attr.id)){
        document.getElementById(attr.id).disabled = true;
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





function setLoader(attr){
    if(attr.add){
        $('#loader-div').addClass('loader');
    }
    else{
        $('#loader-div').removeClass('loader');
    }
}

function setStaticLoader(attr){
    $('#'+attr.section_id).html('<div class="'+attr.class+'">Cargando datos... </div>');
}

function addRemoveClassOnLateload(attr){
    if(attr.counter <= attr.iterations && !document.getElementById(attr.id)){
		setTimeout(
			function(){
				attr.counter++;
				addRemoveClassOnLateload(attr);
			}, attr.delay
		);
	}
    else{
        if(attr.add){
            $('#'+attr.id).addClass(attr.class);
            console.log('add: ', attr.id);
        }
        else{
            $('#'+attr.id).removeClass(attr.class);
            console.log('remove: ', attr.id);
        }
    }
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