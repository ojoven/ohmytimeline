/** FORM **/
var ableToSend = true;

var $progressMessage = $("#progress-message");

$(function() {
	sendForm();
	updateAvatarOnCheckbox();
});

// AVATAR
function updateAvatarOnCheckbox() {

	var $avatarContainer = $('.avatar-container');
	var $checkbox = $('#follow');
	var maxStep = 3;

	// Initial values
	var step = 1;
	var happySad = 'happy';

	$checkbox.on('change', function() {

		happySad = happySad === 'happy' ? 'sad' : 'happy';
		if (happySad === 'happy') {
			step = step < maxStep ? step + 1 : 1;
		}

		var urlAvatar = urlBase + 'img/avatars/avatar_' + happySad + '_' + step + '.jpg';
		var $img = '<img src="' + urlAvatar + '" alt="Avatar ' + happySad + '"/>';
		$avatarContainer.append($img);
		setTimeout(function() {
			$avatarContainer.find('img').last().css('opacity', '1');
			if ($avatarContainer.find('img').length > 3) {
				$avatarContainer.find('img').first().remove();
			}
		},100);

	});


}

// FORMULARY
function sendForm() {

	$("#to-send-form").on('click',function() {
		submitForm();
		return false;
	});

	if (authenticated) {
		//submitForm();
	}

}

function submitForm() {
	$progressMessage.off('click');
	$(".disabler").show();
	if (ableToSend) {
		ableToSend = false;
		$("#main-form").submit();
	}
}

// PROGRESS
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