<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload</title>
<style type="text/css">
<!--
form {
	margin: 0px;
	padding: 0px;
}
body {
	margin: 0px;
	padding: 0px;
}
-->
</style>
</head>

<body>
<form id="upload" method='post' action="__URL__/upload_fengcai_cc/" enctype="multipart/form-data">
<table cellpadding=0 cellspacing=0 class="tabsy" >
<tr>
  <td width="250" height="30" align="left"><input name="image" id="image" type="file" /></td>
  <td width="97" class="center"><input type="submit" value=" 上传 " style="border:1px solid #000"></td>
  </tr>
</table>
</form>
</body>
</html>