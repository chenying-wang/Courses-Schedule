<!--
	index.php
	主页
	
-->
<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<title>智能排课</title>

<style type="text/css">
	.index-bubble
	{
		margin-top: 90px;
		margin-bottom: 12px;
		margin-left: auto;
		margin-right: auto;
		width: 120px;
		height: 120px;
		border-radius: 60px;
	}
	.index-bubble h5
	{
		margin-left: auto;
		margin-right: auto;
	}
</style>

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
	output_index();
?>

</body>

<script type="application/javascript">
	$(document).ready(function()
	{
		doHeaderRight();
		$('.modal').modal();
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

	function loginCheck(frm)
	{
		if(!submitCheck(frm)) return false;
		var passwd=document.getElementById("login_passwd");
		passwd.value=getSha1(passwd.value);

		$.ajax(
		{
			cache: false,
			type: "POST",
			url: "/php/account.php",
			data: $(frm).serialize(),
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				if(response!=true)
				{
					$('#login_uid').val(null);
					$('#login_uid').attr('class', 'validate');
					$('#login_passwd').val(null);
					$('#login_passwd').attr('class', 'validate');
					Materialize.updateTextFields();
					wrongInfo(response);
				}
				else
				{
					$('#modal-login').modal('close');
					wrongInfo("登录成功");
					doHeaderRight();
				}
			}
		});
		return true;
	}

	function registerCheck(frm)
	{
		if(!submitCheck(frm)) return false;
		var passwd=document.getElementById("register_passwd");
		var cnfrm=document.getElementById("register_cnfrm");
		if(!isEqual(passwd.value, cnfrm.value))
		{
			wrongInfo("Password Confirmation Fail.");
			return false;
		}
		passwd.value=getSha1(passwd.value);
		cnfrm.value=getSha1(cnfrm.value);

		$.ajax(
		{
			cache: false,
			type: "POST",
			url: "/php/account.php",
			data: $(frm).serialize(),
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				if(response!=true)
				{
					$('#register_uid').val(null);
					$('#register_uid').attr('class', 'validate');
					$('#register_passwd').val(null);
					$('#register_passwd').attr('class', 'validate');
					$('#register_cnfrm').val(null);
					$('#register_cnfrm').attr('class', 'validate');
					Materialize.updateTextFields();
					wrongInfo(response);
				}
				else
				{
					$('#modal-register').modal('close');
					wrongInfo("注册成功");
					doHeaderRight();
				}
			}
		});
		return true;
	}

	function logOut()
	{
		$.ajax(
		{
			cache: false,
			type: "POST",
			url: "/php/logout.php",
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				if(response) 
				{	
					wrongInfo("注销成功");
					doHeaderRight();
				}
				else
				{
					wrongInfo("注销失败");
				}
			}
		});
		return true;
	}
</script>

</html>
