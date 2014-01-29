/*$(function () {
	$('body').delegate('#submitStep1', 'click', function(e) {
		fileUpload();
	});	
});*/

function validate_form_step_1(){
    $('#zoho_module_p .cmf-skinned-select').removeClass('redBorder');
    var selectedAction = document.getElementById("action").value;
    var selectedZohoModule = document.getElementById("zoho_module_name").value;
    var uploadedFile = document.getElementById("uploaded_file_name").value;

    if (selectedAction == 'zoho' && selectedZohoModule == 'none') {
        alert("Please select correct zoho module to upload your data.");
        $('#zoho_module_p .cmf-skinned-select').addClass('redBorder');
        return false;
    }

    if (uploadedFile == '') {
        alert("Please upload your data file first.");
        $('.fileupload .file').addClass('redBorder');
        return false;
    }

    return true;
}

function validate_authtoken(){
    if ($('#authtoken').val == '') {
        alert("Authtoken can not be empty.");
        return false;
    }

    return true;
}