

<div class="mycontact">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.9581734200306!2d-73.70942638493996!3d40.78493367932398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c289ae191b1c79%3A0x5b82be15eead1586!2sEvangelos+Mihos%2C+Esq.!5e0!3m2!1sen!2sin!4v1529567358852" width="100%" height="550" frameborder="0" style="border:0" allowfullscreen></iframe>
<?php 
if(!empty($aboutData['result'][0])){
    $aboutData = $aboutData['result'][0];
}
echo isset($aboutData->content_1)?$aboutData->content_1:'';
?>
</div>


<div class="contact_forms">
    <div class="container">
        <?php 
        if($this->session->flashdata('success')){
            echo $this->session->flashdata('success');
        }
        ?>
        <div class="my_mainform">
            <h2>Send as a message</h2>
            <form id="" action="<?php echo base_url()?>user/contactSave" method="post">
                <div class="form-group row">
                    <div class="col-md-4">
                        <input type="text" name="name" placeholder="Your Name" class="form-control" required=""/>
                    </div>
                    <div class="col-md-4">
                        <input type="email" name="email" placeholder="Your Email" class="form-control" required=""/>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="phone" placeholder="Phone Number" class="form-control" required=""/>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control" name="message" placeholder="Message" required=""></textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="send_contact"> Send Message </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>