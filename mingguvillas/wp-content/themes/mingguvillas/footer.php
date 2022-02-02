<?php
/**
* The template for displaying the footer
*
* Contains the closing of the #content div and all content after.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package WordPress
* @subpackage Twenty_Seventeen
* @since 1.0
* @version 1.2
*/
require_once( get_parent_theme_file_path( 'countrylist.php' ) );
session_start();
$currency = 'USD';
if(!empty($_SESSION['to_currency'])){
    $currency = $_SESSION['to_currency'];
}

if(empty($_SESSION['symbols'])){
    $_SESSION['symbols'] = $symbol;
}

?>
<input type="hidden" id="site_url" value="<?php echo home_url();?>/">
<section class="footer">
    <div class="footer_section">
        <div class="container">

            <div class="row">
                <div class="col-md-3 col-sm-12 col-12 ColSleOrM">
                    <div class="selector ftNselct currency_selector text-center">
                        <form id="currencyForm" action="#" method="post">
                            <select class="currency_select">
                                <!-- <option value="dummy" <?php echo ($currency == 'dummy')?'selected':'';?>>Currency </option> -->
                                <?php 
                                foreach( $age as $x => $x_value ) { ?>
                                    <option value="<?php echo $x; ?>" <?php echo ($currency == $x)?'selected':'';?>><?php echo $x." ".$x_value;?></option> 
                                <?php } ?>
                            </select>
                        </form>


                    </div>
                    <div class="bankttranS_logo forZidx">
                        <img src="<?php  bloginfo('template_url');?>/assets/images/bank_transfr.png" alt="Image">
                        <img src="<?php  bloginfo('template_url');?>/assets/images/pay-pal-logo.png" alt="Image">
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-12 forZidx ColSleOrM2">
                    <div class="PayFooter text-center">
                        <ul class="nav-pay">
                            <li>
                                <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay1.png" alt="Image"></a>
                            </li>

                            <li>
                                <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/pay2.png" alt="Image"></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"> <img src="<?php  bloginfo('template_url');?>/assets/images/jcb.png" alt="Image"></a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col forZidx">
                    <div class="social_link text-center">
                        <p class="TouchP"> Touch here to Chat with us</p>
                        <ul class="nav-social">
                            <li>
                                <a class="facebook" href="https://www.facebook.com/mingguvillas" title="" rel="external" target="_blank"><img src="<?php  bloginfo('template_url');?>/assets/images/fb.png" alt="Image"></a>
                            </li>

                            <li>
                                <a class="instagram" href="https://www.instagram.com/mingguvillasbali/" title="" rel="external" target="_blank"><img src="<?php  bloginfo('template_url');?>/assets/images/instagram.png" alt="Image"></a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?phone=6287861916870&amp;text=Hello Minggu Villas,"><img src="<?php  bloginfo('template_url');?>/assets/images/whtsap.png" alt="Image"></a>

                            </li>
                            <li>
                                <a class="instagram" href="weixin://dl/chat?mingguvillas"  title="" rel="external"><img src="<?php  bloginfo('template_url');?>/assets/images/wecht.png" alt="Image"></a>
                            </li>
                            <li>
                                <a class="instagram" href="http://telegram.me/mingguvillas?text=Hello Minggu Villas," title="" rel="external"><img src="<?php  bloginfo('template_url');?>/assets/images/telegrm.png" alt="Image"></a>
                            </li>
                            <li>
                                <a class="instagram" href="line://oaMessage/@mingguvillas/?Hello Minggu Villas," title="" rel="external"><img src="<?php  bloginfo('template_url');?>/assets/images/linee.png" alt="Image"></a>
                            </li>

                        </ul>
                    </div>

                </div>



                <div class="col forZidx">
                    <div class="contact text-right">
                        <a class="clickable-phone phone" href="tel:+62 878 6191 6870" itemprop="telephone">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span>+62 878 6191 6870 </span>
                        </a>

                    </div>
                </div>

            </div>
        </div>

    </div>
