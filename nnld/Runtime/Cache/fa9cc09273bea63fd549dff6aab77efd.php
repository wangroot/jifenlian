<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($System_namex); ?></title>
<link href="__PUBLIC__/Css/body.css" rel="stylesheet" media="screen" type="text/css" />
<link href="__PUBLIC__/Css/menu.css" rel="stylesheet" media="screen" type="text/css" />
<link href="__PUBLIC__/Css/main.css" rel="stylesheet" media="all" type="text/css" />
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Base.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/prototype.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/mootools.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Ajax/ThinkAjax.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Form/CheckForm.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/common.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/Util/ImageLoader.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/myfocus-1.0.4.min.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/all.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/jquery-1.7.2.min.js\"></sc"+"ript>")</script>

<script type="text/javascript">document.write("<scr"+"ipt src=\"__PUBLIC__/Js/jquery.SuperSlide.2.1.1.source.js\"></sc"+"ript>")</script>
<script language="JavaScript">
ifcheck = true;
function CheckAll(form)
{
	for (var i=0;i<form.elements.length-2;i++)
	{
		var e = form.elements[i];
		e.checked = ifcheck;
	}
	ifcheck = ifcheck == true ? false : true;
}
</script>
<script>
//function checkLeave(){
//	window.parent.stateChangeIE();
//}
</script>
</head>
<body style=" background: none;">

<script language=javascript src="__PUBLIC__/Js/laydate/laydate.js"></script>
<div class="ncenter_box">
<div class="accounttitle"><h1>业绩纪录 </h1></div>
<table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="1" id="tb1" bgcolor="#b9c8d0">
	<thead>
    <tr align="center">
        <th nowrap>序号</th>
        <th nowrap><span>会员编号</span></th>
        <th nowrap><span>业绩金额</span></th>
        <th nowrap><span>会员服务中心</span></th>
        <th nowrap><span>开通时间</span></th>
        </tr>
    </thead>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="content_td lz" align="center">
        <td nowrap><?php echo ($key+1); ?></td>
        <td nowrap><?php echo (user_id($vo['uid'])); ?></td>
        <td nowrap><?php echo ($vo['money']); ?></td>
        <td nowrap><?php echo (user_id($vo['shop_id'])); ?></td>
        <td nowrap><?php echo (date('Y-m-d H:i:s',$vo["adt"])); ?></td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>
    <table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td align="center">业绩总金额: <a style="color:#ff0099;"><?php echo ($money); ?></a> </td>
        </tr>
    </table>
    <table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1" style="margin-top: 50px;">
        <tr>
            <td colspan="25" class="tabletd"><form id="form1" name="form1" method="post" action="__URL__/benzhou">业绩开始日期：<input name="start" type="text" id="start"  onclick="laydate()" /> 业绩结束日期：<input name="end" type="text" id="end"  onclick="laydate()" /> <input type="submit" name="Submit" value="查询" class="button_text" />
                &nbsp;&nbsp; </form></td>
            <td width="40%"><?php echo ($page); ?></td>
        </tr>
    </table>
</div>
</body>
</html>
<script>new TableSorter("tb1");</script>