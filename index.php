<?php
// MySQLi Check (REMOVE BEFORE PUBLISHING)
if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    die("Fatal Error: MySQLi not Installed!");
}
?>
<!doctype html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title>Simple PHP/ MySQL URL Shortener</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
	// YOUR URL
	$host_url = "https://yoururl.com/";
	// MYSQL SETTINGS - HOSTNAME, USERNAME, PASSWORD, DATABASE NAME
	$con = new mysqli("localhost", "username", "password", "url_shortener");
	// CATCH DB CONN FAIL
	if ($con->connect_error){
		$con->close();
		die("Fatal Error: Cannot Connect to Database!");
	}
	// IF URI SET
	if (isset($_GET['uri'])) {
		$uri = ltrim($_GET['uri'], '/');
		// URI LENGTH CHECK
		if (strlen($uri) != 6) {
			$con->close();
			die('Fatal Error: Invalid URI Len!');
		}
		// URL DB CHECK
		$sql = "SELECT url FROM decode WHERE uri='" . $uri . "'";
		$res = $con->query($sql);
		if ($res->num_rows == 1) {
			// HIT COUNTER
			$con->query("UPDATE decode SET hits=hits+1 WHERE uri='" . $uri . "'");
			// SEND USER AWAY TO URL
			while($row = $res->fetch_assoc()){
				$url = $row["url"];
				header("Location: " . $url);
			}
		}
		else {
			$con->close();
			die('Fatal Error: Invalid URI! Not in Database!');
		}
		$con->close(); 
		die('Fatal Error: Redirect Failure!');
	}
	// IF URL SUBMITTED
	if (isset($_GET['url'])) {
		$url = $_GET['url'];
		// SIMPLE URL VERIFY (MUST USE HTTPS)
		if (substr($url, 0, 8) != "https://") {
			$con->close();
			echo "Fatal Error: String <em>must</em> start with https://!";
		}
		else {
			// CHECK IF URL ALREADY IN DB
			$sql = "SELECT uri FROM decode WHERE url='" . $url . "'";
			$res = $con->query($sql);
			if ($res->num_rows == 1) {
				while($row = $res->fetch_assoc()){
					$uri = $row["uri"];
					// PRINT EXISTING SHORT URL
					echo $host_url . $uri;
				}
			}
			// ELSE INSERT IT
			else {
				$uri_gen = substr(md5(mt_rand()), 0,6); //GEN RAND 6 CHAR URI
				// CHECK IF GEN URI IS IN DATABASE
				$sql = "SELECT * FROM decode WHERE uri='" . $uri_gen . "'";
				$res = $con->query($sql);
				if ($res->num_rows > 0) {
					echo "Fatal Error: URI Already in Database!";
				}
				else {
					// FINALY IF EVERYTHING GOOD INSERT NEW URL/ URI
					$con->query("INSERT INTO decode(url, uri) VALUES ('" . $url . "','" . $uri_gen . "')");
					// AND PRINT IT
					echo "Success! " . $host_url . $uri_gen;
				}
			}
		}
	}
	// CLOSE DATABASE
	$con->close();
	?>
	<h1>Simple PHP/ MySQL URL Shortener</h1>
	<form action="index.php" method="get">
		Long URL: <input name="url" type="text"><br><br>
		<button type="submit" value="Submit">Go!</button>
	</form>
</body>
</html>