<div class="loader" style="">
 <p>Book Direct and get Rewarded with More Benefits</p>
 </div>
</section>

<section class="footer_rights">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="all_rights">
                    <p>©2019 Minggu Villas Seminyak - Bali. All rights reserved <!-- Powered by <a href="http://www.lodgify.com">Lodgify.com</a> --></p>
                </div>
            </div>
        </div>
    </div>

<input type="hidden" id="img_url" value="<?php  bloginfo('template_url');?>/assets/images/">
</section>

<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/popper.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery.fancybox.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/aos.js"></script>
<script type='text/javascript' src='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/smoothscroll.js'></script>
<script type='text/javascript' src='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/owl.carousel.min.js'></script>
<script type='text/javascript' src='<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/jquery-ui.js'></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/custom.js"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/ply.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-jC_2G-SunfuCLwnkSml2Oq-L1k6uB70&callback=initMap" type="text/javascript"></script>
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/flatpickr.js"></script>
<script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
<!-- <script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/select2.min.js"></script> -->
<script src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/js/selectize.min.js"></script>

<script type="text/javascript">
    /*============aos==========*/

    AOS.init({
        easing: 'ease-in-out-sine'
    });

</script>
<script type="text/javascript">
    $(document).on('click','.deleteDates',function(){
        $('#start_date').val('');
        $('#end_date').val('');
        $("#start_date").datepicker("hide");
        $("#end_date").datepicker("hide");
    });
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();

//>=, not <=
if (scroll >= 50) {

    $(".main-header").addClass("headerbg");
}
else {
    $(".main-header").removeClass("headerbg");
}
});
</script>
<script>
    $(function() {
        $( "#date_ex5" ).datepicker();
    });
</script>

<script>
    $(function() {
        $( "#date_ex" ).datepicker();
    });
</script>

<script>
    $(function() {
        $( "#date_ex6" ).datepicker();
    });
</script>

<script>
    $(function() {
        $( "#date_ex2" ).datepicker();
    });
</script>

<script>
    $(function() {
        $( "#date_ex3" ).datepicker();
    });
</script>

<script>
    $(function() {
        $( "#date_ex4" ).datepicker();
    });
</script>

<script>
    $(function() {
        $( "#date_exnew" ).datepicker();
    });
