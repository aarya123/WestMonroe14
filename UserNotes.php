<?php
include_once("db.php");
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$sql_stmt = <<<'EOT'
INSERT INTO event_has_candidate (Event_id, Candidate_id, attended, notes)
VALUES (:event_id, :candidate_id, :attended, :notes)
EOT;
	$stmt = $db->prepare($sql_stmt);
	$stmt->execute(array(
			':candidate_id' => $_POST['select_user'],
			':event_id' => $_POST['select_event'],
			':attended' => $_POST['attended'],
			':notes' => $_POST['Notes'],
		)
	);
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
?>