function getHTMLTableTemplate(attr){

    let template_service_location = 'templates/tables/htmltoexcel/';

    let urls = {
        entered_folders: template_service_location+'entered_folders_table.php',
        entered_folders_super: template_service_location+'entered_folders_super_table.php',
        recieved_folders: template_service_location+'recieved_folders_table.php',
        agreements: template_service_location+'agreements_table.php',
        folders_to_investigation: template_service_location+'folders_to_investigation_table.php',
        folders_to_validation: template_service_location+'folders_to_validation_table.php',
        people_served: template_service_location+'people_served_table.php',
        processing_folders: template_service_location+'processing_folders_table.php',
        inegi_captured_records: template_service_location+'inegi_captured_records_table.php',
        inegi_general: template_service_location+'inegi_general_table.php',
        inegi_general_agreements: template_service_location+'inegi_general_agreements_table.php',
        inegi_victims: template_service_location+'inegi_victims_table.php',
        inegi_imputeds: template_service_location+'inegi_imputeds_table.php',
        inegi_crimes: template_service_location+'inegi_crimes_table.php',
        inegi_pending: template_service_location+'inegi_pending_table.php'
    }

    return urls[attr.section] != undefined ? urls[attr.section] : null;
}

function getInegiSearchService(attr){

    let search_service_location = 'service/inegi/';

    let urls = {
        captured_records: search_service_location+'get_captured_records.php',
        general: search_service_location+'get_general.php',
        general_agreements: search_service_location+'get_general_agreements.php',
        victims: search_service_location+'get_victims.php',
        imputeds: search_service_location+'get_imputeds.php',
        crimes: search_service_location+'get_crimes.php',
        pending: search_service_location+'get_inegi_pending.php',
        default: search_service_location+'get_captured_records.php'
    }

    return urls[attr.search_op] != undefined ? urls[attr.search_op] : null;
}

function getInegiTableTemplateService(attr){

    let template_service_location = 'templates/tables/inegi/';
    
    let urls = {
        captured_records: template_service_location+'captured_records_table.php',
        general: template_service_location+'general_table.php',
        general_agreements: template_service_location+'general_agreements_table.php',
        victims: template_service_location+'victims_table.php',
        imputeds: template_service_location+'imputeds_table.php',
        crimes: template_service_location+'crimes_table.php',
        pending: template_service_location+'pending_table.php',
        default: template_service_location+'captured_records_table.php'
    }

    return urls[attr.search_op] != undefined ? urls[attr.search_op] : null;
}

function getInegiCrimesBeforeService(attr){

    let search_service_location = 'service/inegi/';

    let urls = {
        captured_records: search_service_location+'get_crimes_by_general.php',
        general: search_service_location+'get_crimes_by_general.php',
        general_agreements: search_service_location+'get_crimes_by_general.php',
        victims: search_service_location+'get_crimes_by_general.php',
        imputeds: search_service_location+'get_crimes_by_general.php',
        crimes: search_service_location+'get_crimes_by_general.php',
        pending: search_service_location+'get_crimes_by_general.php',
        default: search_service_location+'get_crimes_by_general.php'
    }

    return urls[attr.search_op] != undefined ? urls[attr.search_op] : null;
}

function getSectionCrimesService(attr){

    let search_service_location = 'service/';

    let urls = {
        entered_folders: search_service_location+'entered_folders/get_crimes_by_entered_folders.php',
        entered_folders_super: search_service_location+'entered_folders_super/get_crimes_by_entered_folders_super.php',
        recieved_folders: search_service_location+'recieved_folders/get_crimes_by_recieved_folders.php',
        agreements: search_service_location+'agreements/get_crimes_by_agreements.php',
        folders_to_investigation: search_service_location+'folders_to_investigation/get_crimes_by_folders_to_investigation.php',
        folders_to_validation: search_service_location+'folders_to_validation/get_crimes_by_folders_to_validation.php',
        people_served: search_service_location+'people_served/get_crimes_by_people_served.php'
    }

    return urls[attr.section] != undefined ? urls[attr.section] : null;
}

function getSectionService(attr){

    let search_service_location = 'service/';

    let urls = {
        entered_folders: search_service_location+'entered_folders/get_entered_folders.php',
        entered_folders_super: search_service_location+'entered_folders_super/get_entered_folders_super.php',
        recieved_folders: search_service_location+'recieved_folders/get_recieved_folders.php',
        agreements: search_service_location+'agreements/get_agreements.php',
        folders_to_investigation: search_service_location+'folders_to_investigation/get_folders_to_investigation.php',
        folders_to_validation: search_service_location+'folders_to_validation/get_folders_to_validation.php',
        people_served: search_service_location+'people_served/get_people_served.php',
        processing_folders: search_service_location+'processing_folders/get_processing_folders.php',
        rejected_folders: search_service_location+'rejected_folders/get_rejected_folders.php'
    }

    return urls[attr.section] != undefined ? urls[attr.section] : null;
}

function getSectionTableTemplateService(attr){

    let search_service_location = 'templates/tables/';

    let urls = {
        entered_folders: search_service_location+'entered_folders_table.php',
        entered_folders_super: search_service_location+'entered_folders_super_table.php',
        recieved_folders: search_service_location+'recieved_folders_table.php',
        agreements: search_service_location+'agreements_table.php',
        folders_to_investigation: search_service_location+'folders_to_investigation_table.php',
        folders_to_validation: search_service_location+'folders_to_validation_table.php',
        people_served: search_service_location+'people_served_table.php',
        processing_folders: search_service_location+'processing_folders_table.php',
        rejected_folders: search_service_location+'rejected_folders_table.php'
    }

    return urls[attr.section] != undefined ? urls[attr.section] : null;
}

function getSectionPeopleService(attr){

    let search_service_location = 'service/';

    let urls = {
        people_served: search_service_location+'people_served/get_people_by_people_served.php'
    }

    return urls[attr.section] != undefined ? urls[attr.section] : null;
}

function getSearchFormElementsBySection(attr){

    let form_elements_by_section = {
        entered_folders: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        recieved_folders: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        agreements: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        folders_to_investigation: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        folders_to_validation: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        people_served: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        processing_folders: [
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        rejected_folders: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            }
        ],
        inegi: [
            {
                id: 'search-nuc',
                type: 'number',
                json_key: 'nuc'
            },
            {
                id: 'search-initial-date',
                type: 'date',
                json_key: 'initial_date'
            },
            {
                id: 'search-finish-date',
                type: 'date',
                json_key: 'finish_date'
            },
            {
                id: 'inegi-search-op',
                type: 'text',
                json_key: 'inegi_search_op'
            }
        ]
    }

    return form_elements_by_section[attr.section] != undefined ? form_elements_by_section[attr.section] : null;
}

function getDefaultDataTableConfig(){
    return {
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
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    }
}