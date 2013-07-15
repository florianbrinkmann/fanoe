document.body.className=document.body.className.replace('nojs', 'js');

jQuery(function() {
	jQuery("a img").each(function() {
		jQuery(this).parent().addClass("image");
	});
});

var showSidebar = function() {

    jQuery('body').toggleClass("active-sidebar");
    jQuery('.sidebar-button').toggleClass("active-button");
	jQuery('#main').click(function(e) {
            hideSidebar();
    });
	jQuery('#site-title').click(function(e) {
		hideSidebar();	
	});
}

var hideSidebar = function(){
	jQuery('body').removeClass("active-sidebar");
    jQuery('.sidebar-button').removeClass("active-button");	
}

jQuery(document).ready(function(jQuery) {
	jQuery('.sidebar-button').click(function(e) {
		e.preventDefault();
		showSidebar();
		jQuery('html, body').animate({ scrollTop: 0 }, 0);							
	});	
});
