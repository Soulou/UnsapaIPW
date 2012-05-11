$('#exam_add').click(
	function()
	{
		url = $('#add_exam_link').attr("href");
		window.location = $(this).attr(url);
		return false;
	});


$('#exam_add').mouseover(
	function()
	{
		$(this).css('cursor','pointer');
	});
