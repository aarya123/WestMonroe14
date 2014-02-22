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
	<select disabled id="Candidate_id" name="candidate_id">
	<?php include("allnames.php"); ?>
	</select>
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
			var formInputs = document.querySelectorAll('#edit_interview input, #edit_interview select');
			for (var i = 0; i < formInputs.length; i++) {
				formInputs[i].removeAttribute('disabled');
			}
			var select = document.querySelector("#Candidate_id");
			for(var i = 0; i < select.options.length; ++i) {
				console.log(i);
				if(select.options[i].value == candidate.candidate_id) {
					console.log("SELECT");
					select.selectedIndex = i;
					break;
				}
			}
			//document.querySelector("#Candidate_id [id= '" + candidate.candidate_id + "']").addAttribute('selected');
		}
		
		req.open('post', 'get_interview.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('id=' + encodeURIComponent(id));
	}
</script>

<?php include('footer.php') ?>