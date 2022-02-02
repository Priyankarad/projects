<!-- add new calendar event modal -->
<!-- jQuery 2.0.2 -->
<script src="js/jquery.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->
<script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- daterangepicker -->
<script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/AdminLTE/demo.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
	$("#example1").dataTable();
	$('#example2').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false
	});
});

//When unchecking the checkbox
$("#check-all").on('ifUnchecked', function(event) {
	//Uncheck all checkboxes
	$("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
});
//When checking the checkbox
$("#check-all").on('ifChecked', function(event) {
	//Check all checkboxes
	$("input[type='checkbox']", ".table-mailbox").iCheck("check");
});

function delsel(){
	
	var element = document.getElementsByName('chk_id[]');
	ln = element.length;
	
	var flag = 0;
		
	for(i=0;i<ln;i++){
		
		//alert(element[i].checked);
		
		if(element[i].checked){
			
			flag = 1;
			break;
		}
	}
	
	if(flag == 0){
		
		alert('You must select atleast one item');
	}
	else{
		
		var cnf = confirm('Are you sure?');
		if(cnf){
			
			document.frmlisting.mode.value = 'delsel';
			document.frmlisting.submit();
		}
		
	}
}

function del(id){
	
	var cnf = confirm('Are you sure?');
	if(cnf){
		
		document.frmlisting.mode.value = 'del';
		document.frmlisting.id.value = id;
		document.frmlisting.submit();
	}
}

</script>