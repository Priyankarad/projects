<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BusinessProfile extends MY_Controller {

    public function index()
    {   
        $this->common_model->updateFields(USERS,array('login_status'=>1),array('id'=>get_current_user_id()));
        if($this->check_userrole())
        {
        //code for yahoo invites mail url //
          require_once(APPPATH.'libraries/yahoo_api/globals.php');
          require_once(APPPATH.'libraries/yahoo_api/oauth_helper.php');
          $callback    =    base_url()."user/yahoo_response";
          $retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET,
            $callback, false, true, true);
          if (! empty($retarr)){
            list($info, $headers, $body, $body_parsed) = $retarr;
            if ($info['http_code'] == 200 && !empty($body)) {
              $_SESSION['request_token']  = $body_parsed['oauth_token'];
              $_SESSION['request_token_secret']  = $body_parsed['oauth_token_secret']; $_SESSION['oauth_verifier'] = $body_parsed['oauth_token'];
              $data['yahooURL'] = urldecode($body_parsed['xoauth_request_auth_url']);
            }
          }
            $this->session->set_userdata('user_login_type','employer');
            $user_id = get_current_user_id();
            $condition=array('id'=>$user_id);                                                                 
            $data['user_data']= get_where('tb_users',$condition,'row'); 
            if($data['user_data']->user_role == ''){
                $this->session->set_flashdata('loginmsg','<div class="alert alert-danger text-center">Oops!.  Plz Set your Role!!!</div>');
                redirect('create-category');
            }
            $userrole = '';
            if(!empty($userdata1)){
              foreach ($data as $userdata1) {
                  $userrole = $userdata1->user_role;
              }
            }
            $category=$data['user_data']->user_category;
            // if($category==""){
            //     redirect('user/create_category');
            // }

            if($userrole == 'Employer'){
                $data['category_details']=$this->common_model->getAllwhere(CATEGORY,array('category_status'=>1));
                //$data['category_questions'] = $this->common_model->getsingle(CATEGORY,array('id'=>$category));

                $this->common_model->updateFields(POSTS,array('repeat_status'=>0),array('user_id'=>$user_id));
                $data['posts_details']    = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0), 'id', 'DESC','all',3,0,$group_by='',$and_where = '');
                if(!empty($data['posts_details']['result'])){
                  foreach($data['posts_details']['result'] as $row1){
                    $this->common_model->updateFields(POSTS,array('repeat_status'=>1),array('id'=>$row1->id));
                  }
                }

                /*Post of all the members within contact*/
            $contactIDs = array();
            //company contacts
            $info = 'tb_users.id';
            $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
            $condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' ";
            $companyContacts = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,"");
            if(!empty($companyContacts)){
                foreach($companyContacts as $id){
                    $contactIDs[] = $id['id'];
                }
            }

            if(!empty($contactIDs)){
                $contacts = implode(",",$contactIDs);
                $condition = ' user_id IN('.$contacts.')';
                $data['highlights'] = $this->common_model->GetJoinRecord(USERS,'id',POSTS,'user_id','tb_users.firstname,tb_users.lastname,tb_users.id as user_id1,tb_users.business_name,tb_users.user_role,tb_users.profile,posts.*',$condition,'','posts.id','DESC','2','0');
            }

            $this->session->set_userdata('posts',array());

                $info=array('tb_users.id','tb_users.firstname','tb_users.lastname','tb_users.email','tb_users.profile','tb_users.city','tb_users.state','tb_users.country');
                $relation="tb_users.id=requests.sender";

                $condition=array('requests.receiver'=>$user_id,'requests.status'=>0,'requests.job_requested_by!='=>get_current_user_id());
                $relation2="tb_users.id=requests.sender OR tb_users.id=requests.receiver";
                $condition2="(requests.receiver='$user_id' OR requests.sender='$user_id') AND requests.status=1 AND tb_users.id!='$user_id' AND tb_users.user_role!='Employer'";
                $data['pendingRequest'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation,$condition,$groupby="");
                $data['allEmployee'] = $this->common_model->get_two_table_data($info,USERS,REQUESTS,$relation2,$condition2,$groupby="");

                $data['logoutUrl'] = $this->facebook->logout_url();
                $companyDTL =$this->common_model->getsingle(USERS,array('id'=>$user_id));
                $company_name=$companyDTL->business_name;
                $postbycomp = $this->common_model->getAllwhere(POSTS,array('user_id'=>$user_id,'post_status'=>0), 'id', 'DESC','all','','',$group_by='',$and_where = '');
                if(!empty($postbycomp['result'])){
                    $data['postbycompany'][$company_name]= $postbycomp;
                }

                //QR code generate
                $userData = $this->session->userdata();
                $data['img_url']="";
                $this->load->library('ciqrcode');
                $qr_image=rand().'.png';
                // $params['data'] = $userData['userData']['email'];
                $params['data'] = base_url().'viewdetails/profile/'.encoding($user_id)."?review=1";
                $params['level'] = 'H';
                $params['size'] = 5;
                $params['savename'] =FCPATH."qr_code/".$qr_image;
                if($this->ciqrcode->generate($params))
                {
                    $data['qr_image']=base_url().'qr_code/'.$qr_image; 
                }
                $data['albumData']=$this->common_model->getAllwhere(ALBUMS,array('user_id'=>get_current_user_id(),'folder_id' => 0));
                $data['albumFolderData']=$this->common_model->getAllwhere(ALBUM_DIR,array('user_id'=>get_current_user_id()));
                $this->pageviewnofooter('businessprofile',$data,$data,array()); 
            }
            else{
                redirect('profile');
            }
        }else{
            $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Oops!.  Plz Set your Role!!!</div>');
            redirect('create-category');
        }
    }

