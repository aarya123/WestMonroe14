<?php include('header.php') ?>
<select id="selectInterview" onchange="updateInterview(this.value);">
	<option disabled selected>Select an interview</option>
	<?php include("allinterviews.php"); ?>
</select>

<form id="edit_interview" method="POST" action="edit_interview.php">
	<input type="hidden" id="interview_id" name="interview_id">
	<input disabled placeholder="Name" id="Name" type="text" name="name">
	<input disabled placeholder="Interviewer" id="Interviewer" type="text" name="interviewer">
	<input disabled placeholder="Notes" id="Notes" type="text" name="notes">
	<input disabled placeholder="Candidate ID" id="Candidate_id" type="text" name="candidate_id">
	<input disabled type="submit" value="Update Interview">
</form>


<script>
	function updateInterview(id) {
		var req = new XMLHttpRequest();
		req.onload = function() {
			document.getElementById('interview_id').value = id;
			var candidate = JSON.parse(req.responseText);
			for(var name in candidate) {
				document.getElementById(name).setAttribute("value", candidate[name].split(" ")[0]);
			}
			var formInputs = document.querySelectorAll('#edit_interview input');
			for (var i = 0; i < formInputs.length; i++) {
				formInputs[i].removeAttribute('disabled');
			}
		}
		
		req.open('post', 'get_interview.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('id=' + encodeURIComponent(id));
	}
</script>

<?php include('footer.php') ?>