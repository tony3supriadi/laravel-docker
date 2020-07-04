$(document).ready(function() {
    var screenHeight = $(window).height();
    var sidebarHight = screenHeight - 185;

    $('.slimscroll-sidebar').slimScroll({
        height: sidebarHight + "px",
    });
    
    var contentHight = screenHeight - 132;
    $('.slimscroll-content').slimScroll({
        height: contentHight + "px",
	});
});