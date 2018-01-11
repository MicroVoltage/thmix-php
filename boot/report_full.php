<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>THMIX Full Report</title>

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
		<h1>Welcome to the THMIX Full Report!
			<small><?php
					$sql = "SELECT CURRENT_TIMESTAMP() AS time";
					$query = $db->prepare($sql);
					$query->execute();
					echo "Current Time : " . $query->fetch()->time;
				?></small>
		</h1>
	</div>
	<a class='btn btn-primary' href='report.php' role='button'>View Report</a>
	<a class='btn btn-default' href='' role='button'>Refresh</a>

	<h2><?php
			$sql = "SELECT COUNT(*) AS count FROM tmx_devices";
			$query = $db->prepare($sql);
			$query->execute();
			echo "Devices Count : " . $query->fetch()->count;
		?></h2>
	<div class='table-responsive'>
		<table class="table table-condensed">
			<thead>
			<tr>
				<th>#</th>
				<th>Device</th>
				<th>Trial</th>
				<th>Record</th>
				<th>Score</th>
				<th>Time</th>
				<th>Combo</th>
				<th>Perfect</th>
				<th>Great</th>
				<th>Good</th>
				<th>Miss</th>
				<th>Update Time</th>
			</tr>
			</thead>
			<?php
				$sql = "SELECT MAX(trial) AS max_trial FROM tmx_devices ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				$max_trial = $query->fetch()->max_trial;

				$sql = "SELECT id, device, trial, record, score, time, combo, perfect, great, good, miss, update_time
                    FROM tmx_devices ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				while ($obj = $query->fetch()) {
					$hash = substr($obj->device, 0, 7);

					if ($obj->id == 1)
						echo "<tr class='info'>";
					else if ($obj->trial > $max_trial / 4 * 3)
						echo "<tr class='danger'>";
					else if ($obj->trial > $max_trial / 2)
						echo "<tr class='warning'>";
					else if ($obj->trial > $max_trial / 4)
						echo "<tr class='active'>";
					else
						echo "<tr>";

					echo "
					<th scope='row'>$obj->id</th>
					<td>$hash</td>
					<td>$obj->trial</td>
					<td>$obj->record</td>
					<td>$obj->score</td>
					<td>$obj->time</td>
					<td>$obj->combo</td>
					<td>$obj->perfect</td>
					<td>$obj->great</td>
					<td>$obj->good</td>
					<td>$obj->miss</td>
					<td>$obj->update_time</td>
				</tr>";
				}
			?>
		</table>
	</div>

	<h2><?php
			$sql = "SELECT COUNT(*) AS count FROM tmx_songs";
			$query = $db->prepare($sql);
			$query->execute();
			echo "Songs Count : " . $query->fetch()->count;
		?></h2>
	<div class='table-responsive'>
		<table class="table table-condensed">
			<thead>
			<tr>
				<th>#</th>
				<th>Song</th>
				<th>Trial</th>
				<th>Record</th>
				<th>Score</th>
				<th>Time</th>
				<th>Combo</th>
				<th>Perfect</th>
				<th>Great</th>
				<th>Good</th>
				<th>Miss</th>
				<th>Update Time</th>
			</tr>
			</thead>
			<?php
				$sql = "SELECT MAX(trial) AS max_trial FROM tmx_songs ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				$max_trial = $query->fetch()->max_trial;

				$sql = "SELECT id, song, trial, record, score, time, combo, perfect, great, good, miss, update_time
                    FROM tmx_songs ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				while ($obj = $query->fetch()) {
					if ($obj->id == 1)
						echo "<tr class='info'>";
					else if ($obj->trial > $max_trial / 4 * 3)
						echo "<tr class='danger'>";
					else if ($obj->trial > $max_trial / 2)
						echo "<tr class='warning'>";
					else if ($obj->trial > $max_trial / 4)
						echo "<tr class='active'>";
					else
						echo "<tr>";

					echo "
					<th scope='row'>$obj->id</th>
					<td>$obj->song</td>
					<td>$obj->trial</td>
					<td>$obj->record</td>
					<td>$obj->score</td>
					<td>$obj->time</td>
					<td>$obj->combo</td>
					<td>$obj->perfect</td>
					<td>$obj->great</td>
					<td>$obj->good</td>
					<td>$obj->miss</td>
					<td>$obj->update_time</td>
				</tr>";
				}
			?>
		</table>
	</div>

	<h2><?php
			$sql = "SELECT COUNT(*) AS count FROM tmx_records";
			$query = $db->prepare($sql);
			$query->execute();
			echo "Records Count : " . $query->fetch()->count;
		?></h2>
	<div class='table-responsive'>
		<table class="table table-condensed">
			<thead>
			<tr>
				<th>Song#</th>
				<th>Device#</th>
				<th>Trial</th>
				<th>Record</th>
				<th>Score</th>
				<th>Combo</th>
				<th>Perfect</th>
				<th>Great</th>
				<th>Good</th>
				<th>Miss</th>
				<th>Update Time</th>
			</tr>
			</thead>
			<?php
				$sql = "SELECT MAX(trial) AS max_trial FROM tmx_records ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				$max_trial = $query->fetch()->max_trial;

				$sql = "SELECT song_id, device_id, trial, record, score, combo, perfect, great, good, miss, update_time
                    FROM tmx_records ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				while ($obj = $query->fetch()) {
					if ($obj->song_id == 1 || $obj->device_id == 1)
						echo "<tr class='info'>";
					else if ($obj->trial > $max_trial / 4 * 3)
						echo "<tr class='danger'>";
					else if ($obj->trial > $max_trial / 2)
						echo "<tr class='warning'>";
					else if ($obj->trial > $max_trial / 4)
						echo "<tr class='active'>";
					else
						echo "<tr>";

					echo "
					<th scope='row'>$obj->song_id</th>
					<th scope='row'>$obj->device_id</th>
					<td>$obj->trial</td>
					<td>$obj->record</td>
					<td>$obj->score</td>
					<td>$obj->combo</td>
					<td>$obj->perfect</td>
					<td>$obj->great</td>
					<td>$obj->good</td>
					<td>$obj->miss</td>
					<td>$obj->update_time</td>
				</tr>";
				}
			?>
		</table>
	</div>

	<h2><?php
			$sql = "SELECT COUNT(*) AS count FROM tmx_trials";
			$query = $db->prepare($sql);
			$query->execute();
			echo "Trials Count : " . $query->fetch()->count;
		?></h2>
	<div class='table-responsive'>
		<table class="table table-condensed">
			<thead>
			<tr>
				<th>Song#</th>
				<th>Device#</th>
				<th>Score</th>
				<th>Combo</th>
				<th>Perfect</th>
				<th>Great</th>
				<th>Good</th>
				<th>Miss</th>
				<th>Update Time</th>
			</tr>
			</thead>
			<?php
				$sql = "SELECT MAX(combo) AS max_combo FROM tmx_trials ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				$max_combo = $query->fetch()->max_combo;

				$sql = "SELECT song_id, device_id, score, combo, perfect, great, good, miss, update_time
                    FROM tmx_trials ORDER BY update_time DESC";
				$query = $db->prepare($sql);
				$query->execute();
				while ($obj = $query->fetch()) {
					if ($obj->song_id == 1 || $obj->device_id == 1)
						echo "<tr class='info'>";
					else if ($obj->combo > $max_combo / 4 * 3)
						echo "<tr class='danger'>";
					else if ($obj->combo > $max_combo / 2)
						echo "<tr class='warning'>";
					else if ($obj->combo > $max_combo / 4)
						echo "<tr class='active'>";
					else
						echo "<tr>";

					echo "
					<th scope='row'>$obj->song_id</th>
					<th scope='row'>$obj->device_id</th>
					<td>$obj->score</td>
					<td>$obj->combo</td>
					<td>$obj->perfect</td>
					<td>$obj->great</td>
					<td>$obj->good</td>
					<td>$obj->miss</td>
					<td>$obj->update_time</td>
				</tr>";
				}
			?>
		</table>
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/boot/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/boot/js/bootstrap.min.js"></script>
</body>
</html>
