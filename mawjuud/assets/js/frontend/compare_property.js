/*for adding property to compare list*/
function removeProperty(type,property_id){
    $('body').append(loader_ajax);
    $('.loader_outer').show();
    $.ajax({
        url: baseUrl+ 'property/removeProperty',
        type: 'post',
        dataType: 'json',
        data: {property_id:property_id,type:type},
        success: function (data) {
            $('.loader_outer').hide();
            if(data.status != 0){
                $('.compare_div'+property_id).hide();
            }
        },
    });
}

/*For redirecting to the last url*/
function goBack(event) {
   if ('referrer' in document) {
        window.location = document.referrer;
    } else {
        window.history.back();
    }
}