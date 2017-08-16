<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function edit()
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$id=$_GET['courseid'];
		$course=$_GET['course'];
		$instructor=$_GET['instructor'];
		$class=$_GET['class'];
		$tpw=$_GET['timesperweek'];
		$clsrm_type=$_GET['classroomtype'];

		if(empty($course) || empty($instructor) || empty($class) || empty($tpw) || empty($clsrm_type))
		{
			return false;
		}
			
		$mysql=connect_db($username);
		update_absence($mysql, "instructors", $instructor);
		update_absence($mysql, "classes", $class);
		update_absence($mysql, "classroom_types", $clsrm_type);

		$result=sql_query($mysql, "select InstructorID from instructors where Name='$instructor'");
		$insid=$result->fetch_row()[0];
		$result->free();

		$result=sql_query($mysql, "select ClassID from classes where Name='$class'");
		$clsid=$result->fetch_row()[0];
		$result->free();

		$result=sql_query($mysql, "select ClassroomTypeID from classroom_types where Name='$clsrm_type'");
		$clsrmtypeid=$result->fetch_row()[0];
		$result->free();

		if(sql_query($mysql, "update courses set Name='$course', InstructorID='$insid', ClassID='$clsid',
			Timesperweek='$tpw', ClassroomTypeID='$clsrmtypeid' where CourseID='$id'"))
		{
			$query="select * from instructors";
			$result=sql_query($mysql, $query);
			for($i=0; $i<$result->num_rows; $i++)
			{
				$row=$result->fetch_object();
				$query="select count(*) from courses where InstructorID='$row->InstructorID'";
				$result_i=sql_query($mysql, $query);
				if(!$result_i->fetch_row()[0]) 
					sql_query($mysql, "delete from instructors where InstructorID='$row->InstructorID'");
			}
			$query="select * from classes";
			$result=sql_query($mysql, $query);
			for($i=0; $i<$result->num_rows; $i++)
			{
				$row=$result->fetch_object();
				$query="select count(*) from courses where ClassID='$row->ClassID'";
				$result_i=sql_query($mysql, $query);
				if(!$result_i->fetch_row()[0]) 
					sql_query($mysql, "delete from classes where ClassID='$row->ClassID'");
			}
			clean_useless_clsrmtype($mysql);
			$mysql->close();
			return true;
		}

		clean_useless_clsrmtype($mysql);
		$mysql->close();
		return false;
	}

	echo edit();
?>
