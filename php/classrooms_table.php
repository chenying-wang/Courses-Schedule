<?php 
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function classrooms_table()
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$mysql=connect_db($username);
		$query="select * from classrooms";
		$result=sql_query($mysql, $query);
		echo "<table class='bordered highlight centered'>";
		echo "<thead><tr><th>序号</th><th>教室名称</th><th>类型</th></tr></thead>";
		echo "<tbody>";
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			$type=get_name_by_id($mysql, "classroom_types", $row->ClassroomTypeID);
			echo "<tr onclick=\"updateEditClsrm('$row->ClassroomID', '$row->Name', '$type');\">";
			echo "<td>$row->ClassroomID</td>";
			echo "<td>$row->Name</td>";
			echo "<td>$type</td>";
			echo "<td><a class='del-clsrm' href='javascript:void(0)' ";
			echo "onclick='delClassroom($row->ClassroomID);'>";
			echo "<i class='material-icons'>delete</i></a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		return;
	}

	function classroom_types_table()
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$mysql=connect_db($username);
		$query="select * from classroom_types";
		$result=sql_query($mysql, $query);
		echo "<table class='bordered highlight centered'>";
		echo "<thead><tr><th>序号</th><th>教室类型名称</th></tr></thead>";
		echo "<tbody>";
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			echo "<tr>";
			echo "<td>$row->ClassroomTypeID</td>";
			echo "<td>$row->Name</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		return;
	}

	if(!$_GET['table']) classrooms_table();
	else classroom_types_table();
?>
