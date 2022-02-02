$("#contactForm").validate({
    errorPlacement: function (error, element) {
        error.css('color', 'red');
        error.insertAfter(element);
    },
    rules: {
        name:{
            required: true
        },
        subject: {
            required: true,

        },
        message: {
            required: true,
        },
        email: {
            email: true,
            required: true,
        }
    },
}); 


/*To contact*/
$(".cnt-submit").click(function(e){
    e.preventDefault();
     if($("#contactForm").valid()){
        var formData = $('#contactForm').serialize();            
        $.ajax({
            url: baseUrl+ 'contact_us',
            type: 'post',
            dataType: 'json',
            data: formData,
            success: function (data) {
                if(data.status == 1){
                    Ply.dialog("alert",'Message sent successfully');
                }
                setTimeout(function () {
                    window.location.href = baseUrl+'contact_us';
                }, 3000); 
            },
        });
    }
});