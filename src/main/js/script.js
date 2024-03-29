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
                            attr: null
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
    if(section == null)
        section = handle_data.main_section;
    console.log('loading sec: ',section);
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
                                attr: {
                                    section: attr.section
                                }
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
                                        attr: {
                                            section: attr.section
                                        }
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
    handle_data.people_served.people = {};
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

            checkAgreementsAddedPeople({
                function: checkActivePeriod,
                attr: {
                    element_id: 'agreement-date',
                    section: 1,
                    function: checkNuc,
                    attr: {
                        section: attr.section,
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
                                        },
                                        {
                                            function: savePeopleSectionAfterAgreement,
                                            attr: {
                                                element_id: 'agreement-nuc',
                                                section: 'people_served',
                                                data: attr.data
                                            },
                                            response: false
                                        }
                                    ]
                                }
                            }
                        }
                    }
                }
            });
            /*console.log('agg');
            checkActivePeriod({
                element_id: 'agreement-date',
                section: 1,
                function: checkNuc,
                attr: {
                    section: attr.section,
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
            });*/
            break;
        case 'folders_to_investigation':
            checkActivePeriod({
                element_id: 'folders-to-investigation-date',
                section: 1,
                function: checkNuc,
                attr: {
                    section: attr.section,
                    element_id: 'folders-to-investigation-nuc',
                    function: checkExistantRecievedFolder,
                    attr: {
                        element_id: 'folders-to-investigation-nuc',
                        function: checkRepeatedNucDate,
                        attr: {
                            section: attr.section,
                            element_date_id: 'folders-to-investigation-date',
                            element_nuc_id: 'folders-to-investigation-nuc',
                            service_file: 'check_repeated_folders_to_investigation_nuc_date.php',
                            function: saveSection,
                            attr: {
                                section: attr.section,
                                data: attr.data
                            }
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
                    section: attr.section,
                    element_id: 'folders-to-validation-nuc',
                    function: checkExistantAgreement,
                    attr: {
                        element_id: 'folders-to-validation-nuc',
                        function: checkRepeatedNucDate,
                        attr: {
                            section: attr.section,
                            element_date_id: 'folders-to-validation-date',
                            element_nuc_id: 'folders-to-validation-nuc',
                            service_file: 'check_repeated_folders_to_validation_nuc_date.php',
                            function: saveSection,
                            attr: {
                                section: attr.section,
                                data: attr.data
                            }
                        }
                    }
                }
            });
            break;
        case 'people_served':
            checkPeopleServedAddedPeople({
                function: checkActivePeriod,
                attr: {
                    element_id: 'people-served-date',
                    section: 1,
                    function: checkNuc,
                    attr: {
                        section: attr.section,
                        element_id: 'people-served-nuc',
                        function: checkExistantEnteredFolder,
                        attr: {
                            element_id: 'people-served-nuc',
                            function: saveSection,
                            attr: {
                                section: attr.section,
                                data: attr.data
                            }
                        }
                    }
                }
            });


            /*checkPeopleServedAddedPeople({
                function: checkActivePeriod,
                attr: {
                    element_id: 'people-served-date',
                    section: 1,
                    function: checkNuc,
                    section: attr.section,
                    attr: {
                        element_id: 'people-served-nuc',
                        function: saveSection,
                        attr: {
                            section: attr.section,
                            data: attr.data
                        }
                    }
                }
            });*/




            /*checkActivePeriod({
                element_id: 'people-served-date',
                section: 1,
                function: checkNuc,
                section: attr.section,
                attr: {
                    element_id: 'people-served-nuc',
                    function: saveSection,
                    attr: {
                        section: attr.section,
                        data: attr.data
                    }
                }
            });*/
            break;
        case 'recieved_folders':
            checkActivePeriod({
                element_id: 'recieved-folders-date',
                section: 1,
                function: checkNuc,
                attr: {
                    section: attr.section,
                    element_id: 'recieved-folders-nuc',
                    function: checkExistantEnteredFolder,
                    attr: {
                        element_id: 'recieved-folders-nuc',
                        function: checkRepeatedNucDate,
                        attr: {
                            section: attr.section,
                            element_date_id: 'recieved-folders-date',
                            element_nuc_id: 'recieved-folders-nuc',
                            service_file: 'check_repeated_recieved_folder_nuc_date.php',
                            function: saveSection,
                            attr: {
                                section: attr.section,
                                data: attr.data
                            }
                        }
                    }
                }
            });
            break;
        case 'entered_folders':
                checkActivePeriod({
                    element_id: 'entered-folders-date',
                    section: 3,
                    function: checkNuc,
                    attr: {
                        section: attr.section,
                        element_id: 'entered-folders-nuc',
                        function: checkRepeatedNucDate,
                        attr: {
                            section: attr.section,
                            element_date_id: 'entered-folders-date',
                            element_nuc_id: 'entered-folders-nuc',
                            service_file: 'check_repeated_entered_folder_nuc_date.php',
                            function: saveSection,
                            attr: {
                                section: attr.section,
                                data: attr.data
                            }
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
                        section: attr.section,
                        element_id: 'entered-folders-nuc',
                        function: checkRepeatedNucDate,
                        attr: {
                            section: attr.section,
                            element_date_id: 'entered-folders-date',
                            element_nuc_id: 'entered-folders-nuc',
                            service_file: 'check_repeated_entered_folder_nuc_date.php',
                            function: saveSection,
                            attr: {
                                section: attr.section,
                                data: attr.data
                            }
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

    /*if(handle_data.sigi_dates.hasOwnProperty(attr.data.nuc)){
        attr.data = {
            ...attr.data,
            sigi_date: handle_data.sigi_dates[attr.data.nuc]
        }
    }*/

    $.ajax({
		url: 'service/'+sections[attr.section].create_file,
        type: 'POST',
        dataType : 'json', 
		data: {
			...attr.data,
            recieved_folders_data: handle_data.current_recieved_folders_data,
            entered_folders_data: handle_data.current_folders_data,
            agreement_data: handle_data.current_agreement_data,
            sigi_date: handle_data.current_sigi_date
		},
		cache: false
	}).done(function(response){

        console.log('si wasd');


        if(response.state == 'success'){
            
            Swal.fire('Correcto', 'Datos guardados correctamente', 'success');
            
            //loadDefaultValuesBySection(attr.section);
            //getRecordsByMonth(attr.section);

            if(response.data.id != null){
                
            
                if(attr.section == 'agreements'){
                    /*savePeopleSectionAfterAgreement({
                        data: {
                            sigi_date: attr.data.sigi_date,
                            people_served_date: attr.data.agreement_date,
                            people_served_nuc: attr.data.agreement_nuc,
                            people_served_number: attr.data.agreement_intervention,
                            people_served_unity: attr.data.agreement_unity,
                            served_people_array: attr.data.served_people_array,
                            recieved_folders_data: attr.data.recieved_folders_data,
                            agreement_id: response.data.id
                        },
                        multiselect: handle_data.current_multiselect['agreement_crime']
                    });*/

                    savePeopleSectionAfterAgreement({
                        data: {
                            sigi_date: handle_data.current_sigi_date,
                            people_served_date: attr.data.agreement_date,
                            people_served_nuc: attr.data.agreement_nuc,
                            people_served_number: attr.data.agreement_intervention,
                            people_served_unity: attr.data.agreement_unity,
                            served_people_array: attr.data.served_people_array,
                            recieved_folders_data: handle_data.current_recieved_folders_data,
                            agreement_id: response.data.id
                        },
                        multiselect: handle_data.current_multiselect['agreement_crime']
                    });

                    $('#people-served-table-section').html('');
                    $('#people-served-table-count').html('');

                    handle_data.people_served.people = {};

                    /*drawTableByElements({
                        data: handle_data.people_served.people,
                        file: 'templates/tables/default_table.php',
                        placement_element_id: 'people-served-table-section',
                        section: 'people_served'
                    });
                
                    drawPeopleCount();*/

                }
                if(attr.section == 'people_served'){

                    console.log('entre a served');


                    $('#people-served-table-section').html('');
                    $('#people-served-table-count').html('');

                    handle_data.people_served.people = {};

                    /*drawTableByElements({
                        data: handle_data.people_served.people,
                        file: 'templates/tables/default_table.php',
                        placement_element_id: 'people-served-table-section',
                        section: 'people_served'
                    });
                
                    drawPeopleCount();*/
                }

                saveMultiselectFieldsBySection({
                    id: response.data.id,
                    section: attr.section 
                });
            
            }

            loadDefaultValuesBySection(attr.section);
            
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

    spetialResetBySection(section);

    resetMultiselect();
}

function spetialResetBySection(section){
    switch(section){
        case 'people_served':
            handle_data.people_served.people = {};
            break;
        default:
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

                        /*attr.attr.data = {
                            ...attr.attr.data,
                            recieved_folders_data: response.data
                        }*/

                        handle_data.current_recieved_folders_data = response.data

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
                        
                        /*attr.attr.data = {
                            ...attr.attr.data,
                            entered_folders_data: response.data
                        }*/

                        handle_data.current_folders_data = response.data

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

                        /*attr.attr.data = {
                            ...attr.attr.data,
                            agreement_data: response.data
                        }*/

                        handle_data.current_agreement_data = response.data;

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

                        handle_data.current_sigi_date = response.data.date.date;

                        /*handle_data.sigi_dates = {
                            ...handle_data.sigi_dates,
                            [document.getElementById(attr.element_id).value]: response.data.date.date
                        }*/

                        /*let some_sec = ['entered_folders', 'people_served'];

                        console.log('attr de check nuc: ', attr);

                        console.log('attr.attr de check nuc: ', attr.attr);

                        console.log('section de check nuc: ', attr.section);

                        if(attr.section == 'people_served' || section == 'entered_folders' || attr.section == 'entered_folders_super'){

                            console.log('served entered: ', attr);

                            attr.attr.data = {
                                ...attr.attr.data,
                                sigi_date: response.data.date.date
                            }
                        }
                        else if(attr.section == 'folders_to_investigation' || attr.section == 'folders_to_validation'){

                            console.log('inves valida: ', attr);

                            attr.attr.attr.attr.data = {
                                ...attr.attr.attr.attr.data,
                                sigi_date: response.data.date.date
                            }
                        }
                        else{
                            console.log('else: ', attr);
                            if(attr.element_id != 'inegi-general-nuc'){
                                console.log('inegi?: ', attr);
                                attr.attr.attr.data = {
                                    ...attr.attr.attr.data,
                                    sigi_date: response.data.date.date
                                }
                            }
                        }*/

                        /*let some_sec = ['entered_folders', 'people_served'];

                        console.log('attr de check nuc: ', attr);

                        console.log('attr.attr de check nuc: ', attr.attr);

                        console.log('section de check nuc: ', attr.attr.section);

                        if(attr.attr.section == 'people_served' || attr.attr.section == 'entered_folders' || attr.attr.section == 'entered_folders_super'){
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
                            
                        }*/

                        

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

function getRecordsByMonth(attr){

    if(!attr.hasOwnProperty('initial_interation')){
        attr = {
            ...attr,
            initial_interation: 1,
            finish_interation: 10
        }
    }

    if(attr.initial_interation < attr.finish_interation){

        console.log('by moneh?', attr.section);

        let date = new Date();
        //date.setHours(date.getHours()+6); 

        if(sections[attr.section].records_by_month_file != null){

            setStaticLoader({
                section_id: 'records-section',
                class: 'static-loader'
            });

            $.ajax({
                url:'service/'+sections[attr.section].records_by_month_file,
                type:'POST',
                dataType: "json",
                data: {
                    month: (date.getMonth()+1),
                    year: date.getFullYear()
                },
                cache:false
            }).done(function(response){
                console.log('res de month:', JSON.stringify(response));

                if(sections[attr.section].active){
                    handle_data.current_records_search_data = response;
                }
                
                drawRecordsTable({
                    section: attr.section,
                    data: response,
                    file: 'templates/tables/'+attr.section+'_table.php',
                    element_id: 'records-section'
                });
            }).fail(function(){

                attr.initial_interation++;

                console.log('attr +iteration', attr);

                getRecordsByMonth(attr);
            });
        }
    }
    else{
        Swal.fire('error', 'Ha ocurrido un error inesperado, favor de contactar a DPE', 'error');
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

                /*if(attr.section == 'agreements')

                $('#agreement-table').DataTable({
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "_START_ - _END_ / _TOTAL_ Registros",
                        "infoEmpty": "Sin registros",
                        "infoFiltered": "(Filtrado de _MAX_ registros)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Muestra de _MENU_ registros",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    }
                });*/
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
        case 'agreements':
        case 'folders_to_investigation':
        case 'folders_to_validation':
        case 'entered_folders':
            if(document.getElementById('search-nuc') && document.getElementById('search-initial-date') && document.getElementById('search-finish-date')){
                attr = {
                    initial_date: document.getElementById('search-initial-date').value,
                    finish_date: document.getElementById('search-finish-date').value,
                    nuc: document.getElementById('search-nuc').value
                }

                if(document.getElementById('search-nuc').value != '' || (document.getElementById('search-initial-date').value != '' && document.getElementById('search-finish-date').value != '')){
                    validated = true;

                    //$('#month-records-label-section').html('');

                }
                else{
                    Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
                }
            }
            break;
        case 'recieved_folders':
            if(document.getElementById('search-nuc') && document.getElementById('search-initial-date') && document.getElementById('search-finish-date')){
                attr = {
                    initial_date: document.getElementById('search-initial-date').value,
                    finish_date: document.getElementById('search-finish-date').value,
                    nuc: document.getElementById('search-nuc').value
                }

                if(document.getElementById('search-nuc').value != '' || (document.getElementById('search-initial-date').value != '' && document.getElementById('search-finish-date').value != '')){
                    validated = true;

                    //$('#month-records-label-section').html('');

                }
                else{
                    Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
                }
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
        setStaticLoader({
            section_id: 'records-section',
            class: 'static-loader'
        });
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


            /*if(section == 'processing_folders' || section == 'inegi'){
                drawRecordsTable({
                    data: response,
                    file: 'templates/tables/'+section+'_table.php',
                    element_id: 'records-section'
                });
                
            }
            else{
                getNucsDate({
                    func: drawRecordsTable,
                    attr: {
                        data: response,
                        file: 'templates/tables/'+section+'_table.php',
                        element_id: 'records-section',
                        nuc_dates: null
                    },
                    section: section
                });
            }*/

            if(sections[section].active){
                handle_data.current_records_search_data = response;
            }

            drawRecordsTable({
                section: section,
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



function loadSearchForm(section){

    $.ajax({
        url:'forms/search/'+sections[section].search_form_file,
        type:'POST',
        contentType:false,
        processData:false,
        cache:false
    }).done(function(response){

        console.log('lo hiciste?', sections[section].search_form_file);
        //$(".title").html(sections[attr.section].title);
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

        /*for(func in attr.success.functions){
            attr.success.functions[func].function( attr.success.functions[func].attr);
        }*/

    });
}

function softLoadForm(section){
    //$('#month-records-label-section').html('');
    loadForm({
        section: section,
        success: {
            functions: [
                {
                    function: loadDefaultValuesBySection,
                    attr: section
                },
                {
                    function: getRecordsByMonth,
                    attr: {
                        section: section
                    }
                },
                {
                    function: loadCatalogsBySection,
                    attr: {
                        section: section,
                        template_file: {
                            select: 'templates/elements/select.php',
                            multiselect: 'templates/elements/multiselect.php'
                        },
                        service_location: 'service/catalogs/'
                    }
                },
                {
                    function: setMultiselectActionsBySection,
                    attr: section
                }
            ] 
        }
    });
}

function addServedPeopleBySection(section){
    
    served_people_attr = {
        gener: {
            element_id: 'people-served-gener',
            type: 'text',
            default: ""
        },
        age: {
            element_id: 'people-served-age',
            type: 'text',
            default: ""
        },
        name: {
            element_id: 'people-served-name',
            type: 'text',
            default: ""
        },
        ap: {
            element_id: 'people-served-ap',
            type: 'text',
            default: ""
        },
        am: {
            element_id: 'people-served-am',
            type: 'text',
            default: ""
        },
        type: {
            element_id: 'people-served-type',
            type: 'text',
            default: ""
        }
    }

    if(validateElements({
        elements: served_people_attr
    })){

        let random_id = 0;

        do{
            random_id = getRandomInt(1000, 9999);
        }while(handle_data.people_served.people.hasOwnProperty(random_id));

        handle_data.people_served.people = {
            ...handle_data.people_served.people,
            [random_id]: {
                age: document.getElementById(served_people_attr.age.element_id).value,
                gener: document.getElementById(served_people_attr.gener.element_id).value,
                name: document.getElementById(served_people_attr.name.element_id).value,
                ap: document.getElementById(served_people_attr.ap.element_id).value,
                am: document.getElementById(served_people_attr.am.element_id).value,
                type: document.getElementById(served_people_attr.type.element_id).value,
                id: random_id
            }
        }

        resetElements({
            elements: served_people_attr
        });

        drawTableByElements({
            data: handle_data.people_served.people,
            file: 'templates/tables/default_table.php',
            placement_element_id: 'people-served-table-section',
            section: section
        });

        drawPeopleCount();

        //checkPeopleType();

    }
    else{
        Swal.fire('Campos faltantes', 'Tiene que completar alguno de los campos para completar la busqueda', 'warning');
    }
}

function removeServedPeople(random_id){

    /*if(handle_data.people_served.people[random_id].type == 'Requerido'){
        addOptionToSelect({
            select_element_id: 'people-served-type',
            select_add_value: 'Requerido'
        });
    }
    else if(handle_data.people_served.people[random_id].type == 'Solicitante'){
        addOptionToSelect({
            select_element_id: 'people-served-type',
            select_add_value: 'Solicitante'
        });
    }*/

    delete handle_data.people_served.people[random_id];

    drawTableByElements({
        data: handle_data.people_served.people,
        file: 'templates/tables/default_table.php',
        placement_element_id: 'people-served-table-section',
        section: 'people_served'
    });

    /*setTimeout(
        function(){
            drawTableByElements({
                data: handle_data.people_served.people,
                file: 'templates/tables/default_table.php',
                placement_element_id: 'people-served-table-section',
                section: 'people_served'
            });
        }, 500
    );*/

    drawPeopleCount();
}

function drawPeopleCount(){
    $('#people-served-table-count h3').html('Personas atendidas: '+Object.keys(handle_data.people_served.people).length);
}

function checkPeopleType(){


    for(element in handle_data.people_served.people){

        if(handle_data.people_served.people[element].type == 'Requerido'){

            removeElementFromSelect({
                select_element_id: 'people-served-type',
                select_remove_value: 'Requerido'
            });
        }
        else if(handle_data.people_served.people[element].type == 'Solicitante'){

            removeElementFromSelect({
                select_element_id: 'people-served-type',
                select_remove_value: 'Solicitante'
            });
        }
    }
}

function removeElementFromSelect(attr){

    let selectobject = document.getElementById(attr.select_element_id);

    for (let i=0; i < selectobject.length; i++){
        if (selectobject.options[i].value == attr.select_remove_value){
            selectobject.remove(i);
        } 
    }
}

function addOptionToSelect(attr){

    if(document.getElementById(attr.select_element_id)){

        let selectobject = document.getElementById(attr.select_element_id);

        let opt = document.createElement('option');
    
        opt.value = attr.select_add_value;
        opt.innerHTML = attr.select_add_value;
        selectobject.appendChild(opt);
    }
}

function validateElements(attr){

    let elements = attr.elements;
    let validated = true;

    for(element in elements){
        if(document.getElementById(elements[element].element_id)){
            switch(elements[element].type){
                case 'number':
                    if(document.getElementById(elements[element].element_id).value < 0){
                        validated = false;
                    }
                    break;
                case 'text':
                    if(document.getElementById(elements[element].element_id).value == ""){
                        validated = false;
                    }
                    break;
                default:
            }
        }
        else{
            validated = false;
        }
    }

    return validated;
}

function resetElements(attr){

    let elements = attr.elements;
    let validated = true;

    for(element in elements){
        if(document.getElementById(elements[element].element_id)){
            switch(elements[element].type){
                case 'number':
                    document.getElementById(elements[element].element_id).value = elements[element].default
                    break;
                case 'text':
                    document.getElementById(elements[element].element_id).value = elements[element].default
                    break;
                default:
            }
        }
        else{
            validated = false;
        }
    }

    return validated;
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

function drawTableByElements(attr){

    console.log('entre a draw');

    if(attr.data != null){

        console.log('data dif de null');

        if(Object.keys(attr.data).length > 0){

            console.log('key mas de 0');
            $.ajax({
                url: attr.file,
                type: 'POST',
                dataType: "html",
                data: {
                    data: JSON.stringify(attr.data)
                },
                cache: false
            }).done(function(response){
                
                if(sections[attr.section].active){

                    console.log('draw active section ');
                    $('#'+attr.placement_element_id).html(response);
                }
                else{
                    console.log('draw no active section ');
                    $('#'+attr.placement_element_id).html(response);
                }
            });
        }
        else{

            console.log('load dashboard');
            loadDashboardAlert({
                template_file: 'templates/elements/dashboard_alert.php',
                element_id: attr.placement_element_id,
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
        loadDashboardAlert({
            template_file: 'templates/elements/dashboard_alert.php',
            element_id: attr.placement_element_id,
            element_attr: {
                attr: {
                    type: 'secondary',
                    message: 'No hay registros!'
                }
            } 
        });
    }
}

function checkPeopleServedAddedPeople(attr){

    console.log('attr de added people: ', attr);

    if(handle_data.people_served.people != null){

        console.log('entre a chek aded: ', Object.keys(handle_data.people_served.people).length);

        if(Object.keys(handle_data.people_served.people).length > 0){

            
            attr.attr.attr.attr.attr.data = {
                ...attr.attr.attr.attr.attr.data,
                people_served_number: Object.keys(handle_data.people_served.people).length,
                served_people_array: JSON.stringify(handle_data.people_served.people)
            }

            console.log('entre a if mas de 0 que tengo: ', attr.attr);

            attr.function(attr.attr);
        }
        else{
            setLoader({
                add: false
            });

            Swal.fire('Campos faltantes', 'Tiene que agregar por lo menos a una persona', 'warning');
        }
    }
    else{
        setLoader({
            add: false
        });

        Swal.fire('Campos faltantes', 'Tiene que agregar por lo menos a una persona', 'warning');
    }
}

function checkAgreementsAddedPeople(attr){

    console.log('cheking ...');

    console.log('attr de added people agreements: ', attr);

    if(handle_data.people_served.people != null){

        console.log('entre a chek aded: ', Object.keys(handle_data.people_served.people).length);

        if(Object.keys(handle_data.people_served.people).length > 1){

            let sol = false;
            let req = false;

            for(element in handle_data.people_served.people){

                if(handle_data.people_served.people[element].type == 'Requerido'){
        
                    req = true;
                }
                else if(handle_data.people_served.people[element].type == 'Solicitante'){
        
                    sol = true;
                }
            }

            if(sol && req){

                attr.attr.attr.attr.attr.data = {
                    ...attr.attr.attr.attr.attr.data,
                    agreement_intervention: Object.keys(handle_data.people_served.people).length,
                    served_people_array: JSON.stringify(handle_data.people_served.people)
                }

                attr.function(attr.attr);
            }
            else if(!sol){
                setLoader({
                    add: false
                });

                Swal.fire('Campos faltantes', 'Debe haber por lo menos una persona en calidad de solicitante', 'warning');
            }
            else if(!req){
                setLoader({
                    add: false
                });

                Swal.fire('Campos faltantes', 'Debe haber por lo menos una persona en calidad de requerido', 'warning');
            }
        }
        else{
            setLoader({
                add: false
            });

            Swal.fire('Campos faltantes', 'Tiene que agregar por lo menos a 2 personas', 'warning');
        }
    }
    else{
        setLoader({
            add: false
        });

        Swal.fire('Campos faltantes', 'Tiene que agregar por lo menos a 2 personas', 'warning');
    }
}

function savePeopleSectionAfterAgreement(attr){

    console.log('espero guarde people after agreements: ', attr);

    $.ajax({
		url: 'service/'+sections['people_served'].create_file,
        type: 'POST',
        dataType : 'json', 
		data: {
			...attr.data
		},
		cache: false
	}).done(function(response){

        console.log('si wasd');


        if(response.state == 'success'){
            
            //Swal.fire('Correcto', 'Datos guardados correctamente', 'success');
            
            //loadDefaultValuesBySection(attr.section);
            //getRecordsByMonth(attr.section);

            if(response.data.id != null){
                /*saveMultiselectFieldsBySection({
                    id: response.data.id,
                    section: 'people_served'
                });*/

                saveMultiselectPeopleCrimesAfterAgreement({
                    section: 'people_served',
                    service_file: 'crimes/create_people_served_crimes.php',
                    post_data: {
                        id: response.data.id,
                        data: attr.multiselect
                    }
                });
            }
            
            console.log('chido chido', response);
            console.log('chido lo', response.state);
        }
        else{

            //Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');

            console.log('not chido', response);
            console.log('chido no lo', response.state);
        }

        setLoader({
            add: false
        });

	}).fail(function (jqXHR, textStatus) {
        //Swal.fire('Error', 'Ha ocurrido un error inesperado del servidor, Favor de nofificar a DPE.', 'error');

        setLoader({
            add: false
        });
    });
    
}

function saveMultiselectPeopleCrimesAfterAgreement(attr){

    console.log('save multiple: ', attr);

    $.ajax({
		url: 'service/'+attr.service_file,
        type: 'POST',
        dataType : 'json', 
		data: attr.post_data,
		cache: false
	}).done(function(response){

        console.log('si wasd');


        if(response.state == 'success'){
            
            Swal.fire('Correcto', 'Datos guardados correctamente', 'success');

            console.log('chido chido', response);

            //resetSection(attr.section);

        }
        else{

            Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');

            console.log('not chido', response);
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

function setDateField(attr){

    switch(attr.set_date){

        case 'today':

            let today = new Date();

            var date_input = document.getElementById(attr.element_id);

            today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

            date_input.valueAsDate = today;

            break;
        default:
    }
}

function checkRepeatedNucDate(attr){

    if(document.getElementById(attr.element_date_id) && document.getElementById(attr.element_nuc_id)){

        if(document.getElementById(attr.element_date_id).value != '' && document.getElementById(attr.element_nuc_id).value != ''){
            
            $.ajax({  
                type: "POST",  
                url: "service/"+attr.service_file, 
                dataType : 'json', 
                data: {
                    nuc: document.getElementById(attr.element_nuc_id).value,
                    date: document.getElementById(attr.element_date_id).value
                },
            }).done(function(response){

                if(response.state != "fail"){

                    if(response.state != 'founded'){

                        attr.function(attr.attr);
                    }
                    else{
                        setLoader({
                            add: false
                        });

                        Swal.fire('NUC existente registrado con misma fecha!', 'Verifique la fecha correcta del NUC que quiere capturar para continuar', 'warning');
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