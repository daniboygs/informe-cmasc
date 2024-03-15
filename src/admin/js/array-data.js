function getHTMLTableTemplate(attr){

    let location = 'templates/tables/htmltoexcel/';

    let urls = {
        entered_folders: location+'entered_folders_table.php',
        entered_folders_super: location+'entered_folders_super_table.php',
        recieved_folders: location+'recieved_folders_table.php',
        agreements: location+'agreements_table.php',
        folders_to_investigation: location+'folders_to_investigation_table.php',
        folders_to_validation: location+'folders_to_validation_table.php',
        people_served: location+'people_served_table.php',
        processing_folders: location+'processing_folders_table.php',
        inegi: location+'inegi_table.php'
    }

    return urls[attr.section] != undefined ? urls[attr.section] : null;
}

function getInegiSearchService(attr){

    let search_service_location = 'service/inegi';

    let urls = {
        captured_records: search_service_location+'get_captured_records.php',
        general: search_service_location+'get_general.php',
        general_agreements: search_service_location+'get_general_agreements.php',
        victims: search_service_location+'get_victims.php',
        imputeds: search_service_location+'get_imputeds.php',
        crimes: search_service_location+'get_crimes.php',
        pending_capture: search_service_location+'get_pending_capture.php',
    }

    return urls[attr.search_op] != undefined ? urls[attr.search_op] : null;
}