<?php
include('header.php');
$sql_stmt = "INSERT INTO Event (name, description, location, time) VALUES (:name, :description, :location, :time)";
include_once("db.php");
	$required = array('name', 'desc', 'location', 'time');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_stmt);
		$stmt->execute(array(
				':name' => $_POST['name'],
				':description' => $_POST['desc'],
				':location' => $_POST['location'],
				':time' => $_POST['time']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		echo json_encode(array('event_id' => $db->lastInsertId()));
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
include('footer.php');
?>