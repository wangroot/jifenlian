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

<script type="text/javascript" src="__PUBLIC__/Js/Ajax/ThinkAjax-1.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/UserJs.js"></script>
<script language='javascript'>
function CheckForm(){
	if(document.form1.ePoints.value==""){
		alert("金额不能为空！");
		return false;
	}
	if(document.form1.select.value==1){
		if(confirm('您确定把 '+document.form1.ePoints.value+' 转借给会员（'+document.form1.UserID.value+'）吗？'))
		{
			return true;
		}else{
			alert('您取消了本次操作');
			return false;
		}
	}
}

function yhServer(Ful){
	str = $F(Ful).replace(/^\s+|\s+$/g,"");
	ThinkAjax.send('__APP__/Fck/check_CCuser/','ajax=1&userid='+str,'',Ful+'1');
}
</script>
<div class="ncenter_box">
<div class="accounttitle"><h1>积分转账 </h1></div>
    <form name="form1" method="post" action="__URL__/transferMoneyAC" onSubmit="{return CheckForm();}">
      <table width="100%" border="0" cellpadding="3" cellspacing="0">
          <tr>
              <td align="right">奖励积分： </td>
              <td colspan="2" width="80%"><span class="hong"><?php echo ($rs["agent_use"]); ?></span></td>

          <tr>

          <tr>
              <td align="right">注册积分： </td>
              <td colspan="2" width="80%"><span class="hong"><?php echo ($rs["agent_cash"]); ?></span></td>

          <tr>
      <!--    <tr>
              <td align="right">升级币： </td>
              <td colspan="2" width="80%"><span class="hong"><?php echo ($rs["agent_cash"]); ?></span></td>

          <tr>
            <td align="right"> 注册积分： </td>
            <td colspan="2" width="80%"><span class="hong"><?php echo ($rs["agent_xf"]); ?></span></td>
          </tr>
           -->


          <tr>
            <td align="right">类型：</td>
            <td colspan="2">
            <select name="select" id="select" onchange="Selev(this.value)" onpropertychange="Selev(this.value)">
            <!--  <option value="1"> 奖励积分 转给 其他会员 </option>  -->
              <option value="2"> 奖励积分 转 注册积分 </option>
              <option value="3"> 注册积分 转 其他会员 </option>
            </select>
            </td>
          </tr>
          <tr id="Selev">
            <td align="right">会员编号：</td>
            <td><input name="UserID" type="text" id="UserID" class="ipt" onblur="javascript:yhServer(this.value);" onfocus="notice('0','')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="msg_tips" id="msg_tips" style="font-size: 16px;"></a></td>
            <td><div id="UserID1" class="info"><div id="0" class="focus_r" style="display:none;"><div class="msg_tip">请输入你要转给会员的编号。</div></div></div></td>
          </tr>
          <tr>
            <td align="right">金额：</td>
            <td><input name="ePoints" type="text" id="ePoints" class="ipt" onkeyup="javascript:Null_Int(this.name)" onfocus="notice('1','')"  onblur="notice('1','none')"/>&nbsp;&nbsp;金额为<?php echo ($str18); ?>的整数</td>
            <td><div id="ePoints1" class="info"><div id="1" class="focus_r" style="display:none;"></div></div></td>
          </tr>
          <tr>
            <td align="right">说明：</td>
            <td colspan="2"><textarea name="content" cols="40" rows="4" id="content"></textarea></td>
          </tr>

          <tr>
              <td align="right">验证码：</td>
              <td><input name="yanzhengmas" type="text" class="ipt"  onblur="yanzhengma(this.value)"/>&nbsp;&nbsp;<input type="button" id="fasong"  value="发送短信" onclick="send(<?php echo ($id); ?>)">&nbsp;&nbsp;<a id="msgd"></a></td>
              <td></td>
          </tr>



          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input type="submit" name="Submit" value="确定转账" class="button_text" /></td>
          </tr>





      </table>
      </form>
<br>
<table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="1" id="tb1" bgcolor="#b9c8d0">
	<thead>
		<tr>
			<th><span>借方会员</span></th>
			<th><span>贷方会员</span></th>
			<th><span>时间</span></th>
			<th><span>交易额</span></th>
            <th><span>类型</span></th>
            <th><span>说明</span></th>
		</tr>
	</thead>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center">
		<td><?php echo ($vo['out_userid']); ?></td>
		<td><?php echo ($vo['in_userid']); ?></td>
		<td><?php echo (date('Y-m-d H:i:s',$vo['rdt'])); ?></td>
		<td><?php echo ($vo['epoint']); ?></td>
        <td>

        <!--    <?php if(($vo['type']) == "1"): ?>奖励积分转给其他会员<?php else: endif; ?>  -->
        	<?php if(($vo['type']) == "2"): ?>奖励积分转注册积分<?php else: endif; ?>
        	<?php if(($vo['type']) == "3"): ?>注册积分转给其他会员<?php else: endif; ?>

        </td>
        <td><?php echo ($vo['sm']); ?></td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<table width="100%" class="tab3_bottom" border="0" cellpadding="0" cellspacing="1">
    <tr>
        <td align="center"><?php echo ($page); ?></td>
    </tr>
</table>
</div>
</body>
</html>
<script language="javascript">
function Selev(o){

	if(o==1){document.getElementById('Selev').style.display = '';}
    if(o==3){document.getElementById('Selev').style.display = '';}
	if(o==2||o==4){document.getElementById('Selev').style.display = 'none';}
}
Selev(document.getElementById('select').value);
new TableSorter("tb1");

function yhServer(user_id){

    $.get("__APP__/Fck/check_CCuser/user_id/"+user_id,{},function(result){
         var data=eval('('+result+')');
         document.getElementById("msg_tips").innerHTML=data.info;

    });
}

     function send(uid) {

         $.ajax({
             method: "POST",
             url: "__APP__/Change/sendmessage",
             data: { uid: uid ,type: 1}
         })
                 .done(function( msg ) {
                     $("#msgd").html(msg);
                     if(msg == "验证码已经发送,请注意查收"){
                         //  $('#fasong').val("已发送");
                         time();
                     }

                 });

     }



var wait=60;
function time() {
    if (wait == 0) {
        $('#fasong').attr("disabled",false);
        $('#fasong').val("发送短信");
        $("#msgd").html('');
        wait = 60;
    } else {
        $('#fasong').val(wait+"s后可发送");
        $('#fasong').attr("disabled",true);
        wait--;
        setTimeout(function() {
                    time()
                },
                1000)
    }
}


function yanzhengma(yanzhengma) {

    $.ajax({
        method: "POST",
        url: "__APP__/Change/yanzhengma",
        data: { yanzhen: yanzhengma,type: 1}
    })
            .done(function( msg ) {

                $("#msgd").html(msg);

            });

}


</script>