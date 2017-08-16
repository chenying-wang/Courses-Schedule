<?php 
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function schedule_table($col, $row, $offset, $id, $type)
	{
		$WEEK = array("周一", "周二", "周三", "周四", "周五", "周六", "周日");

		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$mysql=connect_db($username);
		echo "<table id='$type"."_"."$id'>";
		for($i=-1; $i<$row; $i++)
		{
			if($i==-1)
			{
				echo "<thead><tr>";
				echo "<td></td>";
				for($j=0; $j<$col; $j++)
				{
					$jj=($j-$offset+7)%7;
					echo "<th>".($WEEK[$jj])."</th>";
				}
				echo "</tr></thead>";
				echo "<tbody>";
			}
			else
			{
				echo "<tr>";
				echo "<td>".($i+1)."</td>";
				for($j=0; $j<$col; $j++)
				{
					$jj=($j-$offset+7)%7;
					$name=get_course($mysql, $jj, $i, $id, $type);
					$clsrm=get_classroom($mysql, $jj, $i, $id, $type);

					echo "<td>";
					echo "<div id='".$type."_".$id."_".($i+$jj*$row)."' ";
					echo "class='schedule-course ".$type."_".$id."'";
					echo "ondragover='allowDrop(event, this.className);' ";
					echo "ondrop='drop(event);'";
					echo "draggable='true' ondragstart='drag(event)'>";
					echo $name.$clsrm;
					echo "</div></td>";
				}
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
		$mysql->close();
		return;
	}

	session_start();
	if(!isset($_SESSION['valid_user'])) exit;
	$username=$_SESSION['valid_user'];

	$mysql=connect_db($username);
	$query="select * from info where ID=0";
	$result=sql_query($mysql, $query);
	$row=$result->fetch_object();
	$day=$row->Day;
	$offset=$row->Offset;
	$mysql->close();

	$type=$_GET['type'];
	$id=$_GET['id'];
	schedule_table(7, $day, $offset, $id, $type);
?>
