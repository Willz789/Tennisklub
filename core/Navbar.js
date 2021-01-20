$(document).ready(function() {
	$(".navbar-link[href]").each(function(index) {

		if(this.href == window.location.href) {
			$(this).addClass("active");
		}
	}); 
});