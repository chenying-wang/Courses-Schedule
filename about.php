<!---
	about.php
	关于
	
--->
<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<title>关于 - 智能排课</title>

<link rel="stylesheet" href="/css/fonts.css">
<link rel="stylesheet" href="/css/material_icons.css">
<link rel="stylesheet" href="/css/materialize.css">
<link rel="stylesheet" href="/css/index.css">

<script type="application/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="application/javascript" src="/js/materialize.min.js"></script>
<script type="application/javascript" src="/js/myScript.js"></script>

<?php
	require_once("php/sql.php");
	require_once("php/output.php");
?>

</head>

<body>

<?php
	output_about();
?>

</body>

<script type="application/javascript">
	$(document).ready(function()
	{
		$('.nav-side').css('marginLeft', '0');
		$('.main').css('paddingLeft', '16%');
		doHeaderRight();
		$('.show-nav-side').click(function()
		{
			if($('.nav-side').offset().left!=0)
			{
				$('.nav-side').animate({marginLeft:'0'}, 'slow');
				$('.main').animate({paddingLeft:'16%'}, 'slow');
			}
			else
			{
				$('.nav-side').animate({marginLeft:'-12%'}, 'slow');
				$('.main').animate({paddingLeft:'10%'}, 'slow');
			}
		});
	});
</script>

</html>
