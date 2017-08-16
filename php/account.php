<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function create_database($db_name)
	{
		// 使用mysql命令，依照create_db.sql创建一个初始数据库
		if(!isset($db_name)) return false;
		$mysql=new mysqli("localhost", "chen", "chen");
		$query="create database $db_name";
		$result=$mysql->query($query);
		exec("mysql -uchen -pchen -D".$db_name." < create_db.sql");
		$mysql=connect_db($db_name);
		$query="insert into info values(0, 0, 0)";
		sql_query($mysql, $query);
		$mysql->close();
		return true;
	}

	function account()
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$type=$_POST['formtype'];
			session_start();	//开始会话
			if($type=="LOGIN")
			{
				// 读取前端的POST请求的信息
				$username=$_POST['username'];
				$password=$_POST['password'];

				// 验证信息不为空
				if(empty($username) || $password==sha1(""))
				{
					return 'Required Infomation is Empty.';
				}

				// 连接account数据库，查看users表中是否有对应的用户名密码的记录
				$mysql=connect_db("account");
				$query="select count(*) from users where username='$username' and password='$password'";
				$result=sql_query($mysql, $query);

				$row=$result->fetch_row();
				$result->free();
				$mysql->close();

				if($row[0])
				{
					// 若有，则将会话中的变量valid_user设置为用户名
					$_SESSION['valid_user']=$username;
					return true;
				}
				else
				{
					// 若无，则返回错误信息
					return 'Wrong Username or Password.';
				}
			}

			else if($type=="REGISTER")
			{
				$username=$_POST['username'];
				$password=$_POST['password'];
				$confirm=$_POST['confirm'];
				if(empty($username) || $password==sha1("") || $confirm==sha1(""))
				{
					return 'Required Infomation is Empty.';
					
				}

				if($password!=$confirm)
				{
					return 'Password Confirmation Fail.';
				}

				$mysql=connect_db("account");
				$query="select count(*) from users where username='$username'";
				$result=sql_query($mysql, $query);

				$row=$result->fetch_row();
				$result->free();
				

				if(!$row[0])
				{
					$result=sql_query($mysql, "insert into users(username, password) values('$username', '$password')");
					if(!$result)
					{
						$mysql->close();
						return "Error!";
					}
					else
					{
						$mysql->close();
						$_SESSION['valid_user']=$username;
						$result=create_database($username);
						return $result;
					}
				}
				else
				{
					return "Username \"$username\" has been registered!";
				}
			}
		}
	}

	echo account();
?>
