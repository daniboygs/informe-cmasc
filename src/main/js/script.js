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
                            function: activeSection,
                            attr: attr.section
                        },
                        {
                            function: changeInegiPanel,
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
                                    template_file: 'templates/elements/select.php',
                                    service_location: 'service/catalogs/'
                                }
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
                                            template_file: 'templates/elements/select.php',
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
            template_file: 'templates/elements/select.php',
            service_location: 'service/catalogs/'
        });*/

        for(func in attr.success.functions){
            attr.success.functions[func].function( attr.success.functions[func].attr);
        }

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
    date.setHours(date.getHours()+6); 

    if(sections[section].records_by_month_file != null){

        $('#records-section').html('<div style="color: #EE6E5A;">Cargando datos... </div>');
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
                file: 'templates/tables/'+section+'_table.php',
                element_id: 'records-section'
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
			data: attr.data
		},
		cache: false
	}).done(function(response){
		$('#'+attr.element_id).html(response);
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

function changeInegiPanel(section){

    console.log('section: ', section);
    console.log('inegi: ', inegi);

    

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
                            function: loadInegiCatalogsBySection,
                            attr: {
                                section: section,
                                template_file: 'templates/elements/select.php',
                                service_location: 'service/catalogs/'
                            }
                        },
                        {
                            function: getInegiRecordsByMonth,
                            attr: section
                        },
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
		$("#inegi-capture-section").html(response);
		//attr.success.function(attr.success.attr);
        for(func in attr.success.functions){
            attr.success.functions[func].function( attr.success.functions[func].attr);
        }
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
    inegi.current.nuc = null;
    inegi.current.general_id = null;
}

function validateInegiSection(section){

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
        Swal.fire('Campos faltantes', 'Tiene que completar los campos faltantes', 'warning');
    }
}

function spetialInegiValidationBySection(attr){


    console.log('attttttttttttr', attr);
    switch(attr.section){
        case 'general':
            checkActivePeriod({
                element_id: 'inegi-general-date',
                function: checkNuc,
                attr: {
                    element_id: 'inegi-general-nuc',
                    function: saveInegiSection,
                    attr: {
                        section: attr.section,
                        data: attr.data,
                        success: {
                            functions: [
                                {
                                    function: drawCompletedInegiSection,
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
                                {
                                    function: getInegiRecordsByMonth,
                                    attr: attr.section,
                                    response: false
                                },
                                {
                                    function: resetInegiSection,
                                    attr: attr.section
                                }
                            ]
                        }
                    }
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
                            function: drawCompletedInegiSection,
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
                        {
                            function: getInegiRecordsByMonth,
                            attr: attr.section,
                            response: false
                        },
                        {
                            function: loadInegiDefaultValuesBySection,
                            attr: attr.section
                        },
                        {
                            function: resetInegiSection,
                            attr: attr.section
                        }
                    ] 
                }
            });
            break;
    }
}

function saveInegiSection(attr){

    console.log('seeeec', inegi.sections[attr.section]);
    if(inegi.sections[attr.section].data == null || attr.section == 'victim' || attr.section == 'imputed'){
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
            }
            else{
    
                Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');
    
                console.log('not chido', response);
                console.log('chido no lo', response.state);
            }
        });
    }
    else{
        Swal.fire('Error', 'Ya se ha guardado esta seccion antes', 'error');
    }
    
}

function drawCompletedInegiSection(section){

    //inegi.sections[section].compleated = true;
    $('#'+inegi.sections[section].sidenav_div_id).removeClass('uncompleted');
    $('#'+inegi.sections[section].sidenav_div_id).addClass('completed');

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

}

function loadInegiCatalogsBySection(attr){

    for(field in inegi.sections[attr.section].fields){

        if(inegi.sections[attr.section].fields[field].catalog != null){

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
                    data: response,
                    file: 'templates/tables/inegi/'+attr.section+'_table.php',
                    element_id: 'inegi-current-record-section'
                });
            });
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

            
        }
    }

    loadInegiDefaultValuesBySection(section);
}

/*

loadForm({
                section: attr.section,
                success: {
                    functions: [
                        {
                            function: activeSection,
                            attr: attr.section
                        },
                        {
                            function: changeInegiPanel,
                            attr: 'general'
                        }
                    ] 
                }
            });
            */