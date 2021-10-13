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

                getRecordsByMonth('rejected_folders');
    
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

            getRecordsByMonth('rejected_folders');

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