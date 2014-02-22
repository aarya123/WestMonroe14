<?php include('header.php') ?>
<select id="selectCandidate" onchange="updateCandidate(this.value);">
	<option disabled selected>Select a candidate</option>
	<?php include("allnames.php"); ?>
</select>

<form disabled id="create_candidate" method="POST" action="edit_candidate2.php">
	<input type="hidden" id="id" name="id">
	<input disabled placeholder="Name" id="name" type="text" name="name">
	<input disabled placeholder="Email" id="email" type="email" name="email">
	<input disabled placeholder="School" id="school" type="text" name="school">
	<input disabled placeholder="Major" id="major" type="text" name="major">
	<input disabled placeholder="GPA" id="gpa" type="number" name="gpa">
	<input disabled placeholder="Expected Graduation Date" id="grad_date" type="date" name="grad_date">
	<label for="resume">Resume:</label>
	<input disabled id="resume" type="file" accept=".pdf" name="resume">
	<input disabled type="submit" value="Update Candidate">
</form>


<script>
	function updateCandidate(id) {
		document.getElementById('selectCandidate').disabled = true;
		var req = new XMLHttpRequest();
		req.onload = function() {
			document.getElementById('id').value = id;
			var candidate = JSON.parse(req.responseText);
			for(var name in candidate) {
				document.getElementById(name).setAttribute("value", candidate[name].split(" ")[0]);
			}
			var formInputs = document.querySelectorAll('#create_candidate input');
			for (var i = 0; i < formInputs.length; i++) {
				formInputs[i].removeAttribute('disabled');
			}
		}
		
		req.open('post', 'get_candidate.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('id=' + encodeURIComponent(id));
	}
</script>

<?php include('footer.php') ?>