<?php
/*
Template name:contact
*/
require_once( get_parent_theme_file_path( 'countrylist1.php' ) );
session_start();
$propertyID = $_SESSION['durationPrice']['propertyID'];
$currenDate = date('Y-m-d');
$oneYearDate = date('Y-m-d',strtotime('+1 years'));
$result =  getAvailability($propertyID,$currenDate,$oneYearDate); 
$rooms = $result['RoomsAvailability']['RoomAvailability']['DayAvailability'];

$alottedRooms = array();
$roomPrice = array();
if(!empty($rooms)){
  foreach($rooms as $room){
    if($room['Alot'] == 0){
      $alottedRooms[] = date('d-m-Y',strtotime($room['@attributes']['day']));
    }
    $date = date('d-m-Y',strtotime($room['@attributes']['day']));
    $roomPrice[$date] = number_format($room['Price']);
  }
}

$endDate = $alottedRooms;
$endDateNew = $alottedRooms;
$nextCheckoutDates = array();
foreach($endDate as $key=>$date){
  $prevDate = date('d-m-Y', strtotime($date .' -1 day'));
  if(!in_array($prevDate, $endDate)){
$endDateNew = array_values(array_diff($endDateNew, array($date)));//if the previous date is not allotted then enable(to allow select) the next date for checkout.
$nextCheckoutDates[] = $date;
}
}

/*for not higlighting today's date*/
$date = date('d-m-Y');
$endDateNew[] = date('d-m-Y');
$nextCheckoutDates = array_values(array_diff($nextCheckoutDates, array($date)));


/*currency conversion code*/ 
$toCurrency = 'USD';
if(!empty($_SESSION['to_currency'])){
  $toCurrency = $_SESSION['to_currency'];
}
$currencies = array();
$rates = 0;
if(!empty($_SESSION['exchangeRates'])){
  $currencies = (array)$_SESSION['exchangeRates'];
  $rates = $currencies[$toCurrency];
}
if(!empty($_SESSION['symbols'])){
  $symbols = $_SESSION['symbols'];
  $symbol = $symbols[$toCurrency];
}


$endDate = $alottedRooms;
$endDateNew = $alottedRooms;
foreach($endDate as $key=>$date){
  $prevDate = date('d-m-Y', strtotime($date .' -1 day'));
  if(!in_array($prevDate, $endDate)){
    $endDateNew = array_values(array_diff($endDateNew, array($date)));
  }
}

get_header('one');
?>
    <style type="text/css">
    .drop-item {
        display: block;
        position: relative;
    }

    .nav-content {
        margin-left: 20px;
        display: none;
        flex-direction: column;
    }

    .drop+.nav-content {
        display: block;
    }

    .nav-content a .drop-item {
        margin-bottom: 2%;
    }
</style>
<input type="hidden" id="symbol" value="<?php echo $symbol;?>">
<input type="hidden" id="currency_rate" value="<?php echo $rates;?>">
<input type="hidden" id="start" value="<?php echo $_SESSION['durationPrice']['start_date'];?>">
<input type="hidden" id="end" value="<?php echo $_SESSION['durationPrice']['end_date'];?>">
<input type="hidden" id="villa" value="<?php echo $_SESSION['name'];?>">

