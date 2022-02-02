<?php
/*
Template name:booking
*/
if ( ! session_id() ) {
    session_start();
}

get_header('one');

?>
<style type="text/css">
input.btn1.HideSubmit {
   position: unset;
}
</style>
      <section class="ChoosStepSection pd90">
         <input type="hidden" name="url" value="<?php home_url(); ?>">
         <div class="container">
            <div class="ChoosStepDetail">
               <div class="row">
                  <div class="col-md-8 col-sm-8 col-12">
                     <div class="ChoosStep">
                        <form id="signup" action="somewhere" method="POST" class="multisteps-mawjuuds">
                           <div class="row">
                              <div class="col-md-4">
                                 <ul id="section-tabs">
                                    <li class="current active">step 1<span class="lnr lnr-chevron-down-circle"></span></li>
                                    <li>step 2<span class="lnr lnr-chevron-down-circle"></span></li>
                                    <li>step 3<span class="lnr lnr-chevron-down-circle"></span></li>
                                    <li>step 4<span class="lnr lnr-chevron-down-circle"></span></li>
                                 </ul>
                              </div>
                              <div class="col-md-8">
                                 <div class="mobiitemStep ">
                                    <a class="mobTabStep">Step 1 <span class="lnr lnr-chevron-down-circle"></span></a>
                                </div>
                                 <div id="fieldsets">
                                    <fieldset class="current">
                                       <div class="bydefaultnone">
                                          <div class="title-dates">Thu, 16 May 19 - Fri, 17 May 19</div>
                                          <p>1 Night</p>  
                                       </div>
   
                                    <div class="click-new-hides">
                                       <h1>Check Availability</h1>
                                       <div class="DAthrMain">
                                          <div class="row">
                                             <div class="col-md-1">
                                                <div class="datcal">
                                                   <span class="lnr lnr-calendar-full"></span>
                                                </div>
                                             </div>
                                             <div class="col-md-2 col-sm-2 col-12">
                                                <label>Dates</label>
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-4 col-sm-4 col-12">
                                                <div class="form-group BannrGrup">                                  
                                                   <input type="text" id="date_ex" placeholder="16/05/2019" class="form-control BannerInput hasDatepicker">                                 
                                                </div>
                                             </div>
                                             <div class="col-md-4 col-sm-4 col-12">
                                                <div class="form-group BannrGrup">
                                                   <!--  <label>Selecte Date:</label> -->
                                                   <input type="text" id="date_ex2" placeholder="17/05/2019" class="form-control BannerInput hasDatepicker">
                                                </div>
                                             </div>
                                             <div class="col-md-4 col-sm-4 col-12">
                                                <div class="form-group BannrGrup">
                                                   <!--  <label>Selecte Date:</label> -->
                                                   <p>1 night selected</p>
                                                </div>
                                             </div>
                                          </div>
                                          <hr class="TabHr"></div>
                                          <!-- ========FIRST END===== -->
                                          <div class="DAthrMain">
                                             <div class="row">
                                                <div class="col-md-1">
                                                   <div class="datcal">
                                                      <span class="lnr lnr-calendar-full"></span>
                                                   </div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-12">
                                                   <label>Persons</label>
                                                </div>
                                             </div>
                                             <div class="NighSelMain">
                                                <div class="row">
                                                   <div class="col-md-5 col-sm-5 col-12">
                                                      <div class="form-group BannrGrup mb_20">
                                                         <select name="NumberOfPeople" class="form-control">
                                                            <option>1</option>
                                                            <option selected="selected">2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                            <option>11</option>
                                                            <option>12</option>
                                                         </select>
                                                         <span class="lnr lnr-users"></span>
                                                      </div>
                                                      <p>persons per room</p>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                          <!-- ========FIRST END===== -->
                
                                       </fieldset>
                                       <fieldset class="next">
                                          <div class="mobiitemStep ">
                                    <a class="mobTabStep">Step 2 <span class="lnr lnr-chevron-down-circle"></span></a>
                                </div>
                                       <div class="bydefaultnone">
                                          <div class="title-dates">1 Rental</div>
                                          <p><span class="lnr lnr-users"></span></p>  
                                       </div>
   
                                       <div class="click-new-hides">
                                          <div class="NextFildIg">
                                             <h1>Choose Rental</h1>
                                             <div class="FldBoxImg">
                                                <img src="<?php bloginfo('template_url');?>/assets/images/fldb1.jpg" alt="Image" class="img-fluid">
                                             </div>
                                             <div class="BookBed">
                                                <div class="row">
                                                   <div class="col-md-12 col-sm-12 col-12">
                                                      <div class="RentalBook">
                                                         <p>31,087 Rs</p>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-4 col-sm-4 col-12">
                                                      <span class="lnr lnr-user Sman"></span>
                                                      <div class="form-group BannrGrup chkBnIn">
                                                         <!--  <label>Selecte Date:</label> -->
                                                         <select name="NumberOfPeople" class="form-control">
                                                            <option>1</option>
                                                            <option selected="selected">2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                            <option>11</option>
                                                            <option>12</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-8 col-sm-8 col-12">
                                                      <div class="RentalBookBtn">
                                                         <a href="" class="btn btn-cta">Book Now</a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          </div>
                                       </fieldset>
                                       <fieldset class="next Nxtfld">
                                          <div class="bydefaultnone">
                                             <div class="title-dates dtpExt" >
                                                <p>0 Extra</p>
                                             <a href="#" class="btn btn-cta">Edit vila</a></div>
                                             <!-- <p>1 Night</p>   -->
                                          </div>
   
                                       <div class="click-new-hides">
                                          <div class="SmallCheckout">
                                             <div class="row">
                                                <div class="col-12 col-sm-12 col-12">
                                                   <div class="Extrachs">
                                                      <h2>Choose Extra</h2>
                                                      <a href="#" class="btn btn-cta">Skip</a>
                                                   </div>
                                                   <div class="EarlyCheck">
                                                      <h1>Early Check-In</h1>
                                                      <p>More info</p>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="MoreItem">
                                             <div class="row">
                                                <div class="col-md-6 col-sm-6 col-12">
                                                   <div class="SinglChrz">
                                                      <p>222.5% Single charge Per stay</p>
                                                   </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-12">
                                                   <div class="SinglChrz">
                                                      <div class="RentalBook">
                                                         <p>31,087 Rs</p>
                                                      </div>
                                                      <div class="AddedCheck">
                                                         <div class="form-check">
                                                            <input type="checkbox" class="form-check-input chkIn" id="exampleCheck1">
                                                            <label class="form-check-label" for="exampleCheck1">Add item</label>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       </fieldset>
                                       <fieldset class="next">
                                          <div class="mobiitemStep ">
                                           <a class="mobTabStep">Step 3 <span class="lnr lnr-chevron-down-circle"></span></a>
                                         </div>
                                          <div class="bydefaultnone">
                                             <div class="title-dates">0 Extra</div>
                                             <!-- <p>1 Night</p>   -->
                                          </div>
   
                                          <div class="click-new-hides">
                                             <h2>Enter Details</h2>
                                          <div class="col-md-12 col-sm-12 col-12">
                                             <div class="SymkheadingCol">

                                                <h1>Guest Details</h1>
                                                <form>
                                                   <div class="contFrom">
                                                      <div class="row">
                                                         <div class="col-md-6 col-sm-6 col-12">
                                                            <div class="form-group BannrGrup">
                                                               <input type="text" id="date_ex" placeholder="First Name" class="form-control BannerInput">
                                                            </div>
                                                         </div>
                                                         <div class="col-md-6 col-sm-6 col-12">
                                                            <div class="form-group BannrGrup">
                                                               <input type="text" id="date_ex" placeholder="Last Name" class="form-control BannerInput">
                                                            </div>
                                                         </div>
                                                         <div class="col-md-12 col-sm-12 col-12">
                                                            <div class="form-group BannrGrup">
                                                               <input type="text" id="date_ex" placeholder="Email" class="form-control BannerInput">
                                                            </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <input name="Name" class="form-control" type="text" value="" placeholder="(201) 555-0123">
                                                            </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                            <div class="form-group">
                                                               <select autocomplete="off" class="form-control" id="SelectedHouseId" name="SelectedHouseId">
                                                                  <option value="">Select Country</option>
                                                                  <option value="190601">in </option>
                                                                  <option value="198650"></option>
                                                                  <option value="190600"></option>
                                                                  <option value="190604">asa</option>
                                                                  <option value="189653">gu </option>
                                                                  <option value="189406">u</option>
                                                                  <option value="191090">nsel</option>
                                                               </select>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-12">
                                                            <div class="form-group">
                                                               <textarea cols="20" id="Comment" name="Comment" rows="5" class="form-control" placeholder="Comment"></textarea>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-7">
                                                            <button id="contact-send" type="submit" class="btn-send" data-loading-text="Loading..." tabindex="9">Send</button>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                       </fieldset>
                                       <a class="btn1" id="next">continue <!-- ▷ --></a>
                                       <input type="submit" class="btn1 HideSubmit">
                                    </div>
                                 </div>
                              </div>
                           </form>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-12">
                     <div class="ChoosStepSide">
                        <div class="chosImg">
                           <img src="<?php bloginfo('template_url');?>/assets/images/b1.jpg" class="img-fluid" alt="Image">
                        </div>
                        <div class="Chos04">
                           <h3 >5 Bedroom - 04-Villa Sabtu</h3>
                           <p >Jl.Kunti 1, Gang Mangga N.04 </p>
                           <p>80361 Seminyak, Kuta, Bali Indonesia</p>
                        </div>
                        <div class="Chospill">
                           <ul class="nav nav-pills mb-3 SumrryPils" id="pills-tab" role="tablist">
                              <li class="nav-item">
                                 <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Summary</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Details</a>
                              </li>
                           </ul>
                           <div class="tab-content" id="pills-tabContent">
                              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                 <div class="SummryRw">
                                    <div class="row">
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBox">
                                             <p>Dates</p>
                                             <p>Villa Taxes & Fees incl.</p>
                                          </div>
                                       </div>
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBox">
                                             <p>16/05/2019 - 17/05/2019</p>
                                             <p>31,090.27 Rs</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="SummryRw">
                                    <div class="row">
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <h1>Total</h1>
                                             <p>Property's currency</p>
                                          </div>
                                       </div>
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <p class="BsumClr">31,086.8 Rs</p>
                                             <p>$ 445</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="SummryRw">
                                    <h2>Payment Schedule</h2>
                                    <div class="row">
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <h1 class="Agrh1">Payment 1 (On agreement)</h1>
                                             <p>Remaining Balance</p>
                                          </div>
                                       </div>
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <p class="BsumClr">$ 178</p>
                                             <p>$ 267</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="SummryRw">
                                    <h2>Cancellation Policy</h2>
                                    <div class="row">
                                       <div class="col-md-12 col-sm-12 col-12">
                                          <div class="SummryBoxTo">
                                             <ul>
                                                <li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
                                                <li>60% of paid prepayments refundable when canceled 61 days before arrival or earlier</li>
                                                <li>0% refundable if cancelled after</li>
                                                <li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- ================================================================================== -->
                              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                 <div class="SummryRw">
                                    <div class="row">
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBox">
                                             <p>Dates</p>
                                             <p>Villa Taxes & Fees incl.</p>
                                          </div>
                                       </div>
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBox">
                                             <p>16/05/2019 - 17/05/2019</p>
                                             <p>31,090.27 Rs</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="SummryRw">
                                    <div class="row">
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <h1>Total</h1>
                                             <p>Property's currency</p>
                                          </div>
                                       </div>
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <p class="BsumClr">31,086.8 Rs</p>
                                             <p>$ 445</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="SummryRw">
                                    <h2>Payment Schedule</h2>
                                    <div class="row">
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <h1 class="Agrh1">Payment 1 (On agreement)</h1>
                                             <p>Remaining Balance</p>
                                          </div>
                                       </div>
                                       <div class="col-md-6 col-sm-6 col-12">
                                          <div class="SummryBoxTo">
                                             <p class="BsumClr">$ 178</p>
                                             <p>$ 267</p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="SummryRw">
                                    <h2>Cancellation Policy</h2>
                                    <div class="row">
                                       <div class="col-md-12 col-sm-12 col-12">
                                          <div class="SummryBoxTo">
                                             <ul>
                                                <li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
                                                <li>60% of paid prepayments refundable when canceled 61 days before arrival or earlier</li>
                                                <li>0% refundable if cancelled after</li>
                                                <li>80% of paid prepayments refundable when canceled 360 days before arrival or earlier</li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
     <?php 
