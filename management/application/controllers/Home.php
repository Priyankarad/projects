<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * This class used for home page loading
 * @package   CodeIgniter
 * @category  Controller
 * @author    Priyanka Jain
 */

class Home extends CI_Controller {

    /**
     * Function Name: home
     * Description:   For loading home page
    */
	public function index()
	{
		$this->session->unset_userdata('school_search');
		$this->session->unset_userdata('course_search');
		$this->load->view('home');
	}
}
