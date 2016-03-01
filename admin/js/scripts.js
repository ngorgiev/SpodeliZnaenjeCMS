tinymce.init({
  selector: 'textarea',
  height: 500,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'codesample',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools'
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    'fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    'www.tinymce.com/css/codepen.min.css'
  ]
 });

$(document).ready(function()
{
	$('#selectAllBoxes').click(function(event)
	{
		if(this.checked)
		{
			$('.checkBoxes').each(function(){
				this.checked = true;
			});
		}
		else
		{
			$('.checkBoxes').each(function(){
				this.checked = false;
			});
		}
	});

var div_box = "<div id='load-screen'><div id='loading'></div></div>";
$("body").prepend(div_box);
$("#load-screen").delay(100).fadeOut(50, function()
{
	$(this).remove();
});

});

function loadUsersOnline()
{
	$.get("functions.php?onlineusers=result", function(data)
		{
			$(".usersonline").text(data);
		});
}

setInterval(function()
{
	loadUsersOnline();
}, 500);

