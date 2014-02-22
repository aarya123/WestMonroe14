<?php
include_once("db.php");
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$sql_stmt = <<<'EOT'
SELECT notes, attended FROM Event_has_Candidate WHERE Event_id=:EVID AND Candidate_id=:USID
EOT;
	$stmt = $db->prepare($sql_stmt);
	$stmt->execute(array(
				':USID' => $_GET['usid'],
				':EVID' => $_GET['evid']
			));
	if($stmt->errorCode() != 0) {
		echo json_encode(array('error' => $stmt->errorInfo()));
		exit();
	}
	echo json_encode($stmt->fetchAll());
}
catch(PDOException $e) {
	echo json_encode(array('error' => $e->getMessage()));
}
?>