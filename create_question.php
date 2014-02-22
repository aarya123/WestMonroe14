<?php
$sql_stmt = "INSERT INTO Question (question, answer, interview_id) VALUES (:question, :answer, :interview_id)";
include_once("db.php");
$required = array('question', 'answer', 'interview_id');
if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
	echo json_encode(array('error' => 'invalid args'));
	exit();
}
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$stmt = $db->prepare($sql_stmt);
	$stmt->execute(array(
			':question' => $_POST['question'],
			':answer' => $_POST['answer'],
			':interview_id' => $_POST['interview_id']
		)
	);
	if($stmt->errorCode() != 0) {
		echo json_encode(array('error' => $stmt->errorInfo()));
		exit();
	}
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
header("Location: /");
?>