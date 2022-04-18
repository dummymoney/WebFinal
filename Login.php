<?php
session_start();
$_SESSION["user"] = "guest";
?>
<link href="login.css" rel="stylesheet">
<style> 
body {
  background-image: url("images/bp.jpeg");
}
</style>
<body>
<form name="frmUser" method="post" action="index.php">
	
		<table border="0" cellpadding="10" cellspacing="1" width="500" align="center" class="tblLogin">
			<tr class="tableheader">
			<td align="center" colspan="2"><h1>Enter Login Details</h1></td>
			</tr>
			<tr class="tablerow">
			<td>
			<input type="text" name="userName" placeholder="User Name" class="login-input"></td>
			</tr>
			<tr class="tablerow">
			<td>
			<input type="password" name="password" placeholder="Password" class="login-input"></td>
			</tr>
			<tr class="tableheader">
			<td align="center" colspan="2"><input type="submit" name="submit" value="Submit" class="button-51" role="button"></td>
			</tr>
		</table>
</form>
<nav class="nav-item" >
  <a href="front.php"><button class="button-56" role="button">Guest</button></a>
</nav>
<?php
//echo $_SESSION["user"];
?>
</body>