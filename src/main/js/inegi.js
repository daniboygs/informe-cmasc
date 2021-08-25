function changeInegiPanel(section){

    console.log('section: ', section);
    console.log('inegi: ', inegi);

    /*if(section != 'general'){
        showSections({
            sections: [
                {
                    id: 'month-records-label-section',
                    show: false
                },
                {
                    id: 'records-section',
                    show: false
                }
            ]
        });
    }
    else{
        showSections({
            sections: [
                {
                    id: 'month-records-label-section',
                    show: true
                },
                {
                    id: 'records-section',
                    show: true
                }
            ]
        });
    }*/

    

    if(inegi.active || (!inegi.active && inegi.sections[section].main_form)){
        if(!inegi.sections[section].active){
            loadInegiForm({
                section: section,
                url: 'forms/inegi/'+inegi.sections[section].form_file,
                success: {
                    functions: [
                        {
                            function: activeInegiForm,
                            attr: {
                                section: section
                            }
                        },
                        {
                            function: resetDashboardAlert,
                            attr: {
                                element_id: 'dashboard-alert-section'
                            }
                        },
                        {
                            function: loadInegiCatalogsBySection,
                            attr: {
                                section: section,
                                template_file: 'templates/elements/select.php',
                                service_location: 'service/catalogs/'
                            }
                        },
                        /*{
                            function: getInegiRecordsByMonth,
                            attr: section
                        },*/
                        {
                            function: getInegiCurrentRecordBySectionAndID,
                            attr: {
                                section: section,
                                general_id: inegi.current.general_id
                            }
                        },
                        {
                            function: loadInegiDefaultValuesBySection,
                            attr: section
                        },
                        {
                            function: getInegiPreloadedDataBySection,
                            attr: {
                                service_file: 'service/inegi/get_inegi_general_preloaded_data.php',
                                attr: {
                                    general_id: inegi.current.general_id,
                                    nuc: inegi.current.nuc,
                                    recieved_id: inegi.current.recieved_id,
                                    agreement_id: inegi.current.agreement_id
                                },
                                section: section,
                                success: {
                                    functions: [
                                        {
                                            function: loadInegiPreloadedData,
                                            attr: {
                                                section: section,
                                                data: null
                                            },
                                            response: 'data'
                                        }
                                    ]
                                }
                            }
                        }
                    ]
                }
            });
        }
	}
	else{
		Swal.fire('Ingrese los datos generales!', 'Ingrese los datos generales para continuar', 'error');
	}
}

function activeInegiForm(attr){
    console.log('active: ', attr);
	if(!inegi.sections[attr.section].active){
		for(section in inegi.sections){
            console.log('sec: ', section);
            console.log('remove: ', inegi.sections[section].sidenav_div_id);
            inegi.sections[section].active = false;
            $('#'+inegi.sections[section].sidenav_div_id).removeClass('active');
		}
        console.log('add: ', inegi.sections[attr.section].sidenav_div_id);
		inegi.sections[attr.section].active = true;
		$('#'+inegi.sections[attr.section].sidenav_div_id).addClass('active');
	}
}

function loadInegiForm(attr){
	$.ajax({
		url: attr.url,
		type:'POST',
		contentType:false,
		processData:false,
		cache:false
	}).done(function(response){
		$("#inegi-form-section").html(response);
		//attr.success.function(attr.success.attr);
        for(func in attr.success.functions){
            attr.success.functions[func].function( attr.success.functions[func].attr);
        }
        document.documentElement.scrollTop = 0;
	});
}

function resetInegi(attr){
	inegi.active = false;
    for(section in inegi.sections){
        inegi.sections[section].active = false;
        inegi.sections[section].data = null;
        $('#'+inegi.sections[section].sidenav_div_id).removeClass('completed');
        $('#'+inegi.sections[section].sidenav_div_id).removeClass('uncompleted');
    }
    inegi.current.recieved_id = null;
    inegi.current.agreement_id = null;
    inegi.current.nuc = null;
    inegi.current.general_id = null;
    handle_data.inegi_crimes = null;
    $('#dashboard-alert-section').html('');
    $('#inegi-current-record-section').html('');
    $('#inegi-current-record-label-section').html('');
    showSections({
        sections: [
            {
                id: 'month-records-label-section',
                show: true
            },
            {
                id: 'records-section',
                show: true
            },
            {
                id: 'masc-side-div',
                show: true
            },
            {
                id: 'pending-records-label-section',
                show: true
            }
        ]
    });
}

