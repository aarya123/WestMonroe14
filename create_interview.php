<?php
$sql_stmt = "INSERT INTO Interview (Interviewer, Name, Candidate_id) VALUES (:interviewer, :name, :candidate_id)";
include_once("db.php");
$required = array('interviewer', 'name', 'candidate_id');
if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
	echo json_encode(array('error' => 'invalid args'));
	exit();
}
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$stmt = $db->prepare($sql_stmt);
	$stmt->execute(array(
			':interviewer' => $_POST['interviewer'],
			':candidate_id' => $_POST['candidate_id'],
			':name' => $_POST['name']
		)
	);
	if($stmt->errorCode() != 0) {
		echo json_encode(array('error' => $stmt->errorInfo()));
		exit();
	}
	header("Location: createEvent.php");
	die();
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
?>
