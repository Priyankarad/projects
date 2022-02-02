<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Market extends SR_Controller{

	public function __construct(){

        parent::__construct();

        $this->load->library('pagination');

        $this->load->helper('url');

    }

/***********************************************/

/***********************************************/

/***********************************************/

	public function index(){

		$maindata=array();		

		$headerdata=array();	

		$footerdata=array();

		$page='index';

		$this->pageview($page,$headerdata,$maindata,$footerdata);

	}

/***********************************************/

/******************VIEW-MARKET************************/

/***********************************************/

	public function viewmarket($marketids){

		$maindata=array();		

		$headerdata=array();	

		$footerdata=array();

		$marketid=decoding($marketids);

		$mktdtl=$this->sr_model->getsingle(MARKET,array('id'=>$marketid));

		if(empty($mktdtl)){

         	redirect(BASEURL);		

		}

		$userdata=$this->sr_model->getAllwhere(PRODUCT,"FIND_IN_SET('".$marketid."',market) AND status='1'",'id','DESC','all',20,0);

		$maindata['relatedproducts']=$userdata['result'];
	

		$maindata['mktdtl']=$mktdtl;

		$page='singlemarket';

		$this->pageview($page,$headerdata,$maindata,$footerdata);

	}

/***********************************************/

/******************VIEW-MARKET************************/

/***********************************************/

}