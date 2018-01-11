<?php

function GetPostData () {
	return file_get_contents("php://input");
}

function CheckPostData ($postData) {
	if (strlen($postData) <= 8)
		exit('Invalid Data.');
	
	$bytes = unpack('C*', $postData);
	$byteCount = count($bytes);
	
	$postHash = unpack('lint32', substr($postData, $byteCount - 4, 4))['int32'];
	
	$p = cast_to_int32(3847634);
	$hash = cast_to_int32(39457934875);
	
	for ($i = 1; $i <= $byteCount - 4; $i ++) {
		$hash = cast_to_int32(cast_to_int32($hash ^ $bytes[$i]) * $p);
	}
	
	$hash = cast_to_int32($hash + cast_to_int32($hash << 18));
	$hash = cast_to_int32($hash ^ cast_to_int32($hash >> 3));
	$hash = cast_to_int32($hash + cast_to_int32($hash << 19));
	$hash = cast_to_int32($hash ^ cast_to_int32($hash >> 6));
	$hash = cast_to_int32($hash + cast_to_int32($hash << 17));
	
	// echo "Post : " . $postHash . "\nHash : " . $hash . "\n";
	
	if ($postHash !== $hash)
		exit('Invalid Hash.');
}

function cast_to_int32 ($value) {
	$value = ($value & 0xFFFFFFFF);
	
	if ($value & 0x80000000)
		$value = -((~$value & 0xFFFFFFFF) + 1);
	
	return $value;
}