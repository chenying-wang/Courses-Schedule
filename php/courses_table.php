<?php 
	require_once("output.php");
	require_once("sql.php");
?>

<?php
	function courses_table()
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$mysql=connect_db($username);
		$result=sql_query($mysql, "select * from courses");
	
		echo "<table class='bordered highlight centered'>";
		echo "<thead>";
		echo "<tr><th>序号</th><th>课程名称</th><th>教师</th><th>班级</th>";
		echo "<th>每周节数</th><th>教室类型</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			$ins_name=get_name_by_id($mysql, "instructors", $row->InstructorID);
			$cls_name=get_name_by_id($mysql, "classes", $row->ClassID);
			$clsrm_type=get_name_by_id($mysql, "classroom_types", $row->ClassroomTypeID);
			echo "<tr ";
			echo "onclick=\"updateEditCourse('".$row->CourseID."', '".$row->Name."', ";
			echo "'".$ins_name."', '".$cls_name."', '".$row->Timesperweek."', '".$clsrm_type."')\">";
			echo "<td>$row->CourseID</td><td>$row->Name</td>";
			echo "<td>$ins_name</td>";
			echo "<td>$cls_name</td>";
			echo "<td>$row->Timesperweek</td>";
			echo "<td>$clsrm_type</td>";
			echo "<td><a href='javascript:void(0)' onclick='delCourse($row->CourseID)'><i class='material-icons'>delete</i></a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";

		$result->free();
		$mysql->close();
	}

	courses_table();
?>
