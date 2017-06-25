

// Dropdown menu slide function for header
$(".navbar-menu-toggle").click(function(event) {

	event.stopPropagation(); //Stops the click from reach the elements under the menu button
	
	$("#menu").slideToggle("fast");

});

//  Function from making the header menu slide up when you click outside of the menu
//	It ignores when the menu button is clicked to avoid the menu instantly sliding up after sliding down
//	It also ignores clicks on the menu itself and when links are clicked as it makes the website appear 
//		slow as the menu begins to slide up while transition pages
$("body").not(".navbar-menu-toggle #menu a").click(function() {
	
	$("#menu").slideUp("fast");
	
});


