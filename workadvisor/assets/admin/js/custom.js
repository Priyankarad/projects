$(document).ready(function(){
    site_url = get_url();


    /* Create an array with the values of all the input boxes in a column */
    $.fn.dataTable.ext.order['dom-text'] = function  ( settings, col )
    {
        return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
            return $('input', td).val();
        } );
    }

    /* Create an array with the values of all the input boxes in a column, parsed as numbers */
    $.fn.dataTable.ext.order['dom-text-numeric'] = function  ( settings, col )
    {
        return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
            return $('input', td).val() * 1;
        } );
    }

    /* Create an array with the values of all the select options in a column */
    $.fn.dataTable.ext.order['dom-select'] = function  ( settings, col )
    {
        return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
            return $('select', td).val();
        } );
    }

    /* Create an array with the values of all the checkboxes in a column */
    $.fn.dataTable.ext.order['dom-checkbox'] = function  ( settings, col )
    {
        return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
            return $('input', td).prop('checked') ? '1' : '0';
        } );
    }

    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "formatted-num-pre": function ( a ) {
            a = (a==="-") ? 0 : a.replace( /[^\d\-\.]/g, "" );
            return parseFloat( a );
        },
    });

    t = $('#example').dataTable( {
        aoColumnDefs: [
        {
            bSortable: false,
            aTargets: [0,3]
        }
        ],
        "aoColumns": [
        null,
        null,
        { "sType": "formatted-num" }
        ]
    } );


    jQuery('#team_salary').dataTable({
        aoColumnDefs: [
        {
            bSortable: false,
            aTargets: [0]
        }
        ]
    });

    current = jQuery('#current_game').dataTable({
        aoColumnDefs: [
        {
            bSortable: false,
            aTargets: [0,5,6,7,9]
        }
        ]
    });


    /**************** Cancel Button Script Start *************/

    $('body').on('click','.cancel-btn',function(){
        $('.download-salary').attr('href','javascript:void(0)');
        $('input:not([type="radio"])').val("");
        $('select:not([name="autoupdate_salary_length"],[name="team_salary_length"])').val("");
        $('#featured').prop('checked',false);
        $('#upload-file-info').html("");
        $('.file_btn').addClass('hidden');
        $('#sport').val('').trigger('chosen:updated');
        $('#match_detail').html("").hide();
        $('#match_select').hide();
        $('#autoupdate').val('Auto-update');
        $('#match_detail_daliy, #match_select_daliy').hide();
        tinyMCE.activeEditor.setContent('');
    });

    /**************** Cancel Button Script End ***************/

    function showToaster(type,text){
        var myToast = $().toastmessage('showToast', {
            text     : text,
            sticky   : true,
            position : 'top-right',
            type     : type,
            close    : function () {console.log("toast is closed ...");}
        });
        setTimeout(function(){
            $().toastmessage('removeToast', myToast);
        },4000);
    }
});

function validateNumbers(event) {
    if (event.keyCode == 46){
        return false;
    }
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode == 9 || event.keyCode == 8 || event.keyCode == 46) {
        return true;
    }
    else if ( key < 48 || key > 57 ) {
        return false;
    }
    else return true;
};

window.onload = function() {
    initEditor();
};

/*****************************************************************************
**********************Tinymce editor start ***********************************
******************************************************************************/

document.write("\<script src='//cdn.tinymce.com/4/tinymce.min.js' type='text/javascript'>\<\/script>");

function initEditor() {
    var class_exist = $('textarea').hasClass('mceEditor');
    if (class_exist == true) {
        tinymce.init({
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype == 'image') {
                    var input = document.getElementById('mc-editor-file');
                    input.click();
                    input.onchange = function () {
                        var file = input.files[0];
                        var file_data = $("#mc-editor-file").prop("files")[0];
                        var form_data = new FormData();    
                        form_data.append("file", file_data)        
                        $.ajax({
                            type: "POST",
                            url : site_url + "admin/upload_editor_image",
                            data: form_data,
                            dataType : "JSON",
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('.loading').show();
                                $('.loading_icon').show();
                            },
                            success: function(resp){
                                if(resp.type == "failed"){
                                  Ply.dialog("alert", resp.msg);
                              }else{
                                  $('.mce-combobox .mce-textbox').val(resp.file);
                              }
                              $('.loading').hide();
                              $('.loading_icon').hide();
                          },
                          error:function(error)
                          {
                            $('.loading').hide();
                            $('.loading_icon').hide();
                            Ply.dialog("alert", 'Failed');
                        }
                    });
                    };
                }
            },
            mode: "textareas",
            setup : function(ed)
            {
                ed.on('init', function() 
                {
                    this.execCommand("fontName", false, "HelveticaNeue");
                    this.execCommand("fontSize", false, "12pt");
                });
            },
            editor_selector: "mceEditor",
            theme: "modern",
            font_size_classes: "fontSize1, fontSize2, fontSize3, fontSize4, fontSize5, fontSize6",
            plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
            ],

            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | sizeselect | fontselect | fontsize | fontsizeselect",
            style_formats: [{
                title: 'Bold text',
                inline: 'b'
            }, {
                title: 'Red text',
                inline: 'span',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Red header',
                block: 'h1',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Example 1',
                inline: 'span',
                classes: 'example1'
            }, {
                title: 'Example 2',
                inline: 'span',
                classes: 'example2'
            }, {
                title: 'Table styles'
            }, {
                title: 'Table row 1',
                selector: 'tr',
                classes: 'tablerow1'
            }]
        });
    }
}

function readURL(input){
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
        var reader = new FileReader();
    reader.onload = function (e) {
        $('#img').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
}

/*****************************************************************************
**********************Tinymce editor end *************************************
******************************************************************************/
