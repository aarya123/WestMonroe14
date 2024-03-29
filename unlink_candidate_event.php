<?php
$sql_stmt = "DELETE FROM Event_has_candidate WHERE Event_id=:event_id AND Candidate_id=:candidate_id";
include_once("db.php");
	$required = array('candidate_id', 'event_id');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_stmt);
		$stmt->execute(array(
				':candidate_id' => $_POST['candidate_id'],
				':event_id' => $_POST['event_id']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		echo json_encode(array('ok' => ""));
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>