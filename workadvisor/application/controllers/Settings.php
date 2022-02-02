<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * This Class used as admin management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Priyanka Jain
 */
class Settings extends MY_Controller {
	function __construct(){
		parent::__construct();
	}
	/**
     * Function Name: index
     * Description:   To add sliders
     */
	public function index(){
		$config['parent'] = "Slider Section";
        $where = " 1=1";
        $config['sliderData'] = $this->common_model->getAllwhere(SLIDERS,$where);
		$this->template->load('default', 'slider',$config);
	}

	public function updateSlider(){
        if(!empty($_FILES)){
    		$filesCount = count($_FILES['files']['name']);
    		if($filesCount>0){
    			for($i = 0; $i < $filesCount; $i++){
                    $_FILES['docfile']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['docfile']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['docfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['docfile']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['docfile']['size'] = $_FILES['files']['size'][$i];
                    $config['upload_path'] = FCPATH.'uploads/sliders/';
                    $path=$config['upload_path'];
                    $config['allowed_types'] = 'png|jpg|jpeg|gif';
                    $config['overwrite'] = '1';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('docfile')){
                        $fileData = $this->upload->data();
                        $dataInsert['path']  = 'uploads/sliders/'.$fileData['file_name'];
                        $dataInsert['upload_date'] = date('Y-m-d H:i:s');
                        $ins = $this->common_model->insertData(SLIDERS, $dataInsert);
                    }else{
                        print_r($this->upload->display_errors());
                    }
                }
    		}
        }
		redirect('settings');
	}

    public function terms_of_service(){
        $page="terms_of_service";
        $headerdata=array();
        $maindata=array();
        $footerdata=array();
        $maindata['aboutData'] = $this->common_model->getAllwhere(PAGE_SETTINGS,array('id'=>5));
        $this->pageview($page,$headerdata,$maindata,$footerdata);     
    }

    public function privacy_policy(){
        $page="privacy_policy";
        $headerdata=array();
        $maindata=array();
        $footerdata=array();
        $maindata['aboutData'] = $this->common_model->getAllwhere(PAGE_SETTINGS,array('id'=>4));
        $this->pageview($page,$headerdata,$maindata,$footerdata);     
    }

    public function about_us(){
        $page="about_us";
        $headerdata=array();
        $maindata=array();
        $footerdata=array();
        $headerdata['seo'] = 'about';
        $maindata['aboutData'] = $this->common_model->getAllwhere(PAGE_SETTINGS,array('id'=>1));
        $this->pageview($page,$headerdata,$maindata,$footerdata);     
    }
    public function how_it_works(){
        $page="how_it_works";
        $headerdata=array();
        $maindata=array();
        $footerdata=array();
        $headerdata['seo'] = 'how_it_works';
        $maindata['aboutData'] = $this->common_model->getAllwhere(PAGE_SETTINGS,array('id'=>2));
        $this->pageview($page,$headerdata,$maindata,$footerdata);     
    }
    public function faq(){
        $page="faq";
        $headerdata=array();
        $maindata=array();
        $footerdata=array();
        $headerdata['seo'] = 'faq';
        $maindata['aboutData'] = $this->common_model->getAllwhere(PAGE_SETTINGS,array('id'=>3));
        $this->pageview($page,$headerdata,$maindata,$footerdata);     
    }

    public function contact_us(){
        $page="contact_us";
        $headerdata=array();
        $maindata=array();
        $footerdata=array();
        $maindata['aboutData'] = $this->common_model->getAllwhere(PAGE_SETTINGS,array('id'=>6));
        $this->pageview($page,$headerdata,$maindata,$footerdata);     
    }

    public function page_settings(){
        $config['parent'] = "Page Settings";
        $where = '1=1';
        $config['pageData'] = $this->common_model->getAllwhere(PAGE_SETTINGS);
        $this->template->load('default', 'page_settings',$config);
    }

    public function page_contents($page_id){
        $config['parent'] = "Page Settings";
        $page_id = decoding($page_id);
        $where = array('id'=>$page_id);
        $config['pageData'] = $this->common_model->getSingle(PAGE_SETTINGS,$where);
        if($page_id == 1){
            $page = 'about_us';
        }else{
            $page = 'content_editor';
        }
        $this->template->load('default',$page,$config);
    }

    public function save_page_data(){
        $config['parent'] = "Page Settings";
        $dataUpdate= array();
        if($this->input->post()){
            if($this->input->post('id') == 1){
                if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
                    $image = fileUploading('image','users','jpg|gif|png|jpeg|JPG|PNG');
                    if(isset($image['error'])){
                        $return['status']         =   0; 
                        $return['message']        =   strip_tags($image['error']);
                        $this->session->set_flashdata('content_update','<div class="alert alert-danger text-center">Photo Not Uploaded.'.$image['error'].' </div>');
                        redirect('settings/page_settings');
                        exit;
                    }else{
                        $dataUpdate['image']    = base_url().'uploads/users/'.$image['upload_data']['file_name'];
                    }
                }

                $dataUpdate['heading_1'] = $this->input->post('heading_1');
                $dataUpdate['heading_2'] = $this->input->post('heading_2');
                $dataUpdate['heading_3'] = $this->input->post('heading_3');
                $dataUpdate['content_1'] = $this->input->post('content_1');
                $dataUpdate['content_2'] = $this->input->post('content_2');
                $dataUpdate['content_3'] = $this->input->post('content_3');
                $dataUpdate['content_4'] = $this->input->post('content_4');
                $dataUpdate['content_5'] = $this->input->post('content_5');
                $dataUpdate['content_6'] = $this->input->post('content_6');
                $this->common_model->updateFields(PAGE_SETTINGS,$dataUpdate,array('id'=>$this->input->post('id')));
            }else{
                $dataUpdate['content_1'] = $this->input->post('content_1');
                $this->common_model->updateFields(PAGE_SETTINGS,$dataUpdate,array('id'=>$this->input->post('id')));
            }
        }
        $this->session->set_flashdata('content_update','<div class="alert alert-success text-center">Content updated successfully</div>');
        redirect('settings/page_settings');
    }
}
/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */
?>