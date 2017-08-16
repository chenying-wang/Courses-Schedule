<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function clsins_clash($mysql, $type, $crsid_1, $crsid_2, $wno_1, $cno_1, $wno_2, $cno_2)
	{
		$query="select * from courses where CourseID='$crsid_1'";
		$result_1=sql_query($mysql, $query);
		$query="select * from courses where CourseID='$crsid_2'";
		$result_2=sql_query($mysql, $query);
		if(!$type)
		{
			$id_1=$result_1->fetch_object()->ClassID;
			$id_2=$result_2->fetch_object()->ClassID;
		}
		else
		{
			$id_1=$result_1->fetch_object()->InstructorID;
			$id_2=$result_2->fetch_object()->InstructorID;
		}
		if($id_1==$id_2) return false;
		if(get_course($mysql, $wno_2, $cno_2, $id_1, $type, 'id')==-1
			&get_course($mysql, $wno_1, $cno_1, $id_2, $type, 'id')==-1) return false;
		return true;
	}

	function clsrm_clash($mysql, $clsrmid_1, $clsrmid_2, $wno_1, $cno_1, $wno_2, $cno_2)
	{
		if($clsrmid_1==$clsrmid_2) return false;
		$query="select count(*) from courses_schedule where ClassroomID='$clsrmid_1' and ";
		$query.="WeekNo='$wno_2' and ClassNo='$cno_2'";
		$result=sql_query($mysql, $query);
		if($result->fetch_row()[0]) return true;
		$query="select count(*) from courses_schedule where ClassroomID='$clsrmid_2' and ";
		$query.="WeekNo='$wno_1' and ClassNo='$cno_1'";
		$result=sql_query($mysql, $query);
		if($result->fetch_row()[0]) return true;
		return false;
	}
?>

<?php
	session_start();
	if(!isset($_SESSION['valid_user'])) exit;
	$username=$_SESSION['valid_user'];

	$type=$_GET['type'];
	$id=$_GET['typeId'];
	$src_timeid=$_GET['srcTimeId'];
	$dst_timeid=$_GET['dstTimeId'];	
	$mysql=connect_db($username);
	$query="select * from info where ID=0";
	$result=sql_query($mysql, $query);
	$row=$result->fetch_object();
	$day=$row->Day;
	$src_wno=floor($src_timeid/$day);
	$src_cno=$src_timeid%$day;
	$dst_wno=floor($dst_timeid/$day);
	$dst_cno=$dst_timeid%$day;

	$src_crsid=get_course($mysql, $src_wno, $src_cno, $id, $type, 'id');
	$dst_crsid=get_course($mysql, $dst_wno, $dst_cno, $id, $type, 'id');
	if(clsins_clash($mysql, !$type, $src_crsid, $dst_crsid, $src_wno, $src_cno, $dst_wno, $dst_cno))
	{
		if(!$type) echo "INSTRUCTOR_CONFLICT";
		else echo "CLASS_CONFLICT";
		exit;
	}

	$src_clsrmid=get_classroom($mysql, $src_wno, $src_cno, $id, $type, 'id');
	$dst_clsrmid=get_classroom($mysql, $dst_wno, $dst_cno, $id, $type, 'id');
	if(clsrm_clash($mysql, $src_clsrmid, $dst_clsrmid, $src_wno, $src_cno, $dst_wno, $dst_cno))
	{
		echo "CLASSROOM_CONFLICT";
		exit;
	}

	if($dst_crsid!=-1)
	{
		if($src_crsid!=-1)
		{
			$query="update courses_schedule set CourseID='$dst_crsid' ";
			$query.="where CourseID='$src_crsid' and WeekNo='$src_wno' and ClassNo='$src_cno'";;
			sql_query($mysql, $query);
			$query="update courses_schedule set CourseID='$src_crsid' ";
			$query.="where CourseID='$dst_crsid' and WeekNo='$dst_wno' and ClassNo='$dst_cno'";
			sql_query($mysql, $query);
		}
		else
		{
			$query="select * from courses_schedule where CourseID='$dst_crsid' and ";
			$query.="WeekNo='$dst_wno' and ClassNo='$dst_cno'";
			$result=sql_query($mysql, $query);
			$clsrmid=$result->fetch_object()->ClassroomID;
			
			$query="insert into courses_schedule values('$dst_crsid', '$src_wno', '$src_cno', '$clsrmid')";
			sql_query($mysql, $query);
			$query="delete from courses_schedule ";
			$query.="where CourseID='$dst_crsid' and WeekNo='$dst_wno' and ClassNo='$dst_cno'";
			sql_query($mysql, $query);
		}
	}
	else
	{
		if($src_crsid!=-1)
		{
			$query="select * from courses_schedule where CourseID='$src_crsid' and ";
			$query.="WeekNo='$src_wno' and ClassNo='$src_cno'";
			$result=sql_query($mysql, $query);
			$clsrmid=$result->fetch_object()->ClassroomID;
			
			$query="delete from courses_schedule ";
			$query.="where CourseID='$src_crsid' and WeekNo='$src_wno' and ClassNo='$src_cno'";
			sql_query($mysql, $query);
			$query="insert into courses_schedule values ('$src_crsid', '$dst_wno', '$dst_cno', '$clsrmid')";
			sql_query($mysql, $query);
		}
		else
		{
			;
		}
	}

	if($src_crsid!=-1)
	{
		$query="select * from courses where CourseID='$src_crsid'";
		$result=sql_query($mysql, $query);
		if(!$type) $to_update.=$result->fetch_object()->InstructorID."/";
		else $to_update.=$result->fetch_object()->ClassID."/";
	}
	
	if($dst_crsid!=-1)
	{
		$query="select * from courses where CourseID='$dst_crsid'";
		$result=sql_query($mysql, $query);
		if(!$type) $to_update.=$result->fetch_object()->InstructorID."/";
		else $to_update.=$result->fetch_object()->ClassID."/";
	}

	$mysql->close();
	echo $to_update;
?>
