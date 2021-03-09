var inegi = {
    active: true,
    current: {
        general_id: null,
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
            "records_by_month_file": "get_general_records_by_month.php",
            "records_by_general_id_file": "get_general_records_by_general_id.php",
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
                    "name": "general_attended",
                    "type": "text-number",
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
            "records_by_month_file": "get_victim_records_by_month.php",
            "records_by_general_id_file": "get_victim_records_by_general_id.php",
            "form_id": "victim-form",
            "sidenav_div_id": "victim-side-div",
            "name": "victim",
            "title": "Víctima",
            "fields": [
                {
                    "id": "inegi-victim-gener",
                    "name": "victim_gener",
                    "type": "text",
                    "placeholder": "Ingresa Sexo",
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
                    "id": "inegi-victim-age",
                    "name": "victim_age",
                    "type": "text-number",
                    "placeholder": "Ingresa Edad",
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
                    "id": "inegi-victim-scholarship",
                    "name": "victim_scholarship",
                    "type": "select",
                    "placeholder": "Selecciona Escolaridad",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_scholarships.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-victim-ocupation",
                    "name": "victim_ocupation",
                    "type": "select",
                    "placeholder": "Selecciona Ocupación",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_ocupations.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-victim-applicant",
                    "name": "victim_applicant",
                    "type": "text",
                    "placeholder": "Ingresa Solicitante",
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
                    "id": "inegi-victim-required",
                    "name": "victim_required",
                    "type": "text",
                    "placeholder": "Ingresa Requerido",
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
                    "id": "inegi-victim-type",
                    "name": "victim_type",
                    "type": "select",
                    "placeholder": "Ingresa Tipo de persona",
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
        "imputed": {
            "index": 3,
            "main_form": false,
            "form_file": "imputed_form.php",
            "create_file": "create_imputed_section.php",
            "update_file": "update_imputed_section.php",
            "search_file": "search_imputed_section.php",
            "records_by_month_file": "get_imputed_records_by_month.php",
            "records_by_general_id_file": "get_imputed_records_by_general_id.php",
            "form_id": "imputed-form",
            "sidenav_div_id": "imputed-side-div",
            "name": "imputed",
            "title": "Imputado",
            "fields": [
                {
                    "id": "inegi-imputed-gener",
                    "name": "imputed_gener",
                    "type": "text",
                    "placeholder": "Ingresa Sexo",
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
                    "id": "inegi-imputed-age",
                    "name": "imputed_age",
                    "type": "number-number",
                    "placeholder": "Ingresa Edad",
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
                    "id": "inegi-imputed-scholarship",
                    "name": "imputed_scholarship",
                    "type": "select",
                    "placeholder": "Selecciona Escolaridad",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_scholarships.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-imputed-ocupation",
                    "name": "imputed_ocupation",
                    "type": "select",
                    "placeholder": "Selecciona Ocupación",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_ocupations.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-imputed-applicant",
                    "name": "imputed_applicant",
                    "type": "text",
                    "placeholder": "Ingresa Solicitante",
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
                    "id": "inegi-imputed-required",
                    "name": "imputed_required",
                    "type": "text",
                    "placeholder": "Ingresa Requerido",
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
                    "id": "inegi-imputed-type",
                    "name": "imputed_type",
                    "type": "select",
                    "placeholder": "Ingresa Tipo de persona",
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
        "crime": {
            "index": 4,
            "main_form": false,
            "form_file": "crime_form.php",
            "create_file": "create_crime_section.php",
            "update_file": "update_crime_section.php",
            "search_file": "search_crime_section.php",
            "records_by_month_file": "get_crime_records_by_month.php",
            "records_by_general_id_file": "get_crime_records_by_general_id.php",
            "form_id": "crime-form",
            "sidenav_div_id": "crime-side-div",
            "name": "crime",
            "title": "Caracteristicas de los delitos",
            "fields": [
                {
                    "id": "inegi-crime-rate",
                    "name": "crime_rate",
                    "type": "select",
                    "placeholder": "Selecciona Calificación",
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
                    "id": "inegi-crime-contest",
                    "name": "crime_contest",
                    "type": "select",
                    "placeholder": "Selecciona Concurso",
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
                    "id": "inegi-crime-action",
                    "name": "crime_action",
                    "type": "select",
                    "placeholder": "Selecciona Acción",
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
                    "id": "inegi-crime-commission",
                    "name": "crime_commission",
                    "type": "select",
                    "placeholder": "Selecciona Comision",
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
                    "id": "inegi-crime-violence",
                    "name": "crime_violence",
                    "type": "select",
                    "placeholder": "Selecciona Violencia",
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
                    "id": "inegi-crime-modality",
                    "name": "crime_modality",
                    "type": "select",
                    "placeholder": "Selecciona Modalidad",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_modalities.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-crime-instrument",
                    "name": "crime_instrument",
                    "type": "select",
                    "placeholder": "Selecciona Instrumento",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_instruments.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-crime-alternative-justice",
                    "name": "crime_alternative_justice",
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
                }
            ],
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
            "records_by_month_file": "get_masc_records_by_month.php",
            "records_by_general_id_file": "get_masc_records_by_general_id.php",
            "form_id": "masc-form",
            "sidenav_div_id": "masc-side-div",
            "name": "masc",
            "title": "MASC",
            "fields": [
                {
                    "id": "inegi-masc-mechanism",
                    "name": "masc_mechanism",
                    "type": "select",
                    "placeholder": "Selecciona Mecanismo",
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
                    "id": "inegi-masc-result",
                    "name": "masc_result",
                    "type": "select",
                    "placeholder": "Selecciona Resultado",
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
                    "id": "inegi-masc-compliance",
                    "name": "masc_compliance",
                    "type": "select",
                    "placeholder": "Selecciona Cumplimiento",
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
                    "id": "inegi-masc-total",
                    "name": "masc_total",
                    "type": "select",
                    "placeholder": "Selecciona Total o parcial",
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
                    "id": "inegi-masc-repair",
                    "name": "masc_repair",
                    "type": "select",
                    "placeholder": "Selecciona Reparación",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_repairs.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-masc-conclusion",
                    "name": "masc_conclusion",
                    "type": "select",
                    "placeholder": "Selecciona Conclusión",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_conclusions.php',
                        data: null
                    },
                    "required": true
                },
                {
                    "id": "inegi-masc-recovered-amount",
                    "name": "masc_recovered_amount",
                    "type": "text",
                    "placeholder": "Selecciona Monto",
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
                    "id": "inegi-masc-amount-property",
                    "name": "masc_amount_property",
                    "type": "text",
                    "placeholder": "Selecciona Monto",
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
                    "id": "inegi-masc-turned-to",
                    "name": "masc_turned_to",
                    "type": "select",
                    "placeholder": "Selecciona",
                    "event_listener": null,
                    "conditions": {
                        "unlock": null,
                        "length": null
                    },
                    "default": null,
                    "catalog": {
                        service_file: 'get_turneds.php',
                        data: null
                    },
                    "required": true
                }
            ],
            "active": false,
            "data": null,
            "loaded_data": false
        }
    }
}