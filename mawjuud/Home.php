<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$userId = get_current_user_id();
		$data['page'] = 'home';
		//$where = ' latitude!=""';
                $where = ' thumbnail_photo_media!="" and thumbnail_photo_media IS NOT NULL ';
                /*recently listed*/
                $data['recentlyListed'] = $this->common_model->getAllwhere(PROPERTY,$where,'id','desc','all',50);
                /*most viewed*/
                $data['mostViewed'] = $this->common_model->getAllwhere(PROPERTY,$where,'page_view','desc','all',50);
                /*largest propeties*/
                $data['largestPropeties'] = $this->common_model->getAllwhere(PROPERTY,$where,'square_feet','desc','all',50);
                /*high-end properties*/
                $where = ' latitude!="" and property_price>500000';
                $data['highEnd'] = $this->common_model->getAllwhere(PROPERTY,$where,'square_feet','desc','all',50);
                $favouriteProperties = $this->common_model->getAllwhere(FAVOURITE_PROPERTY,array('user_id'=>$userId,'status'=>1));
                if(!empty($favouriteProperties['result'])){
                        foreach($favouriteProperties['result'] as $property){
                                $data['favourite_properties'][] = $property->property_id;
                        }
                }
                $this->load->view('frontend/home',$data);
        }
}
