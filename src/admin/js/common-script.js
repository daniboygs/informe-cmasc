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

function generateTempName(){

    let today = new Date();
    
    let date = today.getFullYear()+''+(today.getMonth()+1)+''+today.getDate();

    var time = today.getHours() + "" + today.getMinutes() + "" + today.getSeconds();

    return 'request_'+date+''+time;
}

function downloadExcel(attr){

    var uri = 'data:application/vnd.ms-excel;base64,'
      , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta cha' + 'rset="UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>{table}</body></html>'
      , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
      , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    
    var ctx = {worksheet: name || 'Worksheet', table: attr.table}
    window.location.href = uri + base64(format(template, ctx));
}

function formJsonFromFormElements(attr){
    
    let json_data = {};

    for(element in attr.elements){

        json_data = {
           ...json_data,
            [attr.elements[element].json_key]: document.getElementById(attr.elements[element].id).value
        }
    }

    return json_data;
}