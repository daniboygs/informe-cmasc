var sections = {
	"agreements": {
		"index": 1,
		"form_file": "imputed_agreements_form.php",
		"create_file": "create_agreements_section.php",
		"update_file": "update_agreements_section.php",
		"search_file": "search_agreements_section.php",
		"sidebar_div_id": "agreements-side-div",
		"name": "acuerdos",
		"title": "Acuerdos celebrados",
		"fields": [
            {
				"id": "agreement-date",
				"name": "agreement_date",
                "type": "date",
                "placeholder": "Ingresa Fecha",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
			},
			{
				"id": "agreement-crime",
				"name": "agreement_crime",
				"type": "select",
                "placeholder": "Selecciona Delito",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
			},
			{
				"id": "agreement-intervention",
				"name": "agreement_intervention",
				"type": "number",
                "placeholder": "Ingresa Intervensión",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
			},
			{
				"id": "agreement-nuc",
				"name": "agreement_nuc",
				"type": "text-number",
                "placeholder": "Ingresa NUC",
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
				"id": "agreement-compliance",
				"name": "agreement_compliance",
				"type": "text",
                "placeholder": "Ingresa Cumplimiento",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
            },
            {
				"id": "agreement-total",
				"name": "agreement_total",
				"type": "select",
                "placeholder": "Selecciona",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
            },
            {
				"id": "agreement-mechanism",
				"name": "agreement_mechanism",
				"type": "text",
                "placeholder": "Ingresa Mecanismo",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
            },
            {
				"id": "agreement-amount",
				"name": "agreement_amount",
				"type": "number",
                "placeholder": "Ingresa Monto",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
            },
            {
				"id": "agreement-unity",
				"name": "agreement_unity",
				"type": "select",
                "placeholder": "Selecciona Unidad",
                "conditions": {
                    "unlock": null,
                    "length": null
                },
				"default": null,
				"catalog": null,
				"required": true
			}
		],
		"active": true,
		"data": [],
		"loaded_data": false
	}
}