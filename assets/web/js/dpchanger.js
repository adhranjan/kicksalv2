Dropzone.autoDiscover = false;
var myDropzone = new Dropzone(".dropzone", {
    maxFileSize: 20,
    acceptedFiles: "jpeg,.jpg,.png,.gif",
    thumbnailWidth: 250,
    thumbnailHeight: 250,
    paramName: "image",
    maxFiles: 3,
});


myDropzone.on("success", function(file) {
    $newdp=$.parseJSON(file.xhr.responseText).avatar+'?width=400';
    $('#user_dp').attr('src',$newdp)
    $('#dpChanger').modal('hide')
});
myDropzone.on("error", function(file) {
    $error=$.parseJSON(file.xhr.responseText).image;
    alert($error)
    $('#dpChanger').modal('hide')
});


var username=null;
var user_name_parent=$( "#user_name_parent" );
var user_name_input_holder=$( "#user_name_input_holder" );
var user_name_input=$( "#user_name_input" );





$('#user_name_edit').click(function(){
    username = user_name_parent.text();
    user_name_parent.hide();
    user_name_input_holder.show();
});

user_name_input.focusout(function(){
    if($(this).val()!='' && $(this).val()!=null) {
        username=$(this).val();
        user_name_input_holder.hide();
        var data={'user_name': username}
        $.ajax({
            type: "POST",
            url: user_name_change_route,
            data:data,
        }).success(function (data) {
            user_name_parent.text(data.user_name);
            user_name_parent.show();
        })
    }
});
