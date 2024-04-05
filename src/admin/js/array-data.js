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
    }

    return urls[attr.search_op] != undefined ? urls[attr.search_op] : null;
}