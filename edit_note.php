<?php
$sql_update_field = "UPDATE notes SET note=:note, interview_id=:interview_id WHERE id=:note_id";
include_once("db.php");
	$required = array('note', 'interview_id', 'note_id');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_update_field);
		$stmt->execute(array(
				':note' => $_POST['note'],
				':interview_id' => $_POST['interview_id'],
				':note_id' => $_POST['note_id']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		header("Location: editNote.php");
 		die();
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>
