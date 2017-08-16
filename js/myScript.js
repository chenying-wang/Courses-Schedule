document.write("<script type='application/javascript' src='/js/sha.js'> </script>");

function isEmpty(str)
{
	if(str.length==0) return true;
	return false;
}

function isEqual(str1, str2)
{
	if(str1==str2) return true;
	return false;	
}

function getSha1(str)
{
	var shaObj = new jsSHA("SHA-1", "TEXT");
	shaObj.update(str);
	var hash = shaObj.getHash("HEX");
	return hash;
}

function submitCheck(frm)
{
	for(var i=0; i<frm.elements.length-1; i++)
	{
		if(isEmpty(frm.elements[i].value))
		{
			wrongInfo("Required Infomation is Empty.");
			frm.elements[i].focus();
			return false;
		}
	}
	return true;
}

function wrongInfo(msg)
{
	//document.getElementById("info").innerHTML=msg;
	Materialize.toast(msg, 4000);
}

function doHeaderRight()
{
	$.ajax(
	{
		cache: false,
		type: "GET",
		url: "/php/header.php",
		async: true,
		error: function(data)
		{
			wrongInfo("Connection Error");
		},
		success: function(response) 
		{
			if(!response)
			{
				$('.header-right').html("<a href='#modal-login' style='color:#FFFFFF;'>登录</a>");
				$('#index-fab').html(
					"<a class='btn-floating btn-large amber accent-4'>"+
						"<i class='large material-icons'>account_circle</i>"+
					"</a>"+
					"<ul>"+
						"<li>"+
							"<a href='#modal-register'"+
								"class='btn-floating red darken-1 waves-effect waves-light'>"+
								"<i class='material-icons'>add</i>"+
							"</a>"+
						"</li>"+
						"<li>"+
							"<a href='#modal-login'"+
								"class='btn-floating indigo darken-2 waves-effect waves-light'>"+
								"<i class='material-icons'>forward</i>"+
							"</a>"+
						"</li>"+
					"</ul>"
				);
			}
			else
			{
				$('.header-right').html(
					"<a href='' style='color:#FFFFFF;'>您好，"+response+"</a>");
				$('#index-fab').html(
					"<a href='javascript:void(0)' onclick='logOut()'"+ 
						"class='btn-floating btn-large amber accent-4 waves-effect waves-light'>"+
						"<i class='material-icons'>clear</i>"+
					"</a>"
				);
			}
		}
	})
}
