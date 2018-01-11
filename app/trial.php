<?php
	require 'init.php';
	require 'post.php';
	
	$postData = GetPostData();
	CheckPostData($postData);
	
	$format = 'Vsonglen/Vdevicelen/Vscorelen/Vtime/Vcombo/Vperfect/Vgreat/Vgood/lmiss';
	$values = unpack($format, $postData);
	
	//	var_dump($values);
	if (!$values) exit('Invalid Parameters.');
	
	$values_full = unpack(
		$format . '/' .
		'a' . $values['songlen'] . 'song/' .
		'a' . $values['devicelen'] . 'device/' .
		'a' . $values['scorelen'] . 'score', $postData);
	
	//	var_dump($values_full);
	if (!$values_full) exit('Invalid Parameters.');
	
	$song = $values_full['song'];
	$device = $values_full['device'];
	$score = $values_full['score'];
	$time = $values_full['time'];
	$combo = $values_full['combo'];
	$perfect = $values_full['perfect'];
	$great = $values_full['great'];
	$good = $values_full['good'];
	$miss = $values_full['miss'];
	
	//	$song = 'test_song';
	//	$device = 'test_device';
	//	$score = 100;
	//	$time = 1;
	//	$combo = 1;
	//	$perfect = 1;
	//	$great = 1;
	//	$good = 1;
	//	$miss = -1;
	
	if ($score < 10) exit(pack('V', 0));
	
	require 'db.php';
	
	$db = OpenDatabaseConnection();
	
	// Get tmx_songs.id;
	$sql = "SELECT id FROM tmx_songs WHERE song = :song";
	$query = $db->prepare($sql);
	$params = [':song' => $song];
	$query->execute($params);
	LogPDO($sql, $params);
	
	// If null, add tmx_songs;
	if ($query->rowCount() == 0) {
		$sql = "INSERT tmx_songs (song) VALUES (:song)";
		$query = $db->prepare($sql);
		$query->execute($params);
		LogPDO($sql, $params);;
		
		$song_id = $db->lastInsertId();
	} else
		$song_id = $query->fetch()->id;
	
	// Get tmx_devices.id
	$sql = "SELECT id FROM tmx_devices WHERE device = :device";
	$query = $db->prepare($sql);
	$params = [':device' => $device];
	$query->execute($params);
	LogPDO($sql, $params);;
	
	// If null, add tmx_devices;
	if ($query->rowCount() == 0) {
		$sql = "INSERT tmx_devices (device) VALUES (:device)";
		$query = $db->prepare($sql);
		$query->execute($params);
		LogPDO($sql, $params);;
		
		$device_id = $db->lastInsertId();
	} else
		$device_id = $query->fetch()->id;
	
	// -----------------------------------------------------------------------------------------------------------------
	
	// Update tmx_songs;
	$sql = "UPDATE tmx_songs
				SET trial = trial + 1, record = IF(:score > record, :score, record), score = score + :score,
				time = time + :time, combo = combo + :combo, perfect = perfect + :perfect, great = great + :great,
				good = good + :good, miss = miss + :miss
			WHERE id = :song_id";
	$params = [
		':song_id' => $song_id,
		':score' => $score,
		':time' => $time,
		':combo' => $combo,
		':perfect' => $perfect,
		':great' => $great,
		':good' => $good,
		':miss' => $miss];
	$query = $db->prepare($sql);
	$query->execute($params);
	LogPDO($sql, $params);;
	
	// Update tmx_devices;
	$sql = "UPDATE tmx_devices
				SET trial = trial + 1, record = IF(:score > record, :score, record), score = score + :score,
				time = time + :time, combo = combo + :combo, perfect = perfect + :perfect, great = great + :great,
				good = good + :good, miss = miss + :miss
			WHERE id = :device_id";
	$params = [
		':device_id' => $device_id,
		':score' => $score,
		':time' => $time,
		':combo' => $combo,
		':perfect' => $perfect,
		':great' => $great,
		':good' => $good,
		':miss' => $miss];
	$query = $db->prepare($sql);
	$query->execute($params);
	LogPDO($sql, $params);;
	
	// Add tmx_trials;
	$sql = "INSERT INTO tmx_trials (song_id, device_id, score, combo, perfect, great, good, miss) 
				VALUES (:song_id, :device_id, :score, :combo, :perfect, :great, :good, :miss)";
	$params = [
		':song_id' => $song_id,
		':device_id' => $device_id,
		':score' => $score,
		':combo' => $combo,
		':perfect' => $perfect,
		':great' => $great,
		':good' => $good,
		':miss' => $miss];
	$query = $db->prepare($sql);
	$query->execute($params);
	LogPDO($sql, $params);;
	
	// Get MAX(tmx_records.score);
	$sql = "SELECT MAX(record) AS max_score FROM tmx_records WHERE song_id = :song_id";
	$params = [':song_id' => $song_id];
	$query = $db->prepare($sql);
	$query->execute($params);
	$max_score = $query->fetch()->max_score;
	LogPDO($sql, $params);;
	
	// Get tmx_records.score;
	$sql = "SELECT record FROM tmx_records WHERE song_id = :song_id AND device_id = :device_id";
	$params = [':song_id' => $song_id, ':device_id' => $device_id];
	$query = $db->prepare($sql);
	$query->execute($params);
	
	if ($query->rowCount() < 1) {
		// Add tmx_records;
		$sql = "INSERT INTO tmx_records (song_id, device_id, record, score, combo, perfect, great, good, miss)
				VALUES (:song_id, :device_id, :score, :score, :combo, :perfect, :great, :good, :miss)";
		$params = [
			':song_id' => $song_id,
			':device_id' => $device_id,
			':score' => $score,
			':combo' => $combo,
			':perfect' => $perfect,
			':great' => $great,
			':good' => $good,
			':miss' => $miss];
		$query = $db->prepare($sql);
		$query->execute($params);
		LogPDO($sql, $params);;
	} else if ($score > $query->fetch()->record) {
		// Update tmx_records;
		$sql = "UPDATE tmx_records
					SET trial = trial + 1, record = :score, score = score + :score, combo = :combo, perfect = :perfect,
					great = :great, good = :good, miss = :miss
				WHERE song_id = :song_id AND device_id = :device_id";
		$params = [
			':song_id' => $song_id,
			':device_id' => $device_id,
			':score' => $score,
			':combo' => $combo,
			':perfect' => $perfect,
			':great' => $great,
			':good' => $good,
			':miss' => $miss];
		$query = $db->prepare($sql);
		$query->execute($params);
		LogPDO($sql, $params);;
	} else {
		// Update tmx_records.trial;
		$sql = "UPDATE tmx_records SET trial = trial + 1, score = score + :score
				WHERE song_id = :song_id AND device_id = :device_id";
		$params = [
			':song_id' => $song_id,
			':device_id' => $device_id,
			':score' => $score];
		$query = $db->prepare($sql);
		$query->execute($params);
		LogPDO($sql, $params);;
	}
	
	// Return max_score and min_score
	echo pack('V', strlen($max_score)) . $max_score;
	
	exit;
