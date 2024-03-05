function getHTMLTableTemplate(attr){

    let sections = {
        recieved_folders: 'templates/tables/htmltoexcel/recieved_folders_html_to_excel_table.php',
        enetered_folders: ''
    }

    return sections[attr.section];
}