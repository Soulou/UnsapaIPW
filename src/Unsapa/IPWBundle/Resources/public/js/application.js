function resize_nav()
{
    var winheight = $(window).height();
    var docheight = $('#content').height() + $('#user_nav').height();
    
    var newheight = winheight;
    if(winheight < docheight)
        newheight = docheight;

    $('nav').height(newheight - $('#user_nav').height() - 150);
}

$(document).ready(function() {
    resize_nav();
});
$(window).resize(function() {
    resize_nav();
});
