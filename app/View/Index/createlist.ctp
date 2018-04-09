<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!--<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,300' rel='stylesheet' type='text/css'>-->
<?php echo $this->AssetCompress->css('styles'); ?>
</head>
<body>

<script>
function update_progress(step,total,message,type,data) {
	data = JSON.parse(data);
	console.log(data);
	var percentage = (step/total)*100;
	window.parent.updateProgressBar(percentage);
	window.parent.updateProgressMessage(message,type);
	if (type=="error" || type=="success") {
		window.parent.finishCreateList(type,data);
	}
}
</script>

<?php
$twitterList = ClassRegistry::init('TwitterList');
$twitterList->createList($userId, $username); ?>
</body>
</html>
