<?php
$sql_stmt = <<<'EOT'
SELECT `name` FROM `Event`
EOT;
include_once("db.php");
	$required = array('name', 'desc', 'location', 'time');
	try {
		$db = new PDO(DB_CONN_STR, DB_USER, DB_PASSWORD);
		$stmt = $db->prepare($sql_stmt);
		$stmt->execute();
		$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($results as $row) {
   			echo $row['name']."<br>";
		}
	}
	catch(PDOException $e) {
		echo array('error' => $e->getMessage());
	}
?>