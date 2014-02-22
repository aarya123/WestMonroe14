(function() {
	var dateElements = document.querySelectorAll('input[type="date"][placeholder]');
	for (var i = 0; i < dateElements.length; i++) {
		var element = dateElements[i];
		element.type = 'text';
		element.addEventListener('focus', function() {
			this.type = 'date';
		});
		
		element.addEventListener('blur', function() {
			this.type = 'text';
		});
	}
})();