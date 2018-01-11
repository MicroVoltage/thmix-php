<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>THMIX - An Awesome Touhou Rhythm Game</title>

	<link rel="icon" href="http://thmix.cc/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="http://thmix.cc/favicon.ico" type="image/x-icon"/>

	<!-- Bootstrap -->
	<link href="/boot/css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src='/boot/js/html5shiv.min.js'></script>
	<script src='/boot/js/respond.min.js'></script>
	<![endif]-->
</head>
<body>

<?php
	mb_internal_encoding('UTF-8');

	require "../app/db.php";
	$db = OpenDatabaseConnection();
?>

<div class="container">
	<div class='page-header'>
		<h1>Here's the THMIX Index!
			<small><?php
					$sql = "SELECT CURRENT_TIMESTAMP() AS time";
					$query = $db->prepare($sql);
					$query->execute();
					echo "Current Time : " . $query->fetch()->time;
				?></small>
		</h1>
	</div>

	<h3>View THMIX Report:</h3>

	<div class='btn-group'>
		<button class='btn btn-default'>
			<span class='glyphicon glyphicon-phone'></span>
			Devices
			<span class="badge">
				<?php
					$sql = "SELECT COUNT(*) AS count FROM tmx_devices";
					$query = $db->prepare($sql);
					$query->execute();
					echo $query->fetch()->count;
				?>
			</span>
		</button>

		<button class='btn btn-default'>
			<span class='glyphicon glyphicon-music'></span>
			Songs
			<span class="badge">
			<?php
				$sql = "SELECT COUNT(*) AS count FROM tmx_songs";
				$query = $db->prepare($sql);
				$query->execute();
				echo $query->fetch()->count;
			?>
		</span>
		</button>

		<button class='btn btn-default'>
			<span class='glyphicon glyphicon-king'></span>
			Records
			<span class="badge">
			<?php
				$sql = "SELECT COUNT(*) AS count FROM tmx_records";
				$query = $db->prepare($sql);
				$query->execute();
				echo $query->fetch()->count;
			?>
		</span>
		</button>

		<button class='btn btn-default'>
			<span class='glyphicon glyphicon-flag'></span>
			Trials
			<span class="badge">
			<?php
				$sql = "SELECT COUNT(*) AS count FROM tmx_trials";
				$query = $db->prepare($sql);
				$query->execute();
				echo $query->fetch()->count;
			?>
		</span>
		</button>
	</div>

	<a class='btn btn-primary' href='report.php' role='button'>
		<span class='glyphicon glyphicon-dashboard'></span>
		View Report
	</a>

	<hr>

	<h3>Download the latest version of THMIX:</h3>

	<div class='btn-group'>
		<button class='btn btn-default'>
			<span class='glyphicon glyphicon-flag'></span>
			Version
			<span class="badge">
				a2.0.1
			</span>
		</button>

		<button class='btn btn-default'>
			<span class='glyphicon glyphicon-calendar'></span>
			Built Date
			<span class="badge">
			2016/08/02
			</span>
		</button>
	</div>

	<a class='btn btn-primary' href='http://thmix.oss-cn-shanghai.aliyuncs.com/kailang.thmix-a2.0.1.apk' role='button'>
		<span class='glyphicon glyphicon-download-alt'></span>
		Download THMIX
	</a>

	<hr>

	<h3>Stay in Touch:</h3>

	<div class='btn-group'>
		<a class='btn btn-default btn-danger' href='mailto:kailangfu@gmail.com'>
			<span class='glyphicon glyphicon-envelope'></span>
			Mail
			<span class="badge">
			kailangfu@gmail.com
		</span>
		</a>

		<a class='btn btn-default btn-info' href='http://jq.qq.com/?_wv=1027&k=27IHNmB'>
			<span class='glyphicon glyphicon-comment'></span>
			QQ Group
			<span class="badge">
				562614447
			</span>
		</a>
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/boot/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/boot/js/bootstrap.min.js"></script>
</body>
</html>
