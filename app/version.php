<?php
	
	require 'init.php';
	
	/* NetLayer.Version
	 * 0 : a2.0.0.x
	 * 1 : a2.0.0.5
	 * 2 : a2.0.0.6
	 */
	$version = 2;
	$url = 'http://thmix.cc/update.html';
	
	// http://php.net/manual/en/function.pack.php
	echo pack('V', $version) . $url;
