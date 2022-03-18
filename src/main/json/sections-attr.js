var sections = {
	"agreements": {
		"index": 1,
		"form_file": "agreements_form.php",
		"search_form_file": "search_agreements_form.php",
		"create_file": "create_agreements_section.php",
		"update_file": "update_agreements_section.php",
		"search_file": "search_agreements_section.php",
		"records_by_month_file": "get_agreement_records_by_month.php",
		"service": {
			"create_file": "create_agreements_section.php",
			"update_file": "update_agreements_section.php",
			"search_file": "search_agreements_section.php",
			"records_by_month_file": "get_agreement_records_by_month.php",
			"crime_records_by_month_file": "get_agreement_crime_records_by_month.php"
		},
		"form_id": "agreements-form",
		"navigation_element_id": "agreements-nav-div",
		"name": "acuerdos",
		"title": "ACUERDOS CELEBRADOS",
		"fields": [
            {
				"id": "agreement-date",
				"name": "agreement_date",
                "type": "date",
                "placeholder": "Ingresa Fecha",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "agreement-crime",
				"name": "agreement_crime",
				"type": "multiselect",
                "placeholder": "Selecciona Delitos",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_crimes.php',
					data: null
				},
				"required": true,
				"service": {
					"create_file": "crimes/create_agreement_crimes.php",
					"update_file": null,
					"delete_file": "crimes/delete_agreement_crimes.php",
					"search_file": null
				}
			},
			/*{
				"id": "agreement-intervention",
				"name": "agreement_intervention",
				"type": "number",
                "placeholder": "Ingresa Intervensión",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},*/
			{
				"id": "agreement-nuc",
				"name": "agreement_nuc",
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
				"required": true,
				"service": null
			},
			{
				"id": "agreement-compliance",
				"name": "agreement_compliance",
				"type": "text",
                "placeholder": "Ingresa Cumplimiento",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
            },
            {
				"id": "agreement-total",
				"name": "agreement_total",
				"type": "select",
                "placeholder": "Selecciona",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
            },
            {
				"id": "agreement-mechanism",
				"name": "agreement_mechanism",
				"type": "text",
                "placeholder": "Ingresa Mecanismo",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
            },
            {
				"id": "agreement-amount",
				"name": "agreement_amount",
				"type": "number",
                "placeholder": "Ingresa Monto",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
            },
            /*{
				"id": "agreement-unity",
				"name": "agreement_unity",
				"type": "select",
                "placeholder": "Selecciona Unidad",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_unities.php',
					data: null
				},
				"required": true,
				"service": null
			},*/
			{
				"id": "agreement-amount-in-kind",
				"name": "agreement_amount_in_kind",
				"type": "text",
                "placeholder": "Ingresa Monto",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			}
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"recieved_folders": {
		"index": 2,
		"form_file": "recieved_folders_form.php",
		"search_form_file": "search_recieved_folders_form.php",
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
				"required": true,
				"service": null
			},
			{
				"id": "recieved-folders-crime",
				"name": "recieved_folders_crime",
				"type": "multiselect",
                "placeholder": "Selecciona Delitos",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_crimes.php',
					data: null
				},
				"required": true,
				"service": {
					"create_file": "crimes/create_recieved_folders_crimes.php",
					"update_file": null,
					"delete_file": "crimes/delete_recieved_folders_crimes.php",
					"search_file": null
				}
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
				"required": true,
				"service": null
			}/*,
            {
				"id": "recieved-folders-unity",
				"name": "recieved_folders_unity",
				"type": "select",
                "placeholder": "Selecciona Unidad",
				"event_listener": null,
				"conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_unities.php',
					data: null
				},
				"required": true,
				"service": null
			}*/
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"folders_to_investigation": {
		"index": 3,
		"form_file": "folders_to_investigation_form.php",
		"search_form_file": "search_folders_to_investigation_form.php",
		"create_file": "create_folders_to_investigation_section.php",
		"update_file": "update_folders_to_investigation_section.php",
		"search_file": "search_folders_to_investigation_section.php",
		"records_by_month_file": "get_folders_to_investigation_records_by_month.php",
		"form_id": "folders-to-investigation-form",
		"navigation_element_id": "folders-to-investigation-nav-div",
		"name": "folders_to_investigation",
		"title": "CARPETAS ENVIADAS A INVESTIGACIÓN",
		"fields": [
            {
				"id": "folders-to-investigation-date",
				"name": "folders_to_investigation_date",
                "type": "date",
                "placeholder": "Ingresa Fecha",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "folders-to-investigation-crime",
				"name": "folders_to_investigation_crime",
				"type": "multiselect",
                "placeholder": "Selecciona Delitos",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_crimes.php',
					data: null
				},
				"required": true,
				"service": {
					"create_file": "crimes/create_folders_to_investigation_crimes.php",
					"update_file": null,
					"delete_file": "crimes/delete_folders_to_investigation_crimes.php",
					"search_file": null
				}
			},
			{
				"id": "folders-to-investigation-nuc",
				"name": "folders_to_investigation_nuc",
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
				"required": true,
				"service": null
			},
			/*{
				"id": "folders-to-investigation-channeling-reason",
				"name": "folders_to_investigation_channeling_reason",
				"type": "text",
                "placeholder": "Ingresa Motivo",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},*/
            /*{
				"id": "folders-to-investigation-unity",
				"name": "folders_to_investigation_unity",
				"type": "select",
                "placeholder": "Selecciona Unidad",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_unities.php',
					data: null
				},
				"required": true,
				"service": null
			},*/
			{
				"id": "folders-to-investigation-channeling-reason",
				"name": "folders_to_investigation_channeling_reason",
				"type": "select",
                "placeholder": "Selecciona Motivo",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_channeling_reason.php',
					data: null
				},
				"required": true,
				"service": null
			}
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"people_served": {
		"index": 4,
		"form_file": "people_served_form.php",
		"search_form_file": null,
		"create_file": "create_people_served_section.php",
		"update_file": "update_people_served_section.php",
		"search_file": "search_people_served_section.php",
		"records_by_month_file": "get_people_served_records_by_month.php",
		"form_id": "people-served-form",
		"navigation_element_id": "people-served-nav-div",
		"name": "people_served",
		"title": "PERSONAS ATENDIDAS",
		"fields": [
			{
				"id": "people-served-date",
				"name": "people_served_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "people-served-crime",
				"name": "people_served_crime",
				"type": "multiselect",
                "placeholder": "Selecciona Delitos",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_crimes.php',
					data: null
				},
				"required": true,
				"service": {
					"create_file": "crimes/create_people_served_crimes.php",
					"update_file": null,
					"delete_file": "crimes/delete_people_served_crimes.php",
					"search_file": null
				}
			},
			{
				"id": "people-served-nuc",
				"name": "people_served_nuc",
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
				"required": true,
				"service": null
			}/*,
			{
				"id": "people-served-number",
				"name": "people_served_number",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "people-served-unity",
				"name": "people_served_unity",
				"type": "select",
				"placeholder": "Selecciona Unidad",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_unities.php',
					data: null
				},
				"required": true,
				"service": null
			}*/
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"processing_folders": {
		"index": 5,
		"form_file": "processing_folders_form.php",
		"search_form_file": null,
		"create_file": "create_processing_folders_section.php",
		"update_file": "update_processing_folders_section.php",
		"search_file": "search_processing_folders_section.php",
		"records_by_month_file": "get_processing_folders_records_by_month.php",
		"form_id": "processing-folders-form",
		"navigation_element_id": "processing-folders-nav-div",
		"name": "processing_folders",
		"title": "CARPETAS DE TRÁMITE",
		"fields": [
			/*{
				"id": "processing-folders-facilitator",
				"name": "processing_folders_facilitator",
				"type": "text",
				"placeholder": "Ingresa Facilitador",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},*/
			{
				"id": "processing-folders-initial-date",
				"name": "processing_folders_initial_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-finish-date",
				"name": "processing_folders_finish_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-folders",
				"name": "processing_folders_folders",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-inmediate-attention",
				"name": "processing_folders_inmediate_attention",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-cjim",
				"name": "processing_folders_cjim",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-domestic-violence",
				"name": "processing_folders_domestic_violence",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-cyber-crimes",
				"name": "processing_folders_cyber_crimes",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-teenagers",
				"name": "processing_folders_teenagers",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-swealth-and-finantial-inteligence",
				"name": "processing_folders_swealth_and_finantial_inteligence",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-high-impact-and-vehicles",
				"name": "processing_folders_high_impact_and_vehicles",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-human-rights",
				"name": "processing_folders_human_rights",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-fight-corruption",
				"name": "processing_folders_fight_corruption",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-special-matters",
				"name": "processing_folders_special_matters",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-internal-affairs",
				"name": "processing_folders_internal_affairs",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-litigation",
				"name": "processing_folders_litigation",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "processing-folders-environment",
				"name": "processing_folders_environment",
				"type": "number",
				"placeholder": "Ingresa Numero",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 0,
				"catalog": null,
				"required": true,
				"service": null
			}
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"folders_to_validation": {
		"index": 6,
		"form_file": "folders_to_validation_form.php",
		"search_form_file": "search_folders_to_validation_form.php",
		"create_file": "create_folders_to_validation_section.php",
		"update_file": "update_folders_to_validation_section.php",
		"search_file": "search_folders_to_validation_section.php",
		"records_by_month_file": "get_folders_to_validation_records_by_month.php",
		"form_id": "folders-to-validation-form",
		"navigation_element_id": "folders-to-validation-nav-div",
		"name": "folders_to_validation",
		"title": "CARPETAS ENVIADAS A VALIDACIÓN",
		"fields": [
			{
				"id": "folders-to-validation-date",
				"name": "folders_to_validation_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "folders-to-validation-crime",
				"name": "folders_to_validation_crime",
				"type": "multiselect",
                "placeholder": "Selecciona Delitos",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_crimes.php',
					data: null
				},
				"required": true,
				"service": {
					"create_file": "crimes/create_folders_to_validation_crimes.php",
					"update_file": null,
					"delete_file": "crimes/delete_folders_to_validation_crimes.php",
					"search_file": null
				}
			},
			{
				"id": "folders-to-validation-nuc",
				"name": "folders_to_validation_nuc",
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
				"required": true,
				"service": null
			}/*,
			{
				"id": "folders-to-validation-unity",
				"name": "folders_to_validation_unity",
				"type": "select",
				"placeholder": "Selecciona Unidad",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_unities.php',
					data: null
				},
				"required": true,
				"service": null
			}*/
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"entered_folders_super": {
		"index": 9,
		"form_file": "entered_folders_super_form.php",
		"search_form_file": null,
		"create_file": "create_entered_folders_section.php",
		"update_file": "update_entered_folders_section.php",
		"search_file": "search_entered_folders_section.php",
		"records_by_month_file": "get_entered_folders_records_by_month.php",
		"records_by_day_file": "get_entered_folders_records_by_day.php",
		"form_id": "entered-folders-super-form",
		"navigation_element_id": "entered-folders-super-nav-div",
		"name": "entered_folders_super",
		"title": "CARPETAS INGRESADAS",
		"fields": [
			{
				"id": "entered-folders-date",
				"name": "entered_folders_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-crime",
				"name": "entered_folders_crime",
				"type": "multiselect",
				"placeholder": "Selecciona Delito",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_crimes.php',
					data: null
				},
				"required": true,
				"service": {
					"create_file": "crimes/create_entered_folders_crimes.php",
					"update_file": null,
					"delete_file": "crimes/delete_entered_folders_crimes.php",
					"search_file": null
				}
			},
			{
				"id": "entered-folders-nuc",
				"name": "entered_folders_nuc",
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
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-unity",
				"name": "entered_folders_unity",
				"type": "select",
				"placeholder": "Selecciona Unidad",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_unities.php',
					data: null
				},
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-mp-channeler",
				"name": "entered_folders_mp_channeler",
				"type": "text",
				"placeholder": "Ingresa MP Canalizador",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-priority",
				"name": "entered_folders_priority",
				"type": "select",
				"placeholder": "Selecciona",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-recieved-folder",
				"name": "entered_folders_recieved_folder",
				"type": "select",
				"placeholder": "Selecciona",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-rejection-reason",
				"name": "entered_folders_rejection_reason",
				"type": "select",
				"placeholder": "Selecciona",
				"event_listener": 'onchange="onChangeRejectionReason()"',
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 1,
				"catalog": {
					service_file: 'get_rejection_reasons.php',
					data: null
				},
				"required": false,
				"service": null
			},
			{
				"id": "entered-folders-channeler",
				"name": "entered_folders_channeler",
				"type": "text",
				"placeholder": "Ingresa canalizador",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-fiscalia",
				"name": "entered_folders_fiscalia",
				"type": "select",
				"placeholder": "Selecciona fiscalía",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-municipality",
				"name": "entered_folders_municipality",
				"type": "select",
				"placeholder": "Selecciona municipio",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_municipalities.php',
					data: null
				},
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-observations",
				"name": "entered_folders_observations",
				"type": "text",
				"placeholder": "Ingresa observaciones",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-folders-date",
				"name": "entered_folders_folders_date",
				"type": "date",
				"placeholder": "Ingresa",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 'today',
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-facilitator",
				"name": "entered_folders_facilitator",
				"type": "select",
				"placeholder": "Selecciona facilitador",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_facilitators.php',
					data: null
				},
				"required": true,
				"service": null
			}/*,
			{
				"id": "entered-folders-book-date",
				"name": "entered_folders_book_date",
				"type": "date",
				"placeholder": "Ingresa",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 'today',
				"catalog": null,
				"required": true,
				"service": null
			}*/
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"entered_folders": {
		"index": 8,
		"form_file": "entered_folders_form.php",
		"search_form_file": "search_entered_folders_form.php",
		"create_file": "create_entered_folders_section.php",
		"update_file": "update_entered_folders_section.php",
		"search_file": "search_entered_folders_section.php",
		"records_by_month_file": "get_entered_folders_records_by_month.php",
		"form_id": "entered-folders-form",
		"navigation_element_id": "entered-folders-nav-div",
		"name": "entered_folders",
		"title": "CARPETAS INGRESADAS",
		"fields": [
			{
				"id": "entered-folders-date",
				"name": "entered_folders_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-crime",
				"name": "entered_folders_crime",
				"type": "multiselect",
                "placeholder": "Selecciona Delitos",
				"event_listener": null,
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": {
					service_file: 'get_crimes.php',
					data: null
				},
				"required": true,
				"service": {
					"create_file": "crimes/create_entered_folders_crimes.php",
					"update_file": null,
					"delete_file": "crimes/delete_entered_folders_crimes.php",
					"search_file": null
				}
			},
			{
				"id": "entered-folders-nuc",
				"name": "entered_folders_nuc",
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
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-unity",
				"name": "entered_folders_unity",
				"type": "select",
				"placeholder": "Selecciona Unidad",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_unities.php',
					data: null
				},
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-mp-channeler",
				"name": "entered_folders_mp_channeler",
				"type": "text",
				"placeholder": "Ingresa MP Canalizador",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-priority",
				"name": "entered_folders_priority",
				"type": "select",
				"placeholder": "Selecciona",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-recieved-folder",
				"name": "entered_folders_recieved_folder",
				"type": "select",
				"placeholder": "Selecciona",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-rejection-reason",
				"name": "entered_folders_rejection_reason",
				"type": "select",
				"placeholder": "Selecciona",
				"event_listener": 'onchange="onChangeRejectionReason()"',
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 1,
				"catalog": {
					service_file: 'get_rejection_reasons.php',
					data: null
				},
				"required": false,
				"service": null
			},
			{
				"id": "entered-folders-fiscalia",
				"name": "entered_folders_fiscalia",
				"type": "select",
				"placeholder": "Selecciona fiscalía",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_fiscalias.php',
					data: null
				},
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-municipality",
				"name": "entered_folders_municipality",
				"type": "select",
				"placeholder": "Selecciona municipio",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": {
					service_file: 'get_municipalities.php',
					data: null
				},
				"required": true,
				"service": null
			},
			{
				"id": "entered-folders-observations",
				"name": "entered_folders_observations",
				"type": "text",
				"placeholder": "Ingresa observaciones",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": null,
				"catalog": null,
				"required": true,
				"service": null
			}/*,
			{
				"id": "entered-folders-book-date",
				"name": "entered_folders_book_date",
				"type": "date",
				"placeholder": "Ingresa",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": 'today',
				"catalog": null,
				"required": true,
				"service": null
			}*/
		],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"inegi": {
		"index": 9,
		"form_file": "inegi_form.php",
		"search_form_file": null,
		"create_file": "create_inegi_section.php",
		"update_file": "update_inegi_section.php",
		"search_file": "search_inegi_section.php",
		"records_by_month_file": null,
		"form_id": "entered-folders-form",
		"navigation_element_id": "inegi-nav-div",
		"name": "inegi",
		"title": "INEGI",
		"fields": [],
		"active": false,
		"data": [],
		"loaded_data": false
	},
	"rejected_folders": {
		"index": 10,
		"form_file": "rejected_folders_form.php",
		"search_form_file": null,
		"create_file": "create_rejected_folders_section.php",
		"update_file": "update_rejected_folders_section.php",
		"search_file": "search_rejected_folders_section.php",
		"records_by_month_file": "get_rejected_folders_records_by_month.php",
		"records_by_day_file": "get_rejected_folders_records_by_day.php",
		"form_id": "rejected-folders-form",
		"navigation_element_id": "rejected-folders-nav-div",
		"name": "rejected_folders",
		"title": "CARPETAS RECHAZADAS",
		"fields": [
			{
				"id": "rejected-folders-initial-date",
				"name": "rejected_folders_initial_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "rejected-folders-finish-date",
				"name": "rejected_folders_finish_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			}
		],
		"active": false,
		"data": [],
		"loaded_data": false
	}
}

var subsection = {
	"people_served": {
		"fields": [
			{
				"id": "rejected-folders-initial-date",
				"name": "rejected_folders_initial_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			},
			{
				"id": "rejected-folders-finish-date",
				"name": "rejected_folders_finish_date",
				"type": "date",
				"placeholder": "Ingresa Fecha",
				"event_listener": null,
				"conditions": {
					"unlock": null,
					"length": null
				},
				"default": "today",
				"catalog": null,
				"required": true,
				"service": null
			}
		]
	}
}