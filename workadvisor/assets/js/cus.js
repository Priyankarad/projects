var enter_in_folders =  [0];
var user = $('#user_id').val();
var other_user = $('#other_user').val();
$(document).ready(function() {
	callDragFunctionality();

	$(".gr-lst-vie").on("click",function(){
		if($(this).attr('tp') == 'grid') {
			if(!$("#fileSuccess").hasClass('grid')) {
				$("#fileSuccess").addClass('grid');
				$("#fileSuccess").removeClass('list');
			}
		} else {
			$("#fileSuccess").removeClass('grid');
			$("#fileSuccess").addClass('list');
		}
	});
});

$('.arrange').change(function(){
	var order = $(this).val();
	var last = enter_in_folders.slice(-1)[0];
	getDirectoryData(last,user,order);
});

window.fbAsyncInit = function() {
    FB.init({
      appId            : '582985262114491',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v3.0'
    });
  }; 

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk')); 




function publish(sharevideo,sharetitle)
{
	var base_url = $('#base_url').val();
	var overrideDescription = 'View my profile, see my work and leave me a review! ';
      FB.ui({
		method: 'share_open_graph',
		action_type: 'og.shares',
		action_properties: JSON.stringify({
			object: {
				'og:image':base_url+'assets/images/video.png', 
				'og:url': sharevideo,
				'og:title': sharetitle,
				'og:video:type':"application/x-shockwave-flash",
				'og:video':sharevideo,
				'og:video:width':300,
				'og:video:height':300,
				'og:description': overrideDescription,
				//'og:video:secure_url': sharevideo,
			}
		})
	},
	function (response) {
	});
}





function submitAndShare(shareimg,sharetitle,url='') {
	sharedUrl = ''; 
	var title = "-"+sharetitle; 
	//var description = 'workadvisor profile of '+sharetitle;
	var description = 'View my profile, see my work and leave me a review! ';
	if(url == ''){
		sharedUrl = window.location.href
	} else {
		sharedUrl = url;
	}
	shareOverrideOGMeta(sharedUrl,sharetitle,description,shareimg);
	return false;
}

function shareOverrideOGMeta(overrideLink, overrideTitle, overrideDescription, overrideImage)
{
	FB.ui({
		method: 'share_open_graph',
		action_type: 'og.shares',
		action_properties: JSON.stringify({
			object: {
				'og:url': overrideLink,
				'og:title': overrideTitle,
				'og:description': overrideDescription,
				'og:image': overrideImage
			}
		})
	},
	function (response) {
	// Action after response
	});
}

function shareOriginal()
{
	FB.ui({
		method: 'share',
		href: window.location.href
	},
	function (response) {
	// Action after response
	});
	
	return false;
}
function addDirectory(r) {
	$('#dir-name').val('');
	jQuery("#addDirectory").modal().show();
}
function directoryCreate(r,user_id) {
	var parentDirectory = $('#directoryId').val();
	var base_url = $('#base_url').val();
	jQuery("#dnger-msg").html('');
	foldericonapp = '';
	if(jQuery("#dir-name").val() == '') {
		jQuery("#dnger-msg").html('<div class="alert alert-danger">Please insert directory name</div>');
	} else {
		 dirName = jQuery("#dir-name").val();
		 $.ajax({
			  type: "POST",
			  url: base_url+'profile/saveDirectory',
			  data: {dirName:dirName,user_id:user_id,parentDirectory:parentDirectory},
			  success: function (data) {
				alldata = jQuery.parseJSON(data);
				if(alldata.status == 'success') {
					lastinsertedId =  alldata.lastinsertedid;
					directoryname = alldata.directoryname; 
					/* append folder image */
					    foldericonapp = '<div class="col-md-3 col-12 documents_drag folders '+lastinsertedId+'" onclick="setIdDir('+lastinsertedId+')" data-doc_type="folder" id="'+lastinsertedId+'"><div class="album_icon"><div onclick="enterInFolder('+lastinsertedId+','+user_id+',&#39;&#39;,&#39;'+directoryname+'&#39;);"><div class="jerry documents_drag_folder" data-fid="'+lastinsertedId+'" data-doc_type="folder"><div class="cat_img but_imgsize"><img src="'+base_url+'/assets/images/folder_image.png"></div>'+dirName+'</div></div><input class="view_type_folder" type="radio" value="1" name="view_112" id="view_112" data-vid="112" checked="checked">Public<input class="view_type_folder" type="radio" value="2" name="view_112" id="view_112" data-vid="112">Private'; 
						if(alldata.userRole == 'Employer') {
							foldericonapp +='<input class="view_type_folder" type="radio" value="3" name="view_113" id="view_113" data-vid="'+lastinsertedId+'" >Employee</div></div></div>';
						}
					/* append folder image end */
					//jQuery("#fileSuccessmain").prepend(foldericonapp);

					var last = enter_in_folders.slice(-1)[0];
					if(last!='0'){
						getDirectoryData(last,user);
						jQuery("#fileSuccessmain").css('display','none');
						jQuery("#fileSuccessDir").css('display','block');
					}else{
						jQuery("#fileSuccessmain").prepend(foldericonapp);
						jQuery("#fileSuccessmain").css('display','block');
						jQuery("#fileSuccessDir").css('display','none');
					}
					jQuery("#addDirectory").modal('hide');
				} else {
					jQuery("#dnger-msg").html('<div class="alert alert-danger">'+alldata.msg+'</div>');
				}
			  }
			});
	}
}
function setIdDir(dirID) {
	jQuery('#record_id').val(dirID);
	jQuery('#folderrecord_id').val(dirID);
}
function enterInFolder(folderid,userId,other=0,Dirname = '') {
	enter_in_folders.push(folderid);
	user = userId;
	var base_url = $('#base_url').val();
	jQuery("#fileSuccessmain").css('display','none');
	jQuery("#fileSuccessDir").css('display','block');
   jQuery("#directoryId").val(folderid);
	if(other == 1){
		other="other";
		other_user = "other";
	}	
	// alert(other);
	$.ajax({
		type: "POST",
		url: base_url+'profile/retrieveDirectoryFiles',
		data: {folderid:folderid,userId:userId,other:other,Dirname:Dirname},
		success: function (data) {
			alldata = jQuery.parseJSON(data);
			if(alldata.status == 'success') {
				jQuery("#fileSuccessDir").html(alldata.msg);	
			}
			callDragFunctionality();
		}
	})
}
function directoryBack() {
	var last = enter_in_folders.slice(-1)[0];
	if(last!='0'){
		enter_in_folders.splice(-1,1);
	}
	var last = enter_in_folders.slice(-1)[0];
	getDirectoryData(last,user);
	jQuery("#fileSuccessmain").css('display','none');
	jQuery("#fileSuccessDir").css('display','block');
	jQuery("#directoryId").val('');
}

