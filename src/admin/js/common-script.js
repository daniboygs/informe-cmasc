function validateElementsByIdContent(attr){

    let validated = true;

    if(validateExistantElementsById({
        elements: attr.elements
    })){
        for(element in attr.elements){

            if(validated){

                switch(attr.elements[element].type){
                
                    case 'date':
                        if(attr.elements[element].value == '')
                            validated = false;
                        break;
                    case 'text':
                        if(attr.elements[element].value == '')
                            validated = false;
                        break;
                    default:
                }
            }
            else{
                break;
            }
        }
    }

    return validated;
}

function validateExistantElementsById(attr){

    let validated = true;

    for(element in attr.elements){

        if(!document.getElementById(attr.elements[element].id)){
            validated = false;
            break;
        }
    }

    return validated;
}

function formJsonPostDataByID(attr){

    let json_data = {};

    for(element in attr.elements){

        json_data = {
            ...json_data,
            [attr.elements[element].json_key]: document.getElementById(attr.elements[element].id).value
        }
    }

    return json_data;

}