</script>
<script>
    $('.deleteDates').hide();
    $(document).ready(function(){
        $(".TabViewShow").click(function(){
            $(this).parent().siblings(".OverContent").addClass('OverContentUp');
            $(this).siblings('.TabViewHide').show();
            $(this).hide();
        });

        $(".TabViewHide").click(function(){
            $(this).parent().siblings(".OverContent").removeClass('OverContentUp');
            $(this).siblings('.TabViewShow').show();
            $(this).hide();
        });
    });

    $(document).ready(function(){
        if ($(window).width() <767) {
            $('#pills-tabContent > div').removeClass('show active');
            $('.mobiitem').click(function(){
                $(this).next('.tab-pane').toggleClass('show active');
            })
        }
    })

    $(window).on('load', function () {

        $('.BodyPoUp').modal('show');
    });

    $(function () {
        $("#start_date1").datepicker({
            minDate: 0,
            dateFormat:'dd/mm/yy',
            onSelect: function(selected) {
                $("#end_date1").datepicker("option","minDate", selected)
            }
        });
        $("#end_date1").datepicker({
            minDate: 0,
            dateFormat:'dd/mm/yy', 
            onSelect: function (selected) {
                $("#start_date1").datepicker("option","maxDate", selected)
            }
        });
    });

    $('ul').each(function(i) {
        if ( i === 4 || i === 5 ) {
            $(this).addClass('third_sub_menu');
        }
        if(i === 4){
            $(this).addClass('villaUL');
        }
        if(i === 5){
            $(this).addClass('seminyakUL');
        }
        if(i === 6){
            $(this).addClass('kerobokanUL');
        }
    });


    $(document).ready(function() {  
        $("#menu-item-23 > ul").after('<i class="fa fa-angle-down ovr-lep"></i>'); 
        $("#menu-item-24 > ul").after('<i class="fa fa-angle-down"></i>');
        $("#menu-item-24 > ul li").addClass('openAnchor');
        $("#menu-item-825 > ul li").addClass('openAnchor');
        $("#menu-item-27 > ul li").addClass('openAnchor');
        $(".seminyakUL").addClass('openAnchor');
        $(".kerobokanUL").addClass('openAnchor');
        $("#menu-item-27 > ul li").addClass('openAnchor');
        $("#menu-item-865").addClass('openAnchor');
        $("#menu-item-866").addClass('openAnchor');
        $("#menu-item-867").addClass('openAnchor');
        $("#menu-item-27 > ul").after('<i class="fa fa-angle-down"></i>');
        $("#menu-item-825 > ul").after('<i class="fa fa-angle-down"></i>');
        $("#menu-item-801 > ul").after('<i class="fa fa-angle-down"></i>');
        $("#menu-item-802 > ul").after('<i class="fa fa-angle-down"></i>');
        $("#menu-item-873 > ul").after('<i class="fa fa-angle-down"></i>');
        $("#menu-item-873 > a").addClass('villaAnchor');
        $("#menu-item-873 > a").attr('href','javascript:void(0);');
        $("#menu-item-876 > ul").after('<i class="fa fa-angle-down"></i>');
        $("#menu-item-875 > ul").after('<i class="fa fa-angle-down"></i>');
        $('#menu-item-24').addClass('superParent');
        $('#menu-item-825').addClass('superParent');
        $('#menu-item-27').addClass('superParent');
    });


    $(document).ready(function() {
        $('.currency_select').selectize({    plugins: ['remove_button'],onDropdownOpen: function () {
            this.clear();
        }
    });
        $('.currency_select1').selectize({    plugins: ['remove_button'],onDropdownOpen: function () {
            this.clear();
        }
    });
        $('.currency_select11').selectize({    plugins: ['remove_button'],onDropdownOpen: function () {
            this.clear();
        }
    });
    });   
    $(document).on('change','.currency_select',function(){

        var currency = $(this).val();
        if(currency!=''){
            var site_url = $('#site_url').val();
            var data = {
                'action': 'set_currency',
                'currency':currency
            };

            var ajaxurl = site_url+'/wp-admin/admin-ajax.php';
            jQuery.post(ajaxurl, data, function(response) {
                location.reload();
            });
        }
    });

    var mobile = '';
    var event = '';
    checkOperatingSystem();
    function checkOperatingSystem()
    {
        var  userAgent = navigator.userAgent || navigator.vendor || window.opera;
        if (/android/i.test(userAgent)) {
            mobile = 'android';
            event = ' touchmove';
        }

        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            mobile = 'ios';
            event = ' touchstart';
        }
    }

    var villa = 0;
    var kerobokan = 0;
    var seminyak = 0;

    if(mobile == 'android'){
        $(document).on('click'+event,'#menu-item-876',function(){
            villa = 0;
            if(seminyak == 0){
                $('.kerobokanUL').hide();
                $('.seminyakUL').show();
                seminyak = 1;
                activeLi(this);
            }else{
                $('.seminyakUL').hide();
                seminyak = 0;
                activeLi('remove');
            }
        });

        $(document).on('click'+event,'#menu-item-875',function(){
            villa = 0;
            if(kerobokan == 0){
                $('.seminyakUL').hide();
                $('.kerobokanUL').show();
                kerobokan = 1;
                activeLi(this);
            }else{
                $('.kerobokanUL').hide();
                kerobokan = 0;
                activeLi('remove');
            }
        });

        $(document).on('click'+event,'#menu-item-873',function(){
            $('.superParent ul').hide();
            if(villa == 0){
                $('.villaUL').show();
                villa = 1;
                activeLi(this);
            }else{
                $('.villaUL').hide();
                villa = 0;
                activeLi('remove');
            }
        });
    }else if(mobile == 'ios'){
        $(document).on(event,'#menu-item-876',function(){
            villa = 0;
            if(seminyak == 0){
                $('.kerobokanUL').hide();
                $('.seminyakUL').show();
                seminyak = 1;
                activeLi(this);
            }else{
                $('.seminyakUL').hide();
                seminyak = 0;
                activeLi('remove');
            }
        });

        $(document).on(event,'#menu-item-875',function(){
            villa = 0;
            if(kerobokan == 0){
                $('.seminyakUL').hide();
                $('.kerobokanUL').show();
                kerobokan = 1;
                activeLi(this);
            }else{
                $('.kerobokanUL').hide();
                kerobokan = 0;
                activeLi('remove');
            }
        });

// $(document).on(event,'.villaAnchor',function(){
//     $('.superParent ul').hide();
//     if(villa == 0){
//         $('.villaUL').show();
//         villa = 1;
//         activeLi($(this).parent('li'));
//     }else{
//         $('.villaUL').hide();
//         villa = 0;
//         activeLi('remove');
//     }
// });

$(document).on(event,'#menu-item-873',function(){
    $('.superParent ul').hide();
    if(villa == 0){
        $('.villaUL').show();
        villa = 1;
        activeLi(this);
    }else{
        $('.villaUL').hide();
        villa = 0;
        activeLi('remove');
    }
});
}





