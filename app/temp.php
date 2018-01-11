<?php
	
	require 'db.php';
	
	$db = OpenDatabaseConnection();
	
	$params = [':song_id' => '1', ':device_id' => '1', ':score' => '123'];
	
	var_dump($params);
	
	// Add trial and score tp song and device
	$sql = "UPDATE tmx_songs SET trial = trial + 1, score = score + :score WHERE id = :song_id";
	$params = [':song_id' => '1', ':score' => '123'];
	$query = $db->prepare($sql);
	$query->execute($params);
	echo '[ PDO DEBUG ]: ' . LogPDO($sql, $params) . "\n";
	
	$sql = "UPDATE tmx_devices SET trial = trial + 1, score = score + :score WHERE id = :device_id";
	$params = [':song_id' => '1', ':device_id' => '1', ':score' => '123'];
	$query = $db->prepare($sql);
	$query->execute($params);
	echo '[ PDO DEBUG ]: ' . LogPDO($sql, $params) . "\n";
