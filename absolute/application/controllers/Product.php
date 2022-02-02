<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends SR_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('url');
    }
/***********************************************/
/***********************************************/
/***********************************************/
	public function index(){
 
       redirect(siteurl('products'));
	}
/***********************************************/
/************VIEW-MARKET************************/
/***********************************************/
public function live_search($search='')
{
  
  
if(!empty($search))
{
$this->db->select('product,id');
$this->db->from('product');
$this->db->like('product', $search);
$d= $this->db->get();
$data=$d->result_array(); 
if(!empty($data)){
foreach($data as $list)
{
    $id=site_url("product/singleproduct/").encoding($list['id']);
   echo "<p><a href='$id'>".$list['product']."</a></p>";
}
}else
{
    echo "<p>No Record Found</p>";
}
die;
}
 echo "<p>No Record Found</p>";
}

public function copy_product($id)
{
if(!empty($id))
{
$table='product';    
$this->db->where('copy_pid',$id); 
$query = $this->db->get($table);
$num = $query->num_rows();   
$primary_key_field='id';
$this->db->where('id',$id); 
$query = $this->db->get($table);
$duplicate_copy='0';
$pname='';
foreach ($query->result() as $row){   
foreach($row as $key=>$val){ 
if($key=='product')
{
    $pname=$val;
}
if($key != $primary_key_field){ 
  $this->db->set($key, $val);               
  } 
}
}

$this->db->insert($table); 
$pid=$this->db->insert_id(); 
$updata['copy_pid']=$id;
if(strpos($pname,'(Duplicate)') == false)
{
$updata['product']=  $pname.' (Duplicate)';  
}
 
$updata['duplicate_copy']=$num+1;
 
echo $this->db->update($table,$updata,array('id'=>$pid)); 
    }
}


	public function singleproduct($prid){
		$maindata=array();		
		$headerdata=array();	
		$footerdata=array();
		$productid=decoding($prid);
		$prdtl=$this->sr_model->getsingle(PRODUCT,array('id'=>$productid));
		if(empty($prdtl)){
         	redirect(BASEURL);		
		}
		$category = $prdtl->category;
		if(!empty($category)){
			$category = explode(',',$category);
		}
		$count = 0;
		$limit=100;
		$offset=0;
		$productsArr = array();
		foreach($category as $cat){
			$where = " FIND_IN_SET(".$cat.",category) and status=1";
			$productData=$this->sr_model->getAllwhere(PRODUCT,$where,'id','DESC','all',$limit,$offset);
			if(!empty($productData['result'])){
				foreach($productData['result'] as $product){
					if($count<20){
						$productsArr[] = $product;
						$count++;
					}else{
						break;
					}
				}
			}
		}

		$maindata['products']=$productsArr;
		$maindata['productdtl']=$prdtl;
		$page='singleproduct';
		$this->pageview($page,$headerdata,$maindata,$footerdata);
	}	
/***********************************************/
/*****************Add-to-Cart*******************/
/***********************************************/
	public function addtoCart(){
		if(isset($_POST['product_id'])){
		$id=$_POST['product_id'];
		$qty=$_POST['product_qty'];
		$price=$_POST['price'];
		$name=$_POST['name'];
		$data = array(
        'id'      => $id,
        'qty'     => $qty,
        'price'   => $price,
        'name'    => $name,
        'options' => array()
        );
        $carts=$this->cart->insert($data);
 
		if($this->cart){
        $return=array('resp'=>1,'status'=>1,'cart'=>$this->cart->contents(),'msg'=>'Product Added To Cart.');
		}else{
		$return=array('resp'=>0,'status'=>0,'cart'=>'','msg'=>'');	
		}
		echo json_encode($return);
		}
	}
public function updatecart(){
	if(isset($_POST['rowid'])){
		$qty=$_POST['product_qty'];
		$price=$_POST['price'];
		$rowid=$_POST['rowid'];
		
    $data=$this->cart->update(array(
        'rowid'=>$rowid,
        'qty'=>$qty,
        'price'=>$price
    ));

    $this->cart->update($data);  
       if($this->cart){
        $return=array('resp'=>1,'status'=>1,'cart'=>$this->cart->contents(),'msg'=>'Product Added To Cart.');
		}else{
		$return=array('resp'=>0,'status'=>0,'cart'=>'','msg'=>'');	
		}
		echo json_encode($return);
    }
}
/***********************************************/
/*****************Remove-From-Cart*******************/
/***********************************************/
	public function removefromCart(){
		if(isset($_POST['rowid'])){
		$rowid=$_POST['rowid'];
		
        $carts= $this->cart->remove($rowid);
		if($this->cart){
        $return=array('resp'=>1,'status'=>1,'cart'=>$this->cart->contents(),'msg'=>'Product Remove To Cart.');
		}else{
		$return=array('resp'=>0,'status'=>0,'cart'=>'','msg'=>'');	
		}
		echo json_encode($return);
		}
	}
