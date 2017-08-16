<?php 
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function all_id()
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$id='';
		$mysql=connect_db($username);
		$query="select * from instructors";
		$result=sql_query($mysql, $query);
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			$id.=$row->InstructorID.'_';
		}
		$id.="/";
		$mysql=connect_db($username);
		$query="select * from classes";
		$result=sql_query($mysql, $query);
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			$id.=$row->ClassID.'_';
		}
		$id.="/";
		return $id;
	}

	echo all_id();
?>