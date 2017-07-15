var template="<div class='form-group hide' id='bookTemplate'><div class='row'><div class='col-xs-4'><input type='text' class='form-control' name='contents[0][]' placeholder='Content' /></div><div class='col-xs-1'><button type='button' class='btn btn-default addButton'><i class='fa fa-plus'></i></button></div></div></div>";

$( "#content_type" ).change(function() {
    $type=$(this).val();
    showReliableForm($type);
});

$(document).ready(function(){
    bookIndex = 0;
    $('form')   // Add button click handler
        .on('click', '.addButton', function() {
            $('#content_catcher').append(template)
            bookIndex++;
            var $template = $('#bookTemplate');
                $clone    = $template
                    .clone()
                    .removeClass('hide')
                    .removeAttr('id')
                    .attr('data-book-index', bookIndex)
                    .insertBefore($template);
            // Update the name attributes
        })
});

function showReliableForm($type){
    var rows=1;
    switch($type){
        case "Table":
            rows = prompt("Number of rows", 1);
            break;
    }
    $dynamicTemplate=getDynamicRows(rows);
    $('#content_catcher').empty();
    $('#content_catcher').append($dynamicTemplate)

}

function getDynamicRows($rows){
    $input='';
    for($i=0; $i!=$rows; $i++){
        $input+="<div class='col-xs-2'><input type='text' class='form-control' name='contents["+$i+"][]' placeholder='Content' /></div>";
    }
    $dynamicTemplate="<div class='form-group' id='bookTemplate'><div class='row'>"+$input+"<div class='col-xs-1'><button type='button' class='btn btn-default addButton'><i class='fa fa-plus'></i></button></div></div></div>";
    return $dynamicTemplate;
}
