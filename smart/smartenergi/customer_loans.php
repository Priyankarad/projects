<?php

if(isset($_POST['unique_id']) && $_POST['unique_id']!=""){
	require_once('config.php');
    $unique_id=$_POST['unique_id'];
	$upload_invoice =isset($_FILES['upload_invoice']) && $_FILES['upload_invoice']!="";
    if($_FILES['upload_invoice']['name'] != ''){
			
			$allowedExt = array('pdf','doc','docx');
			
			$ext = end(explode(".",$_FILES['upload_invoice']['name']));
			
			if(!in_array($ext,$allowedExt)){
				
				$errors['type'] = 'upload_invoice';
				$errors['msg'] = '* Invoice attachment must be in '.implode(', ',$allowedExt).' format';
				$errors['error'] = 1;
				echo json_encode($errors);
				exit();
			}else{
				$randomStr = $unique_id;
				
				$filenameorig = $_FILES['upload_invoice']['name'];
				$filetmpname = $_FILES['upload_invoice']['tmp_name'];
				
				$ext = end(explode(".",$filenameorig));
				$filename = $randomStr.'.'.$ext;
				//echo $filename;exit();
				move_uploaded_file($filetmpname, 'merchant_invoices/'.$filename);

			   $updateSql = updateQuery("backoffice_loan_applications",
									array("unique_id"=>addslashes($filename)),
									array("upload_invoice"=>addslashes(md5($newpass))),
									$con);;
				//echo $updateSql;		  
			
				$errors['error'] = 0;
				$errors['path'] = $filename;
		   		echo json_encode($errors);
				exit(); 
			}
		
}
}

?>
<?php 
require_once('header.php');

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
	
	header("Location:".BASE_URL.$_SESSION['currentLang'].'/merchant-signin');
	exit;
}
?>
<style type="text/css">
	/* Outer */
.popup {
	width:100%;
	height:100%;
	display:none;
	position:fixed;
	top:0px;
	left:0px;
	background:rgba(0,0,0,0.75);
}

/* Inner */
.popup-inner {
	max-width:700px;
	width:90%;
	padding:40px;
	position:absolute;
	top:50%;
	left:50%;
	-webkit-transform:translate(-50%, -50%);
	transform:translate(-50%, -50%);
	box-shadow:0px 2px 6px rgba(0,0,0,1);
	border-radius:3px;
	background:#fff;
}

/* Close Button */
.popup-close {
	width:30px;
	height:30px;
	padding-top:4px;
	display:inline-block;
	position:absolute;
	top:0px;
	right:0px;
	transition:ease 0.25s all;
	-webkit-transform:translate(50%, -50%);
	transform:translate(50%, -50%);
	border-radius:1000px;
	background:rgba(0,0,0,0.8);
	font-family:Arial, Sans-Serif;
	font-size:20px;
	text-align:center;
	line-height:100%;
	color:#fff;
}

.popup-close:hover {
	-webkit-transform:translate(50%, -50%) rotate(180deg);
	transform:translate(50%, -50%) rotate(180deg);
	background:rgba(0,0,0,1);
	text-decoration:none;
}
</style>

