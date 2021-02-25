var inegi = {
    active: false,
    sections = {
        "generals": {
            "index": 1,
            "form_file": "general_form.php",
            "create_file": "create_general_section.php",
            "update_file": "update_general_section.php",
            "search_file": "search_general_section.php",
            "records_by_month_file": "get_general_records_by_month.php",
            "form_id": "inegi-general-form",
            "navigation_element_id": "general-side-div",
            "name": "datos generales",
            "title": "DATOS GENERALES",
            "fields": [
                {
                    "id": "general-date",
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
                    "id": "general-crime",
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
                    "id": "general-intervention",
                    "name": "general_intervention",
                    "type": "number",
                    "placeholder": "Ingresa Intervensión",
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
                    "id": "general-nuc",
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
                    "id": "general-compliance",
                    "name": "general_compliance",
                    "type": "text",
                    "placeholder": "Ingresa Cumplimiento",
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
                    "id": "general-total",
                    "name": "general_total",
                    "type": "select",
                    "placeholder": "Selecciona",
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
                    "id": "general-mechanism",
                    "name": "general_mechanism",
                    "type": "text",
                    "placeholder": "Ingresa Mecanismo",
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
                    "id": "general-amount",
                    "name": "general_amount",
                    "type": "number",
                    "placeholder": "Ingresa Monto",
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
                    "id": "general-unity",
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
                    "id": "general-amount-in-kind",
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
            "data": [],
            "loaded_data": false
        },
        "recieved_folders": {
            "index": 2,
            "form_file": "recieved_folders_form.php",
            "create_file": "create_recieved_folders_section.php",
            "update_file": "update_recieved_folders_section.php",
            "search_file": "search_recieved_folders_section.php",
            "records_by_month_file": "get_recieved_folders_records_by_month.php",
            "form_id": "recieved-folders-form",
            "navigation_element_id": "recieved-folders-nav-div",
            "name": "recieved_folders",
            "title": "CARPETAS RECIBIDAS",
            "fields": [
                {
                    "id": "recieved-folders-date",
                    "name": "recieved_folders_date",
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
                    "id": "recieved-folders-crime",
                    "name": "recieved_folders_crime",
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
                    "id": "recieved-folders-nuc",
                    "name": "recieved_folders_nuc",
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
                    "id": "recieved-folders-unity",
                    "name": "recieved_folders_unity",
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
                }
            ],
            "active": false,
            "data": [],
            "loaded_data": false
        }
    }
}