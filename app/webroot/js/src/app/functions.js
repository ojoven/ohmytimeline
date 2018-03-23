/** FORM **/
var ableToSend = true;

var $progressMessage = $("#progress-message");

$(function() {
	sendForm();
});

function sendForm() {

	$("#to-send-form").on('click',function() {
		submitForm();
		return false;
	});

}

function submitForm() {
	$progressMessage.off('click');
	$(".disabler").show();
	if (ableToSend) {
		ableToSend = false;
		console.log('submit!!');
		$("#main-form").submit();
	}
}

/** PROGRESS **/
function updateProgressBar(percentage) {
	$("#progress-bar").css('width',percentage+"%");
}

function updateProgressMessage(message,type) {
	$progressMessage.text(message);
	$progressMessage.removeClass();
	$progressMessage.addClass(type);
}

function finishCreateList(type,url) {
	ableToSend = true;
	$(".disabler").hide();

	if (type=="error") {
		$("#progress-bar").css('width',"0");
	}

	if (type=="success" && url != "") {
		$("#username,.username").val('');
		$progressMessage.on('click',function() {
			window.open(url, "_blank");
		});
	}

}