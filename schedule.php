<!---
	schedule.php
	排课
	
--->
<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<title>排课 - 智能排课</title>

<style type="text/css">
	.tabs
	{
		height: 48px !important;
		line-height: 48px !important;
	}
	.tabs a.active, .tabs a:hover
	{
		color: #283593 !important;
	}	
	.tabs a
	{
		font-size: 18px !important;
		color: #7986cb !important;
	}
	.tabs .indicator
	{
		background-color: #283593 !important;
	}
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
	require_once("php/sql.php");
	require_once("php/output.php");
?>

<?php
	function init_select()
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$mysql=connect_db($username);
		$query="select * from instructors";
		$result=sql_query($mysql, $query);
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			?>
			<script type="text/javascript">
				$(document).ready(function()
				{
					var opt=$("<option></option>");
					$(opt).attr("id", "opt_ins_"+"<?php echo $row->InstructorID; ?>");
					$(opt).attr("selected", "selected");
					$(opt).val("<?php echo $row->InstructorID; ?>");
					$(opt).text("<?php echo $row->Name; ?>");
					$(opt).appendTo('#select-ins');
					updateSchedule(1, <?php echo $row->InstructorID; ?>);
				});
			</script>
			<?php
		}
		$query="select * from classes";
		$result=sql_query($mysql, $query);
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			?>
			<script type="text/javascript">
				$(document).ready(function()
				{
					var opt=$("<option></option>");
					$(opt).attr("id", "opt_cls_"+"<?php echo $row->ClassID; ?>");
					$(opt).attr("selected", "selected");
					$(opt).val("<?php echo $row->ClassID; ?>");
					$(opt).text("<?php echo $row->Name; ?>");
					$(opt).appendTo('#select-cls');
					updateSchedule(0, <?php echo $row->ClassID; ?>);
				});
			</script>
			<?php
		}
		$mysql->close();
		?>
		<script type="text/javascript">
			$(document).ready(function()
			{
				$('#export-select-cls').html($('#select-cls').html());
				$('#export-select-ins').html($('#select-ins').html());
				$('select').material_select();
			});
		</script>
		<?php
		return;
	}
?>

</head>

<body>

<?php
	$tab=$_GET['tab'];
	session_start();
	if(!isset($_SESSION['valid_user']))
	{
		header("Location: /");
	}
	init_select();
	output_schedule();
?>

</body>

