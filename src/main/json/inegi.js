var inegi = {
    active: true,
    current: {
        folder_id: null,
        nuc: null
    },
    sections: {
        "general": {
            "index": 1,
            "main_form": true,
            "form_file": "general_form.php",
            "create_file": "create_general_section.php",
            "update_file": "update_general_section.php",
            "search_file": "search_general_section.php",
            "form_id": "inegi-general-form",
            "sidenav_div_id": "general-side-div",
            "name": "datos generales",
            "title": "DATOS GENERALES",
            "fields": [
                {
                    "id": "inegi-general-date",
                    "name": "general_date",
                    "type": "date",
                    "placeholder": "Ingresa Fecha",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": "today",
                    "catalog": null,
                    "required": true
                },
                {
                    "id": "inegi-general-crime",
                    "name": "general_crime",
                    "type": "text",
                    "placeholder": "Ingresa Delito",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": null,
                    "required": true
                },
                {
                    "id": "inegi-general-nuc",
                    "name": "general_nuc",
                    "type": "text-number",
                    "placeholder": "Ingresa NUC",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": {
                            "min": 13,
                            "max": 13
                        }
                    },
                    "default": null,
                    "catalog": null,
                    "required": true
                },
                {
                    "id": "inegi-general-unity",
                    "name": "general_unity",
                    "type": "text",
                    "placeholder": "Ingresa Unidad",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": null,
                    "required": true
                },
                {
                    "id": "inegi-general-attended",
                    "name": "general_amount_in_kind",
                    "type": "text",
                    "placeholder": "Ingresa Monto",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": null,
                    "required": true
                }
            ],
            "active": false,
            "data": null,
            "loaded_data": false
        },
        "victim": {
            "index": 2,
            "main_form": false,
            "form_file": "victim_form.php",
            "create_file": "create_victim_section.php",
            "update_file": "update_victim_section.php",
            "search_file": "search_victim_section.php",
            "form_id": "victim-form",
            "sidenav_div_id": "victim-side-div",
            "name": "victim",
            "title": "Víctima",
            "fields": [],
            "active": false,
            "data": null,
            "loaded_data": false
        },
        "imputed": {
            "index": 3,
            "main_form": false,
            "form_file": "imputed_form.php",
            "create_file": "create_imputed_section.php",
            "update_file": "update_imputed_section.php",
            "search_file": "search_imputed_section.php",
            "form_id": "imputed-form",
            "sidenav_div_id": "imputed-side-div",
            "name": "imputed",
            "title": "Imputado",
            "fields": [],
            "active": false,
            "data": null,
            "loaded_data": false
        },
        "crime": {
            "index": 4,
            "main_form": false,
            "form_file": "crime_form.php",
            "create_file": "create_crime_section.php",
            "update_file": "update_crime_section.php",
            "search_file": "search_crime_section.php",
            "form_id": "crime-form",
            "sidenav_div_id": "crime-side-div",
            "name": "crime",
            "title": "Caracteristicas de los delitos",
            "fields": [],
            "active": false,
            "data": null,
            "loaded_data": false
        },
        "masc": {
            "index": 5,
            "main_form": false,
            "form_file": "masc_form.php",
            "create_file": "create_masc_section.php",
            "update_file": "update_masc_section.php",
            "search_file": "search_masc_section.php",
            "form_id": "masc-form",
            "sidenav_div_id": "masc-side-div",
            "name": "masc",
            "title": "MASC",
            "fields": [],
            "active": false,
            "data": null,
            "loaded_data": false
        }
    }
}