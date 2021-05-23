<?php
session_start();

//Initialize connection info
$server = "sql210.epizy.com";
$userid = "epiz_27849968";
$pw = "YSGfvMca1fq9n";
$db= "epiz_27849968_ccc";

// $username = "";
// $password = "";
$errors   = array();

// Create connection
$conn = new mysqli($server, $userid, $pw, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register_btn'])) {
	register();
}

function register(){
	global $conn, $errors;
	$username = "";
	$password = "";

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {

		$sql = "INSERT INTO users (username, password) VALUES('$username', '$password')";
		$conn->query($sql);

		$logged_in_user_id = $conn->insert_id;

		$_SESSION['user'] = getUserById($logged_in_user_id);
		$_SESSION['success']  = "You are now logged in";
		header('location: index.php');
	}
}

function getUserById($id){
	global $conn;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = $conn->query($query);

	$user = $result->fetch_assoc();
	return $user;
}

function display_error() {
	global $errors;
    console.log("in display errors");
    
	if (count($errors) > 0){
        echo '<div class="error">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
    echo '</div>';
	}
    
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: index.php");
}

if (isset($_POST['login_btn'])) {
	login();
}

function login(){
	global $conn, $errors;
	$username = "";
	$password = "";

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = $conn->query($query);
		if ($results->num_rows == 1) {
			$logged_in_user = $results->fetch_assoc();

			$_SESSION['user'] = $logged_in_user;
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');

		} else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

if (isset($_POST['event_btn'])) {
	event();
}

function event(){
	global $conn, $errors;

	$user_id = $_SESSION['user']['id'];
	$name = $_POST['name'];
	$location = $_POST['location'];
	$description = $_POST['description'];
	$day = $_POST['day'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$start_hour = $_POST['start_hour'];
	$start_min = $_POST['start_min'];
	$end_hour = $_POST['end_hour'];
	$end_min = $_POST['end_min'];
    $start_am_or_pm = $_POST['start_am_or_pm'];
    $end_am_or_pm = $_POST['end_am_or_pm'];

	if (empty($name)) {
		array_push($errors, "Name is required");
	}
	if (empty($location)) {
		array_push($errors, "Location is required");
	}
	if (empty($description)) {
		array_push($errors, "Description is required");
	}
	if (empty($day)) {
		array_push($errors, "Day is required");
	}
	if (empty($month)) {
		array_push($errors, "Month is required");
	}
	if (empty($year)) {
		array_push($errors, "Year is required");
	}
	if (empty($start_hour)) {
		array_push($errors, "Start hour is required");
	}
	if (empty($start_min)) {
		array_push($errors, "Start minute is required");
	}
	if (empty($end_hour)) {
		array_push($errors, "End hour is required");
	}
	if (empty($end_min)) {
		array_push($errors, "End minute is required");
	}
    if (empty($start_am_or_pm)) {
		array_push($errors, "Start AM or PM is required");
	}
    if (empty($end_am_or_pm)) {
		array_push($errors, "End AM or PM is required");
	}

	if (count($errors) == 0) {
        
        if($start_hour == 12){
            $start_hour = 0; 
        }

		$sql = "INSERT INTO events (userID, name, location, description, day, month, year, timeStartHour, timeStartMinute, timeEndHour, timeEndMinute, start_am_or_pm, end_am_or_pm) VALUES('$user_id', '$name', '$location', '$description', '$day', '$month', '$year', '$start_hour', '$start_min', '$end_hour', '$end_min', '$start_am_or_pm', '$end_am_or_pm')";
		$conn->query($sql);

		header('location: index.php');

	}
}

//need to put all events into php arrays for current user
function test(&$id, &$names, &$locals, &$descrips, &$days, &$months, &$years, &$tstarthour, &$tstartmin, &$tendhour, &$tendmin, &$samorpm, &$eamorpm){
    global $conn;
	
    $query = "SELECT * FROM events WHERE userID = " . $_SESSION['user']['id'] . " ORDER BY year, month, day, start_am_or_pm, timeStartHour, timeStartMinute ASC";
	if($result = $conn->query($query)){
        while($row = $result->fetch_assoc()){
            array_push($id, $row["id"]);
            array_push($names, $row["name"]);
			array_push($locals, $row["location"]);
            array_push($descrips, $row["description"]);
            array_push($days, $row["day"]);
            array_push($months, $row["month"]);
            array_push($years, $row["year"]);
            array_push($tstarthour, $row["timeStartHour"]);
            array_push($tstartmin, $row["timeStartMinute"]);
            array_push($tendhour, $row["timeEndHour"]);
            array_push($tendmin, $row["timeEndMinute"]);
            array_push($samorpm, $row["start_am_or_pm"]);
            array_push($eamorpm, $row["end_am_or_pm"]);
        }
    }
}

if (isset($_POST['delete_btn'])) {
    deleteEvent();
}

function deleteEvent(){
    global $conn;
    $id = $_POST['id'];
    
    $query = "DELETE FROM events WHERE id = " . $id;
    
    $conn->query($query);
    
    header('location: index.php');
    
}

?>
