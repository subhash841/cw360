/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var base_url = $("body").attr("data-base_url");
var date = new Date();
var voiceid = $("body").attr("data-detailid");
var timestamp = date.getTime();
$(function () {
    function showalert(message, alerttype) {
        $('#alert_placeholder').fadeIn('fast');
        $('#alert_placeholder').html("<div class ='alert alert-" + alerttype + "' >" + message + "<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times</span></button></div> ");
        setTimeout(function () {
            $('#alert_placeholder').fadeOut('fast');
        }, 3000);
    }
    //start of validation for raise voice save button

    $('#postpoll').on('submit', function (e) {
        e.preventDefault();
        var topic_title = $('[name="voice_topic"]').val();
        var topic_name = $('[name="topics[]"]').map(function () {
            return $(this).val();
        }).get();

        var voice_desc = CKEDITOR.instances.voice_desc.getData();
        var uploaded_file = $("#fileUpload")[0].files[0];
        var img = $('[name="voiceImageUpload"]').val();
        var voice_id = $('#voice_id').val();
        var is_topic_change = $('#is_topic_change').val();
        var is_choice_change = $('#is_choice_change').val();

        if (topic_title == '') {
            showalert('Please enter topic titile', 'danger');
        } else if (topic_name == '') {
            showalert('Please enter topic name', 'danger');
        } else if (voice_desc == '') {
            showalert('Please enter topic description', 'danger');

        } else if (img == '' && voice_id == 0) {
            showalert('Please select the image', 'danger');
        } else if (voice_id == '' && is_topic_change == '' && is_choice_change == '') {
            showalert('Please try again later', 'danger');
        } else {
            var formdata = new FormData(this);
            formdata.append('is_topic_change', is_topic_change);
            formdata.append('voice_topic', topic_title);
            formdata.append('voice_desc', voice_desc);
            formdata.append('uploaded_file', uploaded_file);

            ajax_call_multipart(base_url + "YourVoice/create_update_voice", "POST", formdata, function (result) {
                if (result == '1') {
                    window.location.assign(base_url);
                } else {
                    showalert('Please Try Again Later ');
                }
            });


//            $.post(base_url + "YourVoice/create_update_voice/", {
//                voice_id: voice_id,
//                is_topic_change: is_topic_change,
//                is_choice_change: is_choice_change,
//                voice_topic: topic_title,
//                search_topics: topic_name,
//                voice_desc: voice_desc,
//                poll_img: img
//            }).
//                    done(function (e) {
//                        console.log(e);
////                        window.location.assign(base_url + 'YourVoice');
//                    }).fail(function (f) {
//                showlaert('Please try again later');
//            });
        }
    });

//end of validation for raise voice save button

    var silver_points = $("body").attr("data-silver_points");
    if (silver_points < 25 && voiceid != "0") {
        //show_modal_if points are not there
        //window.location.assign(base_url + "YourVoice");
    }
    /*Load subcategory on category change*/
    $("#category").on('change', callback_category);
    /* display image while edit - START */
    var edit_voice_id = $("#voice_id").val();
    if (edit_voice_id != "0") {
        $('#imgPrime').css('display', 'block');
        $('#removethumb').css('display', 'block');
    } else {
        $('#imgPrime').attr("src", "");
        $('#imgPrime').css('display', 'none');
        $('#removethumb').css('display', 'none');
    }
    /* display image while edit - START */

    /*create voice form submit*/
//    $("form[name='yourvoice']").on("submit", submit_yourvoice);
//    if (config.subcategory_id && config.category_id) {
//        var category_id = config.category_id;
//        var subcategory_id = config.subcategory_id;
//        $.ajax({
//            url: base_url + "YourVoice/load_sub_category",
//            method: "POST",
//            data: {category_id: category_id}
//        }).done(function (response) {
//            response = JSON.parse(response);
//            var options = '';
//            options = '<option value="">--Select sub category--</option>';
//            for (var i in response['data']) {
//                var selected = (response['data'][i].id == subcategory_id) ? 'selected="selected"' : '';
//                options += '<option value="' + response['data'][i].id + '" ' + selected + '>' + response['data'][i].name + '</option>';
//            }
//
//            $("select#subcategory").html(options);
//            $('select').material_select();
//        });
//    }
});
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
CKEDITOR.plugins.addExternal('simpleImageUpload', '/assets/ckeditor/plugins/simpleImageUpload/', 'plugin.js');
CKEDITOR.replace('voice_desc', {
    height: '350',
    //uploadUrl: "https://imageupload.localhost.com",
    uploadUrl: "https://imgupload.crowdwisdom.co.in",
    removeButtons: "EasyImageUpload,Copy,Paste,PasteText,PasteFromWord,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Smiley,SpecialChar,PageBreak,Iframe,Styles,Format,Font,FontSize,ShowBlocks,About,Save,NewPage,Preview,Print,Templates,Cut,Table,HorizontalRule,TextColor",
    extraPlugins: 'simpleImageUpload,easyimage',
    removePlugins: 'image',
    toolbarGroups: [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'forms', groups: ['forms']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
        {name: 'links', groups: ['links']},
        {name: 'insert', groups: ['insert']},
        {name: 'styles', groups: ['styles']},
        {name: 'colors', groups: ['colors']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
        {name: 'about', groups: ['about']}
    ],
    //cloudServices_uploadUrl: 'https://33333.cke-cs.com/easyimage/upload/',
    // Note: this is a token endpoint to be used for CKEditor 4 samples only. Images uploaded using this token may be deleted automatically at any moment.
    // To create your own token URL please visit https://ckeditor.com/ckeditor-cloud-services/.
    //cloudServices_tokenUrl: 'https://33333.cke-cs.com/token/dev/ijrDsqFix838Gh3wGO3F77FSW94BwcLXprJ4APSp3XQ26xsUHTi0jcb1hoBt',
    //pasteFromWordCleanupFile: 'http://my.example.com/customFilters/custom.js'
});
var callback_category = function () {
    var category_id = $(this).val();
    $.ajax({
        url: base_url + "YourVoice/load_sub_category",
        method: "POST",
        data: {category_id: category_id}
    }).done(function (response) {
        response = JSON.parse(response);
        var options = '';
        options = '<option value="">--Select sub category--</option>';
        for (var i in response['data']) {
            options += '<option value="' + response['data'][i].id + '">' + response['data'][i].name + '</option>';
        }

        $("select#subcategory").html(options);
        $('select').material_select();
    });
}

//var submit_yourvoice = function (e) {
//    var topic = $("textarea[name='voice_topic']").val();
//    var category = $('#category').val();
//    var subcategory = $('#subcategory').val();
//    var description = $("textarea[name='voice_desc']").val();
//    var isfileupload = $("#fileUpload").val();
//    var uploaded_file = $("#imgPrime").attr("src");
//    var editorText = CKEDITOR.instances.voice_desc.getData();
//    console.log(editorText);
//    console.log(uploaded_file);
//    if (topic == "") {
//        Materialize.Toast.removeAll();
//        Materialize.toast('Please enter voice topic', 4000);
//        e.preventDefault();
//    } else if (category == "") {
//        Materialize.Toast.removeAll();
//        Materialize.toast('Please select category', 4000);
//        e.preventDefault();
//    } else if (subcategory == "") {
//        Materialize.Toast.removeAll();
//        Materialize.toast('Please select subcategory', 4000);
//        e.preventDefault();
//    } else if (editorText == "") {
//        Materialize.Toast.removeAll();
//        Materialize.toast('Please enter description', 4000);
//        e.preventDefault();
//    } else if (uploaded_file == "") { //isfileupload == "" ||
//        Materialize.Toast.removeAll();
//        Materialize.toast('Please upload image', 4000);
//        e.preventDefault();
//    }
//}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imgPrime").attr("src", e.target.result);
            $('#imgPrime').css('display', 'block');
            $('.dz-preview').remove();
            $('#removethumb').css('display', 'block');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
document.getElementById('removethumb').addEventListener('click', function () {
    $("#imgPrime").attr("src", '');
    $('#imgPrime').css('display', 'none');
    $('#removethumb').css('display', 'none');
    $('input[type=file]').val(null);
});


