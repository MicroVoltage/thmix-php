<?php
	
	function OpenDatabaseConnection () {
		/**
		 * Configuration for: Database
		 * This is the place where you define your database credentials, database type etc.
		 */
		define('DB_TYPE', 'mysql');
		define('DB_HOST', 'qdm17623614.my3w.com');
		define('DB_NAME', 'qdm17623614_db');
		define('DB_USER', 'qdm17623614');
		define('DB_PASS', '23refrdcttrDS34W4');
		
		// set the (optional) options of the PDO connection. in this case, we set the fetch mode to
		// "objects", which means all results will be objects, like this: $result->user_name !
		// For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
		// @see http://www.php.net/manual/en/pdostatement.fetch.php
		$db_options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
		
		// generate a database connection, using the PDO connector
		// @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
		try {
			$db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $db_options);
			
			$sql = "SET NAMES utf8";
			$query = $db->prepare($sql);
			$query->execute();
			
			$sql = "SET CHARACTER SET utf8";
			$query = $db->prepare($sql);
			$query->execute();
		} catch (PDOException $e) {
			exit('Database connection could not be established.');
		}
		
		return $db;
	}
	
	function LogPDO ($raw_sql, $parameters) {
		return;
		
		$keys = [];
		$values = $parameters;
		
		foreach ($parameters as $key => $value) {
			
			// check if named parameters (':param') or anonymous parameters ('?') are used
			if (is_string($key)) {
				$keys[] = '/' . $key . '/';
			} else {
				$keys[] = '/[?]/';
			}
			
			// bring parameter into human-readable format
			if (is_string($value)) {
				$values[$key] = "'" . $value . "'";
			} elseif (is_array($value)) {
				$values[$key] = implode(',', $value);
			} elseif (is_null($value)) {
				$values[$key] = 'NULL';
			}
		}
		
		/*
		echo "<br> [DEBUG] Keys:<pre>";
		print_r($keys);
		
		echo "\n[DEBUG] Values: ";
		print_r($values);
		echo "</pre>";
		*/
		
		$raw_sql = preg_replace($keys, $values, $raw_sql, 1, $count);
		
		echo "<br />\n<b>[PDO]</b>: $raw_sql<br />\n";
		//		return $raw_sql;
	}
