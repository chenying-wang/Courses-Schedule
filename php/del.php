<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function del()
	{
		// 验证和读取会话中的用户名
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$courseid=$_GET['courseid'];
		$mysql=connect_db($username);
		$result=sql_query($mysql, "delete from courses where CourseID='$courseid'");
		if(!$result) return false;
		clean_useless_clsrmtype($mysql);

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
	
	echo del();
?>
