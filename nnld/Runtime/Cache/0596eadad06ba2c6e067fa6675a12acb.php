<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($System_namex); ?></title>
<link href="__PUBLIC__/Css/body.css" rel="stylesheet" media="screen" type="text/css" />
<link href="__PUBLIC__/Css/menu.css" rel="stylesheet" media="screen" type="text/css" />
<link href="__PUBLIC__/Css/main.css" rel="stylesheet" media="all" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Js/Ajax/ajaxpg.js"></script>
</head>

<body>
<div class="ncenter_box">
<div class="accounttitle"><h1>结算销售奖 </h1></div>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
	<tr>
		<td>
<div id="result" style="text-align:center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" >

  <td align="center">
  <br />
<!--   <br />结算分红：<input name="a1" id="a1" type="hidden" value="<?php echo ($yj_rs); ?>">
  <br />当前可分红份数：<?php echo ($all_fs); ?>
  <!-- <br />分红份数：<?php echo ($all_fs2); ?> -->
  <!--结算月份复销奖<br><span style="color:#FF3300;">结算这一期奖励</span><br>-->
  上期结算时间：<?php if(($ti["xiaoshou_time"]) != "0"): echo (date('Y-m-d H:i:s',$ti["xiaoshou_time"])); ?>
      <?php else: ?>无结算<?php endif; ?>
  <br />
  <span style="color:#FF3300;">您好！请在结算销售奖前先备份数据库，防止奖励错误不可返回，</span><a href="__APP__/YouZi/cody/c_id/7"><span style="color:#oof;">备份数据库</span></a>

      <br><br>


          <a href="__URL__/xiaoshouSave"><button id="send_ajax" class="button_text">结算销售奖</button></a>


  <br />
  <br />
</td>
</tr>
</table>
</div>
		</td>
	</tr>
</table>
</div>
</body>
</html>