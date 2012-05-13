$('#exam_add').click(
	function()
	{
		url = $('#add_exam_link').attr("href");
		window.location = url;
		return false;
	});


$('#exam_add').mouseover(
	function()
	{
		$(this).css('cursor','pointer');
	});


$('#record_submit').click(
	function()
	{
		url = $('#add_record_link').attr("href");
		window.location = url;
		return false;
	});
	
	
$('#record_submit').mouseover(
	function()
	{
		$(this).css('cursor','pointer');
	});