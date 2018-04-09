/** FORM **/
var ableToSend = true;

var $progressMessage = $("#progress-message"),
	$seeTimelineButton = $("#to-see-timeline"),
	$avatarContainer = $('.avatar-container'),
	$checkbox = $('#follow');

$(function() {
	sendForm();
	updateAvatarOnCheckbox();
});

// AVATAR
function updateAvatarOnCheckbox() {

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
	$('#progress-render').show();
	$('.to-send-form-container').hide();
	if (ableToSend) {
		ableToSend = false;
		var follow = $checkbox.is(':checked') ? 1 : 0;
		$("#follow-input").val(follow);
		$("#main-form").submit();
	}
}

// PROGRESS
function updateProgressBar(percentage) {
	$("#progress-bar").css('width',percentage+"%");
}

function updateProgressMessage(message, type) {
	$progressMessage.text(message);
	$progressMessage.removeClass();
	$progressMessage.addClass(type);
}

function finishCreateList(type, data) {
	console.log(data);
	ableToSend = true;

	if (type=="error") {
		$("#progress-bar").css('width',"0");
	}

	if (type=="success" && data.url != "") {
		setTimeout(function() {
			$('#progress-render').fadeOut(500, function() {
				$seeTimelineButton.attr('href', data.url);
				$seeTimelineButton.fadeIn();
			});
		}, 2000);

	}

}