/***********************************************/
/*****************Get-Quote*******************/
/***********************************************/
	public function getQuote(){
		if(isset($_POST['pid'])){
		$product_id=$_POST['pid'];
		$productid=decoding($_POST['pid']);
		$prdtl=$this->sr_model->getsingle(PRODUCT,array('id'=>$productid));
		
		$countries_res=$this->sr_model->getAllwhere('countries',array(),'name','ASC','all');
		$countries=$countries_res['result'];
		$allcountries="";
		foreach($countries as $country){
		$allcountries.='<option value="'.$country->id.'">'.$country->name.'</option>';	
		}
		
		if(empty($prdtl)){
         	$return=array('resp'=>0,'status'=>0,'htm'=>'','msg'=>'');		
		}else{
		$product_name=$prdtl->product;
		$product_image='<img src="'.BASEURL.'uploads/products/'.$prdtl->images.'" class="img-fluid" alt="'.$product_name.'">';
		$changestates=site_url('product/getstate');
		$html='<form action="javascript:void(0)" method="post" id="getquoteid">
		      <input type="hidden" name="pid" value="'.$product_id.'" id="pids">
		      <input type="hidden" name="product_name" value="'.$product_name.'" id="product_name">
              <div class="row"> 
              <div class="col-md-6 col-sm-6 col-12 form-group">
              <label for="Form-first">First Name*</label>
              <input type="text" name="firstname" id="Form-first" class="form-control check_empty">
			  <p class="input_error_msg">Please fill First Name.</p>
              </div>
                <div class="col-md-6 col-sm-6 col-12 form-group">
                  <label for="Form-sec">Last Name*</label>
                  <input type="text" name="lastname" id="Form-sec" class="form-control check_empty">
				  <p class="input_error_msg">Please fill Last Name.</p>
                </div>
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-Phone">Phone*</label>
                  <input type="text" name="phone" id="Form-Phone" class="form-control check_empty">
				  <p class="input_error_msg">Please fill Phone.</p>
                </div>

                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-email1">Email address*</label>
                  <input type="text" name="email" id="Form-email1" class="form-control check_empty">
				  <p class="input_error_msg">Please fill Email address.</p>
                </div>
				
                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-Company">Company name (optional)</label>
                  <input type="text" name="company" id="Form-Company" class="form-control">
				  <p class="input_error_msg">Please select company.</p>
                </div>

                <div class="col-md-12 col-sm-12 col-12 form-group">
                <label for="Form-Country">Country*</label>
                <select class="form-control check_empty" id="scountry" name="country" onchange="getRelated(\'scountry\',\'sstate\',\''.$changestates.'\')">
				  <option value="">Select Country</option>
				  '.$allcountries.';
				</select>
				<p class="input_error_msg">Please select Country.</p>
                </div>
             <div class="col-md-12 col-sm-12 col-12 form-group">
               <label for="Form-State">State *</label>
               <select id="sstate" class="form-control check_empty" name="state">
                <option value="">Select State</option>
				</select>
				<p class="input_error_msg">Please select State.</p>
             </div>
			 
				<div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-Company">Town / City*</label>
                  <input type="text" name="city" id="Form-email1" class="form-control check_empty">
				  <p class="input_error_msg">Please fill City.</p>
                </div>

                 <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-pass1">Street address</label>
                  <input name="address" type="text" class="form-control">
				  <p class="input_error_msg">Please fill Street address.</p>
                </div>

                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-Postcode">Postcode / ZIP*</label>
                  <input type="text" name="zipcode" id="Form-Postcode" class="form-control check_empty" >
				  <p class="input_error_msg">Please fill zipcode.</p>
                </div>

                <div class="col-md-12 col-sm-12 col-12 form-group">
                  <label for="Form-email1"></label>
                  <input type="button" name="submit" value="Submit" class="btn btn-info btn-block" onclick="saveData(\'getquoteid\',\''.site_url('product/getproductquote').'\',\'getQuoteForm\')" >
                </div>
              </div>
              </form>';
		
		if($html){
        $return=array('resp'=>1,'status'=>1,'htm'=>$html,'msg'=>'Product Remove To Cart.');
		}else{
		$return=array('resp'=>0,'status'=>0,'cart'=>'','msg'=>'');	
		}
		}
		echo json_encode($return);
		}
	}
/***********************************************/
/*****************getstate*******************/
/***********************************************/
	public function getstate(){
		if(isset($_POST['id'])){
		$countryid=$_POST['id'];
        $states_res=$this->sr_model->getAllwhere('states',array('country_id'=>$countryid),'name','ASC','all');
		$states=$states_res['result'];
	    $allstates="";
		foreach($states as $state){
		$allstates.='<option value="'.$state->id.'">'.$state->name.'</option>';	
		}
		
		if($allstates){
        $return=array('resp'=>1,'status'=>1,'msg'=>$allstates);
		}else{
		$return=array('resp'=>0,'status'=>0,'msg'=>'');	
		}
		echo json_encode($return);
		}
	}
