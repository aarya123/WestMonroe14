<?php
$sql_update_field = "UPDATE Question SET question=:question, answer=:answer,  interview_id=:interview_id WHERE id=:question_id";
include_once("db.php");
	$required = array('question_id', 'interview_id', 'question', 'answer');
	if(count(array_intersect_key(array_flip($required), $_POST)) != count($required)) {
		echo json_encode(array('error' => 'invalid args'));
		exit();
	}
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_update_field);
		$stmt->execute(array(
				':question_id' => $_POST['question_id'],
				':interview_id' => $_POST['interview_id'],
				':question' => $_POST['question'],
				':answer' => $_POST['answer']
			)
		);
		if($stmt->errorCode() != 0) {
			echo json_encode(array('error' => $stmt->errorInfo()));
			exit();
		}
		header("Location: editQuestion.php");
 		die();
	}
	catch(PDOException $e) {
		echo json_encode(array('error' => $e->getMessage()));
	}
?>
