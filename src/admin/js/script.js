$(document).ready(function(){ 
    console.log(sections);

    checkSession({
        success: {
            function: loadSection,
            attr: 'agreements'
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
        //loadDefaultValuesBySection(section);
        getRecordsByMonth(section);

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
                            document.getElementById(fields[field].id).valueAsDate = new Date();
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
            checkNuc({
                element_id: 'agreement-nuc',
                function: saveSection,
                attr: {
                    section: attr.section,
                    data: attr.data
                }
            });
            break;
        case 'folders_to_investigation':
            checkNuc({
                element_id: 'folders-to-investigation-nuc',
                function: saveSection,
                attr: {
                    section: attr.section,
                    data: attr.data
                }
            });
            break;
        case 'folders_to_validation':
            checkNuc({
                element_id: 'folders-to-validation-nuc',
                function: saveSection,
                attr: {
                    section: attr.section,
                    data: attr.data
                }
            });
            break;
        case 'people_served':
            checkNuc({
                element_id: 'people-served-nuc',
                function: saveSection,
                attr: {
                    section: attr.section,
                    data: attr.data
                }
            });
            break;
        case 'recieved_folders':
            checkNuc({
                element_id: 'recieved-folders-nuc',
                function: saveSection,
                attr: {
                    section: attr.section,
                    data: attr.data
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
	console.log('draw_t', attr.file);
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

function searchSection(section){

    console.log('search?', section+'-nuc');

    //let date = new Date();

    if(document.getElementById('search-nuc')){
        console.log(document.getElementById('search-nuc').value, sections[section].search_file);
        $.ajax({
            url:'service/'+sections[section].search_file,
            type:'POST',
            dataType: "json",
            data: {
                nuc: document.getElementById('search-nuc').value
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
    else{
        Swal.fire('Error', 'Ha ocurrido un error, vuelva a intentarlo', 'error');
    }

	
}

function deleteRecord(section, id){

    console.log('hola delete', section+' - '+id);

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
    
      
  
    table = document.getElementById('data-section-table');
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx));
    
}