/***********************************************/
/*****************getstate*******************/
/***********************************************/
	public function getproductquote(){
		if(isset($_POST['pid'])){
		$pid=$_POST['pid'];
		$product_id=decoding($pid);
		$product_name=$_POST['product_name'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		$company=$_POST['company'];
		$address=$_POST['address'];
		$zipcode=$_POST['zipcode'];
		
		$datas['product_id']=$product_id;
		
		$datas['product_name']=$product_name;
		$datas['firstname']=$firstname;
		$datas['lastname']=$lastname;
		$datas['phone']=$phone;
		$datas['email']=$email;
		$datas['company']=$company;
		$datas['address']=$address;
		$datas['zipcode']=$zipcode;
		$insrt=$this->sr_model->insertData('quotes',$datas);
		
        $message="
		<div>
		<h2>Product Quote</h2>
		Product   -
		First Name-".$firstname."<br>
		Last Name - ".$lastname."<br>
		Phone - ".$phone."<br>
		Email -".$email."<br>
		Company -".$company."<br>
		Address -".$address."<br>
		Zipcode -".$zipcode."<br>
		Date -".date('d-M-Y')."<br>
		<p></p>
		</div>";
		$subject="New Product Quote-".date('d-m-Y');
		$to_email="info@absolute-emc.com ";
		$from_email="info@absolute-emc.com";
		if($insrt){
		send_mail($message,$subject,$to_email,$from_email);
		
		send_mail($message,'Your quotation',$email,$from_email);
		
		
        $return=array('resp'=>1,'status'=>1,'msg'=>'Your quotation has been sent successfully.');
		}else{
		$return=array('resp'=>0,'status'=>0,'msg'=>'Something went wrong please reload and try again.');	
		}
		echo json_encode($return);
		}
	}
	
/***********************************************/
/*****************getstate*******************/
/***********************************************/
	public function quoteproducts(){
		if(isset($_POST['firstname'])){
		$carts=$this->cart->contents();
		$allids=array();
		$prhtm="<h2>Product</h2> <table><tr><td>#</td> <td>Image</td><td>Product</td></tr>";
		if(!empty($carts)){ $i=0; foreach($carts as $item){ $i++;
					$rowid=$item['rowid'];
					$pid=$item['id'];
					$id=decoding($pid);
					$allids[]=$id;
					$alldta=getSingleRecord(PRODUCT,array('id'=>$id));
					$rowid=$item['rowid'];
					$qty=$item['qty'];
					$price=$item['price'];
					$name=$item['name'];
					$image=$alldta->images;
					$prhtm.="<tr><td>".$i."</td> <td><img src='".BASEURL."/uploads/products/".$image."' style='width:100px' alt='".$name."' ></td><td>".$name."</td></tr>";
					
					$carts123= $this->cart->remove($rowid);
		}}
		$prhtm.="</table>";
		
		$all_product_ids=implode(',',$allids);
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		$company=$_POST['company'];
		$address=$_POST['address'];
		$zipcode=$_POST['zipcode'];
		
		$datas['product_id']=$all_product_ids;
		$datas['product_name']='';
		$datas['firstname']=$firstname;
		$datas['lastname']=$lastname;
		$datas['phone']=$phone;
		$datas['email']=$email;
		$datas['company']=$company;
		$datas['address']=$address;
		$datas['zipcode']=$zipcode;
		$datas['requirement']=$_POST['requirement'];
		$insrt=$this->sr_model->insertData('quotes',$datas);
		$req='';
		if($_POST['requirement']!=''){
		$req="application/requirements -".$_POST['requirement']."<br>";
		}
        $message="
		<div>
		<h2>Product Quote</h2>
		First Name-".$firstname."<br>
		Last Name - ".$lastname."<br>
		Phone - ".$phone."<br>
		Email -".$email."<br>
		Company -".$company."<br>
		Address -".$address."<br>
		Zipcode -".$zipcode."<br>
		Date -".date('d-M-Y')."<br>
		$red
		<p></p>
		".$prhtm."
		</div>";
		$subject="New Product Quote-".date('d-m-Y');
		$to_email="info@absolute-emc.com";
		$from_email="info@absolute-emc.com";
		if($insrt){
		send_mail($message,$subject,$to_email,$from_email);
		
		send_mail($message,'Your Last quotation',$email,$from_email);
		
        $return=array('resp'=>1,'status'=>1,'msg'=>'Your quotation has been sent successfully.');
		}else{
		$return=array('resp'=>0,'status'=>0,'msg'=>'Something went wrong please reload and try again.');	
		}
		echo json_encode($return);
		}
	}
/***********************************************/
/*****************getstate*******************/
/***********************************************/
}