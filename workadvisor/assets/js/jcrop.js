function checkForm(){return!!parseInt($("#w").val())||($(".error").html("Please select a crop region and then press Upload").show(),!1)}function updateInfo(e){var t=$("#preview")[0].naturalWidth/$("#preview").width(),a=$("#preview")[0].naturalHeight/$("#preview").height(),r=Math.min(t,a);$("#x").val(Math.round(e.x*r)),$("#y").val(Math.round(e.y*r)),$("#w").val(Math.round(e.w*r)),$("#h").val(Math.round(e.h*r))}var jcrop_api,boundx,boundy;function fileSelectHandler(){var e=$("#image_file")[0].files[0];$(".error").hide();var t=document.getElementById("preview"),a=new FileReader;a.onload=function(e){t.src=e.target.result,t.onload=function(){$(".step2").fadeIn(500);var e=this.height,a=this.width;parseInt(e)>=parseInt(180)&&parseInt(a)>=parseInt(160)?(void 0!==jcrop_api&&(jcrop_api.destroy(),jcrop_api=null,$("#preview").width(t.naturalWidth),$("#preview").height(t.naturalHeight)),$("#preview").Jcrop({aspectRatio:1,bgFade:!0,bgOpacity:.2,onChange:updateInfo,onSelect:updateInfo,bgColor:"transparent",setSelect:[50,0,160,180],boxWidth:196,boxHeight:226},function(){var e=this.getBounds();boundx=e[0],boundy=e[1],jcrop_api=this})):($("#upload").hide(),$(".error").html("Image size should be greater or equal to 180 x 160").show(),setTimeout("$('#uploadModal').modal('hide');",3e3))}},a.readAsDataURL(e)}