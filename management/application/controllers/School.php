<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * This class used for school management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Priyanka Jain
 */

class School extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->session->unset_userdata('course_search');
    }

    /**
     * Function Name: index
     * Description:   For showing the list of schools
    */
	public function index()
	{
		redirect('school/list');
	}

    /**
     * Function Name: list
     * Description:   To show schools in pagination
    */
    public function list($rowNo=0){
        $searchText = "";
        if($this->input->post('submit') != NULL ){
            $searchText = $this->input->post('search');
            $this->session->set_userdata('school_search',$searchText);
        }
        else{
            if($this->session->userdata('school_search') != NULL){
                $searchText = $this->session->userdata('school_search');
            }
        }
        $rowPerPage = 3;
        if($rowNo != 0){
            $rowNo = ($rowNo-1) * $rowPerPage;
        }
        $allcount = $this->common_model->getrecordCount($searchText,SCHOOL);
        $schoolRecords = $this->common_model->getLikeData($rowNo,$rowPerPage,$searchText,SCHOOL);
        $config['base_url'] = base_url().'/school/list';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowPerPage;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['schoolRecords'] = $schoolRecords;
        $data['row'] = $rowNo;
        $data['search'] = $searchText;
        $this->load->view('school_list',$data);
        
    }

    /**
     * Function Name: create
     * Description:   To create school and save its data
    */
    public function create(){
        if($this->input->post()){
            if($this->form_validation->run('school') == TRUE){
                $dataInsert = array();
                if (!empty($_FILES['school_logo']['name']))
                {
                    $fileData = fileUploading('school_logo','logos','png|jpg|jpeg');
                }
                $dataInsert['logo'] = !empty($fileData['upload_data']['file_name'])?$fileData['upload_data']['file_name']:DEFAULT_LOGO;
                $dataInsert['registration_id'] = $this->input->post('registration_id');
                $dataInsert['name'] = $this->input->post('school_name');
                $dataInsert['email'] = $this->input->post('email');
                $dataInsert['students'] = $this->input->post('students');
                $dataInsert['contact_no'] = $this->input->post('contact_number');
                $dataInsert['address'] = $this->input->post('address');
                $schoolID = $this->common_model->insertData(SCHOOL,$dataInsert);
                if($schoolID){
                    $courseArr = array();
                    $courses = $this->input->post('courses');
                    foreach($courses as $course){
                        $courseSchoolData['school_id'] = $schoolID;
                        $courseSchoolData['course_id'] = $course;
                        $courseArr[] = $courseSchoolData; 
                    }
                    $this->common_model->insertBatch(SCHOOL_COURSE,$courseArr);
                    $this->session->set_flashdata('success','School added successfully');
                    redirect('school/list');
                }
            }
        }
        $data['courseData'] = $this->common_model->getAllwhere(COURSE);
    	$this->load->view('school_create',$data);
    }

    /**
     * Function Name: edit
     * Description:   To edit school
    */

    public function edit($schoolID){
        if($schoolID){
            $where['id'] = decoding($schoolID);
            $data['schoolData'] = $this->common_model->GetJoinRecord(SCHOOL,'id',SCHOOL_COURSE,'school_id','GROUP_CONCAT(school_course.course_id SEPARATOR ",") as courses,school.*',array('school.id'=>$where['id']));
            $data['courseData'] = $this->common_model->getAllwhere(COURSE);
            $this->load->view('edit_school',$data);
        }else{
            echo json_encode(array('response'=>'Invalid call'));
        }
    }

    /**
     * Function Name: update
     * Description:   To update school data
    */
    public function update(){
        if($this->input->post()){
            if($this->form_validation->run('school') == TRUE){
                $dataUpdate = array();
                if (!empty($_FILES['school_logo']['name']))
                {
                    $fileData = fileUploading('school_logo','logos','png|jpg|jpeg');
                    $dataUpdate['logo'] = !empty($fileData['upload_data']['file_name'])?$fileData['upload_data']['file_name']:DEFAULT_LOGO;
                }
                $dataUpdate['name'] = $this->input->post('school_name');
                $dataUpdate['email'] = $this->input->post('email');
                $dataUpdate['students'] = $this->input->post('students');
                $dataUpdate['contact_no'] = $this->input->post('contact_number');
                $dataUpdate['address'] = $this->input->post('address');
                $schoolID = $this->input->post('school_id');
                $this->common_model->updateFields(SCHOOL,$dataUpdate,array('id'=>$schoolID));
                $courseArr = array();
                $courses = $this->input->post('courses');
                $this->common_model->deleteData(SCHOOL_COURSE,array('school_id'=>$schoolID));
                foreach($courses as $course){
                    $courseSchoolData['school_id'] = $schoolID;
                    $courseSchoolData['course_id'] = $course;
                    $courseExistData = $this->common_model->getsingle(SCHOOL_COURSE,$courseSchoolData);
                    if(empty($courseExistData)){
                        $courseArr[] = $courseSchoolData; 
                    } 
                }
                $this->common_model->insertBatch(SCHOOL_COURSE,$courseArr);
                $this->session->set_flashdata('success','School updated successfully');
                redirect('edit-school/'.encoding($schoolID));
            }
        }
    }

    /**
     * Function Name: delete
     * Description:   To delete school data
    */
    public function delete($schoolID){
        $schoolID = decoding($schoolID);
        if($schoolID){
            if($this->common_model->deleteData(SCHOOL,array('id'=>$schoolID))){
                $this->session->set_flashdata('success','School deleted successfully');
                redirect('school/list');
            }
        }else{
            echo json_encode(array('response'=>'Invalid call'));
        }
    }

    /**
     * Function Name: view
     * Description:   To view school details
    */

    public function view($schoolID){
        $schoolID = decoding($schoolID);
        if($schoolID){
            $data['schoolData'] = $this->common_model->getsingle(SCHOOL,array('id'=>$schoolID));
            $this->load->view('view_school',$data);
        }else{
            echo json_encode(array('response'=>'Invalid call'));
        }
    }
}