var destination = 0;
$(document).on('click'+event,'#menu-item-24',function(){
    $('li ul').hide();
    if(destination == 0){
        $(this).find('ul').show();
        destination = 1;
        activeLi(this);
    }else{
        $(this).find('ul').hide();
        destination = 0;
        activeLi('remove');
    }
});

var gallery = 0;
$(document).on('click'+event,'#menu-item-27',function(){
    $('li ul').hide();
    if(gallery == 0){
        $(this).find('ul').show();
        gallery = 1;
        activeLi(this);
    }else{
        $(this).find('ul').hide();
        gallery = 0;
        activeLi('remove');
    }
});

var review = 0;
$(document).on('click'+event,'#menu-item-825',function(){
    $('li ul').hide();
    if(review == 0){
        $(this).find('ul').show();
        review = 1;
        activeLi(this);
    }else{
        $(this).find('ul').hide();
        review = 0;
        activeLi('remove');
    }
});

function activeLi(current){
    $(".main_menu li a").removeClass('current-menu-item');
    $(".main_menu li").removeClass('current-menu-item');
    if(current!='remove'){
        $(current).addClass('current-menu-item');
    }
}

if((mobile == 'android') || (mobile == 'ios')){
    $(document).on('click'+event,'.openAnchor a',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $('#menu-item-33').find('a').attr('href','javascript:void(0);');
        window.location.href=url;
    });
}

