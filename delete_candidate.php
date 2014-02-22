<?php
$sql_delete_links = "DELETE FROM Event_has_candidate WHERE Candidate_id=:candidate_id";
$sql_delete_candidate = "DELETE FROM Candidate WHERE id=:candidate_id";
include_once("db.php");
	$required = array('id');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$db->beginTransaction();
		$stmt = $db->prepare($sql_delete_links);
		$stmt->execute(array(
				':candidate_id' => $_POST['id']
			)
		);
		if($stmt->errorCode() != 0) {
			throw new Exception($stmt->errorInfo());
		}
		$stmt = $db->prepare($sql_delete_candidate);
		$stmt->execute(array(
				':candidate_id' => $_POST['id']
			)
		);
		if($stmt->errorCode() != 0) {
			throw new Exception($stmt->errorInfo());
		}
		echo json_encode(array('ok' => ""));
		$db->commit();
	}
	catch(Exception $e) {
		$db->rollBack();
		echo json_encode(array('error' => $e->getMessage()));
	}
?>