<section id="content">
            <div class="container">
	            <div class="row">
             <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> View User Details
                         <a style="float:right;" href="<?php echo base_url().'admin/users'?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left" aria-hidden="true">Back</a>
                    </div>
                    </div>
                    <div class="t-body tb-padding">
                    <div class="row">
	                 <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Name:</td>
                        <td><?php echo $performer_details->firstname." ".$performer_details->lastname; ?></td>
                      </tr>
                      <tr>
                        <td>Email-Id:</td>
                        <td><?php echo $performer_details->email; ?></td>
                      </tr>
                       <tr>
                        <td>Contact No.:</td>
                        <td><?php echo $performer_details->phone; ?></td>
                      </tr>
                       <tr>
                        <td>User Category:</td>
                        <td><?php echo $performer_details->user_category; ?></td>
                      </tr>
                       <tr>
                        <td>Country:</td>
                        <td><?php echo $performer_details->country; ?></td>
                      </tr>
                      <tr>
                        <td>City:</td>
                        <td><?php echo $performer_details->city; ?></td>
                      </tr>
                      <tr>
                        <td>State:</td>
                        <td><?php echo $performer_details->state; ?></td>
                      </tr>
                      <tr>
                        <td>Website link:</td>
                        <td><?php echo $performer_details->website_link; ?></td>
                      </tr>
                      <tr>
                        <td>Professional skills:</td>
                        <td><?php echo $performer_details->professional_skill; ?></td>
                      </tr>
                      <tr>
                        <td>Additional Services:</td>
                        <td><?php echo $performer_details->additional_services; ?></td>
                      </tr>
                      
                     
                    </tbody>
                  </table>
	            </div>
            </div>
          </div>
        </div>
    </div>
 </div>
 </section>