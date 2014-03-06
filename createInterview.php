 <?php include('header.php'); ?>

<form id="create_interview" method="POST" action="create_interview.php">
	<select id="selectCandidate" name="candidate_id">
	<option disabled selected>Select a candidate</option>
	<?php include("allnames.php"); ?>
	</select>
	<input placeholder="Interviewer" id="interviewer" type="text" name="interviewer">
	<input placeholder="Date" id="time" type="date" name="time">
	<input placeholder="Name" id="name" type="text" name="name">
	<input type="submit" value="Create Interview">
</form>
<?php include('footer.php'); ?>