<input type="hidden" id="address" value="<?php echo !empty($_SESSION['address_line_1'].'<br>'.$_SESSION['address_line_2'])?'Jl.Kunti 1, Gang Mangga,<br>
80361 Seminyak, Kuta, Bali, Indonesia':'';?>">
<section class="ContactSection">
  <div class="BdBack">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="Symkheading">
            <h1><?php the_field('contact_page_title'); ?></h1>
            <p><?php the_field('contact_page_description'); ?></p>
          </div>
        </div>
      </div>
      <!--  ==========colmn 12 end======= -->


      <div class="row">
        <div class="col-md-8 col-sm-12 col-12">
          <div class="SymkheadingCol">
            <h1>Contact</h1>
            <?php echo do_shortcode('[contact-form-7 id="218" title="Contact form 1"]'); ?>
          </div>
        </div>
        <!--  ==========colmn 12 end======= -->

        <div class="col-md-4">


          <div class="widget-content ConSidWid">
            <p><strong id="villa_title"><?php the_field('contact_page_minggu_vilas_title'); ?></strong><br></p>
            <p>  <strong><?php the_field('contact_page_location_title'); ?></strong></p>

            <p id="villa_location"> <?php the_field('contact_page_location_description'); ?></p>



            <p><strong><br></strong></p>

            <p><strong><?php the_field('contact_page_phone_title'); ?></strong></p>

            <p><strong></strong></p>

            <p><a href="https://api.whatsapp.com/send?phone=6287861916870&text=Hello Minggu Villas," target="_blank">
              <?php the_field('contact_page_phone_description_one'); ?>&nbsp;<img src="https://cdn.pixabay.com/photo/2015/08/03/13/58/soon-873316_640.png" width="20px" alt=""/></a></p>
              <p><a href="tel:+62 361 474 0667"><?php the_field('contact_page_phone_description_two'); ?>&nbsp;</a></p>

              <p><strong><br></strong></p>

              <p><strong><?php the_field('contact_page_email_title');?></strong></p>

              <p><a href="mailto:reservation@mingguvillas.com"><?php the_field('contact_page_email_description');?></a></p>

              <p></p>

              <p><strong><br></strong></p>

              <p><strong><?php the_field('contact_page_office_hours_title'); ?></strong></p>

              <p><?php the_field('contact_page_office_hours_time_first'); ?><br><?php the_field('contact_page_office_hours_time_second'); ?></p>

              <!--<p><?php the_field('contact_page_office_hours_time_third'); ?></p>-->

              <p>  <strong><br></strong></p>

              <p>  <strong><?php the_field('contact_page_language_title'); ?></strong></p>

              <p>
                <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/1-flag.png" alt=""/>&nbsp;&nbsp;<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/2-flag.png" alt=""/>&nbsp;&nbsp;<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/3-flag.png" alt=""/> <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/images/4-flag.png" alt=""/>
              </p>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>
  <?php 
  get_footer();
  session_unset();
  session_destroy();
  ?>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.wpcf7-form').removeAttr('novalidate');
        $('.wpcf7-form').validate({
          error: function(label) {
            $(this).addClass("error");
          },
          rules: {
            "your-name": {
              required: true,
            },
            "phonetext-163": {
              required: true,
              minlength:4,
            },
            "your-email": {
              required: true,
              email: true,
            },
            "your-message": {
              required: true
            }
          },
          messages :{
            "your-name": {
              required: "* Required",
            },
            "phonetext-163": {
              required: "* Required",
              minlength: "* Required",
            },
            "your-email": {
              required: "* Required",
            },
            "your-message": {
              required: "* Required",
            }
          }
        });
        // $('#phone').val('');
        $(".wpcf7-form").validate().form();
      });


      $('#ul').hide();
      $('.dropDown').each(function() {
        $(this).click(function() {
          $('.drop').removeClass('drop');
          $(this).addClass('drop');
        })
      });
      $(document).on('click','#vname',function(){
        $('#ul').show();
      });

      $(document).on('click','.drop-item',function(){
        var item = $(this).data('villa');
        $('#vname').val(item);
        $('#ul').hide();
      });

      $(function () {
        var symbol = $('#symbol').val();
        var startDates = <?php echo json_encode($alottedRooms);?>;
        var roomPrice = <?php echo json_encode($roomPrice);?>;
        $("#startD").datepicker({
          beforeShow: addCustomInformation,
          minDate: 0,
          firstDay: 1,
          onChangeMonthYear: addCustomInformation,
          beforeShowDay: function(date){
              var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
              var year = date.getFullYear();
              var day = ( '0' + (date.getDate()) ).slice( -2 );
              var newdate = day+"-"+month+'-'+year;
              var dateClass = day+month+year;
              if ($.inArray(newdate, startDates) == -1) {
                addCustomInformation(roomPrice[newdate],dateClass,newdate);
                return [true, dateClass];
              } else {
                return [false, "highlight", "Unavailable"];
              }
          },  
          dateFormat:'dd/mm/yy',
          onSelect: function(selected) {
            $("#endD").datepicker("option","minDate", selected);
          }
        });

        var endDates = <?php echo json_encode($endDateNew);?>;
        $("#endD").datepicker({
          beforeShow: addCustomInformation,
          minDate: 0,
          firstDay: 1,
          onChangeMonthYear: addCustomInformation,
          beforeShowDay: function(date){
              var month = ( '0' + (date.getMonth()+1) ).slice( -2 );
              var year = date.getFullYear();
              var day = ( '0' + (date.getDate()) ).slice( -2 );
              var newdate = day+"-"+month+'-'+year;
              var dateClass = day+month+year;
              if ($.inArray(newdate, endDates) == -1) {
                addCustomInformation(roomPrice[newdate],dateClass,newdate);
                return [true, dateClass];
              } else {
                return [false,"highlight", "Unavailable"];
              }
          },  
          dateFormat:'dd/mm/yy',
          onSelect: function(selected) {
            $("#startD").datepicker("option","maxDate", selected);
          } 
        });
      });

      function addCustomInformation(price,dateClass,newdate) {
        var nextCheckoutDates = <?php echo json_encode($nextCheckoutDates);?>;
        if ($.inArray(newdate, nextCheckoutDates) == -1) {
          var priceCal;
          var currencyRate = $('#currency_rate').val();
          var symbol = $('#symbol').val();
          priceCal = (currencyRate*price).toFixed(1);
          if(!isNaN(priceCal)){
          priceCal = numberWithCommas(priceCal);
            setTimeout(function() {
              $("."+dateClass).filter(function() {
                var date = $(this).text();
                return /\d/.test(date);
              }).find("a").attr('data-custom', symbol+' '+priceCal);
              /*to show start date highlighted in end date*/
              var start_date = $('#startD').val();
              if(start_date!=''){
                start_date = start_date.split('/');
                start_date = start_date[0]+start_date[1]+start_date[2];
                if(dateClass==start_date){
                  $('.'+dateClass).find("a").addClass('ui-state-active');
                }
              }

            }, 0);
          }
        }
      }

      function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
      var start_date = $('#start').val();
      var end_date = $('#end').val();
      if(start_date!='' && end_date!=''){
        $('#vname').val($('#villa').val());
        $('#startD').val(start_date);
        $('#endD').val(end_date);
      }

      $(document).mouseup(function(e) 
      {
      	var container = $("#ul");
      	if (!container.is(e.target) && container.has(e.target).length === 0) 
      	{
      		container.hide();
      	}
      });
    </script>
