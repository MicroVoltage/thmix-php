<?php
	
	require 'init.php';
	require 'db.php';
	$db = OpenDatabaseConnection();
	
	// Time
	$sql = "SELECT CURRENT_TIMESTAMP() AS time";
	$query = $db->prepare($sql);
	$query->execute();
	echo "Current Time : " . $query->fetch()->time . "\n";
	
	// Devices
	$sql = "SELECT COUNT(*) AS count FROM tmx_devices";
	$query = $db->prepare($sql);
	$query->execute();
	echo "\nDevices Count : " . $query->fetch()->count . "\n";
	$sql = "SELECT id, device, trial, record, score, time, combo, perfect, great, good, miss, update_time FROM tmx_devices ORDER BY update_time DESC";
	$query = $db->prepare($sql);
	$query->execute();
	while ($obj = $query->fetch())
		echo "id : " . $obj->id .
			"\t device : " . $obj->device .
			"\t trial : " . $obj->trial .
			"\t record : " . $obj->record .
			"\t score : " . $obj->score .
			"\t time : " . $obj->time .
			"\t combo : " . $obj->combo .
			"\t perfect : " . $obj->perfect .
			"\t great : " . $obj->great .
			"\t good : " . $obj->good .
			"\t miss : " . $obj->miss .
			"\t update_time : " . $obj->update_time . "\n";
	
	// Songs
	$sql = "SELECT COUNT(*) AS count FROM tmx_songs";
	$query = $db->prepare($sql);
	$query->execute();
	echo "\nSongs Count : " . $query->fetch()->count . "\n";
	$sql = "SELECT id, song, trial, record, score, time, combo, perfect, great, good, miss, update_time FROM tmx_songs ORDER BY update_time DESC";
	$query = $db->prepare($sql);
	$query->execute();
	while ($obj = $query->fetch())
		echo "id : " . $obj->id .
			"\t song : " . $obj->song .
			"\t trial : " . $obj->trial .
			"\t record : " . $obj->record .
			"\t score : " . $obj->score .
			"\t time : " . $obj->time .
			"\t combo : " . $obj->combo .
			"\t perfect : " . $obj->perfect .
			"\t great : " . $obj->great .
			"\t good : " . $obj->good .
			"\t miss : " . $obj->miss .
			"\t update_time : " . $obj->update_time . "\n";
	
	// Records
	$sql = "SELECT COUNT(*) AS count FROM tmx_records";
	$query = $db->prepare($sql);
	$query->execute();
	echo "\nRecords Count : " . $query->fetch()->count . "\n";
	$sql = "SELECT song_id, device_id, trial, record, score, combo, perfect, great, good, miss, update_time FROM tmx_records ORDER BY update_time DESC";
	$query = $db->prepare($sql);
	$query->execute();
	while ($obj = $query->fetch())
		echo "song_id : " . $obj->song_id .
			"\t device_id : " . $obj->device_id .
			"\t trial : " . $obj->trial .
			"\t record : " . $obj->record .
			"\t score : " . $obj->score .
			"\t combo : " . $obj->combo .
			"\t perfect : " . $obj->perfect .
			"\t great : " . $obj->great .
			"\t good : " . $obj->good .
			"\t miss : " . $obj->miss .
			"\t update_time : " . $obj->update_time . "\n";
	
	// Trials
	$sql = "SELECT COUNT(*) AS count FROM tmx_trials";
	$query = $db->prepare($sql);
	$query->execute();
	echo "\nTrails Count : " . $query->fetch()->count . "\n";
	$sql = "SELECT id, song_id, device_id, score, combo, perfect, great, good, miss, update_time FROM tmx_trials ORDER BY update_time DESC";
	$query = $db->prepare($sql);
	$query->execute();
	while ($obj = $query->fetch())
		echo "id : " . $obj->id .
			"\t song_id : " . $obj->song_id .
			"\t device_id : " . $obj->device_id .
			"\t score : " . $obj->score .
			"\t combo : " . $obj->combo .
			"\t perfect : " . $obj->perfect .
			"\t great : " . $obj->great .
			"\t good : " . $obj->good .
			"\t miss : " . $obj->miss .
			"\t update_time : " . $obj->update_time . "\n";
