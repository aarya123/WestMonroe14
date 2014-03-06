<?php
$sql_stmt = "INSERT INTO event_has_candidate (Event_id, Candidate_id, attended, notes) VALUES (:event_id, :candidate_id, :attended, :notes) ON DUPLICATE KEY UPDATE attended=:attended, notes=:notes";
include_once("db.php");
	$required = array('select_user', 'select_event', 'attended', 'Notes');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_stmt);
		$stmt->execute(array(
			':candidate_id' => $_POST['select_user'],
			':event_id' => $_POST['select_event'],
			':attended' => $_POST['attended'],
			':notes' => $_POST['Notes'],
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
header('Location: /');
?>