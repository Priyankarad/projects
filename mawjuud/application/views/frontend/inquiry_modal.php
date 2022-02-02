<?php $property = (array)$property;
$sessionData = '';
if($this->session->userdata('sessionData')){
    $sessionData = $this->session->userdata('sessionData');
} 
?>
<div class="modal custompopupdesign inquiry_agent inquiry_agent_modal">
    <a href="#!" class="modal-close waves-effect modal_closeA">×</a>    
    <form class="contactOwners" method="post">
        <h4 class="modal-title">Send Inquiry</h4>
        <input type="hidden" name="property_id" value="<?php echo $property['id'];?>">
        <div class="input-field">
            <input name="name" type="text" placeholder="Your Name" value="<?php echo 
            (isset($sessionData['first_name'])&&isset($sessionData['last_name']))?ucwords($sessionData['first_name']." ".$sessionData['last_name']):'';
            ?>" required="">
        </div>
        <div class="input-field">
            <input name="email" type="email" placeholder="Email" value="<?php echo isset($sessionData['username'])?$sessionData['username']:'';?>" required="">
        </div>
        <div class="input-field">
            <input class="phone" name="phone_number" type="tel" placeholder="Phone No." value="<?php echo isset($sessionData['user_number'])?$sessionData['code'].$sessionData['user_number']:'';?>" required="">
        </div>
        <input type="hidden" class="phone_code" name="phone_code">
        <div class="input-field">
            <p class="onlyredsB">I am interested in this Property <b><span>'<?php echo isset($property['title'])?substr($property['title'],0,100).'...':'';?>'</span> <?php echo isset($property['mawjuud_reference'])?$property['mawjuud_reference']:'';?><?php echo isset($property['property_reference'])?'(Reference numbers Mawjuud-'.$property['property_reference'].')':'';?></b> and would like to schedule a viewing. Please Let me know when this would be possible</p>
        </div>
        <?php 
        $propertyQuestions = propertQuestions($property['id']);
        if(!empty($propertyQuestions['result'])){
            ?>
            <div class="questionModal">
                <h6>The agent is asking to answer a few questions to better understand your inquiry!</h6>
                <div class="row">
                    <div class="col s12">
                        <?php 
                        $count = 1;
                        foreach($propertyQuestions['result'] as $row){ ?>
                            <div class="input-field">
                                Ques <?php echo $count;?>: <?php echo ucfirst($row->question);?>
                                <textarea placeholder="Add your answer" name="answer[<?php echo $row->id;?>]" class="materialize-textarea" required></textarea>
                            </div>
                            <?php 
                            $count++;
                        }
                        ?>
                    </div>
                </div> 
            </div>
        <?php } ?>
        <button type="submit" class="cntagents contactOwners waves-effect waves-light">Send Message</button>
    </form>
</div>
<!--===============inquiry================-->
<!--===============inquiry================-->
<script type="text/javascript">
    $(".phone").intlTelInput();
    $('.contactOwners').trigger('click');
</script>