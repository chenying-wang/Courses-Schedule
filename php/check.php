<?php 
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function check()
	{
		$WEEK = array("周一", "周二", "周三", "周四", "周五", "周六", "周日");

		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$check=true;
		$mysql=connect_db($username);
		$result=sql_query($mysql, "select * from courses");
		$crs_num=$result->num_rows;
		for($i=0; $i<$crs_num; $i++)
		{
			$row=$result->fetch_object();
			$crsid=$row->CourseID;
			$clsid=$row->ClassID;
			for($j=0; $j<7; $j++)
			{
				$query="select * from courses_schedule where CourseID='$crsid' and WeekNo='$j'";
				$result_i=sql_query($mysql, $query);
				if($result_i->num_rows>1)
				{
					$info.=get_name_by_id($mysql, 'classes', $clsid)."_";
					$info.=get_name_by_id($mysql, 'courses', $crsid)."_".($WEEK[$j])."/";
					$check=false;
				}
			}
		}
		return $info;
	}	

	echo check();
?>
