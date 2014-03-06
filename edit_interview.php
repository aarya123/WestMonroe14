<?php
$sql_update_field = "UPDATE Interview SET Interviewer=:interviewer, Candidate_id=:candidate_id, Name=:name WHERE id=:interview_id";
include_once("db.php");
	$required = array('interview_id', 'candidate_id', 'name', 'interviewer');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_update_field);
		$stmt->execute(array(
				':interview_id' => $_POST['interview_id'],
				':candidate_id' => $_POST['candidate_id'],
				':name' => $_POST['name'],
				':interviewer' => $_POST['interviewer']
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
header('Location: /');
?>