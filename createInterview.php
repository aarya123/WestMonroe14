 <?php include('header.php'); ?>
<form id="create_interview" method="POST" action="create_interview.php">
	<input placeholder="Interviewer" id="interviewer" type="text" name="interviewer">
	<input placeholder="Notes" id="notes" type="text" name="notes">
	<input placeholder="CandidateId" id="candidate_id" type="text" name="candidate_id">
	<input placeholder="Date" id="time" type="date" name="time">
	<input type="submit" value="Create Event">
</form>
<?php include('footer.php'); ?>