function initMap() {
    var zoomLevel = 0;
    var location = $('#location').val();
    var hoverMarker = [];
    var markers = $('#markers').val();
    var zoomMap = $('#zoom').val();
    zoomMap = Number(zoomMap);
    var myOptions = {
        zoom: zoomMap,
        center: new google.maps.LatLng(-8.688890,115.168807),
    };

    var map = new google.maps.Map(document.getElementById("map"),myOptions);
    var infowindow = new google.maps.InfoWindow(), marker, lat, lng;
    var json=JSON.parse(markers);
    var img_url = $('#img_url').val();
    for(var o in json){
        lat = json[o].lat;
        lng=json[o].lng;
        name=json[o].name;
        city=json[o].city;
        villa_id=json[o].villa_id;
        image=json[o].image;
        price=json[o].price;

        var color;
        if(city == 'Seminyak'){
            color = 'red';
        }else{
            color = 'blue';
        }
        var url = img_url+color+'-dot.png';
        var regIcon = {
            url: url,
            scaledSize: new google.maps.Size(32, 32)
        };
    
        html ='<div id="villaDiv" style="max-width:225px;"><image src="'+image+'" width="100%" height="60%"><br/><span>'+name+'</span><br/><span>Start From : '+price+'</span><br/><span class="includes">Includes Taxes and Fees</span></div>';
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng),
            name:html,
            city:city,
            map: map,
            icon: regIcon
        }); 
        var interval = null;
        google.maps.event.addListener( marker, 'mouseover', function(e){
       // google.maps.event.addListener( marker, 'click', function(e){
            infowindow.setContent( this.name );
            infowindow.open( map, this );
            var iconUrl = getIcon(this.city,'mouseover');
            this.setIcon(iconUrl);
            // toggleBounce(this);
            var this_ = this;
            interval = setInterval(function(){ this_.setAnimation(google.maps.Animation.BOUNCE); }, 100);

            // zoomLevel = Number(zoomLevel)+Number(14);
            // map.setZoom(zoomLevel);
            // map.panTo(this_.position);

        }.bind( marker ) );

        var zoomClick = 0;
        google.maps.event.addListener( marker, 'click', function(e){
            var this_ = this;
            interval = setInterval(function(){ this_.setAnimation(google.maps.Animation.BOUNCE); }, 100);
            zoomClick++;
            if(zoomClick == 1){
                zoomLevel = Number(zoomLevel)+Number(18);
            }else{
                zoomLevel = Number(zoomLevel)+Number(3);
            }
            map.setZoom(zoomLevel);
            map.panTo(this_.position);
        }.bind( marker ) );

        google.maps.event.addListener( marker, 'mouseout', function(e){
            var iconUrl = getIcon(this.city,'mouseout');
            this.setIcon(iconUrl);
            infowindow.close( map, this );
            this.setAnimation(null);
            clearInterval(interval);
        }.bind( marker ) );

        hoverMarker[villa_id] = marker;
    }
    $(document).on('mouseover','.hoverVilla .w-100',function(){
        var villaID = $(this).data('villa_id');
        google.maps.event.trigger(hoverMarker[villaID],'mouseover');
    });
    $(document).on('mouseout','.hoverVilla .w-100',function(){
        var villaID = $(this).data('villa_id');
        google.maps.event.trigger(hoverMarker[villaID],'mouseout');
    });
}
function getIcon(city,event){
    var img_url = $('#img_url').val();
    if(city == 'Seminyak'){
        color = 'red';
    }else{
        color = 'blue';
    }
    var icon;
    var url = img_url+color+'-dot.png';
    if(event == 'mouseout'){
        icon = {
            url: url,
            scaledSize: new google.maps.Size(32, 32)
        };
    }
    else{
        icon = {
            url: url,
            scaledSize: new google.maps.Size(48, 48)
        }
    }
    return icon;
}

function toggleBounce(currentIcon) {
    currentIcon.setAnimation(null);
    if (currentIcon.getAnimation() !== null) {
        currentIcon.setAnimation(null);
    } else {
        currentIcon.setAnimation(google.maps.Animation.BOUNCE);
    }
};

$(document).ready(function(){
    //window.onload = function WindowLoad(event) {
    $(window).load(function(){
        var zoomMobile = 9;
        if ($(window).width() < 767) {
            zoomMobile = 7;
        }
        var myOptions = {
            zoom: zoomMobile,
            center: new google.maps.LatLng(-8.388890,115.168807),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map1 = new google.maps.Map(document.getElementById("villaMap"), myOptions);
        var latitude = $('#latitude').val();
        var longitude = $('#longitude').val();
        var myLatLng = {lat: Number(latitude), lng: Number(longitude)};
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map1,
        });
        google.maps.event.addListener( marker, 'click', function(e){
            map1.setZoom(13);
            map1.panTo(this.position);
        }.bind( marker ) );
    });
});

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return results[1] || 0;
}

window.onload = function () {
var villaURL = $.urlParam('villa');
if(villaURL == 1){
    $('#start_date').focus();
}
}
//loder-js
$(window).load(function(){
     $('.loader').fadeOut();
});
</script>

<style>
    span.select2-dropdown.select2-dropdown--above {
        min-width: 210px;
    }
    
</style>

<?php wp_footer(); ?>

</body>
</html>