function validateInegiSection(section){

    setLoader({
        add: true
    });

    let fields = inegi.sections[section].fields;
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
        spetialInegiValidationBySection({
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

function spetialInegiValidationBySection(attr){

    switch(attr.section){
        case 'general':
            checkActivePeriod({
                element_id: 'inegi-general-date',
                section: 2,
                function: checkNuc,
                attr: {
                    element_id: 'inegi-general-nuc',
                    //function: checkInegiNuc,
                    function: checkInegiRecord,
                    attr: {
                        recieved_id: inegi.current.recieved_id,
                        agreement_id: inegi.current.agreement_id,
                        //element_id: 'inegi-general-nuc',
                        success: {
                            function: saveInegiSection,
                            attr: {
                                section: attr.section,
                                data: {
                                    ...attr.data,
                                    recieved_id: inegi.current.recieved_id,
                                    agreement_id: inegi.current.agreement_id
                                },
                                success: {
                                    functions: [
                                        {
                                            function: validateCompletedInegiSection,
                                            attr: attr.section,
                                            response: false
                                        },
                                        {
                                            function: drawUncompletedInegiSections,
                                            attr: null,
                                            response: false
                                        },
                                        {
                                            function: activeInegi,
                                            attr: null,
                                            response: false
                                        },
                                        {
                                            function: setCurrentInegiId,
                                            attr: null,
                                            response: true
                                        },
                                        {
                                            function: getInegiCurrentRecordBySectionAndID,
                                            attr: null,
                                            response: true 
                                        },
                                        /*{
                                            function: getInegiRecordsByMonth,
                                            attr: attr.section,
                                            response: false
                                        },*/
                                        {
                                            function: resetInegiSection,
                                            attr: attr.section,
                                            response: false
                                        },
                                    ]
                                }
                            }
                        }
                    }
                }
            });
                break;
        case 'crime':

            saveInegiSection({
                section: attr.section,
                data: {
                    ...attr.data,
                    general_id: inegi.current.general_id
                },
                success: {
                    functions: [
                        {
                            function: validateCompletedInegiSection,
                            attr: attr.section,
                            response: false
                        },
                        {
                            function: getInegiCurrentRecordBySectionAndID,
                            attr: {
                                section: attr.section,
                                general_id: inegi.current.general_id
                            },
                            response: false 
                        },
                        /*{
                            function: getInegiRecordsByMonth,
                            attr: attr.section,
                            response: false
                        },*/
                        {
                            function: loadInegiDefaultValuesBySection,
                            attr: attr.section,
                            response: false
                        },
                        {
                            function: resetInegiSection,
                            attr: attr.section,
                            response: false
                        },
                        {
                            function: getMissingInegiCrimesByGeneralId,
                            attr: {
                                service_file: 'service/inegi/get_missing_crime_records_by_general_id.php',
                                template_file: 'templates/elements/select.php',
                                element_attr: {
                                    element_id: 'inegi-crime-crime',
                                    element_placeholder: 'Selecciona Delito',
                                    element_event_listener: ''
                                },
                                select_type: 'select'
                            },
                            response: false
                        }
                    ] 
                }
            });

            break;
        default:
            saveInegiSection({
                section: attr.section,
                data: {
                    ...attr.data,
                    general_id: inegi.current.general_id
                },
                success: {
                    functions: [
                        {
                            function: validateCompletedInegiSection,
                            attr: attr.section,
                            response: false
                        },
                        {
                            function: getInegiCurrentRecordBySectionAndID,
                            attr: {
                                section: attr.section,
                                general_id: inegi.current.general_id
                            },
                            response: false 
                        },
                        /*{
                            function: getInegiRecordsByMonth,
                            attr: attr.section,
                            response: false
                        },*/
                        {
                            function: loadInegiDefaultValuesBySection,
                            attr: attr.section,
                            response: false
                        },
                        {
                            function: resetInegiSection,
                            attr: attr.section,
                            response: false
                        }
                    ] 
                }
            });
            break;
    }
}

function saveInegiSection(attr){

    console.log('seeeec', inegi.sections[attr.section]);
    if(inegi.sections[attr.section].data == null || attr.section == 'victim' || attr.section == 'imputed' || attr.section == 'crime'){
        $.ajax({
            url: 'service/inegi/'+inegi.sections[attr.section].create_file,
            type: 'POST',
            dataType : 'json', 
            data: {
                ...attr.data
            },
            cache: false
        }).done(function(response){
            if(response.state == 'success'){
                
                Swal.fire('Correcto', 'Datos guardados correctamente', 'success');
                /*resetSection(attr.section);
                loadDefaultValuesBySection(attr.section);
                getRecordsByMonth(attr.section);*/
                
                console.log('chido chido', response);
                console.log('chido lo', response.state);

                inegi.sections[attr.section].data = response;

                for(func in attr.success.functions){
                    if(!attr.success.functions[func].response)
                        attr.success.functions[func].function(attr.success.functions[func].attr);
                    else{
                        attr.success.functions[func].function({
                            section: attr.section,
                            general_id: response.data.id
                        });
                    }
                }

                if(attr.section == 'general'){
                    console.log('saving crimes...');
                    saveMultiselectField({
                        section: 'inegi',
                        service_file: 'crimes/create_inegi_crimes.php',
                        post_data: {
                            id: response.data.id,
                            data: handle_data.inegi_crimes
                        }
                    });
                }

                setLoader({
                    add: false
                });
            }
            else{

                setLoader({
                    add: false
                });
    
                Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');
    
                console.log('not chido', response);
                console.log('chido no lo', response.state);
                
            }
        });
    }
    else{
        setLoader({
            add: false
        });

        Swal.fire('Error', 'Ya se ha guardado esta seccion antes', 'error');
    }
    
}

function validateCompletedInegiSection(section){

    switch(section){
        case 'crime':
            checkMissingInegiCrimesByGeneralId({
                service_file: 'service/inegi/get_missing_crime_records_by_general_id.php',
                section: section
            });
            break;
        default:
            drawCompletedInegiSection({
                section: section
            });
            break;
    }

}

function drawCompletedInegiSection(attr){
    //inegi.sections[attr.section].compleated = true;
    $('#'+inegi.sections[attr.section].sidenav_div_id).removeClass('uncompleted');
    $('#'+inegi.sections[attr.section].sidenav_div_id).addClass('completed');
}

function drawUncompletedInegiSections(attr){

    for(section in inegi.sections){
        if(inegi.sections[section].data == null){
            $('#'+inegi.sections[section].sidenav_div_id).addClass('uncompleted');
        }
    }

}

function activeInegi(attr){

    inegi.active = true;

}

function setCurrentInegiId(attr){

    inegi.current.general_id = attr.general_id;
    inegi.current.nuc = inegi.current.nuc;
    inegi.current.recieved_id = inegi.current.recieved_id;
    inegi.current.agreement_id = inegi.current.agreement_id;

}

function loadInegiCatalogsBySection(attr){

    for(field in inegi.sections[attr.section].fields){

        if(inegi.sections[attr.section].fields[field].catalog != null && inegi.sections[attr.section].fields[field].type != 'list'){

            if(inegi.sections[attr.section].fields[field].catalog.data != null){
                loadSelect({
                    template_file: attr.template_file,
                    element_attr: {
                        element_id: inegi.sections[attr.section].fields[field].id,
                        element_placeholder: inegi.sections[attr.section].fields[field].placeholder,
                        element_event_listener: inegi.sections[attr.section].fields[field].event_listener,
                        elements: inegi.sections[attr.section].fields[field].catalog.data
                    }
                });
            }
            else{
                getInegiCatalog({
                    service_file: attr.service_location+inegi.sections[attr.section].fields[field].catalog.service_file,
                    template_file: attr.template_file,
                    element_attr: {
                        element_id: inegi.sections[attr.section].fields[field].id,
                        element_placeholder: inegi.sections[attr.section].fields[field].placeholder,
                        element_event_listener: inegi.sections[attr.section].fields[field].event_listener
                    },
                    section: attr.section,
                    field: field
                });
            }
        }
    }
}

function getInegiCatalog(attr){

    $.ajax({
        url: attr.service_file,
        dataType: "json",
        cache:false
    }).done(function(response){

        inegi.sections[attr.section].fields[attr.field].catalog.data = response;

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


function getInegiRecordsByMonth(section){

    console.log('by moneh?', section);

    let date = new Date();
    date.setHours(date.getHours()+6); 

    if(inegi.sections[section].records_by_month_file != null){
        $.ajax({
            url:'service/inegi/'+inegi.sections[section].records_by_month_file,
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
                section: 'inegi',
                data: response,
                file: 'templates/tables/inegi/'+section+'_table.php',
                element_id: 'records-section'
            });
        });
    }	
}

function getInegiCurrentRecordBySectionAndID(attr){


    console.log('raro: ', inegi.current.general_id);

    console.log('by moneh? attr: ', attr);

    let date = new Date();
    date.setHours(date.getHours()+6); 

    if(attr != null){
        if(inegi.sections[attr.section].records_by_general_id_file != null && attr.general_id != null){

            if(attr.section != 'general'){
                $.ajax({
                    url:'service/inegi/'+inegi.sections[attr.section].records_by_general_id_file,
                    type:'POST',
                    dataType: "json",
                    data: {
                        general_id: attr.general_id
                    },
                    cache:false
                }).done(function(response){
                    console.log(response);
                    test2 = response;
    
                    drawRecordsTable({
                        section: 'inegi',
                        data: response,
                        file: 'templates/tables/inegi/'+attr.section+'_table.php',
                        element_id: 'inegi-current-record-section'
                    });
    
                    $('#inegi-current-record-label-section').html('CAPTURANDO: '+inegi.current.nuc);
                });
            }
            else{
                setTimeout(
                    function(){
                        $.ajax({
                            url:'service/inegi/'+inegi.sections[attr.section].records_by_general_id_file,
                            type:'POST',
                            dataType: "json",
                            data: {
                                general_id: attr.general_id
                            },
                            cache:false
                        }).done(function(response){
                            console.log(response);
                            test2 = response;
            
                            drawRecordsTable({
                                section: 'inegi',
                                data: response,
                                file: 'templates/tables/inegi/'+attr.section+'_table.php',
                                element_id: 'inegi-current-record-section'
                            });
            
                            $('#inegi-current-record-label-section').html('CAPTURANDO: '+inegi.current.nuc);
                        });
                    }, 500
                );
            }
        }
        else{
            console.log('nada nada nada q no q no', attr);
        }	
    }    
}

function loadInegiDefaultValuesBySection(section){
    let fields = inegi.sections[section].fields;

    for(field in fields){
        if(document.getElementById(fields[field].id)){

            if(fields[field].default != null){

                switch(fields[field].type){
                    case "date":
                        if(fields[field].default == "today"){
                            let today = new Date();
                            console.log('tod', today);
                            var inp = document.getElementById(fields[field].id);
                            var date1 = new Date();
                            date1 = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate()); 
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

function resetInegiSection(section){

    let fields = inegi.sections[section].fields;

    for(field in fields){

        if(document.getElementById(fields[field].id)){

            switch(fields[field].type){
                case 'select':
                    document.getElementById(fields[field].id).selectedIndex = 0;
                    break;
                case 'text':
                    document.getElementById(fields[field].id).value = "";
                    break;
                case 'number':
                    document.getElementById(fields[field].id).value = 0;
                    break;
                case 'text-number':
                    document.getElementById(fields[field].id).value = "";
                    break;
                default:
                    document.getElementById(fields[field].id).value = "";
                    break;
            }

            document.getElementById(fields[field].id).disabled = false;
        }
    }
    loadInegiDefaultValuesBySection(section);
    $('#dashboard-alert-section').html('');
}


function inegiStartCapture(recieved, agreement){

    resetInegi(null);

    inegi.current.recieved_id = recieved;
    inegi.current.agreement_id = agreement;

    getInegiNuc({
        service_file: 'service/inegi/get_inegi_nuc.php',
        recieved_id: recieved,
        agreement_id: agreement
    });

    //inegi.current.nuc = nuc;

    console.log('jalas o noo');
    

    document.getElementById('inegi-capture-section').style.display = 'block';

    document.getElementById('inegi-pending-section').style.display = 'none';

    showSections({
        sections: [
            {
                id: 'month-records-label-section',
                show: false
            },
            {
                id: 'records-section',
                show: false
            },
            {
                id: 'pending-records-label-section',
                show: false
            }
        ]
    });

    if(agreement == ''){
        showSections({
            sections: [
                {
                    id: 'masc-side-div',
                    show: false
                }
            ]
        });
    }
    else{
        showSections({
            sections: [
                {
                    id: 'masc-side-div',
                    show: true
                }
            ]
        });
    }

    changeInegiPanel('general');

}

function getInegiPreloadedDataBySection(attr){

    let service_file = null;
    console.log('get preload: ', attr);

    console.log('attr.section prev: ', attr.section);
    
    switch(attr.section){
        case 'general':
            service_file = 'service/inegi/get_inegi_general_preloaded_data.php';

            getInegiPreloadedCrimes({
                service_file: 'service/inegi/get_inegi_general_crimes_preloaded_data.php',
                attr: {
                    general_id: inegi.current.general_id,
                    nuc: inegi.current.nuc,
                    recieved_id: inegi.current.recieved_id,
                    agreement_id: inegi.current.agreement_id
                },
                success: {
                    functions: [
                        {
                            function: loadInegiPreloadedCrimes,
                            attr: {
                                section_id: 'inegi-general-crime-section',
                                template_file: 'templates/elements/list.php',
                                element_attr: {
                                    element_id: 'general-inegi-crime-list',
                                    element_placeholder: '',
                                    element_event_listener: '',
                                    elements: ''
                                },
                                data: null
                            },
                            response: 'data'
                        }
                    ]
                }
            });

            break;

        case 'crime':

            getMissingInegiCrimesByGeneralId({
                service_file: 'service/inegi/get_missing_crime_records_by_general_id.php',
                template_file: 'templates/elements/select.php',
                element_attr: {
                    element_id: 'inegi-crime-crime',
                    element_placeholder: 'Selecciona Delito',
                    element_event_listener: ''
                },
                select_type: 'select'
            });

            break;
        case 'masc':
            if(attr.attr.recieved_id != null){
                
                service_file = 'service/inegi/get_inegi_masc_preloaded_data.php';

                console.log('entre: ', service_file);
            }
            break;
        default:
            console.log('attr.section: ', attr.section);
            break;
    }

    console.log('service file: ', service_file);

    if(service_file != null){
        
        console.log('hay inegi data section: ', inegi.sections[attr.section].data);
        if(inegi.sections[attr.section].data == null){

            
            $.ajax({
                url: service_file,
                type:'POST',
                dataType: "json",
                data: attr.attr,
                cache:false
            }).done(function(response){

                console.log('get preloaded  data res: ', response);
        
                if(attr.success != null){
                    for(func in attr.success.functions){
                        if(attr.success.functions[func].response != null){
                            attr.success.functions[func].attr[attr.success.functions[func].response] = response;
                        }
                        attr.success.functions[func].function(attr.success.functions[func].attr);
                    }
                }
            });
        }
    }
    else{
        console.log('nul weeeeeee');
    }    
}

function loadInegiPreloadedData(attr){

    console.log('tell me what r u setting: ',attr);

    let loaded = false;

    for(element in attr.data){

        for(attrib in attr.data[element]){

            for(field in inegi.sections[attr.section].fields){

                if(inegi.sections[attr.section].fields[field].name == attrib){

                    loaded = true;
    
                    if(document.getElementById(inegi.sections[attr.section].fields[field].id)){
                        document.getElementById(inegi.sections[attr.section].fields[field].id).value = attr.data[element][attrib].value;
                        document.getElementById(inegi.sections[attr.section].fields[field].id).disabled = true;
                    }
                    else{
                        setValueOnLateLoad({
                            id: inegi.sections[attr.section].fields[field].id,
                            value: attr.data[element][attrib].value,
                            type: inegi.sections[attr.section].fields[field].type,
                            placeholder: inegi.sections[attr.section].fields[field].placeholder,
                            counter: 1,
                            iterations: 10,
                            delay: 500,
                            success: {
                                functions: [
                                    {
                                        function: disableInput,
                                        attr: {
                                            id: inegi.sections[attr.section].fields[field].id
                                        }
                                    }
                                ]
                            }
                        });
                    }
                    break;
                }
            }
        }
    }

    if(loaded){
        loadDashboardAlert({
            template_file: 'templates/elements/dashboard_alert.php',
            element_id: 'dashboard-alert-section',
            element_attr: {
                attr: {
                    type: 'warning',
                    message: 'Atención!, Se ha precargado Información previamente capturada.'
                }
            } 
        });
    }
}

function getInegiPreloadedCrimes(attr){

    if(attr.service_file != null){
        
        $.ajax({
            url: attr.service_file,
            type:'POST',
            dataType: "json",
            data: attr.attr,
            cache:false
        }).done(function(response){
            console.log(response);
    
            if(attr.success != null){
                for(func in attr.success.functions){
                    if(attr.success.functions[func].response != null){
                        attr.success.functions[func].attr.data = response;

                        handle_data.inegi_crimes = [];

                        for(element in response){

                            handle_data.inegi_crimes.push(response[element].id);
                        }
                    }
                    attr.success.functions[func].function(attr.success.functions[func].attr);
                }
            }
        });
    }
    else{
        console.log('nul weeeeeee');
    }    
}

function loadInegiPreloadedCrimes(attr){

    if(attr.data != null){
        attr.element_attr.elements = attr.data;

        if(attr.template_file != null){
            
            $.ajax({
                url: attr.template_file,
                type:'POST',
                dataType: "html",
                data: attr.element_attr,
                cache:false
            }).done(function(response){
                $('#'+attr.section_id).html(response);
            });
        }
        else{
            console.log('nul weeeeeee');
        }
    }
    else{
        loadDashboardAlert({
            template_file: 'templates/elements/dashboard_alert.php',
            element_id: attr.section_id,
            element_attr: {
                attr: {
                    type: 'danger',
                    message: 'No hay registros!'
                }
            } 
        });
    }
}

function checkInegiNuc(attr){

    console.log('attr: ', attr);

    if(document.getElementById(attr.element_id)){

        if(document.getElementById(attr.element_id).value.length == 13){
            
            $.ajax({  
                type: "POST",  
                url: "service/inegi/check_inegi_nuc.php", 
                dataType : 'json', 
                data: {
                    nuc: document.getElementById(attr.element_id).value
                },
            }).done(function(response){

                if(response.state != "fail"){
        
                    if(response.data != null){

                        Swal.fire('NUC Capturado previamente en INEGI', 'Verifique el NUC! o ingrese uno distinto', 'warning');

                    }
                    else{
                        attr.success.function(attr.success.attr);
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

}

function getInegiPendingAgreementsByMonth(attr){

    let date = new Date();
    date.setHours(date.getHours()+6); 

    $('#'+attr.section_id).html('<div style="color: #EE6E5A;">Cargando datos... </div>');

    $.ajax({
        url:'service/inegi/get_pending_agreements_by_month.php',
        type:'POST',
        dataType: "json",
        data: {
            month: (date.getMonth()+1),
            year: date.getFullYear()
        },
        cache:false
    }).done(function(response){
        drawRecordsTable({
            section: 'inegi',
            data: response,
            file: 'templates/tables/inegi/pending_agreements_table.php',
            element_id: attr.section_id
        });
        
    });

}

function resetInegiCapture(){

    if(inegi.current.general_id == null){
        document.getElementById('inegi-capture-section').style.display = 'none';

        document.getElementById('inegi-pending-section').style.display = 'block';
        $('#dashboard-alert-section').html('');

        resetInegi(null);

        getInegiRecordsByMonth('general');

        getInegiPendingAgreementsByMonth({
            section_id: 'inegi-pending-section'
        });
    }
    else{
        Swal.fire({
            title: 'Estas seguro?',
            text: 'No será posible seguir capturando la información de este registro si quieres capturar un nuevo!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.isConfirmed){
                document.getElementById('inegi-capture-section').style.display = 'none';

                document.getElementById('inegi-pending-section').style.display = 'block';
                $('#dashboard-alert-section').html('');

                resetInegi(null);

                getInegiRecordsByMonth('general');

                getInegiPendingAgreementsByMonth({
                    section_id: 'inegi-pending-section'
                });

            }
        });
    }
}

function checkInegiRecord(attr){

    console.log('attr: ', attr);

    if(attr.recieved_id || attr.agreement_id){

        if((attr.recieved_id != null || attr.recieved_id != '') || (attr.agreement_id != null || attr.agreement_id != '')){
            
            $.ajax({  
                type: "POST",  
                url: "service/inegi/check_inegi_record.php", 
                dataType : 'json', 
                data: {
                    recieved_id: attr.recieved_id,
                    agreement_id: attr.agreement_id
                },
            }).done(function(response){

                if(response.state != "fail"){
        
                    if(response.data != null){

                        Swal.fire('Registro Capturado previamente en INEGI', 'Verifique el registro! o ingrese uno distinto', 'warning');

                    }
                    else{
                        attr.success.function(attr.success.attr);
                    }
                }
                else{
                    Swal.fire('Oops...', 'Ha fallado la conexión!', 'error');
                }
                setLoader({
                    add: false
                });
                
            }); 
        }
        else{
            setLoader({
                add: false
            });

            Swal.fire('error', 'Ha ocurrido algo un error, favor de comunicar a DPE', 'warning');
        }
    }
    else{
        setLoader({
            add: false
        });
        
        Swal.fire('error', 'Ha ocurrido algo un error, favor de comunicar a DPE', 'warning');
    }

}

function getInegiNuc(attr){

    setLoader({
        add: true
    });

    if(attr != null){
        $.ajax({
            url: attr.service_file,
            type:'POST',
            dataType: "json",
            data: {
                recieved_id: attr.recieved_id,
                agreement_id: attr.agreement_id
            },
            cache:false
        }).done(function(response){

            inegi.current.nuc = response.data.nuc;

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
}

function getMissingInegiCrimesByGeneralId(attr){

    if(attr.service_file != null){
        $.ajax({
            url: attr.service_file,
            type:'POST',
            dataType: "json",
            data: {
                general_id: inegi.current.general_id
            },
            cache:false
        }).done(function(response){

            loadSelect({
                template_file: attr.template_file,
                element_attr: {
                    ...attr.element_attr,
                    elements: response
                }
            });
    
        });
    }
}

function checkMissingInegiCrimesByGeneralId(attr){

    if(attr.service_file != null){
        $.ajax({
            url: attr.service_file,
            type:'POST',
            dataType: "json",
            data: {
                general_id: inegi.current.general_id
            },
            cache:false
        }).done(function(response){

            console.log('check res:', response);

            if(response == null){
                drawCompletedInegiSection({
                    section: attr.section
                });
            }
    
        });
    }
}

function showSections(attr){

    for(section in attr.sections){
        if(document.getElementById(attr.sections[section].id)){
            if(!attr.sections[section].show){
                document.getElementById(attr.sections[section].id).style.display = 'none';
            }
            else{
                document.getElementById(attr.sections[section].id).style.display = '';
            }
        }
    }

}