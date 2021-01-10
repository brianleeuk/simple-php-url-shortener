<?php
// ERROR REPORTING - REMOVE THIS BEFORE PUBLISHING
ini_set('display_errors', 1);   
ini_set('display_startup_errors', 1);   
error_reporting(E_ALL);
// MySQLi Check
if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    die("Fatal Error: MySQLi not Installed!");
}
?>
<!doctype html>
<html>
	<title>Simple PHP/ MySQL URL Shortener</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
</head>
<body>
	<?php
	// YOUR URL
	$host_url = "https://yoururl.com/";
	// MYSQL SETTINGS - HOSTNAME, USERNAME, PASSWORD, DATABASE NAME
	$con = new mysqli("localhost", "username", "password", "url-shortener");
	// CATCH DB CONN FAIL
	if ($con->connect_error){
		$con->close();
		die("Fatal Error: Cannot Connect to Database!");
	}
	// IF URI SET
	if (isset($_GET['uri'])) {
		$uri = ltrim($_GET['uri'], '/');
		// URI CHECK
		if (strlen($uri) != 6) {
			$con->close();
			die('Fatal Error: Invalid URI!');
		}
		// HIT COUNTER
		$con->query("UPDATE decode SET hits=hits+1 WHERE uri='" . $uri . "'");
		// FETCH URL WITH URI
		$sql = "SELECT url FROM decode WHERE uri='" . $uri . "'";
		$res = $con->query($sql);
		// SEND USER AWAY TO URL
		if ($res->num_rows == 1) {
			while($row = $res->fetch_assoc()){
				$url = $row["url"];
				header("Location: " . $url);
			}
		}
		else {
			$con->close();
			die('Fatal Error: Duplicate in Database!');
		}
		$con->close(); 
		die('Fatal Error: Redirect Failure!');
	}
	// IF URL SUBMITTED
	if (isset($_GET['url'])) {
		$url = $_GET['url'];
		// SIMPLE URL VERIFY - MUST USE HTTPS (STOPS BOTS)
		if (substr($url, 0, 8) != "https://") {
			$con->close();
			die("Fatal Error: String <i>must</i> start with https://!");
		}
		// CHECK IF URL ALREADY IN DB
		$sql = "SELECT uri FROM decode WHERE url='" . $url . "'";
		$res = $con->query($sql);
		if ($res->num_rows == 1) {
			while($row = $res->fetch_assoc()){
				$uri = $row["uri"];
				echo $host_url . $uri;
				$con->close();
			}
		}
		// ELSE INSERT IT
		else {
			$uri_gen = substr(md5(mt_rand()), 0,6); //GEN RAND 6 CHAR URI
			$sql = "SELECT * FROM decode WHERE uri='" . $uri_gen . "'";
			// KILLS SCRIPT IF URI HAPPENS TO BE IN DB ALREADY
			$res = $con->query($sql);
			if ($res->num_rows > 0) {
				$con->close();
				die('Fatal Error: Generated URI already exists in database. Please try again.');
			}
			// FINALY INSERT NEW URL/ URI
			$con->query("INSERT INTO decode(url, uri) VALUES ('" . $url . "','" . $uri_gen . "')");
			echo "Success! " . $host_url . $uri_gen;
			$con->close();
		}
	}
	?>
	<h1>Simple PHP/ MySQL URL Shortener</h1>
	<form action="index.php" method="get">
		Long URL: <input name="url" type="text"/><br/></br>
		<button type="submit" value="Submit">Go!</button>
	</form>
</body>
</html>
