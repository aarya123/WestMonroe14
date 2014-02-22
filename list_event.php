<?php
$sql_stmt = <<<'EOT'
SELECT `id`, `name` FROM `Event`
EOT;
include_once("db.php");
try {
	$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
	$stmt = $db->prepare($sql_stmt);
	$stmt->execute();
	$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($results);
}
catch(PDOException $e) {
	echo array('error' => $e->getMessage());
}
?>