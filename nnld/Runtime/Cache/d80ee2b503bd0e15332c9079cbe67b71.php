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

<div class="ncenter_box">
<div class="accounttitle"><h1>参数设置 </h1></div>
<form method='post' id="myform" action="__URL__/setParameterSave" >
<table width="100%" cellpadding=3 cellspacing=0 border=0 id="tb1" class="tab4">
<tr class="content_td">
                <td width="15%" >&nbsp;</td>
                <td width="85%">&nbsp;</td>
</tr>
<!--
<tr>
				<td align="right">会员类型：</td>
				<td class="center"><input name="s10" type="text" id="s10" value="<?php echo ($fee_s10); ?>" size="40" maxlength="120" />
                用|分割</td>
</tr>
-->

<tr>
				<td align="right">注册金额：</td>
				<td class="center"><input name="s9" type="text" id="s9" value="<?php echo ($fee_s9); ?>" size="40" maxlength="120" />
                ￥ </td>
</tr>

    <tr>
        <td align="right">市场所有级别：</td>
        <td class="center"><input name="str28" type="text" id="str28" value="<?php echo ($fee_str28); ?>" size="94" maxlength="120" /> 用| 分割 <a> 注:前三个级别对应上面的金额</a></td>
    </tr>


        <tr>
            <td align="right">PV值比例：</td>
            <td class="center"><input name="s2" type="text" id="s2" value="<?php echo ($fee_s2); ?>" size="40" maxlength="120" />
                %</td>
        </tr>


      <tr>
                      <td align="right">犹豫期：</td>
                      <td class="center"><input name="str6" type="text" id="str6" value="<?php echo ($fee_str6); ?>" size="40" maxlength="120" />
                      天  <a> 注:按天来算</a> </td>
      </tr>


    <tr style="">
        <td align="right">销售奖：</td>
        <td class="center"><input name="str3" type="text" id="str3" value="<?php echo ($fee_str3); ?>" size="40" maxlength="120" /> %   </td>
    </tr>


        <tr>
               <td align="right">直推销售单：</td>
               <td class="center"><input name="s14" type="text" id="s14" value="<?php echo ($fee_s14); ?>" size="40" maxlength="120" />
                    用|分割 <a> 注:N为无限个</a></td>
        </tr>


    <tr>
        <td align="right">1W会员：</td>
        <td class="center"><input name="str9" type="text" id="str9" value="<?php echo ($fee_str9); ?>" size="40" maxlength="120" />
            % 用|分割 <a> 注:与直推销售单对应</a>  </td>
    </tr>

    <tr>
        <td align="right">5W会员：</td>
        <td class="center"><input name="str12" type="text" id="str12" value="<?php echo ($fee_str12); ?>" size="40" maxlength="120" />
            % 用|分割 <a> 注:与直推销售单对应</a> </td>
    </tr>

    <tr >
        <td align="right">10W会员：</td>
        <td class="center"><input name="str29" type="text" id="str29" value="<?php echo ($fee_str29); ?>" size="40" maxlength="120" />  % 用|分割 <a> 注:与直推销售单对应</a> </td>
    </tr>






    <tr>
        <td align="right">销售市场级别：</td>
        <td class="center"><input name="s4" type="text" id="s4" value="<?php echo ($fee_s4); ?>" size="40" maxlength="120" />
             用|分割</td>
    </tr>
    <tr style="">
        <td align="right">销售累积业绩：</td>
        <td class="center"><input name="str8" type="text" id="str8" value="<?php echo ($fee_str8); ?>" size="40" maxlength="120" />
            万 ￥ 用|分割</td>
    </tr>

    <tr>
        <td align="right">小市场累积业绩：</td>
        <td class="center"><input name="s12" type="text" id="s12" value="<?php echo ($fee_s12); ?>" size="40" maxlength="120" />
            万 ￥ 用|分割 </td>
    </tr>



    <tr>
        <td align="right">市场级差奖：</td>
        <td class="center"><input name="s6" type="text" id="s6" value="<?php echo ($fee_s6); ?>" size="40" maxlength="120" />
            % 用|分割</td>
    </tr>


    <tr>
        <td align="right">董事市场级别：</td>
        <td class="center"><input name="s3" type="text" id="s3" value="<?php echo ($fee_s3); ?>" size="40" maxlength="120" /> 用|分割
            </td>
    </tr>


       <tr>
           <td align="right">市场业绩累积：</td>
           <td class="center"><input name="str7" type="text" id="str7" value="<?php echo ($fee_str7); ?>" size="40" maxlength="120" />
               亿 用|分割</td>
       </tr>


    <tr>
        <td align="right"> 小市场业绩累积：</td>
        <td class="center"><input name="str4" type="text" id="str4" value="<?php echo ($fee_str4); ?>" size="40" maxlength="120" />
            亿 用|分割 </td>
    </tr>


    <tr style="">
        <td align="right">董事加权分红：</td>
        <td class="center"><input name="str17" type="text" id="str17" value="<?php echo ($fee_str17); ?>" size="40" maxlength="120" />
          % 用|分割  </td>
    </tr>





    <tr>
        <td align="right">消费基金：</td>
        <td class="center"><input name="s1" type="text" id="s1" value="<?php echo ($fee_s1); ?>" size="40" maxlength="120" />
            %</td>
    </tr>


    <tr>
        <td align="right">静态释放的消费积分：</td>
        <td class="center"><input name="str2" type="text" id="str2" value="<?php echo ($fee_str2); ?>" size="40" maxlength="150" />
            %</td>
    </tr>

    <tr>
        <td align="right">静态释放的市场积分：</td>
        <td class="center"><input name="s20" type="text" id="s20" value="<?php echo ($fee_s20); ?>" size="40" maxlength="150" />
            %</td>
    </tr>



    <tr>
        <td align="right">VAP积分比例：</td>
        <td class="center"><input name="s5" type="text" id="s5" value="<?php echo ($fee_s5); ?>" size="40" maxlength="120" />
            %</td>
    </tr>

    <tr>
        <td align="right">VAP释放比例：</td>
        <td class="center"><input name="s13" type="text" id="s13" value="<?php echo ($fee_s13); ?>" size="40" maxlength="120" />
            %</td>
    </tr>


    <tr>
        <td align="right">VAP提现比例(人民币)：</td>
        <td class="center"><input name="i6" type="text" id="i6" value="<?php echo ($fee_i6); ?>" size="40" maxlength="120" />
            </td>
    </tr>



    <tr style="">
        <td align="right">VAP释放天数：</td>
        <td class="center"><input name="i5" type="text" id="i5" value="<?php echo ($fee_i5); ?>" size="40" maxlength="120" />
            天 <a> 注:满天数,24小时为一天,以开通时间为准</a></td>
    </tr>



    <tr>
            <td align="right">爱心基金条件：</td>
            <td class="center">领导人收入超过 <input name="str10" type="text" id="str10" value="<?php echo ($fee_str10); ?>" size="5" maxlength="20" /> 万以上，扣  <input name="str11" type="text" id="str11" value="<?php echo ($fee_str11); ?>" size="10" maxlength="120" />% 进入爱心基金。</td>
    </tr>





    <tr>
        <td align="right">扣税：</td>
        <td class="center"><input name="s19" type="text" id="s19" value="<?php echo ($fee_s19); ?>" size="40" maxlength="120" />
            %</td>
    </tr>

    <tr >
        <td align="right">提现手续费：</td>
        <td class="center"><input name="s8" type="text" id="s8" value="<?php echo ($fee_s8); ?>" size="40" maxlength="120" />
            %</td>
    </tr>


    <tr >
        <td align="right">VAP手续费：</td>
        <td class="center"><input name="str32" type="text" id="str32" value="<?php echo ($fee_str32); ?>" size="40" maxlength="120" />
            %</td>
    </tr>



    <tr >
        <td align="right">最低提现额度：</td>
        <td class="center"><input name="s16" type="text" id="s16" value="<?php echo ($fee_s16); ?>" size="40" maxlength="120" /> 元 </td>
    </tr>



    <tr>
        <td align="right" class="tabr">转账倍数：</td>
        <td class="center"><input name="str18" type="text" id="str18" value="<?php echo ($fee_str18); ?>" size="40" maxlength="120" /> 元
        </td>
    </tr>



    <tr>
        <td align="right">关闭提现：</td>
        <td class="center"><input name="i10" type="radio" id="i10" value="0" <?php if(($fee_i10) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
            开启
            <input type="radio" name="i10" id="i10" value="1" <?php if(($fee_i10) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
            关闭 </td>
    </tr>

    <tr>
        <td align="right">关闭物流：</td>
        <td class="center"><input name="i11" type="radio" id="i11" value="0" <?php if(($fee_i11) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
            开启
            <input type="radio" name="i11" id="i11" value="1" <?php if(($fee_i11) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
            关闭 </td>
    </tr>

    <tr>
        <td align="right">关闭充值：</td>
        <td class="center"><input name="i12" type="radio" id="i12" value="0" <?php if(($fee_i12) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
            开启
            <input type="radio" name="i12" id="i12" value="1" <?php if(($fee_i12) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
            关闭 </td>
    </tr>


    <tr>
        <td align="right">系统vap汇率：</td>
        <td class="center"><input name="s20" type="text" id="s20" value="<?php echo ($fee_s20); ?>" size="40" maxlength="120" />
        </td>
    </tr>


    <tr>
        <td align="right">系统vap汇率开关：</td>
        <td class="center"><input name="i13" type="radio" id="i13" value="0" <?php if(($fee_i13) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
            开启
            <input type="radio" name="i13" id="i13" value="1" <?php if(($fee_i13) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
            关闭 </td>
    </tr>



    <tr>
        <td align="right">奖名称：</td>
        <td class="center"><input name="s18" type="text" id="s18" value="<?php echo ($fee_s18); ?>" size="80" maxlength="120" /> 用| 分割</td>
    </tr>


<tr>
            <td colspan="3" style="height:5px;"><hr></td>
</tr>

    <tr>
        <td align="right">汇款账号：</td>
        <td><span class="tLeft">
      <textarea name="str99" cols="60" rows="6" id="str99"><?php echo ($fee_str99); ?></textarea>
    开户名:xxx 银行:xxx账号:xxx 用|分割</span></td>
    </tr>


<tr>
    <td align="right">关闭网站提示：</td>
    <td><textarea name="str27" cols="60" rows="5" id="str27"><?php echo ($fee_str27); ?></textarea>
    （200字内）
    </td>
</tr>





<tr>
				<td align="right">登录设置：</td>
				<td class="center">
				<input type="radio" name="i1" id="i1" value="0" <?php if(($fee_i1) == "0"): ?>checked<?php endif; ?>  class="ipt_radi" />
				允许
				<input type="radio" name="i1" id="i1" value="1" <?php if(($fee_i1) == "1"): ?>checked<?php endif; ?>  class="ipt_radi" />
				不允许 <span class="stytle1">(是否允许一个用户同时多人在线！)</span>
				</td>
</tr>


<!--

-->


<tr>
  <td align="right">前台设置：</td>
  <td class="center"><input name="i3" type="radio" id="i3" value="0" <?php if(($fee_i3) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
    开启
      <input type="radio" name="i3" id="i3" value="1" <?php if(($fee_i3) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
      关闭 <span class="stytle1">(关闭前台会员登录！)</span></td>
</tr>


<tr style="display:none">
  <td align="right">网络图开关：</td>
  <td class="center"><input name="i4" type="radio" id="i4" value="0" <?php if(($fee_i4) == "0"): ?>checked<?php endif; ?> class="ipt_radi"/>
    开启
      <input type="radio" name="i4" id="i4" value="1" <?php if(($fee_i4) == "1"): ?>checked<?php endif; ?> class="ipt_radi"/>
      关闭 <span class="stytle1">(开启/关闭网络图！)</span></td>
</tr>
<tr>
				<td align="right">&nbsp;</td>
				<td class="center">&nbsp;</td>
</tr>
<tr>
  <td></td>
  <td class="center">
    <input type="submit" value="修改" class="button_text">
    <input type="reset" value="还原" class="button_text"></td>
</tr>
</table>
</form>
</div>
</body>
</html>