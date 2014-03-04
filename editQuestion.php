<?php include('header.php') ?>
<select id="selectInterview" onchange="updateInterview(this.value);">
	<option disabled selected>Select an interview</option>
	<?php include("allinterviews.php"); ?>
</select>
<select id="selectQuestion" onchange="updateQuestion();">
</select>

<form id="edit_question" method="POST" action="edit_question.php">
	<input type="hidden" id="interview_id" name="interview_id">
	<input type="hidden" id="question_id" name="question_id">
	<input disabled placeholder="Question" id="question" name="question">
	<input disabled placeholder="Answer" id="answer" name="answer">
	<input disabled type="submit" id = "submit" value="Update Question">
</form>


<script>
	var questions = null;
	function updateInterview(id) {
		var req = new XMLHttpRequest();
		req.onload = function() {
			document.getElementById('interview_id').value = id;
			var questionList = document.getElementById("selectQuestion");
			while(questionList.firstChild) {
				questionList.removeChild(questionList.firstChild);
			}
			document.getElementById('question').value = '';
			document.getElementById('answer').value = '';
			document.getElementById('question').disabled = true;
			document.getElementById('answer').disabled = true;
			document.getElementById('submit').disabled = true;
			questions = JSON.parse(req.responseText);
			if(questions.length > 0) {
				var selectOption = document.createElement("option");
				selectOption.text = "Select a question";
				selectOption.disabled = true;
				questionList.appendChild(selectOption);
				for(var i = 0; i < questions.length; ++i) {
					var questionElement = document.createElement("option");
					questionElement.text = questions[i].question;
					questionList.appendChild(questionElement);
				}
				questionList.selectedIndex = 1;
				document.getElementById('question_id').value = questions[1].id;
				updateQuestion();
			}
			else {
				var noneOption = document.createElement("option");
				noneOption.text = "No questions available";
				noneOption.disabled = true;
				questionList.appendChild(noneOption);
			}
		}
		
		req.open('post', 'get_questions.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('interview_id=' + encodeURIComponent(id));
	}

	function updateQuestion() {
		var curQuestion = questions[document.getElementById('selectQuestion').selectedIndex - 1];
		document.getElementById('question').value = curQuestion.question;
		document.getElementById('answer').value = curQuestion.answer;
		document.getElementById('question').disabled = false;
		document.getElementById('answer').disabled = false;
		document.getElementById('submit').disabled = false;

	}
</script>

<?php include('footer.php') ?>