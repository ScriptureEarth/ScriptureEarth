// App Builder Menu Functions 
// Requires jQuery plugin

function toggleBookMenu() {
    if ($("#book-menu").data('shown')) {
        hideBookMenu();
	}
    else {
		hideChapterMenu();
        showBookMenu();
	}
}

function toggleChapterMenu(chs, hasIntro, baseRef) {
    if ($("#chapter-menu").data('shown')) {
        hideChapterMenu();
	}
    else {
		hideBookMenu();
        showChapterMenu(chs, hasIntro, baseRef);
	}
}

function showBookMenu() {
    var popUp = document.getElementById("book-menu");
    var toolbarElement = document.getElementById("toolbar-top");
    var rect = toolbarElement.getBoundingClientRect();
	var scrollTop = $(window).scrollTop();
	
    popUp.style.top = rect.top + rect.height + scrollTop + "px";
    popUp.style.left = "45%";
    popUp.style.width = 170 + "px";
    popUp.style.height = 400 + "px";
     
	baseText = "";
	$.each(books, function(i) {
	    baseText = baseText + "<div class='book-menu-item'><a href='" + this.ref + "'>" + this.name + "</a></div>";
	});
	   	   
	popUp.innerHTML = baseText;
    popUp.style.visibility = "visible";
	   
    $(document).bind("click", function(event) {
		           var el1 = $(event.target).closest('#book-menu');
		           var el2 = $(event.target).closest('#book-selector');
		           if (!el1.length && !el2.length) {
				       hideBookMenu();
	               }} );
    $("#book-menu").data('shown', true);
	
    $(document).scroll(function() {
		hideBookMenu();
    });
}

function showChapterMenu(chs, hasIntro, baseRef) {
    var popUp = document.getElementById("chapter-menu");
    var toolbarElement = document.getElementById("toolbar-top");
    var rect = toolbarElement.getBoundingClientRect();
	var scrollTop = $(window).scrollTop();
	 
    popUp.style.top = rect.top + rect.height + scrollTop + "px";
    popUp.style.left = "45%";
    popUp.style.width = 200 + "px";
    popUp.style.maxHeight = 400 + "px";
     
	baseText = "";
	
	if (hasIntro) {
		ref = baseRef + padWithLeadingZeros(0, 3) + ".html";
		baseText = baseText + "<div class='intro-menu-item'>" + "<a href='" + ref + "'>" + "Introduction" + "</a></div>";
	}
	 
	baseText = baseText + "<table class='chapter-table'>";
	var count = 0;
	
	$.each(chs, function(i) {
		for (n = this.start; n <= this.end; n++) {
			count++;
			
			if (count == 1) {
				baseText = baseText + "<tr>";
			}
			
			ref = baseRef + padWithLeadingZeros(n, 3) + ".html";
			baseText = baseText + "<td class='chapter-menu-cell'><div class='chapter-menu-item'><a href='" + ref + "'>" + n + "</a></div></td>";
			
			if (count == 5) {
				baseText = baseText + "</tr>";
				count = 0;
			}
		}
	});
	
	if ((count > 0) && (count < 5)) {
		baseText = baseText + "</tr>";
	}
	
    baseText = baseText + "</table>";
	
	popUp.innerHTML = baseText;
    popUp.style.visibility = "visible";
	   
    $(document).bind("click", function(event) {
		           var el1 = $(event.target).closest('#chapter-menu');
		           var el2 = $(event.target).closest('#chapter-selector');
		           if (!el1.length && !el2.length) {
				       hideChapterMenu();
	               }} );
    $("#chapter-menu").data('shown', true);
	
    $(document).scroll(function() {
		hideChapterMenu();
    });
}

function hideBookMenu() {
	hideMenu("book-menu");
}

function hideChapterMenu() {
	hideMenu("chapter-menu");
}
	
function hideMenu(id) {
	var popUp = document.getElementById(id);
	popUp.style.visibility = "hidden";
   
	$(document).unbind("click");
	$("#" + id).data('shown', false);    
}

function padWithLeadingZeros(num, len) {
    var s = num + "";
    while (s.length < len) s = "0" + s;
    return s;
}


