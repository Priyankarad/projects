$('.types').hide();
$(document).on('change','#source',function(){
	var type = $(this).val();
	if(type == 'gomaster'){
		$('.types').show();
	}else{
		$('.types').hide();
	}
});