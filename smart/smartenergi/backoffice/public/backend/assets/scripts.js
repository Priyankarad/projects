$(function() {
    // Side Bar Toggle
    $('.hide-sidebar').click(function() {
    	$('#sidebar').hide('fast', function() {
    		$('#content').removeClass('span9');
    		$('#content').addClass('span12');
    		$('.hide-sidebar').hide();
    		$('.show-sidebar').show();
    	});
    });

    $('.show-sidebar').click(function() {
    	$('#content').removeClass('span12');
    	$('#content').addClass('span9');
    	$('.show-sidebar').hide();
    	$('.hide-sidebar').show();
    	$('#sidebar').show('fast');
    });

    $('.btn-primary[type="submit"]').click(function(){
    	$(this).html('Please wait...');
    	setTimeout(function(){
    		$('.btn-primary[type="submit"]').prop('disabled',true);
    	},50);	
    });
    /*----- Pixlr -----*/
    
	/*----- Pixlr -----*/
});

/*
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
    	
        var min = parseInt( $('#filterDays').val(), 10 );
        var max = parseInt( $('#filterDays').val(), 10 );
        var age = parseFloat( data[3] ) || 0; // use data for the age column
 
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
        	
            return true;
        }
        console.log("min : "+min+" max : "+min+" age"+age);
        return false;
    }
    
);

 
$(document).ready(function() {
    var table = $('.datatable_smartcredit').DataTable();
     
    // Event listener to the two range filtering inputs to redraw on input
    $('#filterDays').change( function() {
        table.draw();
    } );
} );
*/
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
    	
        var min = parseInt( $('#filterDays').val(), 10 );
        var max = parseInt(365, 10 );
        var age = parseFloat( data[5] ) || 0; // use data for the age column

 		if($('#filterDays').find("option:selected").val()){
 			min=$('#filterDays').find("option:selected").attr("min");
 			max=$('#filterDays').find("option:selected").val();
 			if ( ( isNaN( min ) && isNaN( max ) ) ||
	             ( isNaN( min ) && age <= max ) ||
	             ( min <= age   && isNaN( max ) ) ||
	             ( min <= age   && age <= max ) )
 			{
 				return true;
 			}
 			return false;
        }else if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {        	
            return true;
        }

        
        //console.log("min : "+min+" age : "+age);
        return false;
    }
    
);

 
$(document).ready(function() {
    var table = $('.datatable_smartcredit').DataTable();
     
    // Event listener to the two range filtering inputs to redraw on input
    $('#filterDays').change( function() {
        table.draw();
    } );
} );

        
    $(function() {
      if($(".uniform_on").length > 0)
        $(".uniform_on").uniform();
      if($(".chzn-select").length > 0)
        $(".chzn-select").chosen();
    });
    
    $(document).ready(function(){
        
        $('.delclass').click(function(e){
            
            e.preventDefault();
            
            var cnf = confirm("Are you sure?");
            var redirectto = $(this).attr('href');
            
            if(cnf){
                location.href = redirectto;
            }
        });
    
        
        
        
    });
        
    function truncate(){
        
        var cnf = confirm('Are you sure?');
        if(cnf){
            
            document.frmlisting.act.value = 'truncate';
            document.frmlisting.submit();
        }
    }
        
    function showsection(currentsection){

        if(currentsection.value==1){
            currentsection.parentNode.parentNode.parentNode.nextElementSibling.style.display='block';
        }else
           currentsection.parentNode.parentNode.parentNode.nextElementSibling.style.display='none';
    }   

    if($(".cash").length > 0){
            var table = $('.cash').DataTable({
                "oLanguage": {
                    "sSearch": "<b>Filter By Lender Name : </b>"
                },
                "bPaginate": false
            });
           
            $("#walletfilter").change(function() {
                  var filterValue = $(this).val();
                  var row = $('.walletrow');
                  var row1=$("#loanfilter option:selected").val();
                  row.parents("tr").hide();
                  row.each(function(i, el) {
                    var loanid=$.trim($(el).next().html());
                    if ("all" == filterValue && row1=="all"){
                        $(el).parents("tr").show();
                    }else if ("all" == filterValue && row1!="all") {
                        if(loanid==row1)
                              $(el).parents("tr").show();
                    }else if ("all" == row1 && filterValue!="all") {
                        if ($.trim($(el).html()) == filterValue)
                              $(el).parents("tr").show();
                            
                    }else{
                        if ($.trim($(el).html()) == filterValue && loanid==row1)
                              $(el).parents("tr").show();
                    }


                  });
                  /*
                  if ("all" == filterValue) {
                    row.parents("tr").show();
                  }
                  */
                    
/*
                  var filterValue = $(this).val();
                  var row = $('.walletrow');

                  row.parents("tr").hide();
                  row.each(function(i, el) {
                    if ($.trim($(el).html()) == filterValue) {
                      $(el).parents("tr").show();
                    }

                  });
                  if ("all" == filterValue) {
                    row.parents("tr").show();
                  }
*/
            });

            $("#loanfilter").change(function() {
                
                  var filterValue = $(this).val();
                  var row = $('.loanrow');
                  var row1=$("#walletfilter option:selected").val();
                  row.parents("tr").hide();
                  row.each(function(i, el) {
                    var walletid=$.trim($(el).prev().html());
                    if ("all" == filterValue && row1=="all"){
                        $(el).parents("tr").show();
                    }else if ("all" == filterValue && row1!="all") {
                        if(walletid==row1)
                              $(el).parents("tr").show();
                    }else if ("all" == row1 && filterValue!="all") {
                        if ($.trim($(el).html()) == filterValue)
                              $(el).parents("tr").show();
                            
                    }else{
                        if ($.trim($(el).html()) == filterValue && walletid==row1)
                              $(el).parents("tr").show();
                    }

                  });
                // In Addition to Wlin's Answer (For "All" value)
                /*
                  if ("all" == filterValue) {
                    row.parents("tr").show();
                  }
*/
                });
    }