<script type="text/javascript">
	$(document).ready(function()
	{
		$('.nav-side').css({marginLeft:'0'});
		$('.main').css({paddingLeft:'12%', paddingRight:'0%'});
		doHeaderRight();
		$('ul.tabs').tabs('select_tab', 'classrooms');
		$('ul.tabs').tabs();
		showClassroomsTable();
		showClassroomTypesTable();
		$('.modal').modal();
		$('select').material_select();

		$('.show-nav-side').click(function()
		{
			if($('.nav-side').offset().left!=0)
			{
				$('.nav-side').animate({marginLeft:'0'}, 'slow');
				$('.main').animate({paddingLeft:'12%', paddingRight:'0%'}, 'slow');
			}
			else
			{
				$('.nav-side').animate({marginLeft:'-12%'}, 'slow');
				$('.main').animate({paddingLeft:'6%', paddingRight:'6%'}, 'slow');
			}
		});

		$('#select-cls').change(function()
		{
			showClassesSchedule();
			
		});

		$('#select-ins').change(function()
		{
			showInstructorsSchedule()
		});
	});

	function showClassroomsTable()
	{
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/classrooms_table.php",
			data: {table: 0},
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				$("#classrooms-field").html(response);
			}
		});
	}

	function showClassroomTypesTable()
	{
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/classrooms_table.php",
			data: {table: 1},
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				$("#classroom_types-field").html(response);
			}
		});
	}

	function submitAddClassroom(frm)
	{
		if(!submitCheck(frm)) return false;
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/addclsrm.php",
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
					showClassroomsTable();
					showClassroomTypesTable();
				}
			}
		});
	}

	function submitEditClassroom(frm)
	{
		if(!submitCheck(frm)) return false;
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/editclsrm.php",
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
					showClassroomsTable();
					showClassroomTypesTable();
				}
			}
		});
	}

	function updateEditClsrm(id, clsrm, type)
	{
		$('#edit-clsrmid').val(id);
		$('#edit-clsrm').val(clsrm);
		$('#edit-type').val(type);
		Materialize.updateTextFields();
		$('#modal-edit').modal('open');
	}

	function delClassroom(id)
	{
		ev = arguments.callee.caller.arguments[0] || window.event;
		ev.stopPropagation();
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/delclsrm.php",
			data: {classroomid: id},
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
					showClassroomsTable();
					showClassroomTypesTable();
				}
			}
		});
	}

	function toSchedule(week, day, offset)
	{
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/to_schedule.php",
			data:
			{
				week: week,
				day: day,
				offset: offset
			},
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				if(response!=true) wrongInfo("排课错误");
				else wrongInfo("排课成功");
				//afterSchedule()
			}
		});
	}

	function afterSchedule()
	{
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/update.php",
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				insId=response.split('/')[0].split('_');
				clsId=response.split('/')[1].split('_');
				for(i=0; i<insId.length-1; i++)
				{
					//wrongInfo(insId[i]);
					updateSchedule(1, insId[i]);
				}
				for(i=0; i<clsId.length-1; i++)
				{
					//wrongInfo(clsId[i]);
					updateSchedule(0, clsId[i]);
				}
			}
		});
	}

	function updateSchedule(tableType, scheduleId)
	{ 
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/schedule_table.php",
			data: {type: tableType, id: scheduleId},
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				var card=$("<div style='margin-bottom:36px; padding: 12px;'></div>");
				$(card).attr("id", "sch-card-"+tableType+"-"+scheduleId);
				$(card).attr("class", "sch-card-"+tableType+" z-depth-1 hoverable");
				var title=$("<h5 style='margin-left: 36px'>"+scheduleId+"</h5>");
				var table=$("<div></div>");
				var name=tableType?"教师 "+$("#opt_ins_"+scheduleId).text():"班级 "+$("#opt_cls_"+scheduleId).text();
				$(title).html(name);
				$(table).html(response);
				$(title).appendTo($(card));
				$(table).appendTo($(card));

				if(!$("div #sch-card-"+tableType+"-"+scheduleId).length)
				{
					if(tableType) $(card).appendTo($('#ins-schedule-field'));
					else $(card).appendTo($('#cls-schedule-field'));
				}
				else
				{
					$(card).replaceAll($("div #sch-card-"+tableType+"-"+scheduleId));
				}
			}
		});
	}

	function showClassesSchedule()
	{
		$('div .sch-card-0').hide();
		for(i=0; i<$('#select-cls').val().length; i++)
		{
			$('div #sch-card-0-'+$('#select-cls').val()[i]).show();
		}
	}

	function showInstructorsSchedule()
	{
		$('div .sch-card-1').hide();
		for(i=0; i<$('#select-ins').val().length; i++)
		{
			$('div #sch-card-1-'+$('#select-ins').val()[i]).show();		
		}
	}

	function check()
	{
		$.ajax(
		{
			cache: true,
			type: "GET",
			url: "/php/check.php",
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				if(response.indexOf('/')==-1)
				{
					wrongInfo("排课合理");
				}
				info=response.split('/');
				for(i=0; i<info.length-1; i++)
				{
					msg="班级 "+info[i].split('_')[0];
					msg+="的课程 "+info[i].split('_')[1];
					msg+=" 在"+info[i].split('_')[2];
					msg+="有重复!";
					wrongInfo(msg);
				}
			}
		});
	}

	function drag(ev)
	{
		ev.dataTransfer.setData("text", ev.target.id);
	}

	function allowDrop(ev, thisClass)
	{
		srcClass=$("#"+ev.dataTransfer.getData("text")).attr("class");
		if(thisClass==srcClass) 
			ev.preventDefault();
	}

	function drop(ev)
	{
		ev.preventDefault();
		swap(ev.dataTransfer.getData("text"), ev.target.id);
	}

	function swap(srcDivId, dstDivId)
	{
		type=srcDivId.split('_')[0];
		typeId=srcDivId.split('_')[1];
		srcTimeId=srcDivId.split('_')[2];
		dstTimeId=dstDivId.split('_')[2];
		type=type=='1'?1:0
		if(isEqual(srcTimeId, dstTimeId)) return;

		// call php
		$.ajax(
		{
			cache: false,
			type: "GET",
			url: "/php/swap.php",
			data: 
			{
				type: type,
				typeId: typeId,
				srcTimeId: srcTimeId,
				dstTimeId: dstTimeId
			},
			async: true,
			error: function(data)
			{
				wrongInfo("Connection Error");
			},
			success: function(response) 
			{
				if(response.indexOf("INSTRUCTOR_CONFLICT")!=-1)
				{
					wrongInfo("教师冲突");
					return;
				}
				else if(response.indexOf("CLASS_CONFLICT")!=-1)
				{
					wrongInfo("班级冲突");
					return;
				}
				else if(response.indexOf("CLASSROOM_CONFLICT")!=-1)
				{
					wrongInfo("教室冲突");
					return;
				}
				updateSchedule(type, typeId);
				updateSchedule(type?0:1, parseInt(response.split("/")[0]));
				if(response.split("/").length==3) updateSchedule(type?0:1, parseInt(response.split("/")[1]));
			}
		});
	}

	function exportSchedule()
	{
		cls=$('#export-select-cls').val();
		ins=$('#export-select-ins').val();
		url="/export.php?cls="+cls+"&ins="+ins;
		window.open(url);
	}
</script>

</html>
