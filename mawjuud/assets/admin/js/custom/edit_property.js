$("#profile_img").change(function() {
		readURL(this,'user_img');
	});
	$(document).ready(function(){
		var dateToday = new Date();  
		$('.datepicker').datepicker({ minDate: dateToday,dateFormat: 'dd-mm-yy'});
		$('.textareaeditors').richText();
	});
	/*==========add-Aminities============*/ 
	var additional_amenities = [];

	jQuery(document).on('click', '#newAddAminities', function(){ 
		var newAmiadd = jQuery(this).siblings('input').val(); 
		if(newAmiadd == 0){
			Ply.dialog("alert",'Please add Amenities');
		}else{ 
			jQuery(this).siblings('input').val(' '); 
			jQuery('.newAmntsAppend').append('<div class="group-checkbox"> <label class="hide_P"><span class=span_ami> ' + newAmiadd + ' </span></label> <i class="removeTags"> x </i></div>'); 
		}
		addAmenities();
	});

	jQuery(document).on('click', '.newAmntsAppend .group-checkbox', function(){
		$(this).remove();  
		addAmenities();
	});


	function addAmenities(){
		additional_amenities = [];
		jQuery('.span_ami').each(function() {
			var currentElement = $(this);
			var value = currentElement.text();
			additional_amenities.push(value);
		});
		$('#additional_amenities1').val(additional_amenities);
	}

	var storedFiles = [];
var index;
$('.selFile').on('click',function(){
    var images = $('#images').val();
    var source = $(this).data('source');
    if(source!=''){
        var img = images.split(",");
        img = jQuery.grep(img, function(value) {
        return value != source;
        });
        $('#images').val(img);
    }
});

$(document).ready(function() {
    $("#filesss").on("change", handleFileSelect);
    $("body").on("click", ".selFile", removeFile);
});

function handleFileSelect(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    filesArr.forEach(function(f) {      
        if(!f.type.match("image.*")) {
            return;
        }
        storedFiles.push(f);

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<div class='col s2 documentUploadS'><img class='imageThumb' src='"+e.target.result+"' title='"+f.name+ "'></img><span class='ti-close selFile' data-file='"+f.name+"'></span></div>").appendTo("#dragimgappend");

        }
        reader.readAsDataURL(f); 
    });

}

$( function() {
    $( "#dragimgappend" ).sortable();
});

function removeFile(e) {
    var file = $(this).data("file");
    for(var i=Number(0);i<Number(storedFiles.length);i++) {
        if(storedFiles[i].name === file) {
            storedFiles.splice(i,1);
            break;
        }
    }
    $(this).closest(".documentUploadS").remove();
}
var quest_count = $('#quest_count').val();
var x = $('#quest_count').val();
if(Number(x) == Number(0)){
	$('.questionAnswer').hide();
	x=1;
}else{
	x=Number(x)+Number(1);
    $('.questionAnswer').show();
}

//================QUESTION ADD DIV =================
$(document).ready(function(){
    var maxField = 4; 
    var addButton = $('.addQuestionT'); 
    var wrapper = $('#questionsList'); 
    var fieldHTML = '<div><input type="text" name="questions[]" value=""/><a class="remove_button">Delete</a></div>'; 
    $(addButton).click(function(){
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML); 
        }
    });

    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
        x--; 
    });

    $('.switchCheck').trigger('change');
    $('.switchCheck').change(function(){
        if(this.checked) {
            $('.questionAnswer').show();
        } else {
            $('.questionAnswer').hide();
        }
    });   
});

/*To add property*/
$(document).on('click',".add_property",function(e){
    e.preventDefault();
        var formData = new FormData($('#editPropertyForm')[0]);
        if(storedFiles.length>0){
            for(var i=0, len=storedFiles.length; i<len; i++) {
                formData.append('file[]', storedFiles[i]);  
            } 
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', base_url+ 'property_update', true);
        xhr.responseType = 'json';
        xhr.onload = function(e) {
        	window.location.href=base_url+"listings";
        }
        xhr.send(formData);
});   
