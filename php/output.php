<?php
	function wrong_info($msg)
	{
		$msg=strtr($msg, array("'"=>"\\'", "\""=>"\\\""));
		$msg="Server:".$msg;
		?>
		<script type='text/javascript'>
			wrongInfo(<?php echo "'$msg'"; ?>);
		</script>
		<?php
	}

	function output_unified_header()
	{
		?>
		<div class="nav-header indigo darken-2 z-depth-1">
			<div class="header-left">
				<a href="javascript:void(0)" class="show-nav-side waves-effect waves-light" style="color:#FFFFFF;">
					<i class="material-icons">menu</i>
				</a>
				<a href="/" class="brand-logo" style="color:#FFFFFF;">智能排课</a>
			</div>
			<div class="header-right">
			</div>
		</div>
		<div class="nav-side grey lighten-4 z-depth-1">
			<ul>
				<a href="/courses.html">
					<li onmouseover="$(this).addClass('grey lighten-1');"
						onmouseout="$(this).removeClass('grey lighten-1');">课程</li>
				</a>
				<a href="/schedule.html">
					<li onmouseover="$(this).addClass('grey lighten-1');"
						onmouseout="$(this).removeClass('grey lighten-1');">排课</li>
				</a>
				<a href="/help.html">
					<li onmouseover="$(this).addClass('grey lighten-1');"
						onmouseout="$(this).removeClass('grey lighten-1');">帮助</li>
				</a>
				<a href="/about.html">
					<li onmouseover="$(this).addClass('grey lighten-1');"
						onmouseout="$(this).removeClass('grey lighten-1');">关于</li>
				</a>
			</ul>
		</div>
		<?php
	}

	function output_index()
	{
		output_unified_header();
		?>
		<div id="content">
			<div class="main">
				<div class="row">
					<div class="col l2 offset-l1 grey-text text-lighten-5">
						<div class="index-bubble red darken-3 valign-wrapper">
							<h5 class="valign">高 效</h5>
						</div>
					</div>
					<div class="col l2 offset-l1 grey-text text-lighten-5">
						<div class="index-bubble blue darken-3 valign-wrapper">
							<h5 class="valign">简 单</h5>
						</div>
					</div>
					<div class="col l2 offset-l1 grey-text text-lighten-5">
						<div class="index-bubble yellow darken-3 valign-wrapper">					
							<h5 class="valign">自 动</h5>
						</div>
					</div>
					<div class="col l2 offset-l1 grey-text text-lighten-5">
						<div class="index-bubble green darken-3 valign-wrapper">
							<h5 class="valign">快 捷</h5>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col l2 offset-l1 grey-text text-darken-3">
						<p class="flow-text">高效的计算机自动化排课，提供丰富的排课规则设置，
							满足不同的排课需求</p>
					</div>  
					<div class="col l2 offset-l1 grey-text text-darken-3">
						<p class="flow-text">简单人性化的界面设计，操作方便。
							简单四步操作，即可得到满意的课表</p1>
					</div>  
					<div class="col l2 offset-l1 grey-text text-darken-3">
						<p class="flow-text">自动排课完成后，
							查看班级课表和教师课表内，并且支持拖拽改课</p1>
					</div>  
					<div class="col l2 offset-l1 grey-text text-darken-3">
						<p class="flow-text">快捷导出到Excel，自由选择打印范围，
						点击一个按钮，就可以导出并下载</p1>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
		</div>

		<!--index FAB-->
		<div id="index-fab" class="fixed-action-btn">
		</div>

		<!--login modal-->
		<div id="modal-login" class="modal" style="padding:24px; width:24%;">
			<form id="login" name="login">
				<div class="modal-content">
					<h4>登录</h4>
					<div class="input-field" style="margin-top:48px">
						<i class="material-icons prefix">account_box</i>
						<input id="login_uid" type="text" class="validate" name="username" />
						<label for="login_uid">用户名</label>
					</div>
					<div class="input-field" style="margin-top:24px">
						<i class="material-icons prefix">lock</i>
						<input id="login_passwd" type="password" class="validate" name="password" />
						<label for="login_passwd">密码</label>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0)" 
						class=" modal-action indigo darken-2 white-text waves-effect waves-light btn-flat"
						onclick="loginCheck(document.getElementById('login'))">
						登录
					</a>
					<a href="javascript:void(0)" 
						class=" modal-action modal-close waves-effect btn-flat" 
						style="margin-right:12px">
						取消
					</a>
				</div>
				<input id="login_frmtype" type="hidden" name="formtype" value="LOGIN" />
			</form>
		</div>

		<!--register modal-->
		<div id="modal-register" class="modal" style="padding:24px; width:24%;">
			<form id="register" name="regsiter">
				<div class="modal-content">
					<h4>注册</h4>
					<div class="input-field" style="margin-top:48px">
						<i class="material-icons prefix">account_box</i>
						<input id="register_uid" type="text" class="validate" name="username" />
						<label for="register_uid">用户名</label>
					</div>
					<div class="input-field" style="margin-top:24px">
						<i class="material-icons prefix">lock</i>
						<input id="register_passwd" type="password" class="validate" name="password" />
						<label for="register_passwd">密码</label>
					</div>
					<div class="input-field" style="margin-top:24px">
						<i class="material-icons prefix">lock</i>
						<input id="register_cnfrm" type="password" class="validate" name="confirm" />
						<label for="register_passwd">确认</label>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0)" 
						class=" modal-action red darken-1 white-text waves-effect waves-light btn-flat"
						onclick="registerCheck(document.getElementById('register'))">
						注册
					</a>
					<a href="javascript:void(0)" 
						class=" modal-action modal-close waves-effect btn-flat" 
						style="margin-right:12px">
						取消
					</a>
				</div>
				<input id="register_frmtype" type="hidden" name="formtype" value="REGISTER" />
			</form>
		</div>
	<?php
	}