get_footer();
?>
<script type="text/javascript">
   $("body").on("keyup", "form", function(e){
         if (e.which == 13){
         if ($("#next").is(":visible") && $("fieldset.current").find("input, textarea").valid() ){
         e.preventDefault();
         nextSection();
         return false;
         }
         }
         });
         
         
         $("#next").on("click", function(e){
         console.log(e.target);
         nextSection();
         });
         
         $(".multisteps-mawjuuds").on("submit", function(e){
         if ($("#next").is(":visible") || $("fieldset.current").index() < 3){
         e.preventDefault();
         }
         });
         
         function goToSection(i){
         $(".multisteps-mawjuuds fieldset:gt("+i+")").removeClass("current").addClass("next");
         $(".multisteps-mawjuuds fieldset:lt("+i+")").removeClass("current").addClass('showbartopR');
         $(".multisteps-mawjuuds li").eq(i).addClass("current").siblings().removeClass("current");
         $(".multisteps-mawjuuds li").prev().addClass("showbartopL");
         setTimeout(function(){
         $(".multisteps-mawjuuds fieldset").eq(i).removeClass("next").addClass("current active");
         if ($(".multisteps-mawjuuds fieldset.current").index() == 3){
         $("#next").hide();
         $(".multisteps-mawjuuds input[type=submit]").show();
         } else {
         $("#next").show();
         $(".multisteps-mawjuuds input[type=submit]").hide();
         }
         }, 80);
         
         }
         
         function nextSection(){
         var i = $(".multisteps-mawjuuds fieldset.current").index();
         if (i < 3){
         $(".multisteps-mawjuuds #section-tabs li").eq(i+1).addClass("active");
         goToSection(i+1);
         }
         }
         
         $("#section-tabs li").on("click", function(e){
         var i = $(this).index();
         if ($(this).hasClass("active")){
         goToSection(i);
         } else {
         alert("Please complete previous sections first.");
         }
         });
</script>