 <?php include('header.php'); ?>

<form id="create_note" method="POST" action="create_note.php">
	<select id="selectInterview" name="interview_id">
	<option disabled selected>Select a interview</option>
	<?php include("allinterviews.php"); ?>
	</select>
	<input placeholder="Note" id="note" type="text" name="note">
	<input type="submit" value="Create Note">
</form>
<?php include('footer.php'); ?>