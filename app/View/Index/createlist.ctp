<?php header('Content-Encoding: none'); ?>
<html>
<head>
	<script>
		function update_progress(step,total,message,type,data) {
			data = JSON.parse(data);
			var percentage = (step/total)*100;
			window.parent.updateProgressBar(percentage);
			window.parent.updateProgressMessage(message,type);
			if (type=="error" || type=="success") {
				window.parent.finishCreateList(type,data);
			}
		}
	</script>
	<?php $twitterList = ClassRegistry::init('TwitterList');
	$twitterList->startProgress();
	echo str_repeat(" ", 1024), "\n";
	echo 1; ?>

</head>
<body>
<?php $twitterList->createList($userId, $username); ?>
</body>
</html>
