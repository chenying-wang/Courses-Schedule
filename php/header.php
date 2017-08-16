<?php
	function header_account()
	{
		session_start();
		if(isset($_SESSION['valid_user']))
		{
			return $_SESSION['valid_user'];
		}
		else
		{
			return false;
		}
	}

	echo header_account();
?>