public function Update_profileimg(){
    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){
        $newImage = '';
        $fileName = basename($_FILES["profileimg"]["name"]);
        $fileTmp = $_FILES["profileimg"]["tmp_name"];
        $fileType = $_FILES["profileimg"]["type"];
        $fileSize = $_FILES["profileimg"]["size"];
        $fileExt = substr($fileName, strrpos($fileName, ".") + 1);
        $largeImageLoc = 'uploads/images/'.time().".".$fileExt;
        $thumbImageLoc = 'uploads/images/thumb/'.time().".".$fileExt;

        if(!empty($fileName)){
            if(move_uploaded_file($fileTmp, $largeImageLoc)){
                $Orientation = 0;
                $imgdata=@exif_read_data(FCPATH.$largeImageLoc,"FILE,COMPUTED,ANY_TAG,IFD0,THUMBNAIL,COMMENT,EXIF,Orientation", true);
                if(isset($imgdata['IFD0']['Orientation'])){
                    $Orientation = $imgdata['IFD0']['Orientation'];
                }

                chmod ($largeImageLoc, 0777);
                list($width_org, $height_org) = getimagesize($largeImageLoc);
                $x = (int) $_POST['x'];
                $y = (int) $_POST['y'];
                $width = (int) $_POST['w'];
                $height = (int) $_POST['h'];
                $width_new = $width;
                $height_new = $height;
                if($width_new!='' && $height_new!=''){
                    $newImage = imagecreatetruecolor($width_new,$height_new);
                }
                $source = '';
                switch($fileType) {
                    case "image/gif":
                    $source = imagecreatefromgif($largeImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    $source = imagecreatefromjpeg($largeImageLoc); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    $source = imagecreatefrompng($largeImageLoc); 
                    break;
                }

                if($x!='' && $y!=''){
                    imagecopyresampled($newImage,$source,0,0,$x,$y,$width_new,$height_new,$width,$height);
                }

                switch($fileType) {
                    case "image/gif":
                    imagegif($newImage,$thumbImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    imagejpeg($newImage,$thumbImageLoc,90); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    imagepng($newImage,$thumbImageLoc);  
                    break;
                }
                imagedestroy($newImage);
                $config['image_library'] = 'gd2';
                $config['master_dim'] = 'auto';
                $config['maintain_ratio'] = FALSE;
                $this->load->library('image_lib',$config); 
                if (!$this->image_lib->resize()){  
                    echo "error";
                }else{
                    $this->image_lib->clear();
                    $config=array();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = FCPATH.$thumbImageLoc;
                    if($Orientation!=0){
                        switch($Orientation) {
                            case 3:
                            $config['rotation_angle']='180';
                            break;
                            case 6:
                            $config['rotation_angle']='270';
                            break;
                            case 8:
                            $config['rotation_angle']='90';
                            break;
                        }
                        $this->image_lib->initialize($config); 
                        $this->image_lib->rotate();
                    }
                }
                $dataArr['profile']    =  base_url().$thumbImageLoc;
                $user_id = get_current_user_id();
                $condition=array('id'=>$user_id);   
                $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
                if($update)
                {                   
                    redirect('businessprofile');
                }
            }else{
                $error = "Sorry, there was an error uploading your file.";
            }
        }else{
            echo $error;
        }
    }
}

public function Update_profileimg111(){
    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){

        $config['upload_path'] = 'uploads/users/';

        $config['allowed_types'] = 'jpg|jpeg|gif|png';

        $config['max_size'] = '6048';

        $this->load->library('upload', $config);

//check if a file is being uploaded

        if(strlen($_FILES["profileimg"]["name"])>0){

            if ( !$this->upload->do_upload("profileimg"))

            {

                $error = array('error' => $this->upload->display_errors());

                print_r($error);

            }

            else

            {

                $config['image_library'] = 'gd2';

                $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                $filename = $_FILES['profileimg']['tmp_name'];





                $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');





                list($width, $height) = getimagesize($filename);

                if ($width >= $height){

                    $config['width'] = 800;

                }

                else{

                    $config['height'] = 800;

                }

                $config['master_dim'] = 'auto';

// $config['maintain_ratio'] = TRUE;

                $config['maintain_ratio'] = FALSE;



                $this->load->library('image_lib',$config); 



                if (!$this->image_lib->resize()){  

                    echo "error";

                }else{



                    $this->image_lib->clear();

                    $config=array();



                    $config['image_library'] = 'gd2';

                    $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;



                    if(isset($imgdata['Orientation'])){

                        switch($imgdata['Orientation']) {

                            case 3:

                            $config['rotation_angle']='180';

                            break;

                            case 6:

                            $config['rotation_angle']='270';

                            break;

                            case 8:

                            $config['rotation_angle']='90';

                            break;

                        }



                        $this->image_lib->initialize($config); 

                        $this->image_lib->rotate();

                    }

                }

            }      

        }  

    }

    $dataArr['profile']    =  base_url().'uploads/users/'.$this->upload->file_name;



    $user_id = get_current_user_id();



    $condition=array('id'=>$user_id);   



    $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));

    if($update)

    {                   

        redirect('profile');

    }



}
 public function Update_profileimg1111111111(){
    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){
        $newImage = '';
        $fileName = basename($_FILES["profileimg"]["name"]);
        $fileTmp = $_FILES["profileimg"]["tmp_name"];
        $fileType = $_FILES["profileimg"]["type"];
        $fileSize = $_FILES["profileimg"]["size"];
        $fileExt = substr($fileName, strrpos($fileName, ".") + 1);
        $largeImageLoc = 'uploads/images/'.$fileName;
        $thumbImageLoc = 'uploads/images/thumb/'.$fileName;
        if((!empty($_FILES["profileimg"])) && ($_FILES["profileimg"]["error"] == 0)){
            if($fileExt != "jpg" && $fileExt != "jpeg" && $fileExt != "png"){
                $error = "Sorry, only JPG, JPEG & PNG files are allowed.";
            }
        }else{
            $error = "Select a JPG, JPEG & PNG image to upload";
        }
        if(!empty($fileName)){
            if(move_uploaded_file($fileTmp, $largeImageLoc)){
                $Orientation = 0;
                $imgdata=@exif_read_data(FCPATH.$largeImageLoc,"FILE,COMPUTED,ANY_TAG,IFD0,THUMBNAIL,COMMENT,EXIF,Orientation", true);
                if(isset($imgdata['IFD0']['Orientation'])){
                    $Orientation = $imgdata['IFD0']['Orientation'];
                }

                chmod ($largeImageLoc, 0777);
                list($width_org, $height_org) = getimagesize($largeImageLoc);
                $x = (int) $_POST['x'];
                $y = (int) $_POST['y'];
                $width = (int) $_POST['w'];
                $height = (int) $_POST['h'];
                $width_new = $width;
                $height_new = $height;
                if($width_new!='' && $height_new!=''){
                    $newImage = imagecreatetruecolor($width_new,$height_new);
                }
                switch($fileType) {
                    case "image/gif":
                    $source = imagecreatefromgif($largeImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    $source = imagecreatefromjpeg($largeImageLoc); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    $source = imagecreatefrompng($largeImageLoc); 
                    break;
                }

                if($x!='' && $y!=''){
                    imagecopyresampled($newImage,$source,0,0,$x,$y,$width_new,$height_new,$width,$height);
                }

                switch($fileType) {
                    case "image/gif":
                    imagegif($newImage,$thumbImageLoc); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    imagejpeg($newImage,$thumbImageLoc,90); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    imagepng($newImage,$thumbImageLoc);  
                    break;
                }
                imagedestroy($newImage);
                $config['image_library'] = 'gd2';
                $config['master_dim'] = 'auto';
                $config['maintain_ratio'] = FALSE;
                $this->load->library('image_lib',$config); 
                if (!$this->image_lib->resize()){  
                    echo "error";
                }else{
                    $this->image_lib->clear();
                    $config=array();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = FCPATH.$thumbImageLoc;
                    if($Orientation!=0){
                        switch($Orientation) {
                            case 3:
                            $config['rotation_angle']='180';
                            break;
                            case 6:
                            $config['rotation_angle']='270';
                            break;
                            case 8:
                            $config['rotation_angle']='90';
                            break;
                        }
                        $this->image_lib->initialize($config); 
                        $this->image_lib->rotate();
                    }
                }
                $dataArr['profile']    =  base_url().$thumbImageLoc;
                $user_id = get_current_user_id();
                $condition=array('id'=>$user_id);   
                $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
                if($update)
                {                   
                    redirect('businessprofile');
                }
            }else{
                $error = "Sorry, there was an error uploading your file.";
            }
        }else{
            echo $error;
        }
    }
}


    public function Update_profileimg11(){
        if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){

            $config['upload_path'] = 'assets/uploadimages/';
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['max_size'] = '6048';
            $this->load->library('upload', $config);
            //check if a file is being uploaded
            if(strlen($_FILES["profileimg"]["name"])>0){
                if ( !$this->upload->do_upload("profileimg"))
                {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                }
                else
                {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                    $filename = $_FILES['profileimg']['tmp_name'];


                    $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');


                    list($width, $height) = getimagesize($filename);
                    if ($width >= $height){
                        $config['width'] = 800;
                    }
                    else{
                        $config['height'] = 800;
                    }
                    $config['master_dim'] = 'auto';
                    $config['maintain_ratio'] = TRUE;
                    
                    $this->load->library('image_lib',$config); 

                    if (!$this->image_lib->resize()){  
                        echo "error";
                    }else{

                        $this->image_lib->clear();
                        $config=array();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                        if(isset($imgdata['Orientation'])){
                          switch($imgdata['Orientation']) {
                              case 3:
                              $config['rotation_angle']='180';
                              break;
                              case 6:
                              $config['rotation_angle']='270';
                              break;
                              case 8:
                              $config['rotation_angle']='90';
                              break;
                          }

                          $this->image_lib->initialize($config); 
                          $this->image_lib->rotate();
                        }
                    }
                }      
            }  
        }
        $dataArr['profile']    =  base_url().'assets/uploadimages/'.$this->upload->file_name;
        
        $user_id = get_current_user_id();

        $condition=array('id'=>$user_id);   

        $update = $this->common_model->updateFields(USERS,$dataArr,array('id'=>$user_id));
        if($update)
        {                   
            redirect('businessprofile');
        }

    }

    public function Editprofile(){

        if(!empty($this->input->post('oldprofessional_skill')))
        {
            $profressional_skill = implode(",",$this->input->post('oldprofessional_skill')).','.$this->input->post('newprofessional_skill');
            $profressional_skill = rtrim($profressional_skill,",");
        }
        else
        {
            $profressional_skill = $this->input->post('newprofessional_skill');
        }
        if(!empty($this->input->post('oldadditional_services')))
        {
            $additional_services = implode(",",$this->input->post('oldadditional_services')).','.$this->input->post('newadditional_services');     
            $additional_services = rtrim($additional_services,",");     
        }
        else
        {  
            $additional_services = $this->input->post('newadditional_services');
        }    
        if(!empty($this->input->post('cnewpassword')))
        {
            $oldpass = $this->input->post('oldpassword');
            $newpass = $this->input->post('newpassword');
            $cnewpass = $this->input->post('cnewpassword');

            $user_id = get_current_user_id();
            $condition=array('id'=>$user_id);                                                                  
            $user_data = get_where('tb_users',$condition,'row');
            $hashpassword = $user_data->password;
            $checkoldpassword = password_check($oldpass,$hashpassword);

            $userdata = array(
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'business_name' => $this->input->post('business_name'),
                'business_address' => $this->input->post('business_address'),
                'website_link' => $this->input->post('website_link'), 
                'password' => generate_password($this->input->post('cnewpassword')),                
                'phone' => $this->input->post('phone'),
                'zip' => $this->input->post('zip'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'country' => $this->input->post('country'),
                'user_category' => $this->input->post('user_category'),
                'professional_skill' => $profressional_skill, 
                'additional_services' => $additional_services                       
            );
            if($this->input->post('noti_msg')){
              $userdata['message_notification'] = 1;
            }else{
              $userdata['message_notification'] = 0;
            }
            if($this->input->post('noti_job')){
              $userdata['job_request_received_notification'] = 1;
            }else{
              $userdata['job_request_received_notification'] = 0;
            }
            if($this->input->post('new_task_notification')){
              $userdata['new_task_notification'] = 1;
            }else{
              $userdata['new_task_notification'] = 0;
            }
            
            if(!empty($this->input->post('oldpassword'))){

                if($checkoldpassword=='verified'){

                   if($newpass == $cnewpass){                                                 

                      $user_id = get_current_user_id();

                      $condition=array('id'=>$user_id);  
                      $this->session->set_userdata('user_login_type','');
                      $update = update_data('tb_users',$userdata,$condition);
                      if($update){ 
                         $this->session->unset_userdata('id');
                         $this->session->sess_destroy();             
                         redirect('login');
                     }
                 }else{
                    $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Password does not match please try again!!!</div>');
                    redirect('profile'); 
                }

            }else{
              $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Your current password is wrong please enter correct password!!!</div>');
              redirect('profile'); 
          } 
      }
      else{       
        if($newpass == $cnewpass){

          $user_id = get_current_user_id();

          $condition=array('id'=>$user_id);  

          $update = update_data('tb_users',$userdata,$condition);
          if($update){ 
           $this->session->unset_userdata('id');
           $this->session->sess_destroy();             
           redirect('login');
       }
   }else{
     $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Password does not match please try again!!!</div>');
     redirect('profile'); 
 }
}                                          
}else{ 

    $userdata = array(
      'firstname' => $this->input->post('firstname'),
      'lastname' => $this->input->post('lastname'), 
      'business_name' => $this->input->post('business_name'),
      'business_address' => $this->input->post('business_address'),
      'website_link' => $this->input->post('website_link'),                         
      'phone' => $this->input->post('phone'),
      'zip' => $this->input->post('zip'),
      'city' => $this->input->post('city'),
      'state' => $this->input->post('state'),
      'country' => $this->input->post('country'),
      'user_category' => $this->input->post('user_category'),
      'professional_skill' => $profressional_skill, 
      'additional_services' => $additional_services                         
  );
    if($this->input->post('noti_msg')){
      $userdata['message_notification'] = 1;
    }else{
      $userdata['message_notification'] = 0;
    }
    if($this->input->post('noti_job')){
      $userdata['job_request_received_notification'] = 1;
    }else{
      $userdata['job_request_received_notification'] = 0;
    }
    if($this->input->post('new_task_notification')){
        $userdata['new_task_notification'] = 1;
    }else{
        $userdata['new_task_notification'] = 0;
    }
    $user_id = get_current_user_id();
    $condition=array('id'=>$user_id);  
    $update = update_data('tb_users',$userdata,$condition);
    if($update)
    { 
        $this->session->set_flashdata('updatemsg','<div class="alert alert-success text-center">You have successfully updated your profile!</div>');                
        redirect('profile');
    }
    else
    {
        $this->session->set_flashdata('updatemsg','<div class="alert alert-danger text-center">Error in updating your profile</div>');
        redirect('profile');  
    }
}


}

public function Checkoldpassword(){

    if($this->input->server('REQUEST_METHOD') == 'POST'){ 

        $userdata=json_decode($this->input->post('userdata'));
        $oldpassword = $userdata->oldpassword;

        $user_id = get_current_user_id();
        $condition=array('id'=>$user_id);                                                                  
        $user_data = get_where('tb_users',$condition,'row');

        $hashpassword = $user_data->password;
        $checkoldpassword = password_check($oldpassword,$hashpassword);

        if($checkoldpassword=='verified'){

            $arr['result']=1;

        }
        else
        {
            $arr['result']=0;
        }

    }
    else{
        $arr['result']=0;

    }     
    echo json_encode($arr);
}

  public function saveBusinessProfileData(){
    $userdata = array(
      'firstname' => $this->input->post('firstname'),
      'lastname' => $this->input->post('lastname'),
      'business_name' => $this->input->post('business_name'),
      'business_address' => $this->input->post('business_address'),
      'website_link' => $this->input->post('website_link'),             
      'phone' => $this->input->post('phone'),
      'zip' => $this->input->post('zip'),
      'city' => $this->input->post('city'),
      'state' => $this->input->post('state'),
      'country' => $this->input->post('country'),
      'user_category' => $this->input->post('user_category'),      
      'basic_info' => 1              
    );
    if(isset($_FILES['profileimg']['name']) && !empty($_FILES['profileimg']['name'])){


        $config['upload_path'] = 'uploads/users/';

        $config['allowed_types'] = 'jpg|jpeg|gif|png';

        $config['max_size'] = '6048';

        $this->load->library('upload', $config);

//check if a file is being uploaded

        if(strlen($_FILES["profileimg"]["name"])>0){

            if ( !$this->upload->do_upload("profileimg"))

            {

                $error = array('error' => $this->upload->display_errors());

                print_r($error);

            }

            else

            {

                $config['image_library'] = 'gd2';

                $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;

                $filename = $_FILES['profileimg']['tmp_name'];





                $imgdata=@exif_read_data($this->upload->upload_path.$this->upload->file_name, 'IFD0');





                list($width, $height) = getimagesize($filename);

                if ($width >= $height){

                    $config['width'] = 800;

                }

                else{

                    $config['height'] = 800;

                }

                $config['master_dim'] = 'auto';

// $config['maintain_ratio'] = TRUE;

                $config['maintain_ratio'] = FALSE;



                $this->load->library('image_lib',$config); 



                if (!$this->image_lib->resize()){  

                    echo "error";

                }else{



                    $this->image_lib->clear();

                    $config=array();



                    $config['image_library'] = 'gd2';

                    $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;



                    if(isset($imgdata['Orientation'])){

                        switch($imgdata['Orientation']) {

                            case 3:

                            $config['rotation_angle']='180';

                            break;

                            case 6:

                            $config['rotation_angle']='270';

                            break;

                            case 8:

                            $config['rotation_angle']='90';

                            break;

                        }



                        $this->image_lib->initialize($config); 

                        $this->image_lib->rotate();

                    }

                }

            }      

        }  

       $userdata['profile'] =  base_url().'uploads/users/'.$this->upload->file_name;
    }


    $this->session->set_userdata('basic_info_data',$userdata);
    echo json_encode(array('status'=>1));
  }

  public function saveProfileData(){
    $basicInfo = $this->session->userdata('basic_info_data');
    $basicInfo['professional_skill'] = $this->input->post('newprofessional_skills');
    $basicInfo['additional_services'] = $this->input->post('newadditional_servicess');
    $user_id = get_current_user_id();
    $condition=array('id'=>$user_id);  
    $this->session->set_userdata('user_login_type','');
    $update = update_data('tb_users',$basicInfo,$condition);
    $this->session->set_userdata('basic_info_data','');
    if($update){             
      redirect('businessprofile');
    }
  }
}