/**
	function output_login()
	{
		?>
        <div id="header">
			<a  href="/">
				<img src ="/images/logo.png" />
			</a>
		</div>

		<div id="content" class="shadow">
			<div id="account_card">
				<div id="card_title">
					<p>登 录</p>
				</div>
				<div id="error_msg">
					<p id="info"></p>
				</div>

				<div id="account_form">
					<form id="login" name="login"  onSubmit="return loginCheck(this)"
						action="<?php echo $_SERVER['PHP_SELF']?>"  method="post">

						<div id="uid_field">
							<img class="icon" src ="/images/user.png" />
							<input id="uid" class="ipt" type="text" name="username" placeholder="用户名"
								onfocus="borderBlue('uid_field')"
								onblur="borderGrey('uid_field')" />
						</div>

						<div id="passwd_field">
							<img class="icon" src ="/images/password.png" align="middle" />
							<input id="passwd" class="ipt" type="password" name="password" placeholder="密码"
								onfocus="borderBlue('passwd_field')"
								onblur="borderGrey('passwd_field')" />
						</div>

						<div id="login_btn">
							<input id="submit" type="submit" class="shadow" name="submit" value="    登 录    "
								style="background:#4285F4; color:#F2F2F2;"
								onmouseover="this.style.background='#4374E0'"
								onmouseout="this.style.background='#4285F4'" />
							<a href="/register.php" >
								<input id="reg" type="button" class="shadow" value="    注 册    "
									style="background:#CCCCCC; color:#333333;"
									onmouseover="this.style.background='#B3B3B3'"
									onmouseout="this.style.background='#CCCCCC'" />
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="footer">
			
		</div>
        <?php
	}

	function output_register()
	{
		?>
		<div id="header">
			<img src ="/images/logo.png" />
		</div>

		<div id="content" class="shadow">
			<div id="account_card">
				<div id="card_title">
					<p>注 册</p>
				</div>
				<div id="error_msg">
					<p id="info"></p>
				</div>

				<div id="account_form">
					<form name="register" onSubmit="return registerCheck(this)"
						action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

						<div id="uid_field">
							<img class="icon" src ="/images/user.png" />
							<input id="uid" class="ipt" type="text" name="username" placeholder="用户名"
								onfocus="borderBlue('uid_field')"
								onblur="borderGrey('uid_field')" />
						</div>

						<div id="passwd_field">
							<img class="icon" src ="/images/password.png" align="middle" />
							<input id="passwd" class="ipt" type="password" name="password" placeholder="密码"
								onfocus="borderBlue('passwd_field')"
								onblur="borderGrey('passwd_field')" />
						</div>

						<div id="cnfrm_field">
							<img class="icon" src ="/images/password.png" align="middle" />
							<input id="cnfrm" class="ipt" type="password" name="confirm" placeholder="确认"
								onfocus="borderBlue('cnfrm_field')"
								onblur="borderGrey('cnfrm_field')" />
						</div>

						<div id="reg_btn">
							<input id="submit" type="submit" class="shadow" name="submit" value="    注 册    " 
								style="background:#4285F4; color:#F2F2F2;"
								onmouseover="this.style.background='#4374E0'"
								onmouseout="this.style.background='#4285F4'" />
							<a href="/login.php" >
								<input id="bck" type="button" class="shadow" value="    返 回    " 
									style="background:#CCCCCC; color:#333333;"
									onmouseover="this.style.background='#B3B3B3'"
									onmouseout="this.style.background='#CCCCCC'" />
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="footer">
			
		</div>
		<?php
    }
**/
	function output_courses()
	{
		output_unified_header();
		?>
		<div id="content">
			<div class="main">
				<div class="row">
					<div id="courses-field"class="col l8 offset-l2"></div>
				</div>
			</div>
		</div>

		<div id="footer">
		</div>

		<div id="modal-add" class="modal" style="padding:24px; width:36%;">
			<form id="add">
				<div class="modal-content">
					<h4>增加课程</h4>
					<div class="row" style="margin-top:36px">
						<div class="col l12">
							<div class="input-field">
								<i class="material-icons prefix">school</i>
								<input id="add-crs" type="text" class="validate" name="course" />
								<label for="add-crs">课程名称</label>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:18px">
						<div class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">person</i>
								<input id="add-ins" type="text" class="validate" name="instructor" />
								<label for="add-ins">教师</label>
							</div>
						</div>
						<div  class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">group</i>
								<input id="add-cls" type="text" class="validate" name="class" />
								<label for="add-cls">班级</label>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:18px">
						<div class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">list</i>
								<input id="add-tpw" type="number" class="validate" name="timesperweek" />
								<label for="add-tpw">每周课时</label>
							</div>
						</div>
						<div  class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">group</i>
								<input id="add-clsrmtype" type="text" class="validate" name="classroomtype" />
								<label for="add-clsrmtype">教室类型</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0)" 
						class=" modal-action amber accent-4 white-text waves-effect waves-light btn-flat"
						onclick="submitAddCourse(document.getElementById('add'));">
						增加
					</a>
					<a href="javascript:void(0)" 
						class=" modal-action modal-close waves-effect btn-flat" 
						style="margin-right:12px">
						取消
					</a>
				</div>
			</form>
		</div>

		<div id="modal-edit" class="modal" style="padding:24px; width:36%;">
			<form id="edit">
				<div class="modal-content">
					<h4>编辑课程</h4>
					<div class="row" style="margin-top:36px">
						<div class="col l12">
							<div class="input-field">
								<i class="material-icons prefix">school</i>
								<input id="edit-crs" type="text" class="validate" name="course" />
								<label for="edit-crs">课程名称</label>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:18px">
						<div class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">person</i>
								<input id="edit-ins" type="text" class="validate" name="instructor" />
								<label for="edit-ins">教师</label>
							</div>
						</div>
						<div  class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">group</i>
								<input id="edit-cls" type="text" class="validate" name="class" />
								<label for="edit-cls">班级</label>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:18px">
						<div class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">list</i>
								<input id="edit-tpw" type="number" class="validate" name="timesperweek" />
								<label for="edit-tpw">每周课时</label>
							</div>
						</div>
						<div  class="col l6">
							<div class="input-field">
								<i class="material-icons prefix">group</i>
								<input id="edit-clsrmtype" type="text" class="validate" name="classroomtype" />
								<label for="edit-clsrmtype">教室类型</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0)" 
						class=" modal-action amber accent-4 white-text waves-effect waves-light btn-flat"
						onclick="submitEditCourse(document.getElementById('edit'));">
						编辑
					</a>
					<a href="javascript:void(0)" 
						class=" modal-action modal-close waves-effect btn-flat" 
						style="margin-right:12px">
						取消
					</a>
				</div>
				<input id="edit-id" type="hidden" name="courseid" value="0" />
			</form>
		</div>

		<!--courses FAB-->
		<div class="fixed-action-btn">
			<a href="#modal-add" class="btn-floating btn-large waves-effect waves-light amber accent-4">
				<i class="material-icons">add</i>
			</a>
		</div>
		<?php
	}
	/***
	function output_add()
	{
		?>
		<p id="info"></p>

		<form name="add" onSubmit="return submitCheck(this)" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<p>Course  <input id="crs" type="text" name="course" /></p>
			<p>Instructor  <input id="ins" type="text" name="instructor" /></p>
			<p>Class <input id="cls" type="text" name="class" /></p>
			<p>Times/Week <input id="tpw" type="number" name="timesperweek" /></p>
			<input type="submit" name="submit" value="Add" /> 
			<input type="reset" name="reset" value="Reset" />
		</form>
		<a href="/view.php">Back</a>
		<?php
	}

	function output_edit()
	{
		?>
		<p id="info"></p>

		<form name="edit" onSubmit="return submitCheck(this)" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<p><input id="courseid" type="hidden" name="id" /></p>
			<p>Course  <input id="crs" type="text" name="course" /></p>
			<p>Instructor  <input id="ins" type="text" name="instructor" /></p>
			<p>Class <input id="cls" type="text" name="class"/></p>
			<p>Times/Week <input id="tpw" type="number" name="timesperweek" /></p>
			<input type="submit" name="submit" value="Edit" /> 
			<input type="reset" name="reset" value="Reset" />
		</form>
		<a href="/view.php">Back</a>
		<?php
	}
	***/

	function output_schedule()
	{
		output_unified_header();
		?>
		<div id="content">
			<div class="main">
				<div class="row" style="margin-bottom: 48px;">
					<div class="col l12">
						<ul class="tabs">
							<li class="tab col l1 offset-l1">
								<a href="#classrooms" class="active">教室</a>
							</li>
							<li class="tab col l1 offset-l1">
								<a href="#regulation">规则</a>
							</li>
							<li class="tab col l1 offset-l1">
								<a href="#view">查看</a>
							</li>
							<li class="tab col l1 offset-l1">
								<a href="#export">导出</a>
							</li>
						</ul>
					</div>
				</div>

				<div id="classrooms" class="row">
					<div id="classrooms-field" class="col l5 offset-l1"></div>
					<div id="classroom_types-field" class="col l5 offset-l1"></div>
					<div class="fixed-action-btn">
						<a href="#modal-add" class="btn-floating btn-large amber accent-4 waves-effect waves-light">
							<i class="material-icons">add</i>
						</a>
					</div>
				</div>

				<div id="regulation" class="row">
					<div class="row">
						<div class="col l4 offset-l4">
							<div class="input-field" style="margin-bottom: 48px">	
								<select id="select-week">
									<option value="" disabled>排课日</option>
									<option value="5" selected>周一至周五</option>
									<option value="7">周一至周日(周日至周六)</option>
								</select>
								<label>排课日</label>
							</div>
							<div class="input-field" style="margin-bottom: 48px">
								<input id="reg-day" type="number" class="validate" value="4" />
								<label for="reg-day">每天课程节数</label>
							</div>
							<div class="input-field" style="margin-bottom: 48px">	
								<select id="select-offset">
									<option value="" disabled>每周首日</option>
									<option value="0" selected>周一</option>
									<option value="1">周日</option>
								</select>
								<label>每周首日</label>
							</div>
						</div>	
					</div>
					<div class="fixed-action-btn">
						<a onclick="toSchedule($('#select-week').val(), $('#reg-day').val(), $('#select-offset').val())"
							class="btn-floating btn-large amber accent-4 waves-effect waves-light">
							<i class="material-icons">playlist_play</i>
						</a>
					</div>
				</div>

				<div id="view" class="row">
					<div class="input-field col l3 offset-l2">
						<select id="select-cls" multiple="multiple">
							<option value="" disabled selected>按班级查询</option>
						</select>
						<label>按班级查询</label>
					</div>
					<div class="input-field col l3 offset-l2">
						<select id="select-ins" multiple="multiple">
							<option value="" disabled selected>按教师查询</option>
						</select>
						<label>按教师查询</label>
					</div>
					<div class="row">
						<div id="cls-schedule-field" class="col l6"></div>
						<div id="ins-schedule-field" class="col l6"></div>
					</div>
					<div class="fixed-action-btn">
						<a onclick="check();"
							class="btn-floating btn-large amber accent-4 waves-effect waves-light">
							<i class="material-icons">playlist_add_check</i>
						</a>
					</div>
				</div>

				<div id="export" class="row">
					<div class="input-field col l4 offset-l4" style="margin-bottom: 72px;">
						<select id="export-select-cls" multiple="multiple">
							<option value="" disabled selected>按班级导出</option>
						</select>
						<label>按班级导出</label>
					</div>
					<div class="input-field col l4 offset-l4">
						<select id="export-select-ins" multiple="multiple">
							<option value="" disabled selected>按教师导出</option>
						</select>
						<label>按教师导出</label>
					</div>
					<div class="fixed-action-btn">
						<a onclick="exportSchedule()"
							class="btn-floating btn-large amber accent-4 waves-effect waves-light">
							<i class="material-icons">open_in_new</i>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div id="footer">
		</div>

		<div id="modal-add" class="modal" style="padding:24px; width:24%;">
			<form id="add">
				<div class="modal-content">
					<h4>增加教室</h4>
					<div class="row" style="margin-top:36px">
						<div class="col l12">
							<div class="input-field">
								<i class="material-icons prefix">school</i>
								<input id="add-clsrm" type="text" class="validate" name="classroom" />
								<label for="add-clsrm">教室名称</label>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:18px">
						<div class="col l12">
							<div class="input-field">
								<i class="material-icons prefix">group</i>
								<input id="add-type" type="text" class="validate" name="type" />
								<label for="add-type">类型</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0)" 
						class=" modal-action amber accent-4 white-text waves-effect waves-light btn-flat"
						onclick="submitAddClassroom(document.getElementById('add'));">
						增加
					</a>
					<a href="javascript:void(0)" 
						class=" modal-action modal-close waves-effect btn-flat" 
						style="margin-right:12px">
						取消
					</a>
				</div>
			</form>
		</div>

		<div id="modal-edit" class="modal" style="padding:24px; width:24%;">
			<form id="edit">
				<div class="modal-content">
					<h4>编辑教室</h4>
					<div class="row" style="margin-top:36px">
						<div class="col l12">
							<div class="input-field">
								<i class="material-icons prefix">school</i>
								<input id="edit-clsrm" type="text" class="validate" name="classroom" />
								<label for="edit-clsrm">教室名称</label>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:18px">
						<div class="col l12">
							<div class="input-field">
								<i class="material-icons prefix">group</i>
								<input id="edit-type" type="text" class="validate" name="type" />
								<label for="edit-type">类型</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0)" 
						class=" modal-action amber accent-4 white-text waves-effect waves-light btn-flat"
						onclick="submitEditClassroom(document.getElementById('edit'));">
						编辑
					</a>
					<a href="javascript:void(0)" 
						class=" modal-action modal-close waves-effect btn-flat" 
						style="margin-right:12px">
						取消
					</a>
				</div>
				<input id="edit-clsrmid" type="hidden" name="classroomid" value="0" />
			</form>
		</div>
		<?php
	}

	function output_help()
	{
		output_unified_header();
		?>
		<div id="content">
			<div class="main">
				<div class="row">
					<ul class="collapsible col l8 offset-l1" data-collapsible="expandable">
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>智能排课实现了哪些功能
							</div>
							<div class="collapsible-body">
								<p>
									自动排课：系统会根据用户提供的信息自动排好课表；<br />
									自由改课：在自动排好课后，用户可以自由便捷的进行修改；<br />
									智能校错：修改后的课表若出现错误，系统第一时间向用户反馈；<br />
									方便导出：网页内自带的打印功能可以将排好的课表下载保存。<br />
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>对比传统排课智能排课的优势体现在哪些地方？
							</div>
							<div class="collapsible-body">
								<p>
									传统的排课费时费力，而计算机智能排课只需单人短时间操作，省时省力；<br />
									加课改课方便，支持拖拽改课；<br />
									计算机算法比人脑更加精密，不会重课漏课。<br />
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>智能排课的结果能否进行修改？
							</div>
							<div class="collapsible-body">
								<p>
									当然可以。您可以通过单击排好的课表上格子内的课程来修改课程信息，
									或者长按某格子内的课程拖拽到其他格子。
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>排课以及改课后的结果怎么保存？
							</div>
							<div class="collapsible-body">
								<p>
									自动排课或者手动加课改课后系统将自动把得到的结果保存在您的账户，
									不需要手动保存，下次登录时可以在之前操作的基础上进行更改。
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>注册账号有什么限制？
							</div>
							<div class="collapsible-body">
								<p>
									注册账号唯一的限制是不能注册已注册过的账号。
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>如何注销当前账号？
							</div>
							<div class="collapsible-body">
								<p>
									首先，点击左上方的智能排课logo进入主页，
									这时右下方黄色圆圈内的“+”号会变成“×”号；
									然后，点击这个“×”号即可注销当前账号。
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>我需要完成哪些步骤来完成一次排课？
							</div>
							<div class="collapsible-body">
								<p>
									首先，您需要注册一个账号，具体步骤如下：<br />
										点击右下方的黄色圆圈；<br />
										点击弹出来的“+”号按钮；<br />
										完成注册。<br />
									注册好之后需要登录，具体步骤如下：<br />
										点击右上方的登录按钮或者右下方的黄色圆圈弹出的箭头按钮；<br />
										输入之前注册的账号密码；<br />
									完成登录。<br />
									登录后点击左边菜单栏的“课程”填写相应的课程信息；<br />
									最后点击排课完成排课。<br />
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>排好课表后发现需要修改课程信息怎么办？
							</div>
							<div class="collapsible-body">
								<p>
									系统会保存您之前填好的课程信息，
									所以只需要点击左边菜单栏的“课程”修改课程信息步骤重新开始即可。
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>怎么将排好的课表导出到我的电脑？
							</div>
							<div class="collapsible-body">
								<p>
									网站支持打印课表功能，点击左边菜单栏的“课程”，
									然后点击打印课表后会以Excel或者pdf的格式保存在您的电脑
								</p>
							</div>
						</li>
						<li>
							<div class="collapsible-header">
								<i class="material-icons">question_answer</i>我遇到的问题在以上FAQ未得到解决怎么办？
							</div>
							<div class="collapsible-body">
								<p>
									您可以参考网站说明书寻找更详细的解决方案。
								</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="footer">
		</div>
		<?php
	}

	function output_about()
	{
		output_unified_header();
		?>
		<div id="content">
			<div class="main">
				<div class="row">
					<div class="col l7 offset-l1">
						<h4 style="margin-bottom: 36px">智能排课</h4>
						<p style="margin-bottom: 60px">
							我们一直致力于使我们的产品更加实用与便捷。
							如果您在使用过程中发现任何问题，或者您对我们产品有任何意见和建议，
							请及时反馈给我们: wangchenying96@gmail.com
						</p>
						<p>Copyright (c) 2016-2017 WANG Chenying.</p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
?>
