<?php

ob_start();
set_time_limit(0);

@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
ob_implicit_flush(1);

for ($i = 0; $i < 3; $i++) {

	echo $i . " step";
	echo "<script>console.log(1);</script>";
	ob_flush();
	flush();
	sleep(1);
}