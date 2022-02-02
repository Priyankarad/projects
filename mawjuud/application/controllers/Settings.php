<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function accessibility(){
        $data['contents'] = $this->common_model->getsingle(PAGE_SETTINGS,array('page'=>'accessibility'));
        $this->load->view('frontend/accessibility',$data);
    }

    public function contactUs(){
        if($this->input->post()){
            $name = $this->input->post('name');
            $from = $this->input->post('email');
            $subject = $this->input->post('subject');
            $contactMessage = $this->input->post('message');
            /*For sending contact mail to admin*/
            $admin  = 'info@mawjuud.com';
            $message = ucwords($name).' contacted you on Mawjuud by sending the following message : <br/><br/>';
            $message.=$contactMessage;
            sendMail($admin,$from,$message,'Admin',$subject);
            /*For sending contact successful message to user*/
            $message = 'Thanks for contacting us! We will be right back to you soon.';
            sendMail($from,$admin,$message,$name,'Mawjuud');
            echo json_encode(array('status'=>1));
            die;
        }
        $this->load->view('frontend/contact_us');
    }

    public function privacyPolicy(){
        $data['contents'] = $this->common_model->getsingle(PAGE_SETTINGS,array('page'=>'privacy-policy'));
        $this->load->view('frontend/privacy_policy',$data);
    }

    public function termsConditions(){
        $data['contents'] = $this->common_model->getsingle(PAGE_SETTINGS,array('page'=>'terms-of-use'));
        $this->load->view('frontend/terms_and_conditions',$data);
    }

    public function cookiePolicy(){
        $data['contents'] = $this->common_model->getsingle(PAGE_SETTINGS,array('page'=>'cookie-policy'));
        $this->load->view('frontend/cookie_policy',$data);
    }
}
