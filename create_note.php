<?php
$sql_stmt = "INSERT INTO notes (note, interview_id) VALUES (:note, :interview_id)";
include_once("db.php");
$required = array('note', 'interview_id');
if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
	echo json_encode(array('error' => 'invalid args'));
	exit();
}
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$stmt = $db->prepare($sql_stmt);
	$stmt->execute(array(
			':interview_id' => $_POST['interview_id'],
			':note' => $_POST['note']
		)
	);
	if($stmt->errorCode() != 0) {
		echo json_encode(array('error' => $stmt->errorInfo()));
		exit();
	}
	header("Location: createNote.php");
	die();
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
?>