// function albumFolderDelete(folderId) {
// 	jQuery("#directoryId").val(folderId);
// 	jQuery("#foldermodalAlbumDelete").modal().show();
// }

// function albumFolderEdit(folderId){
// 	var base_url = $('#base_url').val();
// 	$.ajax({
// 		type: "POST",
// 		url: base_url+'profile/renameFolder',
// 		data: {folderId:folderId},
// 		dataType : "json",
// 		success: function (data) {
// 			$('#rename_folder').val(data.foldername);
// 			$('#folder_id').val(data.folder_id);
// 			jQuery("#foldermodalAlbumEdit").modal().show();
// 		}
// 	});	
// }

function renameFolder(){
	var base_url = $('#base_url').val();
	var folderid = $('#folder_id').val();
	var rename_folder = $('#rename_folder').val();
	$.ajax({
		type: "POST",
		url: base_url+'profile/renameFolderName',
		data: {folderid:folderid,rename_folder:rename_folder},
		success: function (data) {
			alldata = jQuery.parseJSON(data);
			if(alldata.status == 1){
				$('#success_rename').html('<div class="alert alert-success">Document renamed successfully</div>');
                setTimeout(function(){
                    $('#foldermodalAlbumEdit').modal('hide');
                    $('#success_rename').html('');
                }, 3000);
                var last = enter_in_folders.slice(-1)[0];
				getDirectoryData(last,user,'asc');
			}else if(alldata.status == 0){
				$('#success_rename').html('<div class="alert alert-danger">Folder already exist</div>');
			}
		}
	});	
}

function renameFile(){
	var base_url = $('#base_url').val();
	var fileid = $('#file_id').val();
	var fileName = $('#rename_file').val();
	$.ajax({
		type: "POST",
		url: base_url+'profile/renameFileName',
		data: {fileid:fileid,rename_file:fileName},
		success: function (data) {
			alldata = jQuery.parseJSON(data);
			if(alldata.status == 1){
				$('#success_renames').html('<div class="alert alert-success">Document renamed successfully</div>');
                setTimeout(function(){
                    $('#filemodalAlbumEdit').modal('hide');
                    $('#success_renames').html('');
                }, 3000);
                var last = enter_in_folders.slice(-1)[0];
				getDirectoryData(last,user,'asc');
			}else if(alldata.status == 0){
				$('#success_renames').html('<div class="alert alert-danger">Folder already exist</div>');
			}
		}
	});	
}



function checkFolderExist(){
	$.ajax({
		type: "POST",
		url: base_url+'profile/renameFolderName',
		data: {folderid:folderid,rename_folder:rename_folder},
		success: function (data) {
			alldata = jQuery.parseJSON(data);
			if(alldata.status == 1){
				$('#success_rename').html('<div class="alert alert-success">Document renamed successfully</div>');
                setTimeout(function(){
                    $('#foldermodalAlbumEdit').modal('hide');
                    $('#success_rename').html('');
                }, 3000);
                var last = enter_in_folders.slice(-1)[0];
				getDirectoryData(last,user,'asc');
			}
		}
	});	
}

