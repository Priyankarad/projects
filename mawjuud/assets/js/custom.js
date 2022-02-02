$(document).ready(function(){
    $(window).load(function(){
        $('.loader').fadeOut();
    });
    $('.sidenav').sidenav();
    $(".phone").intlTelInput();
    $('.tooltipped').tooltip();
    $(".dropdown-trigger").dropdown();
    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: true
    });
    $('.tabs').tabs();
    var dateToday = new Date();    
    $('.datepicker').datepicker({ minDate: dateToday,dateFormat: 'dd-mm-yy'});
    $('#listproperty, #listproperty1, #listproperty2, #listproperty3').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        },
        navText: ["<span class='ti-angle-left'></span>","<span class='ti-angle-right'></span>"]
    });

    $('#logo_sliderM').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        }

    })  



//===========autocomplete==============//

// function initialize() {

//     var input = document.getElementById('City');

//     var autocomplete = new google.maps.places.Autocomplete(input);

//   }

// google.maps.event.addDomListener(window, 'load', initialize);







if ($(window).width() < 991){

    var GetHtml = $('.my_allmenus').html();

    $('#mobile-demo').html(GetHtml);

}





$('#bannerSlider').owlCarousel({

    loop:false,

    margin:0,

    animateOut: 'fadeOut',

    animateIn: 'fadeIn',

    nav:true,

    responsive:{

        0:{

            items:1

        },

        600:{

            items:1

        },

        1000:{

            items:1

        }

    }

})  





$(document).on('click', '.tab_3Tops #clickBuy', function(){

    $("#bannerSlider .owl-next").trigger("click");

})



$(document).on('click', '.tab_3Tops #clickRent', function(){

    $("#bannerSlider .owl-prev").trigger("click");

})


});

var storedFiles = [];
var index;
$('.selFile').on('click',function(){
    var images = $('#images').val();
    var source = $(this).data('source');
    if(source!=''){
        var img = images.split(",");
        img = jQuery.grep(img, function(value) {
        return value != source;
        });
        $('#images').val(img);
    }
});

$(document).ready(function() {
    $("#filesss").on("change", handleFileSelect);
    $("body").on("click", ".selFile", removeFile);
});

function handleFileSelect(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    filesArr.forEach(function(f) {      
        if(!f.type.match("image.*")) {
            return;
        }
        storedFiles.push(f);

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<div class='col s2 documentUploadS'><img class='imageThumb' src='"+e.target.result+"' title='"+f.name+ "'></img><span class='ti-close selFile' data-file='"+f.name+"'></span></div>").appendTo("#dragimgappend");

        }
        reader.readAsDataURL(f); 
    });

}



function removeFile(e) {
    var file = $(this).data("file");
    for(var i=Number(0);i<Number(storedFiles.length);i++) {
        if(storedFiles[i].name === file) {
            storedFiles.splice(i,1);
            break;
        }
    }
    $(this).closest(".documentUploadS").remove();
}
