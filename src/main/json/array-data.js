function getSearchService(attr){

    let service_location = 'service/victim_validation/';

    let urls = {
        unknown_age: service_location+'search_unknown_age.php',
        unknown_gener: service_location+'search_unknown_gener.php',
        crimes_by_minor: service_location+'search_crimes_by_minor.php',
        crimes_by_unknown_gener: service_location+'search_crimes_by_unknown_gener.php',
        crimes_by_moral: service_location+'search_crimes_by_moral.php',
        robbery_months_old: service_location+'search_robbery_months_old.php',
        default: service_location+'search_unknown_age.php'
    };

    return attr.search_op != undefined ? (
        urls[attr.search_op]!= undefined? urls[attr.search_op] : null
    ) : null;
}

function getSearchFormElementsBySection(attr){

    let form_elements_by_section = {
        victim_validation: [
            {
                id: 'main-search-month',
                type: 'date',
                json_key: 'year_month',
                required: true
            },
            {
                id: 'main-search-op',
                type: 'text',
                json_key: 'search_op',
                required: true
            }
        ]
    };
    
    return attr.section != undefined ? (
        form_elements_by_section[attr.section]!= undefined? form_elements_by_section[attr.section] : null
    ) : null;
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