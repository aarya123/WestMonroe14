<?php
include_once('gen.php');
create("INSERT INTO Interview (Interviewer, Notes, Name, Candidate_id) VALUES (:interviewer, :notes, :name, :candidate_id)", 
	array('interviewer', 'notes', 'name', 'candidate_id')
);
?>