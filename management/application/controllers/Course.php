<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * This class used for course management
 * @package   CodeIgniter
 * @category  Controller
 * @author    Priyanka Jain
 */

class Course extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->session->unset_userdata('school_search');
    }
    
    /**
     * Function Name: index
     * Description:   For showing the list of courses
    */
	public function index()
	{
		redirect('course/list');
	}

    /**
     * Function Name: list
     * Description:   To show courses in pagination
    */
    public function list($rowNo=0){
        $searchText = "";
        if($this->input->post('submit') != NULL ){
            $searchText = $this->input->post('search');
            $this->session->set_userdata('course_search',$searchText);
        }
        else{
            if($this->session->userdata('course_search') != NULL){
                $searchText = $this->session->userdata('course_search');
            }
        }
        $rowPerPage = 5;
        if($rowNo != 0){
            $rowNo = ($rowNo-1) * $rowPerPage;
        }
        $allcount = $this->common_model->getrecordCount($searchText,COURSE);
        $courseRecords = $this->common_model->getLikeData($rowNo,$rowPerPage,$searchText,COURSE);
        $config['base_url'] = base_url().'/course/list';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowPerPage;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['courseRecords'] = $courseRecords;
        $data['row'] = $rowNo;
        $data['search'] = $searchText;
        $this->load->view('course_list',$data);
        
    }

    /**
     * Function Name: create
     * Description:   To create course and save its data
    */
    public function create(){
        if($this->input->post()){
            if($this->form_validation->run('course') == TRUE){
                $dataInsert = array();
                $dataInsert['name'] = $this->input->post('course_name');
                $dataInsert['duration'] = $this->input->post('duration');
                $dataInsert['price'] = $this->input->post('price');
                $courseID = $this->common_model->insertData(COURSE,$dataInsert);
                if($courseID){
                    $schoolArr = array();
                    $schools = $this->input->post('schools');
                    foreach($schools as $school){
                        $courseSchoolData['school_id'] = $school;
                        $courseSchoolData['course_id'] = $courseID;
                        $schoolArr[] = $courseSchoolData; 
                    }
                    $this->common_model->insertBatch(SCHOOL_COURSE,$schoolArr);
                    $this->session->set_flashdata('success','Course added successfully');
                    redirect('course/list');
                }
            }
        }
        $data['schoolData'] = $this->common_model->getAllwhere(SCHOOL);
    	$this->load->view('course_create',$data);
    }

    /**
     * Function Name: edit
     * Description:   To edit course
    */

    public function edit($courseID){
        if($courseID){
            $where['id'] = decoding($courseID);
            $data['courseData'] = $this->common_model->GetJoinRecord(COURSE,'id',SCHOOL_COURSE,'course_id','GROUP_CONCAT(school_course.school_id SEPARATOR ",") as schools,course.*',array('course.id'=>$where['id']));
            $data['schoolData'] = $this->common_model->getAllwhere(SCHOOL);
            $this->load->view('edit_course',$data);
        }else{
            echo json_encode(array('response'=>'Invalid call'));
        }
    }

    /**
     * Function Name: update
     * Description:   To update course data
    */
    public function update(){
        if($this->input->post()){
            if($this->form_validation->run('course') == TRUE){
                $dataUpdate = array();
                $dataUpdate['name'] = $this->input->post('course_name');
                $dataUpdate['duration'] = $this->input->post('duration');
                $dataUpdate['price'] = $this->input->post('price');
                $courseID = $this->input->post('course_id');
                $this->common_model->updateFields(COURSE,$dataUpdate,array('id'=>$courseID));
                $schoolArr = array();
                $schools = $this->input->post('schools');
                $this->common_model->deleteData(SCHOOL_COURSE,array('course_id'=>$courseID));
                foreach($schools as $school){
                    $courseSchoolData['school_id'] = $school;
                    $courseSchoolData['course_id'] = $courseID;
                    $courseExistData = $this->common_model->getsingle(SCHOOL_COURSE,$courseSchoolData);
                    if(empty($courseExistData)){
                        $schoolArr[] = $courseSchoolData; 
                    }
                }
                $this->common_model->insertBatch(SCHOOL_COURSE,$schoolArr);
                $this->session->set_flashdata('success','Course updated successfully');
                redirect('edit-course/'.encoding($courseID));
            }
        }
    }

    /**
     * Function Name: delete
     * Description:   To delete course data
    */
    public function delete($courseID){
        $courseID = decoding($courseID);
        if($courseID){
            if($this->common_model->deleteData(COURSE,array('id'=>$courseID))){
                $this->session->set_flashdata('success','Course deleted successfully');
                redirect('course/list');
            }
        }else{
            echo json_encode(array('response'=>'Invalid call'));
        }
    }

    /**
     * Function Name: view
     * Description:   To view course details
    */

    public function view($courseID){
        $courseID = decoding($courseID);
        if($courseID){
            $data['courseData'] = $this->common_model->getsingle(COURSE,array('id'=>$courseID));
            $this->load->view('view_course',$data);
        }else{
            echo json_encode(array('response'=>'Invalid call'));
        }
    }
}