<!-- One -->
<section id="main" class="wrapper">
	<div class="container">
	
		<header class="major myaccountheader">
			<h2><?php echo($transArr['Customer Loans']); ?></h2>
		</header>
		
		<section>
			
			
			<table id="example" class="display" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo($transArr['Loan']); ?> #</th>
						<th><?php echo($transArr['Borrower Name']); ?></th>
						<th><?php echo($transArr['Amount Lended']); ?></th>
						<th><?php echo($transArr['Terms']); ?></th>
						<th>% APR</th>
						<th><?php echo($transArr['Product Name']); ?></th>
						<th><?php echo($transArr['Date of sale']); ?></th>
						<th><?php echo($transArr['Status']); ?></th>
						<th><?php echo($transArr['Service Cost']); ?></th>
						<th><?php echo($transArr['Payment Sent']); ?></th>
						<th><?php echo($transArr['Actions']); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
												
					$qry = selectQueryWithJoin("SELECT LA.*, CONCAT_WS(' ',BO.firstname, BO.surname) AS borrowername FROM ".TABLE_PREFIX."backoffice_loan_applications AS LA
							LEFT JOIN ".TABLE_PREFIX."backoffice_borrowers BO ON BO.id = LA.borrower_id 
							WHERE LA.merchant_id = '".$_SESSION['userid']."'",$con);;
					$rows = mysqli_num_rows($qry);
					
					if(count($rows)){
						$sl = 1;
						while($row = mysqli_fetch_assoc($qry)){
							
							$loan_id = stripslashes($row['unique_id']);
							$borrowername = stripslashes($row['borrowername']);
							$loan_terms = stripslashes($row['loan_terms']);
							$loan_amount = stripslashes($row['loan_amount']);
							$loan_apr = stripslashes($row['loan_apr']);
							$product_name = stripslashes($row['product_name']);
							$createdate = stripslashes($row['createdate']);
							$status = ucfirst(stripslashes($row['status']));
							$payment_sent = ucfirst(stripslashes($row['payment_sent']));
							$upload_invoice = stripslashes($row['upload_invoice']);
							?>
							<tr>
								<td><?php echo($sl); ?></td>
								<td><?php echo($loan_id); ?></td>
								<td><?php echo($borrowername); ?></td>
								<td>&euro;<?php echo($loan_amount); ?></td>
								<td><?php echo($loan_terms); ?> months</td>
								<td><?php echo($loan_apr); ?></td>
								<td><?php echo($product_name); ?></td>
								<td><?php echo(date('d/m/Y',$createdate)); ?></td>
								<td><?php echo($status); ?></td>
								<td><?php echo(DEFAULT_FEE); ?></td>
								<td><?php echo($payment_sent); ?></td>
								<td>
									<a filePath="<?php echo($upload_invoice); ?>" unique_id="<?php echo($loan_id); ?>" class="btn" data-popup-open="popup-1" href="#">Upload</a>
								</td>
							</tr>
							<?php
							$sl++;
						}
					}
					?>					
				</tbody>
			</table>
			
			
		</section>
		
	</div>
</section>
<div class="popup" data-popup="popup-1">
	<div class="popup-inner">
		<h2>Upload Invoice</h2>
		<a href="" target="_blank"></a>
		 <form class="form-horizontal" id="upload_invoice_form" name="" action="" method="post" enctype="multipart/form-data">
		 	<input class="unique_id" type="hidden" name="unique_id"/>
		 	<input type="file" name="upload_invoice" id="upload_invoice" />
		 	<input type="submit" value="submit" name="upload_submit_invoice"/>
		 </form>
		<p><a data-popup-close="popup-1" href="#">Close</a></p>
		
		<a class="popup-close" data-popup-close="popup-1" href="#">x</a>
	</div>
</div>
<script>

$.extend( true, $.fn.dataTable.defaults, {
    "searching": true
} );

$(document).ready(function() {
    $('#example').DataTable();
	$('#example_length').hide();
});
$(function() {
	//----- OPEN
	$('[data-popup-open]').on('click', function(e) {
		$(".unique_id").val(jQuery(this).attr('unique_id'));
		if($(this).attr('filePath')!=""){
			$("#upload_invoice_form").parents('.popup-inner').find('a').attr('href','merchant_invoices/'+$(this).attr('filePath'));
			$("#upload_invoice_form").parents('.popup-inner').find('a').first().text($(this).attr('filePath'));
		}
		var targeted_popup_class = jQuery(this).attr('data-popup-open');
		$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

		e.preventDefault();
	});

	//----- CLOSE
	$('[data-popup-close]').on('click', function(e) {
		var targeted_popup_class = jQuery(this).attr('data-popup-close');
		$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

		e.preventDefault();
	});
});


$('#upload_invoice_form').unbind().submit(function(event){
    event.preventDefault();
    var formData = new FormData($(this)[0]);            
    $('#upload_invoice_form').find('.errbrdr').length;
    if($('#upload_invoice_form').find('.errbrdr').length > 0){
    	$('#upload_invoice_form').find('.errbrdr').removeClass();
    	$('#upload_invoice_form').find('.errtxt').remove();
    }
    if($('.success_msg').length > 0){
    	$('.success_msg').remove();
    }
    var request = $.ajax({
        type: 'POST',
        url: '<?=BASE_URL.$_SESSION['currentLang']; ?>/myaccount/merchant/customerloans',
        dataType:'json',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){  
        	$(".globalloader").hide();
        	$(".blurback").hide();
            if(data.error==1){
            	$('#' + data.type).addClass('errbrdr');
			    $('#' + data.type).after('<div class="errtxt">' + data.msg + '</div>');
            }else{
     $('<div class="success_msg">File Uploaded Successfully.</div>').insertBefore("#upload_invoice_form");
        $('#upload_invoice').val('');
        $("#upload_invoice_form").parents('.popup-inner').find('a').attr('href','merchant_invoices/'+data.path);
			$("#upload_invoice_form").parents('.popup-inner').find('a').first().text(data.path);

            }
        },
        error: function(msg){
           // alert(JSON.stringify(msg,null,4));
        }
    });             
});



</script>

<?php 
require_once('footer.php');
?>