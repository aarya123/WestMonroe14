<?php include('header.php'); ?>
<form id="create_candidate" method="POST" action="create_candidate.php">
	<input placeholder="Name" id="name" type="text" name="name">
	<input placeholder="Email" id="email" type="email" name="email">
	<input placeholder="School" id="school" type="text" name="school">
	<input placeholder="Major" id="major" type="text" name="major">
	<input placeholder="GPA" id="gpa" type="number" step="any" min="0" max="4" name="gpa">
	<input placeholder="Expected Graduation Date" id="grad_date" type="date" name="grad_date">
	<select id="offer_status" name="offer_status">
		<option>None</option>
		<option>No Offer</option>
		<option>Pending</option>
		<option>Rejected</option>
		<option>Accepted</option>
	</select>
	<label for="resume">Resume:</label>
	<input id="resume" type="file" accept=".pdf" name="resume">
	<input type="submit" value="Create Candidate">
</form>
<?php include('footer.php'); ?>
