/*code for selecting multiple options*/
$('.courses').select2({
    placeholder: "Select Option",
    allowClear: true,
});

/*code for client side validation*/
//$('.managementForm').validationEngine();

/*code for reading the image src and updating it*/
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#logo').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function(){  

    $(document).on('change','#school_logo',function () {
        readURL(this);
    });

    $(document).on('click','#delete',function(){
        return confirm('Are you sure want to delete?');
    });
});