<!---
	courses.php
	课程
	
--->
<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<title>课程 - 智能排课</title>

<style type="text/css">
	table
	{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
		-khtml-user-select: none;
		user-select: none;
		cursor: default;
	}
	td a i.material-icons:hover
	{
		color: #303F9F;
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
	require_once("php/output.php");
	require_once("php/sql.php");
?>

</head>

<body>

<?php
	session_start();
	if(!isset($_SESSION['valid_user']))
	{
		header("Location: /");
	}
	output_courses(true, $_SESSION['valid_user']);
?>

</body>

<script type="application/javascript">
	$(document).ready(function()
	{
		$('.nav-side').css('marginLeft', '0');
		$('.main').css('paddingLeft', '16%');
		doHeaderRight();
		showCoursesTable();
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

	function showCoursesTable()
	{
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/courses_table.php",
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				$("#courses-field").html(response);
			}
		});
	}

	function updateEditCourse(id, name, insName, clsName, tpw, clsrmType)
	{
		$('#edit-id').val(id);
		$('#edit-crs').val(name);
		$('#edit-ins').val(insName);
		$('#edit-cls').val(clsName);
		$('#edit-tpw').val(tpw);
		$('#edit-clsrmtype').val(clsrmType);
		Materialize.updateTextFields();
		$('#modal-edit').modal('open');
	}

	function submitAddCourse(frm)
	{
		if(!submitCheck(frm)) return false;
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/add.php",
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
					wrongInfo("添加错误");
				}
				else
				{
					wrongInfo("添加成功");
					$('#modal-add').modal('close');
					showCoursesTable();
				}
			}
		});
	}

	function submitEditCourse(frm)
	{
		if(!submitCheck(frm)) return false;
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/edit.php",
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
					wrongInfo("编辑错误");
				}
				else 
				{
					wrongInfo("编辑成功");
					$('#modal-edit').modal('close');
					showCoursesTable();
				}
			}
		});
	}

	function delCourse(id)
	{
		ev = arguments.callee.caller.arguments[0] || window.event;
		ev.stopPropagation();
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/del.php",
			data: {courseid: id},
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				if(response!=true)
				{
					wrongInfo("删除错误");
				}
				else 
				{
					wrongInfo("删除成功");
					showCoursesTable();
				}
			}
		});		
	}
</script>

</html>
