// App Builder Footnote Functions 
// Requires jQuery and Tooltipster plugins

function initFootnotes(footnotes) {

	$.each(footnotes, function(id, value) {
		$('#' + id).tooltipster({
			content: $(value),
			interactive: true,
			theme: 'tooltipster-theme',
			maxWidth: 500
		});
	});
}