function getDirectoryData(folderid,user,order=false){
	$('.folder_loader').show();
	var base_url = $('#base_url').val();
	$.ajax({
		type: "POST",
		url: base_url+'profile/getFolderData',
		data: {folderid:folderid,user:user,other:other_user,order:order},
		success: function (data) {
			alldata = jQuery.parseJSON(data);
			if(alldata.status == 'success') {
				jQuery("#fileSuccessDir").html(alldata.msg);
				if(order){
					jQuery("#fileSuccessmain").html(alldata.msg);
					jQuery("#fileSuccessmain").css('display','block');
					jQuery("#fileSuccessDir").css('display','none');
				}
				$('.folder_loader').hide();
			}
			callDragFunctionality();
		}
	});	
}

var profileSet = $('#profileSet').val();
function callDragFunctionality(){
	if(profileSet!==undefined){
		if(other_user!='other'){
			$.contextMenu({
				selector: '.documents_drag_folder', 
				callback: function(key, options) {
		           var id = $(this).data('fid'); 
		           var doc_type = $(this).data('doc_type');
		           var current_folder = enter_in_folders.slice(-1)[0];
		           if(key == 'copy'){
			           $.ajax({
			           	type: "POST",
			           	url: base_url+'profile/createFolderCopy',
			           	dataType : "json",
			           	data: {id:id,doc_type:doc_type,current_folder:current_folder},
			           	success: function (data) {
			           		if(data.status == 1){
			           			$('#fileSuccessmain').html('');
			           			getDirectoryData(current_folder,user,'asc');
			           		}
			           		callDragFunctionality();
			           	}
			           });	
			       }
			       else if(key == 'edit'){
			       		$.ajax({
			       			type: "POST",
			       			url: base_url+'profile/renameFolder',
			       			data: {folderId:id},
			       			dataType : "json",
			       			success: function (data) {
			       				$('#rename_folder').val(data.foldername);
			       				$('#folder_id').val(data.folder_id);
			       				jQuery("#foldermodalAlbumEdit").modal().show();
			       			}
			       		});
			       }
			   else if(key == 'delete'){
			       		jQuery("#directoryId").val(id);
						jQuery("#foldermodalAlbumDelete").modal().show();
			       }
		        },
				items: {
					"edit": {name: "Rename", icon: "edit"},
					copy: {name: "Duplicate", icon: "copy"},
					"delete": {name: "Delete", icon: "delete"},
				}
			});

			$.contextMenu({
				selector: '.documents_drag_file', 
				callback: function(key, options) {
		           var id = $(this).data('fid'); 
		           var doc_type = $(this).data('doc_type');
		           var current_folder = enter_in_folders.slice(-1)[0];
		           if(key == 'copy'){
			           $.ajax({
			           	type: "POST",
			           	url: base_url+'profile/createFolderCopy',
			           	dataType : "json",
			           	data: {id:id,doc_type:doc_type,current_folder:current_folder},
			           	success: function (data) {
			           		if(data.status == 1){
			           			$('#fileSuccessmain').html('');
			           			getDirectoryData(current_folder,user,'asc');
			           		}
			           		callDragFunctionality();
			           	}
			           });	
			       }
			       // else if(key == 'edit'){
			       // 		$.ajax({
			       // 			type: "POST",
			       // 			url: base_url+'profile/renameFile',
			       // 			data: {fileId:id},
			       // 			dataType : "json",
			       // 			success: function (data) {
			       // 				$('#rename_file').val(data.foldername); //file name
			       // 				$('#file_id').val(data.folder_id); //file id
			       // 				jQuery("#filemodalAlbumEdit").modal().show();
			       // 			}
			       // 		});
			       // }
			       else if(key == 'delete'){
			       		jQuery('#record_id').val(id);
			       		jQuery("#modalAlbumDelete").modal().show();
			       }else if(key == 'download'){
			       		var url = $(this).parent('a').attr('href');
			       		window.location = url;
			       }
		        },
				items: {
					//"edit": {name: "Rename", icon: "edit"},
					copy: {name: "Duplicate", icon: "copy"},
					"download": {name: "Download", icon: "download"},
					"delete": {name: "Delete", icon: "delete"},
				}
			});

			var base_url = $('#base_url').val();
			$('.documents_drag').draggable(
			{   
				containment: "parent",
				stop: function(event, ui) 
				{
					$(div).find('a').attr('download', '');
					$( event.originalEvent.target).one('click', function(e){ e.stopImmediatePropagation(); } );
				}
			});
			$(".folders").droppable({
				drop: function(event, ui) {
					var source = ui.draggable.attr("id");
					var destination = $(this).attr("id");
					var file_folder = ui.draggable.data("doc_type");
					$.ajax({
						type: "POST",
						url: base_url+'profile/dragDocument',
						data: {source:source,destination:destination,file_folder:file_folder},
						dataType : "json",
						success: function (data) {
							if(data.status==1){
								if(file_folder == 'file'){
									last = enter_in_folders.slice(-1)[0];
								}else{
								 	last = enter_in_folders.slice(-1)[0];
									if(last!='0'){
										enter_in_folders.splice(-1,1);
									}
									last = enter_in_folders.slice(-1)[0];
								}
								getDirectoryData(last,user,'asc');
							}
						}
					});	
				}
			});
		}
	}
}