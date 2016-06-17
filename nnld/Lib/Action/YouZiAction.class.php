<?php
class YouZiAction extends CommonAction {
	function _initialize() {
		$this->_inject_check(1);//调用过滤函数
		$this->_checkUser();
		$this->_Admin_checkUser();//后台权限检测
		$this->_Config_name();//调用参数
		header("Content-Type:text/html; charset=utf-8");

	}
	//================================================二级验证
	public function cody(){
		$UrlID  = (int) $_GET['c_id'];
	    if (empty($UrlID)){
            $this->error('二级密码错误1!');
            exit;
        }
        if(!empty($_SESSION['user_pwd2'])){
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
		$cody   =  M ('cody');
        $list	=  $cody->where("c_id=$UrlID")->field('c_id')->find();
		if ($list){
			$this->assign('vo',$list);
			$this->display('../Public/cody');
			exit;
		}else{
			$this->error('二级密码错误!');
			exit;
		}
	}
	//====================================二级验证后调转页面
	public function codys(){
		$Urlsz	= $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass	= $_POST['oldpassword'];
			$fck   =  M ('fck');
		    if (!$fck->autoCheckToken($_POST)){
	            $this->error('页面过期请刷新页面!');
	            exit();
	        }
			if (empty($pass)){
				$this->error('二级密码错误!');
				exit();
			}
			$where =  array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopen'] = md5($pass);
			$list = $fck->where($where)->field('id')->find();
			if($list == false){
				$this->error('二级密码错误!');
				exit();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz){
			case 1;
				$_SESSION['UrlPTPass'] = 'MyssShenShuiPuTao';
				$bUrl = __URL__.'/auditMenber';//审核会员
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
				$bUrl = __URL__.'/adminMenber';//会员管理
				$this->_boxx($bUrl);
				break;

			case 31;
				$_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
				$bUrl = __URL__.'/adminBenzhou';//会员管理
				$this->_boxx($bUrl);
				break;




			case 36;
				$_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
				$bUrl = __URL__.'/adminCenter';//会员管理
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/setParameter';//参数设置
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlPTPass'] = 'MyssPingGuo';
				$bUrl = __URL__.'/adminParameter';//比例设置
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['UrlPTPass'] = 'MyssMiHouTao';
				$bUrl = __URL__.'/adminFinance';//拨出比例(当期出纳*changeby  sarwen)
				$this->_boxx($bUrl);
				break;




			case 6;
				$_SESSION['UrlPTPass'] = 'MyssGuanPaoYingTao';
				$bUrl = __URL__.'/adminCurrency';//提现管理
				$this->_boxx($bUrl);
				break;
			case 7;
				$_SESSION['UrlPTPass'] = 'MyssHaMiGua';
				$bUrl = __APP__.'/Backup/';//数据库管理
				$this->_boxx($bUrl);
				break;
			case 8;
				$_SESSION['UrlPTPass'] = 'MyssPiPa';
				$bUrl = __URL__.'/adminFinanceTable';//奖金查询
				$this->_boxx($bUrl);
				break;

			case 9;
				$_SESSION['UrlPTPass'] = 'MyssQingKong';
				$bUrl = __URL__.'/delTable';//清空数据
				$this->_boxx($bUrl);
				break;
			case 10;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/adminAgents';//会员管理
				$this->_boxx($bUrl);
				break;
			case 11;
				$_SESSION['UrlPTPass'] = 'MyssBaiGuoJS';
				$bUrl = __URL__.'/adminClearing';//奖金结算
				$this->_boxx($bUrl);
				break;
			case 12;
				$_SESSION['UrlPTPass'] = 'MyssGuanMangGuo';
				$bUrl = __URL__.'/adminCurrencyRecharge';//充值管理
				$this->_boxx($bUrl);
				break;
			case 13;
                $_SESSION['UrlPTPass'] = 'MyssGuansingle';
                $bUrl = __URL__.'/adminsingle';//加单管理
                $this->_boxx($bUrl);
                break;
            case 14;
				$_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
				$bUrl = __URL__.'/adminMenberUse';//会员管理
				$this->_boxx($bUrl);
				break;


			case 15;
				$_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
				$bUrl = __URL__.'/Ip';//会员管理
				$this->_boxx($bUrl);
				break;


			case 18;
                $_SESSION['UrlPTPass'] = 'MyssMoneyFlows';
                $bUrl = __URL__.'/adminmoneyflows';//财务流向管理
                $this->_boxx($bUrl);
                break;
			case 19;
                $_SESSION['UrlPTPass'] = 'MyssProduct';
                $bUrl = __URL__.'/product';//加单管理
                $this->_boxx($bUrl);
                break;
			case 21;
                $_SESSION['UrlPTPass'] = 'MyssGuanXiGuaUp';
                $bUrl = __URL__.'/adminUserUp';//升级管理
                $this->_boxx($bUrl);
                break;
			case 22;
                $_SESSION['UrlPTPass'] = 'MyssPingGuoCPB';
                $bUrl = __URL__.'/setParameter_B';
                $this->_boxx($bUrl);
                break;
			case 23;
                $_SESSION['UrlPTPass'] = 'MyssOrdersList';
                $bUrl = __URL__.'/OrdersList';//加单管理
                $this->_boxx($bUrl);
                break;
            case 24;
                $_SESSION['UrlPTPass'] = 'MyssWuliuList';
                $bUrl = __URL__.'/adminLogistics';//物流管理
                $this->_boxx($bUrl);
                break;
            case 25;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGuaJB';
				$bUrl = __URL__.'/adminJB';//金币中心管理
				$this->_boxx($bUrl);
				break;
			case 26;
				$_SESSION['UrlPTPass'] = 'MyssGuanChanPin';
				$bUrl = __URL__.'/pro_index';//产品管理
				$this->_boxx($bUrl);
				break;
			case 27;
				$_SESSION['UrlPTPass'] = 'MyssGuanzy';
				$bUrl = __URL__.'/admin_zy';//专营店管理
				$this->_boxx($bUrl);
				break;
			case 28;
				$_SESSION['UrlPTPass'] = 'MyssShenqixf';
				$bUrl = __URL__.'/adminXiaofei';//消费申请
				$this->_boxx($bUrl);
				break;
			case 29;
				$_SESSION['UrlPTPass'] = 'MyssJinji';
				$bUrl = __URL__.'/adminmemberJJ';//晋级
				$this->_boxx($bUrl);
				break;
			case 30;
                $_SESSION['UrlPTPass'] = 'Myssadminlookfhall';
                $bUrl = __URL__.'/adminlookfhall';
                $this->_boxx($bUrl);
                break;



			case 32;
				$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/xiaoshou';
				$this->_boxx($bUrl);
				break;
			case 33;
				$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/fuwu';
				$this->_boxx($bUrl);
				break;

			case 34;
				$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/shichang';
				$this->_boxx($bUrl);
				break;


			case 35;
				$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/dongshi';
				$this->_boxx($bUrl);
				break;


			case 37;
				//$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/jifen';
				$this->_boxx($bUrl);
				break;

			case 38;
				//$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/shifang';
				$this->_boxx($bUrl);
				break;


			default;
				$this->error('二级密码错误!');
				break;
		}
	}



/***************T050业务逻辑******************/

public function xiaoshou(){

	if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP'){



		$ti = M('fck')->where('id=1')->find();
		$this->assign('ti',$ti);




        $this->display();
	}else{

      echo $this->error("数据错误");
	  exit;

	}


}


	public function xiaoshouSave(){
		$Fck = D('Fck');
		$Fck->xiaoshou();
		$fck = M('fck')->where('id=1')->setField('xiaoshou_time',time());

		echo $this->success("结算成功");

	}



	public function fuwu(){

		if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP'){



			$ti = M('fck')->where('id=1')->find();
			$this->assign('ti',$ti);




			$this->display();
		}else{

			echo $this->error("数据错误");
			exit;

		}


	}


	public function fuwuSave(){
		$Fck = D('Fck');
		$Fck->fuwuyongjin();
		$fck = M('fck')->where('id=1')->setField('yongjin_time',time());

		echo $this->success("结算成功");

	}



	public function shichang(){

		if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP'){



			$ti = M('fck')->where('id=1')->find();
			$this->assign('ti',$ti);


			$money = M('jicha')->where('is_jiesuan=0')->sum('money');
			$this->assign('money',$money);


			$this->display();
		}else{

			echo $this->error("数据错误");
			exit;

		}


	}


	public function shichangSave(){
		$Fck = D('Fck');

		$dangtian = strtotime(date('Y-m-d'));
		$fee_rs = M('fee')->find(1);

		$list = M('jicha')->where('is_jiesuan=0')->select();

		foreach($list as $v){

			$qiantian = strtotime(date('Y-m-d',$v['pdt']));
			$days=round(($dangtian-$qiantian)/3600/24);
			if($days > $fee_rs['str6']) {

				$gai = M('jicha')->where('id=' . $v['id'])->setField('is_jiesuan', 1);
				if ($gai) {
					$Fck->rw_bonus($v['uid'], $v['user_id'], 3, $v['money']);
				}


			}


		}


		$fck = M('fck')->where('id=1')->setField('jifen_time',time());

		echo $this->success("结算成功");

	}


	public function dongshi(){

		if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP'){

			$ti = M('fck')->where('id=1')->find();
			$this->assign('ti',$ti);

			$one = M('fck')->where('u_level=5')->count();
			$this->assign('one',$one);


			$two = M('fck')->where('u_level=6')->count();
			$this->assign('two',$two);

			$three = M('fck')->where('u_level=7')->count();
			$this->assign('three',$three);

			$four = M('fck')->where('u_level=8')->count();
			$this->assign('four',$four);


			$m = M('fenhong')->find();
			$this->assign('money',$m['money']);


			$this->display();
		}else{

			echo $this->error("数据错误");
			exit;

		}


	}




	public function jifen(){


            if($_REQUEST['start'] && $_REQUEST['end']){
				$map['pdt'] = array(array('egt',strtotime($_REQUEST["start"])),array('elt',strtotime($_REQUEST["end"])));
				$this->assign('start',strtotime($_REQUEST["start"]));
				$this->assign('end',strtotime($_REQUEST["end"]));
			}

		if($_REQUEST['user_id']){
			$map['tousername'] = array('eq',$_REQUEST['user_id']);
			$map['fromusername'] = array('eq',$_REQUEST['user_id']);
			$map['_logic'] = 'OR';
			$this->assign('user_id',$_REQUEST["user_id"]);
		}

		if($_REQUEST['uniqueid']){
			$map['uniqueid'] = array('eq',$_REQUEST['uniqueid']);
			$this->assign('uniqueid',$_REQUEST["uniqueid"]);
		}

			$trans=M('trans');
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $trans->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$listrows = 5000;//每页显示的记录数
			$page_where ='start='.$_REQUEST["start"].'&end='.$_REQUEST["end"].'&user_id='.$_REQUEST['user_id'].'&uniqueid='.$_REQUEST['uniqueid'];//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $trans->order('pdt desc')->where($map)->page($Page->getPage().','.$listrows)->select();
		   //  echo $list=M()->getLastSql();
			$this->assign('list',$list);//数据输出到模板

			$this->display();

	}




	public function shifang(){


		if($_REQUEST['start'] && $_REQUEST['end']){
			$map['pdt'] = array(array('egt',strtotime($_REQUEST["start"])),array('elt',strtotime($_REQUEST["end"])));
			$this->assign('start',strtotime($_REQUEST["start"]));
			$this->assign('end',strtotime($_REQUEST["end"]));
		}

		if($_REQUEST['user_id']){
			$map['user_id'] = array('eq',$_REQUEST['user_id']);
			$this->assign('user_id',$_REQUEST["user_id"]);
		}

		$shifang=M('shifang');
		import ( "@.ORG.ZQPage" );  //导入分页类
		$count = $shifang->where($map)->count();//总页数
		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
		$listrows = 5000;//每页显示的记录数
		$page_where ='start='.$_REQUEST["start"].'&end='.$_REQUEST["end"].'&user_id='.$_REQUEST['user_id'];//分页条件
		$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板
		$list = $shifang->order('pdt desc')->where($map)->page($Page->getPage().','.$listrows)->select();
		//  echo $list=M()->getLastSql();
		$this->assign('list',$list);//数据输出到模板

		$this->display();

	}





	public function dongshiSave(){
		$Fck = D('Fck');
		$Fck->jiaquanFh();
		$fck = M('fck')->where('id=1')->setField('dongshi_time',time());

		echo $this->success("结算成功");

	}


/***************T050业务逻辑******************/




	public function codyT(){
		$UrlID  = (int) $_GET['c_id'];
	    if (empty($UrlID)){
            $this->error('三级密码错误!');
            exit;
        }
  //       if(!empty($_SESSION['user_pwd2'])){
		// 	$url = __URL__."/codys/Urlsz/$UrlID";
		// 	$this->_boxx($url);
		// 	exit;
		// }
		$cody   =  M ('cody');
        $list	=  $cody->where("c_id=$UrlID")->field('c_id')->find();
		if ($list){
			$this->assign('vo',$list);
			$this->display('../Public/codyT');
			exit;
		}else{
			$this->error('三级密码错误!');
			exit;
		}
	}
	//====================================二级验证后调转页面
	public function codyTs(){
		$Urlsz	= $_POST['Urlsz'];
		// if(empty($_SESSION['user_pwd2'])){
			$pass	= $_POST['oldpassword'];
			$fck   =  M ('fck');
		    if (!$fck->autoCheckToken($_POST)){
	            $this->error('页面过期请刷新页面!');
	            exit();
	        }
			if (empty($pass)){
				$this->error('三级密码错误!');
				exit();
			}
			$where =  array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopentwo'] = md5($pass);
			$list = $fck->where($where)->field('id')->find();
			if($list == false){
				$this->error('三级密码错误!');
				exit();
			}
		// 	$_SESSION['user_pwd2'] = 1;
		// }else{
		// 	$Urlsz = $_GET['Urlsz'];
		// }
		switch ($Urlsz){
			case 1;
				$_SESSION['UrlPTPass'] = 'MyssShenShuiPuTao';
				$bUrl = __URL__.'/auditMenber';//审核会员
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
				$bUrl = __URL__.'/adminMenber';//会员管理
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
				$bUrl = __URL__.'/setParameter';//参数设置
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlPTPass'] = 'MyssPingGuo';
				$bUrl = __URL__.'/adminParameter';//比例设置
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['UrlPTPass'] = 'MyssMiHouTao';
				$bUrl = __URL__.'/adminFinance';//拨出比例
				$this->_boxx($bUrl);
				break;
			case 6;
				$_SESSION['UrlPTPass'] = 'MyssGuanPaoYingTao';
				$bUrl = __URL__.'/adminCurrency';//提现管理
				$this->_boxx($bUrl);
				break;
			case 7;
				$_SESSION['UrlPTPass'] = 'MyssHaMiGua';
				$bUrl = __APP__.'/Backup/';//数据库管理
				$this->_boxx($bUrl);
				break;
			case 8;
				$_SESSION['UrlPTPass'] = 'MyssPiPa';
				$bUrl = __URL__.'/adminFinanceTable';//奖金查询
				$this->_boxx($bUrl);
				break;
			case 9;
				$_SESSION['UrlPTPass'] = 'MyssQingKong';
				$bUrl = __URL__.'/delTable';//清空数据
				$this->_boxx($bUrl);
				break;
			case 10;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/adminAgents';//会员管理
				$this->_boxx($bUrl);
				break;
			case 11;
				$_SESSION['UrlPTPass'] = 'MyssBaiGuoJS';
				$bUrl = __URL__.'/adminClearing';//奖金结算
				$this->_boxx($bUrl);
				break;
			case 12;
				$_SESSION['UrlPTPass'] = 'MyssGuanMangGuo';
				$bUrl = __URL__.'/adminCurrencyRecharge';//充值管理
				$this->_boxx($bUrl);
				break;
			case 13;
                $_SESSION['UrlPTPass'] = 'MyssGuansingle';
                $bUrl = __URL__.'/adminsingle';//加单管理
                $this->_boxx($bUrl);
                break;
			case 18;
                $_SESSION['UrlPTPass'] = 'MyssMoneyFlows';
                $bUrl = __URL__.'/adminmoneyflows';//财务流向管理
                $this->_boxx($bUrl);
                break;
			case 19;
                $_SESSION['UrlPTPass'] = 'MyssProduct';
                $bUrl = __URL__.'/product';//加单管理
                $this->_boxx($bUrl);
                break;
			case 23;
                $_SESSION['UrlPTPass'] = 'MyssOrdersList';
                $bUrl = __URL__.'/OrdersList';//加单管理
                $this->_boxx($bUrl);
                break;
            case 24;
                $_SESSION['UrlPTPass'] = 'MyssWuliuList';
                $bUrl = __URL__.'/adminLogistics';//物流管理
                $this->_boxx($bUrl);
                break;
            case 25;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGuaJB';
				$bUrl = __URL__.'/adminJB';//金币中心管理
				$this->_boxx($bUrl);
				break;
			case 26;
				$_SESSION['UrlPTPass'] = 'MyssGuanChanPin';
				$bUrl = __URL__.'/pro_index';//产品管理
				$this->_boxx($bUrl);
				break;
			case 27;
				$_SESSION['UrlPTPass'] = 'MyssGuanzy';
				$bUrl = __URL__.'/admin_zy';//专营店管理
				$this->_boxx($bUrl);
				break;
			case 28;
				$_SESSION['UrlPTPass'] = 'MyssShenqixf';
				$bUrl = __URL__.'/adminXiaofei';//消费申请
				$this->_boxx($bUrl);
				break;
			case 29;
				$_SESSION['UrlPTPass'] = 'MyssJinji';
				$bUrl = __URL__.'/adminmemberJJ';//晋级
				$this->_boxx($bUrl);
				break;
			case 30;
                $_SESSION['UrlPTPass'] = 'Myssadminlookfhall';
                $bUrl = __URL__.'/adminlookfhall';
                $this->_boxx($bUrl);
                break;
			case 21;
                $_SESSION['UrlPTPass'] = 'MyssGuanXiGuaUp';
                $bUrl = __URL__.'/adminUserUp';//升级管理
                $this->_boxx($bUrl);
                break;
			case 22;
                $_SESSION['UrlPTPass'] = 'MyssPingGuoCPB';
                $bUrl = __URL__.'/setParameter_B';
                $this->_boxx($bUrl);
                break;
			default;
				$this->error('三级密码错误!');
				break;
		}
	}

	
	//========================================数据库管理
	public function adminManageTables(){
		if ($_SESSION['UrlPTPass'] == 'MyssHaMiGua'){
			$Url =__ROOT__.'/HaMiGua/';
			$_SESSION['shujukuguanli!12312g@#$%^@#$!@#$~!@#$'] = md5("^&%#hdgfhfg$@#$@gdfsg13123123!@#!@#");
			$this ->_boxx($Url);
		}
	}
	//============================================审核会员
	public function auditMenber($GPid=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao'){

			$fee=M('fee')->find(1);
			$str28 = explode('|',$fee['str28']);
			$this->assign('level',$str28);//会员级别

			$fck = M('fck');
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
               
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}

	
			$map['_string']    = ' is_pay =0';

            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay,id,rdt desc')->page($Page->getPage().','.$listrows)->select();
          
            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别
            $this->assign('list',$list);//数据输出到模板
            //=================================================






			$this->display ('auditMenber');
		}else{
			$this->error('数据错误!');
			exit;
		}
	}
	public function auditMenberData() {
		if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao' ){
			//查看会员详细信息
			$fck = M ( 'fck' );
			$ID = (int) $_GET['PT_id'];
			//判断获取数据的真实性 是否为数字 长度
			if (strlen($ID) > 11){
				$this->error ('数据错误!');
				exit;
			}
			$where = array();
			$where['id'] = $ID;
			$field = '*';
			$vo = $fck ->where($where)->field($field)->find();
			if ($vo){
				$this->assign ( 'vo', $vo );
				$this->display ();
			}else{
				$this->error ('数据错误!');
				exit;
			}
		}else{
			$this->error ('数据错误!');
			exit;
		}
	}
	public function auditMenberData2() {
		if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao' ){
			//查看会员详细信息
			$fck = M ( 'fck' );
			$ID = (int) $_GET['PT_id'];
			//判断获取数据的真实性 是否为数字 长度
			if (strlen($ID) > 11){
				$this->error ('数据错误!');
				exit;
			}
			$where = array();
			$where['id'] = $ID;
			$field = '*';
			$vo = $fck ->where($where)->field($field)->find();
			if ($vo){
				$this->assign ( 'vo', $vo );
				$this->display ();
			}else{
				$this->error ('数据错误!');
				exit;
			}
		}else{
			$this->error ('数据错误!');
			exit;
		}
	}
	public function auditMenberData2AC() {
		if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao' ){

			$fck = M ('fck');
			$data = array();

			$where['id'] = (int) $_POST['id'];
			$rs = $fck -> where('is_pay = 0') -> find($where['id']);
			if(!$rs){
				$this->error ('非法操作!');
				exit;
			}

			$data['nickname'] = $_POST['NickName'];
			$rs = $fck -> where($data) -> find();
			if($rs){
				if($rs['id'] != $where['id']){
					$this->error ('该会员名已经存在!');
					exit;
				}
			}

			$data['bank_name'] = $_POST['BankName'];
			$data['bank_card'] = $_POST['BankCard'];
			$data['user_name'] = $_POST['UserName'];
			$data['bank_province'] = $_POST['BankProvince'];
			$data['bank_city'] = $_POST['BankCity'];
			$data['user_code'] = $_POST['UserCode'];
			$data['bank_address'] = $_POST['BankAddress'];
			$data['user_address'] = $_POST['UserAddress'];
			$data['user_post'] = $_POST['UserPost'];
			$data['user_tel'] = $_POST['UserTel'];
			$data['bank_province'] = $_POST['BankProvince'];
			$data['is_lock'] = $_POST['isLock'];

			$fck->where($where)->data($data)->save();
			$bUrl = __URL__.'/auditMenberData2/PT_id/'.$where['id'];
			$this->_box(1,'修改会员信息！',$bUrl,1);

		}else{
			$this->error ('数据错误!');
			exit;
		}
	}
	public function auditMenberAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/auditMenber';
			$this->_box(0,'请选择会员！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '开通会员';
				$this->_auditMenberOpenUser($PTid);
				break;
//			case '设为空单';
//				$this->_auditMenberOpenNull($PTid);
//				break;
			case '删除会员';
				$this->_auditMenberDelUser($PTid);
				break;
			case '申请通过';
				$this->_AdminLevelAllow($PTid);
				break;
			case '拒绝通过';
				$this->_AdminLevelNo($PTid);
				break;
		default;
			$bUrl = __URL__.'/auditMenber';
			$this->_box(0,'没有该会员！',$bUrl,1);
			break;
		}
	}






    //===============================================设为空单
    private function _auditMenberOpenNull($PTid=0){
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao'){
            $fck = D ('Fck');
            $where = array();
            if (!$fck->autoCheckToken($_POST)){
                $this->error('页面过期，请刷新页面！');
                exit;
            }
            $ID = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = array ('in',$PTid);
            $where['is_pay'] = 0;
            $field = "id,u_level,re_id,cpzj,re_path,user_id,p_path,p_level,shop_id,f4";
            $vo = $fck ->where($where)->order('rdt asc')->field($field)->select();
            $nowdate = strtotime(date('c'));
            $nowday=strtotime(date('Y-m-d'));
            foreach($vo as $voo){
            $ppath = $voo['p_path'];
				//上级未开通不能开通下级员工
				$frs_where['is_pay'] = array('eq',0);
				$frs_where['id'] = $voo['father_id'];
				$frs = $fck -> where($frs_where) -> find();
				if($frs){
					$this->error('开通失败，上级未开通');
					exit;
				}
				
				$data = array();
				$data['open_id'] = $_SESSION[C('USER_AUTH_KEY')];
				$data['is_pay'] = 2;
				$data['pdt'] = $nowdate;
                $data['wlf'] = $nowdate - $fee_rs['s3'] * 86400; //收费周期，秒数;
				$data['open'] = 1;
				$data['get_date'] = $nowday;
				$data['fanli_time'] = $nowday;
                                
                                //网络费
				// $fck->wlf($voo['id'],$voo['user_id']);

				//开通会员
				$result = $fck->where('id='.$voo['id'])->save($data);

				// 删除购物
				M('gouwu')->where('uid='.$voo['id'])->delete();
				unset($data,$varray);

            }
            unset($fck,$where,$field,$vo,$nowday);
            $bUrl = __URL__.'/auditMenber';
            $this->_box(1,'设为空单！',$bUrl,1);
            exit;

        }else{
            $this->error('错误！');
            exit;
        }
    }

	//===============================================开通会员
	private function _auditMenberOpenUser($PTid=0){
		if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao'){
			$shouru = M ('shouru');
			$fck = D ('Fck');
			$fee = D ('Fee');
			$fee_rs = $fee->find();
			$s4 = explode("|", $fee_rs['s4']);
			$bili = $fee_rs['s2']/100;
			// $card = A('Phonecard');

			$where = array();
			$where['id'] = array ('in',$PTid);
			$where['is_pay'] = 0;
			$field = "*";
			$vo = $fck ->where($where)->field($field)->order('id asc')->select();
			$nowdate = strtotime(date('c'));
			$nowday = strtotime(date('Y-m-d'));
			$fck->emptyTime();
			foreach($vo as $voo){
				$ppath = $voo['p_path'];
				//上级未开通不能开通下级员工
				$frs_where['is_pay'] = array('eq',0);
				$frs_where['id'] = $voo['father_id'];
				$frs = $fck -> where($frs_where) -> find();
				if($frs){
					$this->error('开通失败，上级未开通');
					exit;
				}

				if($fee_rs['i13'] ==1){
					$url = "https://api.allcoin.com/api/v1/ticker?symbol=vap_usd";
					$res = file_get_contents($url);
					$res = json_decode($res,true);
					$fl = $res['ticker']['last'];
				}else{
					$fl = $fee_rs['s20'];
				}


				$this->assign('fl',$fl);

				
				//给推荐人添加推荐人数或单数
				$fck->query("update __TABLE__ set `td_yj`=td_yj+" .$voo['cpzj']*$bili. ",`re_nums`=re_nums+1 where `id`=".$voo['re_id']);
				
				unset($re_rs);
				$data = array();
				$data['open_id'] = $_SESSION[C('USER_AUTH_KEY')];
				$data['is_pay'] = 1;
				$data['pdt'] = $nowdate;
                $data['wlf'] = $nowdate - $fee_rs['s3'] * 86400; //收费周期，秒数;
				$data['open'] = 1;
				$data['get_date'] = $nowday;
				$mm = date('m',time());
				$s5=explode('|',$fee_rs['s5']);


				$rmb=$fee_rs['i6'];

				$s2=$fee_rs['s2'];
				$s5 = explode('|',$fee_rs['s5']);


				//	$data['agent_gc'] = $voo['cpzj']*$s5[$voo['u_level']]/100;

				$data['vap_total'] = ($voo['cpzj']*$s5[$voo['cpzj_level']]/100)/($rmb*$fl);
				$data['vap_amount'] = ($voo['cpzj']*$s5[$voo['cpzj_level']]/100)/($rmb*$fl);
			//	$data['fafang_time'] = strtotime(date("Y-m-d",strtotime("+6 day")));
				$data['fafang_time'] = '1462032000';
				$data['fafang_cishu'] = 200;
				//开通会员
				$result = $fck->where('id='.$voo['id'])->save($data);
				unset($data,$varray);
				$data = array();
				$data['uid'] = $voo['id'];
				$data['user_id'] = $voo['user_id'];
				$data['in_money'] = $voo['cpzj'];
				$data['in_time'] = time();
				$data['in_bz'] = "新会员加入";
				$shouru->add($data);




				$bid = $fck->_getTimeTableList(10799);
				$bid = $fck->_getTimeTableList(10800);
				$bid = $fck->_getTimeTableList(10801);
				$bonus = M('bonus');
				$md = $voo['cpzj']*$bili*0.01;
				$bonus->where('uid=10799')->order('id desc')->setInc('b8',$md);
				$bonus->where('uid=10800')->order('id desc')->setInc('b8',$md);
				$bonus->where('uid=10801')->order('id desc')->setInc('b8',$md);

				$fck->where('id=10799')->setInc('agent_use',$md);
				$fck->where('id=10800')->setInc('agent_use',$md);
				$fck->where('id=10801')->setInc('agent_use',$md);


				$fck->addencAdd(10799, $voo['user_id'], $md, 8);//历史记录
				$fck->addencAdd(10800, $voo['user_id'], $md, 8);//历史记录
				$fck->addencAdd(10801, $voo['user_id'], $md, 8);//历史记录


				/************T050业务逻辑***********/
			//	$fck->dsfenhong($voo['cpzj']*$bili);  //董事分红


				//添加团队业绩
				$map = array();
				$map['id'] = array('in',$voo['re_path']);
			    $f =	$fck->where($map)->setInc('team_yj',$voo['cpzj']*$bili);

			  //  echo $f=M()->getLastSql();


				$fck->shjifen($voo['user_id'],$voo['re_path'],$voo['cpzj']*$bili);   //级差奖结算

				$fck->xiaoshoujiang($voo['id'],$voo['user_id'],$voo['cpzj'],$voo['cpzj_level'],$voo['cpzj']*$bili,$voo['u_level'],$voo['father_id'],$voo['re_id'],$voo['re_path'],$voo['p_path'],$nowdate);  //销售奖


				$fck->dsfenhong($voo['cpzj']*$bili);  // 董事分红


				$fck->dailiLevel($voo['re_path']);  // 代理级别
				$fck->dongshiLevel($voo['re_path']);  // 董事级别


			//	$fck->fuwuyj($voo['id'],$voo['user_id'],$voo['cpzj'],$voo['cpzj_level'],$voo['cpzj']*$bili,$voo['u_level'],$voo['father_id'],$voo['re_id'],$voo['re_path'],$voo['p_path'],$nowdate);  //服务佣金




			/*
						$g = array();
			//	$g['u_level']=array('egt',3);
				$g['u_level'] = array(array('egt',3),array('elt',6), 'and') ;
				$jiancha=M('fck')->where($g)->select();

				if($jiancha) {
					$fck->jifen($voo['id'], $voo['user_id'], $voo['cpzj'], $voo['cpzj_level'], $voo['cpzj'] * $bili, $voo['u_level'], $voo['father_id'], $voo['re_id'], $voo['re_path'], $voo['p_path'], $nowdate);  //市场积分
				}


				*/


				$fck->shichangyj($voo['id'],$voo['user_id'],$voo['cpzj'],$voo['cpzj_level'],$voo['cpzj']*$bili,$voo['u_level'],$voo['father_id'],$voo['re_id'],$voo['re_path'],$voo['p_path'],$nowdate);  //市场业绩

				/************T050业务逻辑***********/





				//统计单数
			//	$fck->xiangJiao($voo['id'], $voo['f4'], $voo['id']);
				
				//算出奖金
			//	$fck->getusjj($voo['id']);

			//	$fck->benqi($voo['id'],$voo['shop_id'],$voo['cpzj']);

			//	$fck->jiandian($voo['user_id']);

				// 显示购物
				M('gouwu')->where('uid='.$voo['id'])->setField('lx',1);
                                
                                //网络费
//				$fck->wlf($voo['id'],$voo['user_id']);

				// $this->addyj($voo['id'],$voo['cpzj']);

//				$f_numb = $s4[$voo['u_level']-1];
//				$card->fafang_card($voo['id'],$voo['user_id'],$f_numb);
					
			}
			unset($fck,$field,$where,$vo);
			$bUrl = __URL__.'/auditMenber';
			$this->_box(1,'开通会员成功！',$bUrl,1);
			exit;
		}else{
			$this->error('错误！');
			exit;
		}
	}
	private function _auditMenberDelUser($PTid=0){
		//删除会员
		if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao'){
			$fck = M ('fck');
			$ispay = M('ispay');
			$where['is_pay'] = 0;
//			$where['id'] = array ('in',$PTid);
			foreach($PTid as $voo){
				$rs = $fck -> find($voo);
				if($rs){
					$whe['father_name'] = $rs['user_id'];
					$rss = $fck -> where($whe) -> find();
					if($rss){
						$bUrl = __URL__.'/auditMenber';
						$this -> error('该 '. $rs['user_id'] .' 会员有下级会员，不能删除！');
						exit;
					}else{
		            	$where['id'] = $voo;
			            $a= $fck->where($where)->delete();
			            	$bUrl = __URL__.'/auditMenber';
						$this->_box(1,'删除会员！',$bUrl,1);
					}
				}else{
					$this->error('错误!');
				}
			}

//			$rs = $fck->where($where)->delete();
//			if ($rs){
//				$bUrl = __URL__.'/auditMenber';
//				$this->_box(1,'删除会员！',$bUrl,1);
//				exit;
//			}else{
//				$bUrl = __URL__.'/auditMenber';
//				$this->_box(0,'删除会员！',$bUrl,1);
//				exit;
//			}
		}else{
			$this->error('错误!');
		}
	}
//会员管理
	public function adminMenber($GPid=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){


           $fee=M('fee')->find(1);
           $str28 = explode('|',$fee['str28']);
		   $this->assign('level',$str28);


			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];
			$ss_type = (int) $_REQUEST['type'];
			
			$map = 'is_pay > 0';
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
// 				$where['nickname'] = array('like',"%".$UserID."%");
// 				$where['user_id'] = array('like',"%".$UserID."%");
// 				$where['_logic']    = 'or';
// 				$map['_complex']    = $where;
                                $map .= " and (user_name like '%".$UserID."%') or (user_id like '%".$UserID."%')";
				$UserID = urlencode($UserID);
			}




            $u_type = $_POST['u_type'];
            $state_type = $_POST['state_type'];
            if(!empty($u_type)){
                $u_type = $u_type == 'a' ? 0 : $u_type;
                $map .= " and cp_time=".$u_type;
            }
            if(!empty($state_type)){
                if($state_type == 1){
                    $map .= " and pdt<".  time() . '-(cp_time*30*86400)';
                }
                else{
                    $map .= " and pdt>".  time() . '-(cp_time*30*86400)';
                }
                $map .= " and cp_time>0";
                
            }

            $uLevel = (int)$_POST['u_level'];
            switch ($uLevel) {
               	case '1':
               		$map .= " and u_level=1";
               		break;
               	case '2':
               		$map .= " and u_level=2";
               		break;
               	case '3':
               		$map .= " and is_agent=2";
               		break;
               	case '4':
               		$map .= " and is_company=2";
               		break;
               	default:
               		break;
               }


			
			$R_UserID =  $_REQUEST['RID'];
			$sdata = strtotime($_REQUEST['sNowDate']);
			$edata = strtotime($_REQUEST['endNowDate']);
			
			if(!empty($sdata)){
				$map .=  ' and pdt >='.$sdata;
			}
			
			if(!empty($edata)){
				$enddata = $edata + 24*3600-1;
				$map .=  ' and pdt <'.$enddata;
			}
			if(!empty($R_UserID)){
				$map .=  " and re_name='$R_UserID'";
			}
			if ($_SESSION[C('USER_AUTH_KEY')] != 1) {
				$map .= ' and id!=1';
			}

			$open_type = $_REQUEST['open_type'];
			if ($open_type === null) { // 没有传open_type，看传不传open_type
				$open_type_name = $_POST['open_type_name'];
				switch ($open_type_name) {
					case '后台开通':
						$open_type = 0;
						break;
					case '现金币开通':
						$open_type = 1;
						break;
					case '注册积分开通':
						$open_type = 2;
						break;
					default:
						$open_type = -1;
						break;
				}
				
			}
			$this->assign('open_type',$open_type);





// 			$map['is_pay'] = array('egt',1);
			if ($open_type != -1) {
				$map .= ' and open_type='.$open_type;
			}
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
       		$listrows = 5000;//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&sNowDate=' . $sdata. '&endNowDate=' . $edata. '&RID=' . $R_UserID. '&open_type=' . $open_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();
			
            $f4_count =  $fck->where($map)->sum('cpzj');
            $this->assign('f4_count',$f4_count);
            
            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别

            $shoplx = "";
	    	$this->_levelShopConfirm($shoplx);
	    	$this->assign('shoplx',$shoplx);






	    	$this->_getLevelConfirm($getLevel);
	    	$this->assign('getLevel',$getLevel);


            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
            $fee = M ('fee');
            $fee_s = $fee->field('s9')->find();
            $s9 = explode('|',$fee_s['s9']);
            $this->assign('s9',$s9);

			 $this->assign('id',$_SESSION[C('USER_AUTH_KEY')]);
			$title = '会员管理';
			$this->assign('title',$title);
			$this->_levelShopConfirm($lvArr);
			$this->assign('lvArr',$lvArr);
			$this->display ('adminMenber');
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}



	public function adminBenzhou($GPid=0)
	{
		//列表过滤器，生成查询Map对像
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {


			$start = date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y")));
			$end = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")));
			$less =  strtotime($start);
			$more =  strtotime($end);
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$benqi =M('benqi');
			$where['adt'] = array(array('EGT',$less),array('ELT',$more),'AND');
			// $where['shop_id'] = array('eq',$id);

			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $benqi->where($where)->count();//总页数
			$money = $benqi->where($where)->sum('money');//总页数
			$listrows = 5000;//每页显示的记录数
			$page_where = '';//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $benqi->where($where)->order('adt desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);
			$this->assign('money',$money);
			$this->display();

			return;
		}else{
			$this->error('数据错误!');
			exit;
		}





	}

			public function adminCenter($GPid=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){


			$fee=M('fee')->find(1);
			$s4 = explode('|',$fee['s4']);
			$this->assign('level',$s4);


			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];

			if($UserID){
				$map['user_id']=array('eq',$UserID);

			}


			$map['is_agent']=array('eq',2);
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $fck->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$listrows = 5000;//每页显示的记录数
			$page_where = '';//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板



			$list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();



			$f4_count =  $fck->where($map)->sum('cpzj');
			$this->assign('f4_count',$f4_count);

			$HYJJ = '';
			$this->_levelConfirm($HYJJ,1);
			$this->assign('voo',$HYJJ);//会员级别

			$shoplx = "";
			$this->_levelShopConfirm($shoplx);
			$this->assign('shoplx',$shoplx);






			$this->_getLevelConfirm($getLevel);
			$this->assign('getLevel',$getLevel);


			$this->assign('list',$list);//数据输出到模板
			//=================================================

			$fee = M ('fee');
			$fee_s = $fee->field('s9')->find();
			$s9 = explode('|',$fee_s['s9']);
			$this->assign('s9',$s9);

			$this->assign('id',$_SESSION[C('USER_AUTH_KEY')]);
			$title = '会员管理';
			$this->assign('title',$title);
			$this->_levelShopConfirm($lvArr);
			$this->assign('lvArr',$lvArr);
			$this->display ();
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}






	public function ok($GPid=0){


			$fee=M('fee')->find(1);
			$s4 = explode('|',$fee['s4']);
			$this->assign('level',$s4);


			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];

			if($UserID){
				$map['user_id']=array('eq',$UserID);

			}

             if($_GET['shop_id'] != null){
				 $map['shop_id']=array('eq',$_GET['shop_id']);
				 $this->assign('shop_id',$_GET['shop_id']);
			 }else{
				 $map['shop_id']=array('eq',$_POST['shop_id']);
				 $this->assign('shop_id',$_POST['shop_id']);
			 }



			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $fck->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$listrows = 5000;//每页显示的记录数
			$page_where = '';//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板



			$list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();

         //   echo $list=M()->getLastSql();

			$f4_count =  $fck->where($map)->sum('cpzj');
			$this->assign('f4_count',$f4_count);

			$HYJJ = '';
			$this->_levelConfirm($HYJJ,1);
			$this->assign('voo',$HYJJ);//会员级别

			$shoplx = "";
			$this->_levelShopConfirm($shoplx);
			$this->assign('shoplx',$shoplx);




			$this->_getLevelConfirm($getLevel);
			$this->assign('getLevel',$getLevel);


			$this->assign('list',$list);//数据输出到模板
			//=================================================

			$fee = M ('fee');
			$fee_s = $fee->field('s9')->find();
			$s9 = explode('|',$fee_s['s9']);
			$this->assign('s9',$s9);

			$this->assign('id',$_SESSION[C('USER_AUTH_KEY')]);
			$title = '会员管理';
			$this->assign('title',$title);
			$this->_levelShopConfirm($lvArr);
			$this->assign('lvArr',$lvArr);
			$this->display ();


	}






	//1111111111
	public function adminMenberUse($GPid=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];
			$ss_type = (int) $_REQUEST['type'];
			
			$map = 'is_pay > 0';
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                                $KuoZhan = new KuoZhan();
                                if ($KuoZhan->is_utf8($UserID) == false){
                                    $UserID = iconv('GB2312','UTF-8',$UserID);
                                }
                                unset($KuoZhan);
// 				$where['nickname'] = array('like',"%".$UserID."%");
// 				$where['user_id'] = array('like',"%".$UserID."%");
// 				$where['_logic']    = 'or';
// 				$map['_complex']    = $where;
                                $map .= " and (nickname like '%".$UserID."%') or (user_id like '%".$UserID."%')";
				$UserID = urlencode($UserID);
			}
            $u_type = $_POST['u_type'];
            $state_type = $_POST['state_type'];
            if(!empty($u_type)){
                $u_type = $u_type == 'a' ? 0 : $u_type;
                $map .= " and cp_time=".$u_type;
            }
            if(!empty($state_type)){
                if($state_type == 1){
                    $map .= " and pdt<".  time() . '-(cp_time*30*86400)';
                }
                else{
                    $map .= " and pdt>".  time() . '-(cp_time*30*86400)';
                }
                $map .= " and cp_time>0";
                
            }

            $uLevel = (int)$_POST['u_level'];
            switch ($uLevel) {
               	case '1':
               		$map .= " and u_level=1";
               		break;
               	case '2':
               		$map .= " and u_level=2";
               		break;
               	case '3':
               		$map .= " and is_agent=2";
               		break;
               	case '4':
               		$map .= " and is_company=2";
               		break;
               	default:
               		break;
               }           
			
			$R_UserID =  $_REQUEST['RID'];
			$sdata = strtotime($_REQUEST['sNowDate']);
			$edata = strtotime($_REQUEST['endNowDate']);
			
			if(!empty($sdata)){
				$map .=  ' and pdt >='.$sdata;
			}
			
			if(!empty($edata)){
				$enddata = $edata + 24*3600-1;
				$map .=  ' and pdt <'.$enddata;
			}
			if(!empty($R_UserID)){
				$map .=  " and re_name='$R_UserID'";
			}
			if ($_SESSION[C('USER_AUTH_KEY')] != 1) {
				$map .= ' and id!=1';
			}
// 			$map['is_pay'] = array('egt',1);
			$map .= ' and open_type=1';
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
       		$listrows = 5000;//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&sNowDate=' . $sdata. '&endNowDate=' . $edata. '&RID=' . $R_UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();
		
            $f4_count =  $fck->where($map)->sum('cpzj');
            $this->assign('f4_count',$f4_count);
            
            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别

            $shoplx = "";
	    	$this->_levelShopConfirm($shoplx);
	    	$this->assign('shoplx',$shoplx);

	    	$this->_getLevelConfirm($getLevel);
	    	$this->assign('getLevel',$getLevel);


            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
            $fee = M ('fee');
            $fee_s = $fee->field('s9')->find();
            $s9 = explode('|',$fee_s['s9']);
            $this->assign('s9',$s9);

			 $this->assign('id',$_SESSION[C('USER_AUTH_KEY')]);
			$title = '会员管理';
			$this->assign('title',$title);
			$this->_levelShopConfirm($lvArr);
			$this->assign('lvArr',$lvArr);
			$this->display ('adminMenberUse');
			return;
		}else{
			$this->error('数据错误!');
			exit;
		}
	}

	//Ip白名单
	public function Ip($GPid=0){
		//列表过滤器，生成查询Map对像
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){

			$ip=M('ip');
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $ip->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$listrows = 5000;//每页显示的记录数
			$page_where = '';//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $ip->order('pdt desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);//数据输出到模板

			$this->display ();

        }else{
            $this->error('权限错误!');
        }
    }


	public function Ipadd(){
		$data['ip_address'] = $_POST['ip_address'];
		$data['pdt'] = time();
		$l=M('ip')->add($data);
		if($l){
			$this->success("添加成功");
		}

	}

	public function ip_del(){
       $id = $_GET['id'];
	   $l=M('ip')->where('id='.$id)->delete();
       if($l){
		  $this->success("删除成功");
	   }

	}


	public function premAdd(){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$id = (int) $_GET['id'];
			$table = M ('fck');
			$rs = $table -> field('id,is_boss,prem') ->find($id);
			if ($rs){
				$ars = array();
				$arr = explode(',',$rs['prem']);
				for ($i=1;$i<=30;$i++){
					if (in_array($i,$arr)){
						$ars[$i] = "checked";
					}else{
						$ars[$i] = "";
					}
				}
				$this->assign('ars',$ars);
				$this->assign('rs',$rs);
				$title = '修改权限';
			}else{
				$title = '添加权限';
			}
			$this->assign('open_type',(int)$_GET['open_type']);
			$this->assign('title',$title);
			$this->display('premAdd');
		}else{
			$this->error('权限错误!');
		}
	}




	public function premAddSave(){
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
            $id = (int) $_POST['id'];
            if ($id == 1 && $_SESSION[C('USER_AUTH_KEY')] != 1){
                $this->error('不能修改该会员的权限!');
                exit;
            }
            $table = M ('fck');
            $is_boss = $_POST['is_boss'];
            $boss = $_POST['isBoss'];
            $arr = ',';
            if (is_array($is_boss)){
                foreach ($is_boss as $vo){
                    $arr .= $vo.',';
                }
            }
            $data = array();
            $data['is_boss'] = $boss;
            $data['prem'] = $arr;
         //   $data['id'] = $id;
//            if ($id == 1){
//            	$this->error('不能修改最高会员！');
//            }
            $user = $table->where('id='.$id)->save($data);
			
            $title = '修改权限';
            $open_type = (int)$_POST['open_type'];
            $bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
            $this->_box(1,$title,$bUrl,2);
        }else{
            $this->error('权限错误!');
        }
    }

	//显示劳资详细
	public function BonusShow($GPid=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$hi = M ('history');

			$where = array();
			$where['Uid']   = $_REQUEST['PT_id'];
			$where['type'] = 19;

			$list = $hi -> where($where) -> select();
			$this -> assign('list',$list);
			$this->display ('BonusShow');
		}else{
			$this->error('数据错误!');
			exit;
		}
	}


	public function adminuserData() {
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle' || $_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao'){
			//查看会员详细信息
			$fck = M ( 'fck' );
			$ID = (int) $_GET['PT_id'];
			//判断获取数据的真实性 是否为数字 长度
			if (strlen($ID) > 15){
				$this->error ('数据错误!');
				exit;
			}
			$where = array();


			$fee=M('fee')->find(1);
			$str28=explode('|',$fee['str28']);
			$this->assign('s4',$str28);

			//查询条件
			//$where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $ID;

			if ($_SESSION[C('USER_AUTH_KEY')] !=1 && $ID==1) {
				$this->error("没有权限");
			}
			$isAdmin = $_SESSION[C('USER_AUTH_KEY')] == 1 ? 1 : 0;
			$this->assign('isAdmin',$isAdmin);

			$field ='*';
			$vo = $fck ->where($where)->field($field)->find();
			if ($vo){
				$this->assign ('vo',$vo);

				$fee = M ('fee');
				$fee_s = $fee->field('str29')->find();
				$bank = explode('|',$fee_s['str29']);
				$this->assign('bank',$bank);
				$this->assign('b_bank',$vo);

				$this->display ();
			}else{
				$this->error ('数据错误!');
				exit;
			}
		}else{
			$this->error ('数据错误!');
			exit;
		}
	}



	public function adminuserDataSave() {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle' || $_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao'){
            $fck     =   M('fck');
            if(!$fck->autoCheckToken($_POST)) {
                $this->error('页面过期，请刷新页面！');
            }




            $ID = (int) $_POST['ID'];
            $data = array();
            $data['pwd1']             = trim($_POST['pwd1']);      //一级密码不加密
			$data['pwd2']             = trim($_POST['pwd2']);
			$data['pwd3']             = trim($_POST['pwd3']);
			$data['password']         = md5(trim($_POST['pwd1'])); //一级密码加密
			$data['passopen']         = md5(trim($_POST['pwd2']));
			$data['passopentwo']      = md5(trim($_POST['pwd3']));

			if ($_SESSION[C('USER_AUTH_KEY')] !=1 && $ID==1) {
				$this->error("没有权限");
			}

			$wenti = trim($_POST['wenti']);
			$wenti_dan = trim($_POST['wenti_dan']);
			if(!empty($wenti)){
          		$data['wenti']         = $wenti;
			}
			if(!empty($wenti_dan)){
          		$data['wenti_dan']     = $wenti_dan;
			}


            $data['nickname']         = $_POST['NickName'];
            $data['bank_name']        = $_POST['BankName'];
            $data['bank_card']        = $_POST['BankCard'];
            $data['user_name']        = $_POST['UserName'];
            $data['bank_province']    = $_POST['BankProvince'];
            $data['bank_city']        = $_POST['BankCity'];
            $data['bank_address']     = $_POST['BankAddress'];
            $data['user_code']        = $_POST['UserCode'];

			$data['province']        = $_POST['province'];
			$data['city']        = $_POST['city'];
			$data['address']        = $_POST['address'];


//             $data['user_address']     = $_POST['UserAddress'];
//            $data['user_post']        = $_POST['UserPost'];
//            $data['user_phone']       = $_POST['user_phone'];//邮编
            $data['user_tel']         = $_POST['UserTel'];
			$data['get_address']         = $_POST['get_address'];
//            $data['is_lock']          = $_POST['isLock'];
            $data['qq']          = $_POST['qq'];
//             $data['email']          = $_POST['email'];
            if ($_SESSION[C('USER_AUTH_KEY')] == 1) {
	            $data['agent_use']          = $_POST['AgentUse'];
	            $data['agent_cash']          = $_POST['AgentCash'];
            }
            $data['zjj']			  = $_POST['zjj'];
            $data['id']               = $_POST['ID'];

			$data['agent_kt']				= $_POST['AgentKt'];
			$data['agent_xf']				= $_POST['agent_xf'];
			$data['agent_gp']				= $_POST['AgentGp'];
			$data['agent_gc']				= $_POST['AgentGc'];
			$data['agent_cf']				= $_POST['AgentCf'];
			$data['u_level']				= $_POST['u_level'];
			$data['gp_num']				= (int)$_POST['gp_num'];

			$data['wang_j']               = (int)$_POST['wang_j'];
			$data['wang_t']               = (int)$_POST['wang_t'];


//            $data['u_level']          = $_POST['uLevel'];
//            if ($_POST['ID'] == 1){
//                $data['is_boss'] = 1;
//            }else{
//                $data['is_boss'] = $_POST['isBoss'];
//            }
            //$data['agent_use'] = $_POST['AgentUse'];
            //$data['agent_cash'] = $_POST['AgentCash'];
//            $ReName = $_POST['ReName'];
//            $re_where = array();
//            $where = array();
//            $where['nickname']  = $ReName;
//            $where['user_id']   = $ReName;
//            $where['_logic']    = 'or';
//            $re_where['_complex']    = $where;
//            $re_fck_rs = $fck->where($re_where)->field('id,nickname,user_id')->find();
//            if ($re_fck_rs){
//					if ($ID == 1){
//							$data['re_id'] = 0;
//							$data['re_name'] = 0;
//					}else{
//							$data['re_id'] = $re_fck_rs['id'];
//							$data['re_name'] = $re_fck_rs['user_id'];
//					}
//			}else{
//					if ($ID != 1 ){
//						 $this->error('推荐人不存在，请重新输入！');
//						exit;
//					}
//			}


//            $p_shop = $_POST['p_shop'];
//            $c_shop = $_POST['c_shop'];
//            $a_shop = $_POST['a_shop'];
//            $p_shop_id = 0;
//            if (!empty($p_shop)){
//                $p_where = array();
//                $p_where['nickname'] = $p_shop;
//                $p_where['is_agent'] = 2;
//                $p_where['shoplevel'] = 3;
//                $p_rs = $fck->where($p_where)->field('id,nickname,shop_path')->find();
//                if (!$p_rs){
//                    $this->error('省级代理不存在，请重新输入！');
//                    exit;
//                }
//                $p_shop_id = $p_rs['id'];
//            }
//            $c_shop_id = 0;
//            if (!empty($c_shop)){
//                $p_where = array();
//                $p_where['nickname'] = $c_shop;
//                $p_where['is_agent'] = 2;
//                $p_where['shoplevel'] = 2;
//                $p_rs = $fck->where($p_where)->field('id,nickname,shop_path')->find();
//                if (!$p_rs){
//                    $this->error('市级代理不存在，请重新输入！');
//                    exit;
//                }
//                $c_shop_id = $p_rs['id'];
//            }
//            $a_shop_id = 0;
//            if (!empty($a_shop)){
//                $p_where = array();
//                $p_where['nickname'] = $a_shop;
//                $p_where['is_agent'] = 2;
//                $p_where['shoplevel'] = 1;
//                $p_rs = $fck->where($p_where)->field('id,nickname,shop_path')->find();
//                if (!$p_rs){
//                    $this->error('县级代理不存在，请重新输入！');
//                    exit;
//                }
//                $a_shop_id = $p_rs['id'];
//            }
//            $where_nic = array();
//            $where_nic['nickname'] = $data['nickname'];
//            $rs = $fck -> where($where_nic) -> find();
//            if($rs){
//                if($rs['id'] != $data['id']){
//                    $this->error ('该会员编号已经存在!');
//                    exit;
//                }
//            }
//            $where = array();
//            $id = $_SESSION[C('USER_AUTH_KEY')];
//            $where['id'] = $data['id'];
//            $frs = $fck->where($where)->field('id,user_id,password,passopen,p_shop,c_shop,a_shop')->find();
//            if ($frs){
//                if ($frs['p_shop'] != $p_shop_id){
//                    $data['p_shop'] = $p_shop_id;
//                }
//                if ($frs['c_shop'] != $c_shop_id){
//                    $data['c_shop'] = $c_shop_id;
//                }
//                if ($frs['a_shop'] != $a_shop_id){
//                    $data['a_shop'] = $a_shop_id;
//                }
//
//                if ($_POST['Password']!= $frs['password']){
//                    $data['password'] = md5($_POST['Password']);
//                    if ($id == $data['id']){
//                        $_SESSION['login_sf_list_u'] = md5($frs['user_id']. ALL_PS .$data['password'].$_SERVER['HTTP_USER_AGENT']);
//                    }
//                }
//                if ($_POST['PassOpen'] != $frs['passopen']){
//                    $data['passopen'] = md5($_POST['PassOpen']);
//                }
//            }
            $result =   $fck->save($data);






            if($result) {
                $bUrl = __URL__.'/adminMenber';
                $this->_box(1,'资料修改成功！',$bUrl,1);
                exit;
            }else{
                $bUrl = __URL__.'/adminMenber';
                $this->_box(0,'资料修改失败！',$bUrl,1);
            }
        }else{
            $bUrl = __URL__.'/adminMenber';
            $this->_box(0,'数据错误！',$bUrl,1);
            exit;
        }
    }


	public function slevel() {
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle'){
			//查看会员详细信息
			$fck = M ( 'fck' );
			$ID = (int) $_GET['PT_id'];
			//判断获取数据的真实性 是否为数字 长度
			if (strlen($ID) > 15){
				$this->error ('数据错误!');
				exit;
			}
			$where = array();
			//查询条件
			//$where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $ID;
			$field ='*';
			$vo = $fck ->where($where)->field($field)->find();
			if ($vo){
				$this->assign ( 'vo', $vo );
				$this->display ();
			}else{
				$this->error ('数据错误!');
				exit;
			}
		}else{
			$this->error ('数据错误!');
			exit;
		}
	}
	public function slevelsave() {  //升级保存数据
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle'){
			//查看会员详细信息
			$fck = D ('Fck');
			$fee = M ('fee');
			$ID = (int) $_POST['ID'];
			$slevel = (int) $_POST['slevel'];  //升级等级

			//判断获取数据的真实性 是否为数字 长度
			if (strlen($ID) > 15 or $ID <= 0){
				$this->error ('数据错误!');
				exit;
			}

			$fee_rs = $fee -> find(1);
			if( $slevel <= 0 or $slevel >= 7){
				$this->error('升级等级错误！');
				exit;
			}

			$where = array();
			//查询条件
			//$where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $ID;
			$field ='*';
			$vo = $fck ->where($where)->field($field)->find();
			if($vo){
				switch($slevel){  //通过注册等级从数据库中找出注册金额及认购单数
					case 1:
						 $cpzj = $fee_rs['uf1'];  //注册金额
						 $F4 = $fee_rs['jf1'];    //自身认购单数
						 break;
					case 2:
						 $cpzj = $fee_rs['uf2'];
						 $F4 = $fee_rs['jf2'];
						 break;
					case 3:
						 $cpzj = $fee_rs['uf3'];
						 $F4 = $fee_rs['jf3'];
						 break;
					case 4:
						 $cpzj = $fee_rs['uf4'];
						 $F4 = $fee_rs['jf4'];
						 break;
					case 5:
						 $cpzj = $fee_rs['uf5'];
						 $F4 = $fee_rs['jf5'];
						 break;
					case 6:
						 $cpzj = $fee_rs['uf6'];
						 $F4 = $fee_rs['jf6'];
						 break;
				}

				$number = $F4 - $vo['f4'];  //升级所需单数差
				$data = array();
				$data['u_level'] = $slevel;  // 升级等级
				$data['cpzj'] = $cpzj;     // 注册金额
				$data['f4'] = $F4;       // 自身认购单数
				$fck -> where($where) -> data($data) -> save();

				$fck->xiangJiao_lr($ID,$number);//住上统计单数

				$bUrl = __URL__.'/adminMenber';
				$this->_box(1,'会员升级！',$bUrl,1);
				exit;
			}else{
				$this->error ('数据错误!');
				exit;
			}
		}else{
			$this->error ('数据错误!');
			exit;
		}
	}
	public function adminMenberAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		$open_type = $_POST['open_type'];
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/adminMenber';
			$this->_box(0,'请选择会员！',$bUrl,1);
			exit;
		}
		switch ($action){
			case '解锁会员';
				$this->_adminMenberOpen($PTid,$open_type );
				break;
			case '锁定会员';
				$this->_adminMenberLock($PTid,$open_type );
				break;
			case '开启会员';
				$this->_adminMenberOpenZZ($PTid,$open_type );
				break;
			case '锁定会员';
				$this->_adminMenberLockZZ($PTid,$open_type );
				break;
			case '开启会员';
				$this->_adminMenberOpenTX($PTid,$open_type );
				break;
			case '锁定会员';
				$this->_adminMenberLockTX($PTid,$open_type );
				break;

			case '解锁升级';
				$this->_adminMenberJs($PTid,$open_type );
				break;

//			case '奖金提现';
//				$this->adminMenberCurrency($PTid );
//				break;
			case '开启奖金';
				$this->adminMenberFenhong($PTid,$open_type );
				break;
//			case '删除会员';
//				$this->adminMenberDel($PTid );
//				break;
			case '关闭奖金';
				$this->_Lockfenh($PTid,$open_type );
				break;
//			case '开启打卡奖';
//				$this->_OpenQd($PTid );
//				break;
//			case '关闭打卡奖';
//				$this->_LockQd($PTid );
//				break;
			case '开启分红奖';
				$this->_OpenFh($PTid,$open_type );
				break;
			case '关闭分红奖';
				$this->_LockFh($PTid,$open_type );
				break;
//			case '奖金转注册积分';
//				$this->adminMenberZhuan($PTid );
//				break;
			case '设为服务中心';
				$this->_adminMenberAgent($PTid,$open_type );
				break;
			// case '设为分公司';
			// 	$this->_adminMenberCompany($PTid );
			// 	break;
			// case '设为代理商';
			// 	$this->_adminMenberLevel2($PTid );
			// 	break;
		default;
			$bUrl = __URL__.'/adminMenber';
			$this->_box(0,'没有该会员！',$bUrl,1);
			break;
		}
	}






	public function adminMenberDL(){

		if($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$result=$fck->execute('update __TABLE__ set agent_cash=agent_cash+agent_use,agent_use=0 where is_pay>0');

			$bUrl = __URL__.'/adminMenber';
			$this->_box(1,'转换会员奖金为注册积分！',$bUrl,1);

		}else{
			$this->error('错误2!');
		}
	}

	public function adminMenberZhuan($PTid=0){

		if($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->field('id')->select();
			foreach($rs as $vo){
				$myid=$vo['id'];
				$fck->execute('update __TABLE__ set agent_cash=agent_cash+agent_use,agent_use=0 where is_pay>0 and id='.$myid.'');
			}
			unset($fck,$where,$rs,$myid,$result);
			$bUrl = __URL__.'/adminMenber';
			$this->_box(1,'转换会员奖金为注册积分！',$bUrl,1);

		}else{
			$this->error('错误2!');
		}
	}

	private function adminMenberDel($PTid=0){
		if($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$times = M ('times');
			$bonus = M ('bonus');
			$history = M ('history');
			$chongzhi = M ('chongzhi');
			$gouwu = M ('gouwu');
			$tiqu = M ('tiqu');
			$zhuanj = M ('zhuanj');

			foreach($PTid as $voo){
				$rs = $fck -> find($voo);
				if($rs){
					$id = $rs['id'];
					$whe['id'] = $rs['father_id'];
					$con = $fck ->where($whe)->count();
					if($id == 1){
						$bUrl = __URL__.'/adminMenber';
						$this -> error('该 '. $rs['user_id'] .' 不能删除！');
						exit;
					}
					if($con==2){
						$bUrl = __URL__.'/adminMenber';
						$this -> error('该 '. $rs['user_id'] .' 会员有下级会员，不能删除！');
						exit;
					}
					if($con==1){
						$this->set_Re_Path($id);
						$this->set_P_Path($id);
					}
					$where = array();
					$where['id'] = $voo;
					$map['uid'] = $voo;
					$bonus->where($map) -> delete();
					$history->where($map) -> delete();
					$chongzhi->where($map) -> delete();
					$times->where($map) -> delete();
					$tiqu->where($map) -> delete();
					$zhuanj->where($map) -> delete();
					$gouwu->where($map) -> delete();
					$fck->where($where)->delete();
					$bUrl = __URL__.'/adminMenber';
					$this->_box(1,'删除会员！',$bUrl,1);
				}
			}
		}else{
			$this->error('错误!');
		}
	}


	public function set_Re_Path($id){
		$fck = M("fck");
		$frs = $fck -> find($id);

		$r_rs = $fck -> find($frs['re_id']);
		$xr_rs = $fck ->where("re_id=".$id)-> select();
		foreach($xr_rs as $xr_vo){
			$re_Level = $r_rs['re_level'] + 1;
			$re_path = $r_rs['re_path'].$r_rs['id'].',';
			$fck->execute("UPDATE __TABLE__ SET re_id=".$r_rs['id'].",re_name='".$r_rs['user_id']."',re_path='".$re_path."',re_level=".$re_Level." where `id`= ".$xr_vo['id']);
			//修改推荐路径
			$f_where = array();
			$f_where['re_path'] = array('like','%,'.$xr_vo['id'].',%');
			$ff_rs = $fck->where($f_where)->order('re_level asc')->select();
			$r_where = array();
			foreach($ff_rs as $fvo){
				$r_where['id'] = $fvo['re_id'];
				$sr_rs = $fck->where($r_where)->find();
				$r_pLevel = $sr_rs['re_level'] + 1;
				$r_re_path = $sr_rs['re_path'].$sr_rs['id'].',';
				$fck->execute("UPDATE __TABLE__ SET re_path='".$r_re_path."',re_level=".$r_pLevel." where `id`= ".$fvo['id']);
			}
		}
	}

	public function set_P_Path($id){
		$fck = M("fck");
		$frs = $fck -> find($id);

		$r_rs = $fck -> find($frs['father_id']);
		$xr_rs = $fck ->where("father_id=".$id)-> find();
		if($xr_rs){
			$p_level = $r_rs['p_level'] + 1;
			$p_path = $r_rs['p_path'].$r_rs['id'].',';
			$fck->execute("UPDATE __TABLE__ SET treeplace=".$frs['treeplace'].",father_id=".$r_rs['id'].",father_name='".$r_rs['user_id']."',p_path='".$p_path."',p_level=".$p_level." where `id`= ".$xr_rs['id']);
			//修改推荐路径
			$f_where = array();
			$f_where['p_path'] = array('like','%,'.$xr_rs['id'].',%');
			$ff_rs = $fck->where($f_where)->order('p_level asc')->select();
			$r_where = array();
			foreach($ff_rs as $fvo){
				$r_where['id'] = $fvo['father_id'];
				$sr_rs = $fck->where($r_where)->find();
				$p_level = $sr_rs['p_level'] + 1;
				$p_path = $sr_rs['p_path'].$sr_rs['id'].',';
				$fck->execute("UPDATE __TABLE__ SET p_path='".$p_path."',p_level=".$p_level." where `id`= ".$fvo['id']);
			}
		}
	}

	public function jiandan($Pid=0,$DanShu=1,$pdt,$t_rs){
        //========================================== 往上统计单数
        $fck = M ('fck');
        $where = array();
        $where['id'] = $Pid;
        $field = 'treeplace,father_id,pdt';
        $vo = $fck ->where($where)->field($field)->find();
        if ($vo){
            $Fid = $vo['father_id'];
            $TPe = $vo['treeplace'];
			if($pdt>$t_rs){
				if ($TPe == 0 && $Fid > 0){
                	$fck->execute("update __TABLE__ Set `l`=l-$DanShu, `benqi_l`=benqi_l-$DanShu where `id`=".$Fid);
	            }elseif($TPe == 1 && $Fid > 0){
	                $fck->execute("update __TABLE__ Set `r`=r-$DanShu, `benqi_r`=benqi_r-$DanShu  where `id`=".$Fid);
	            }
			}else{
				if ($TPe == 0 && $Fid > 0){
                	$fck->execute("update __TABLE__ Set `l`=l-$DanShu where `id`=".$Fid);
	            }elseif($TPe == 1 && $Fid > 0){
	                $fck->execute("update __TABLE__ Set `r`=r-$DanShu  where `id`=".$Fid);
	            }
			}

            if ($Fid > 0) $this->jiandan($Fid,$DanShu,$pdt,$t_rs);
        }
        unset($where,$field,$vo,$pdt,$t_rs);
    }

	private function adminMenberFenhong($PTid=0,$open_type=0){
		if($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['id'] = array ('in',$PTid);
			$where['is_pay'] = array('gt',0);
			$rs = $fck->where($where)->setField('is_fenh','0');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'开启奖金成功！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'开启奖金失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}

	private function _Lockfenh($PTid=0,$open_type=0){
		//锁定会员
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['is_pay'] = array('egt',1);
			$where['_string'] = 'id>1';
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_fenh','1');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'关闭奖金成功！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'关闭奖金失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}

	//开启会员
	private function _adminMenberOpen($PTid=0,$open_type=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$fck2 = M ('fck2');
			$where['id'] = array ('in',$PTid);
			$data['is_pay'] = 1;
			$rs = $fck->where($where)->setField('is_lock','0');
			$rss = $fck->where($where)->setField('is_suo','0');
			$rss = $fck->where($where)->select();
			foreach($rss as $v){
				$wheres['user_id'] = array ('eq',$v['user_id']);
				$rsd = $fck2->where($wheres)->setField('is_suo','0');
				$rsds = $fck2->where($wheres)->setField('time','0');
			}

			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'解锁会员！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'解锁会员！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}
	private function _adminMenberLock($PTid=0,$open_type=0){
		//锁定会员
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$fck2 = M ('fck2');
			$where['is_pay'] = array('egt',1);
			$where['is_boss'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_lock','1');
			$rs = $fck->where($where)->setField('is_suo','1');
			$rss = $fck->where($where)->select();
			foreach($rss as $v){
				$wheres['user_id'] = array ('eq',$v['user_id']);
				$rsd = $fck2->where($wheres)->setField('is_suo','1');
				$rsds = $fck2->where($wheres)->setField('time','0');
			}



			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'锁定会员！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'锁定会员！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}


	private function _adminMenberJS($PTid=0,$open_type=0){
		//锁定会员
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');

			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_suo','0');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'会员已经解锁升级！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'会员解锁升级失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}



	//开启会员
	private function _adminMenberOpenZZ($PTid=0,$open_type=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['id'] = array ('in',$PTid);
			$data['is_pay'] = 1;
			$rs = $fck->where($where)->setField('is_zz','0');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'开启转账！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'开启转账！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}
	private function _adminMenberLockZZ($PTid=0,$open_type=0){
		//锁定转账
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['is_pay'] = array('egt',1);
			$where['is_boss'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_zz','1');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'锁定转账！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'锁定转账！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}

	//开启会员
	private function _adminMenberOpenTX($PTid=0,$open_type=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['id'] = array ('in',$PTid);
			$data['is_pay'] = 1;
			$rs = $fck->where($where)->setField('is_tx','0');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'开启提现！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'开启提现！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}
	private function _adminMenberLockTX($PTid=0,$open_type=0){
		//锁定提现
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['is_pay'] = array('egt',1);
			$where['is_boss'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_tx','1');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'锁定提现！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'锁定提现！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}

	//设为报单中心
	private function _adminMenberAgent($PTid=0,$open_type=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['id'] = array ('in',$PTid);
			$where['is_agent'] = array ('lt',1);
			// $rs2 = $fck->where($where)->setField('idt',time());
			$rs1 = $fck->where($where)->setField(array('is_agent'=>'2','idt'=>time(),'adt'=>time(),'shoplx'=>1));
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs1){
				$this->_box(1,'设置报单中心成功！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'设置报单中心失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}

	//设为分公司
	private function _adminMenberCompany($PTid=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['id'] = array ('in',$PTid);
			$where['is_company'] = array ('lt',2);
			$rs2 = $fck->where($where)->setField('company_pdt',time());
			$rs1 = $fck->where($where)->setField('is_company','2');
			if ($rs1){
				$bUrl = __URL__.'/adminMenber';
				$this->_box(1,'设置分公司成功！',$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminMenber';
				$this->_box(0,'设置分公司失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}

	//设为代理
	private function _adminMenberLevel2($PTid=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['id'] = array ('in',$PTid);
			$where['u_level'] = array ('eq',1);
			$data['dl_pdt'] = time();
			$data['u_level'] = 2;
			// $rs2 = $fck->where($where)->setField('dl_pdt',time());
			// $rs1 = $fck->where($where)->setField('u_level','2');
			$rs1 = $fck->where($where)->setField($data);
			if ($rs1){
				$bUrl = __URL__.'/adminMenber';
				$this->_box(1,'设置代理商成功！',$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminMenber';
				$this->_box(0,'设置代理商失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误！');
			exit;
		}
	}

	//开启打卡奖
	private function _OpenQd($PTid=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['is_lockqd'] = array('egt',1);
			$where['_string'] = 'id>1';
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_lockqd','0');
	
			if ($rs){
				$bUrl = __URL__.'/adminMenber';
				$this->_box(1,'开启打卡奖成功！',$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminMenber';
				$this->_box(0,'开启打卡奖失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}
	//关闭打卡奖
	private function _LockQd($PTid=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['is_lockqd'] = array('egt',0);
			$where['_string'] = 'id>1';
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_lockqd','1');
	
			if ($rs){
				$bUrl = __URL__.'/adminMenber';
				$this->_box(1,'关闭打卡奖成功！',$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminMenber';
				$this->_box(0,'关闭打卡奖失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}
	
	//开启分红奖
	private function _OpenFh($PTid=0,$open_type=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$nowday = strtotime(date('Y-m-d'));
			$where['is_lockfh'] = array('egt',1);
			$where['_string'] = 'id>1';
			$where['id'] = array ('in',$PTid);
			$varray = array(
				'is_lockfh'=>'0',
				'fanli_time'=>$nowday
			);
			$rs = $fck->where($where)->setField($varray);
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'开启分红奖成功！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'开启分红奖失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}
	//关闭分红奖
	private function _LockFh($PTid=0,$open_type=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where['is_lockfh'] = array('egt',0);
			$where['_string'] = 'id>1';
			$where['id'] = array ('in',$PTid);
			$rs = $fck->where($where)->setField('is_lockfh','1');
			$bUrl = __URL__.'/adminMenber/open_type/'.$open_type;
			if ($rs){
				$this->_box(1,'关闭分红奖成功！',$bUrl,1);
				exit;
			}else{
				$this->_box(0,'关闭分红奖失败！',$bUrl,1);
				exit;
			}
		}else{
			$this->error('错误!');
		}
	}



	//=================================================管理员帮会员提现处理
	public function adminMenberCurrency($PTid=0){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao'){
			$fck = M ('fck');
			$where = array();//
			$tiqu = M ('tiqu');
			//查询条件
			$where['id'] = array('in',$PTid);
			$where['agent_use'] = array('egt',100);
			$field ='id,user_id,agent_use,bank_name,bank_card,user_name';
			$fck_rs = $fck ->where($where)->field($field)->select();

			$data = array();
			$tiqu_where = array();
			$eB = 0.02;//提现税收
			$nowdate = strtotime(date('c'));
			foreach ($fck_rs as $vo){
				$is_qf = 0;//区分上次有没有提现
				$ePoints = 0;
				$ePoints = $vo['agent_use'];

				$tiqu_where['uid'] = $vo['id'];
				$tiqu_where['is_pay'] = 0;
				$trs = $tiqu ->where($tiqu_where)->field('id')->find();
				if ($trs){
					$is_qf = 1;
				}
				//提现税收
//				if ($ePoints >= 10 && $ePoints <= 100){
//					$ePoints1 = $ePoints - 2;
//				}else{
//					$ePoints1 = $ePoints - $ePoints * $eB;//(/100);
//				}

				if ($is_qf == 0){
					$fck->query("UPDATE `nnld_fck` SET `zsq`=zsq+agent_use,`agent_use`=0 where `id`=".$vo['id']);
					//开始事务处理
					$data['uid']            = $vo['id'];
					$data['user_id']        = $vo['user_id'];
					$data['rdt']            = $nowdate;
					$data['money']          = $ePoints;
					$data['money_two']      = $ePoints;
					$data['is_pay']         = 1;
					$data['user_name']      = $vo['user_name'];
					$data['bank_name']      = $vo['bank_name'];
					$data['bank_card']      = $vo['bank_card'];
					$tiqu->add($data);
				}
			}
			unset($fck,$where,$tiqu,$field,$fck_rs,$data,$tiqu_where,$eB,$nowdate);
			$bUrl = __URL__.'/adminMenber';
			$this->_box(1,'奖金提现！',$bUrl,1);
			exit;
		}else{
			$this->error('错误!');
			exit;
		}
	}

	//获取所有奖金名
	public function getBonusName()
	{
		$arr = array();
		for ($i=0; $i < 4; $i++) { 
			$arr[$i] = L('奖金'.($i+1));
		}
		return $arr;
	}

	//出纳管理
	public function adminFinance(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
			$times = M ('times');
			$field = '*';
			$where = 'is_count=0';
			$Numso = array();
			$Numss = array();

			$rs = $times->where($where)->field($field)->order('id desc')->find();
			$Numso['0'] = 0;
			$Numso['1'] = 0;
			$Numso['2'] = 0;
			if ($rs){
				// $eDate = strtotime(date('c'));  //time()
				$eDate = $rs['shangqi'] ;//开始时间
				$sDate = $rs['benqi'] ;//时间

				$this->MiHouTaoBenQi($eDate, $sDate, $Numso, 0);
				$this->assign('list3', $Numso);   //本期收入
				$this->assign('list4', $sDate);   //本期时间截
			}else{
				$this->assign('list3', $Numso);
			}

			// $fee = M('fee');
			// $fee_rs = $fee->field('s18')->find();
			// $fee_s7 = explode('|',$fee_rs['s18']);
			$fee_s7 = $this->getBonusName();
			$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组

            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $times->where($where)->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $rs = $times->where($where)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$rs);//数据输出到模板

			if ($rs){
				$occ = 1;
				$Numso['1'] = $Numso['1']+$Numso['0'];
				$Numso['3'] = $Numso['3']+$Numso['0'];
				foreach ($rs as $Roo){
					$eDate          = $Roo['benqi'];//本期时间
                    $sDate          = $Roo['shangqi'];//上期时间
					$Numsd          = array();
					$Numsd[$occ][0] = $eDate;
					$Numsd[$occ][1] = $sDate;

					$this->MiHouTaoBenQi($eDate,$sDate,$Numss,1);
					//$Numoo = $Numss['0'];   //当期收入
					$Numss[$occ]['0'] = $Numss['0'];
					$Dopp  = M ('bonus');
					$field = '*';
					$where = " s_date>= '".$sDate."' And e_date<= '".$eDate."' ";
					$rsc   = $Dopp->where($where)->field($field)->select();
					$Numss[$occ]['1'] = 0;

					foreach ($rsc as $Roc){
						$Numss[$occ]['1'] += $Roc['b0'] ;  //当期支出
						$Numb2[$occ]['1'] += $Roc['b1'];
						$Numb3[$occ]['1'] += $Roc['b2'];
						$Numb4[$occ]['1'] += $Roc['b3'];
						//$Numoo          += $Roc['b9'];//当期收入
					}
					$Numoo              = $Numss['0'];//当期收入
					$Numss[$occ]['2']   = $Numoo - $Numss[$occ]['1'];   //本期赢利
					$Numss[$occ]['3']   = substr( floor(($Numss[$occ]['1'] / $Numoo) * 100) , 0 ,3);  //本期拔比
					$Numso['1']        += $Numoo;  //收入合计
					$Numso['2']        += $Numss[$occ]['1'];           //支出合计
					$Numso['3']        += $Numss[$occ]['2'];           //赢利合计
					$Numso['4']         = substr( floor(($Numso['2'] / $Numso['1']) * 100) , 0 ,3);  //总拔比
					$Numss[$occ]['4']   = substr( ($Numb2[$occ]['1'] / $Numoo) * 100 , 0 ,4);  //小区奖金拔比
					$Numss[$occ]['5']   = substr( ($Numb3[$occ]['1'] / $Numoo) * 100 , 0 ,4);  //互助基金拔比
					$Numss[$occ]['6']   = substr( ($Numb4[$occ]['1'] / $Numoo) * 100 , 0 ,4); //管理基金拔比
					$Numss[$occ]['7']	= $Numb2[$occ]['1'];//小区奖金
					$Numss[$occ]['8'] 	= $Numb3[$occ]['1'] ;  //互助基金
					$Numss[$occ]['9'] 	= $Numb4[$occ]['1'];//管理基金
					$Numso['5']        += $Numb2[$occ]['1'];  //小区奖金合计
					$Numso['6']        += $Numb3[$occ]['1'];  //互助基金合计
					$Numso['7']        += $Numb4[$occ]['1'];  //管理基金合计
					$Numso['8']         = substr( ($Numso['5'] / $Numso['1']) * 100 , 0 ,4);  //小区奖金总拔比
					$Numso['9']         = substr( ($Numso['6'] / $Numso['1']) * 100 , 0 ,4);  //互助基金总拔比
					$Numso['10']         = substr( ($Numso['7'] / $Numso['1']) * 100 , 0 ,4);  //管理基金总拔比
					$occ++;
				}
			}

			$PP = $_GET['p'];
			$this->assign('PP',$PP);
			$this->assign('list1',$Numss);
			$this->assign('list2',$Numso);
			$this->assign('list5',$Numsd);
			$this->display('adminFinance');
		}else{
			$this->error('错误!');
			exit;
		}
	}

	//当期收入会员列表
    public function adminFinanceList(){
    	$this->_Admin_checkUser();
        if ($_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
            $shouru = M('shouru');
            $eDate  = $_REQUEST['eDate'];
            $sDate  = $_REQUEST['sDate'];
            $UserID = $_REQUEST['UserID'];
            if (!empty($UserID)){
            	import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
				unset($KuoZhan);
				$map['user_id'] = array('like',"%".$UserID."%");
				$UserID = urlencode($UserID);
			}
			$sDate = $eDate + 86400;
            $map['in_time'] = array(array('gt',$eDate),array('elt',$sDate));
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $shouru->where($map)->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&eDate='. $eDate .'&sDate='. $sDate ;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $shouru->where($map)->field($field)->order('in_time desc')->page($Page->getPage().','.$listrows)->select();

            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$this->assign('sDate',$sDate);
			$this->assign('eDate',$eDate);
            $this->display ('adminFinanceList');
        }else{
            $this->error('数据错误!');
            exit;
        }
    }


	private function MiHouTaoBenQi($eDate,$sDate,&$Numss,$ppo){
		if ($_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
			$shouru = M('shouru');
			// $fwhere = "in_time>".$sDate." and in_time<=".$eDate;
			$sDate = $eDate + 86400;
			$fwhere = "in_time>".$eDate." and in_time<=".$sDate;
			$Numss['0'] = $shouru->where($fwhere)->sum('in_money');
			if (is_numeric($Numss['0']) == false){
				$Numss['0'] = 0;
			}
			unset($shouru,$fwhere);
		}else{
			$this->error('错误');
			exit;
		}
	}

    public function adminFinanceTableGrant(){
    	//奖金发放
    	if ($_SESSION['UrlPTPass'] == 'MyssPiPa'){
    		$DID = (int) $_GET['Tid'];
    		if ($DID){
    			$fck = M ('fck');
    			$bonus = M ('bonus');
    			$times = M ('times');
    			$where = array();
    			$where['did'] = $DID;
    			$where['type'] = 0;
    			$brs = $bonus->where($where)->select();
    			foreach ($brs as $vo){
    				$money = 0;
    				$money = $vo['b0'] - ($vo['b5'] - $vo['b6']);
    				$fck->query("UPDATE `nnld_fck` SET `agent_use`=agent_use+". $money .",`zjj`=zjj+". $money .",re_peat_money=re_peat_money+". $vo['b5'] .",m_money=m_money+". $vo['b1'] ." where id=".$vo['uid']);
    			}
    			$times->where("id=$DID")->setField('type',1);
    			$bonus->where("did=$DID")->setField('type',1);
    			unset($fck,$bonus,$times,$where,$brs);
    			$bUrl = __URL__.'/adminFinanceTable';
                $this->_box(1,'发放奖金！',$bUrl,1);
                exit;
    		}
    	}else{
            $this->error('错误');
            exit;
        }
    }

	//=====================================================奖金查询(所有期所有会员)
	public function adminFinanceTable(){
		if ($_SESSION['UrlPTPass'] == 'MyssPiPa'){
				$bonus = M ('bonus');  //奖金表
				$fee   = M ('fee');    //参数表
				$times = M ('times');  //结算时间表

				$fee_rs = $fee->field('s18')->find();
				$fee_s7 = explode('|',$fee_rs['s18']);
				$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组

				$where = array();
				$sql = '';
				if(isset($_REQUEST['FanNowDate'])){  //日期查询
					if(!empty($_REQUEST['FanNowDate'])){
						$time1 = strtotime($_REQUEST['FanNowDate']);                // 这天 00:00:00
						$time2 = strtotime($_REQUEST['FanNowDate']) + 3600*24 -1;   // 这天 23:59:59
						$sql = "where e_date >= $time1 and e_date <= $time2";
					}
				}


				$field  = '*';
				//=====================分页开始==============================================
				import ( "@.ORG.ZQPage" );  //导入分页类
				$count = count($bonus -> query("select id from __TABLE__ ". $sql ." group by did")); //总记录数
       			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
				$page_where = 'FanNowDate=' . $_REQUEST['FanNowDate'];//分页条件
				if(!empty($page_where)){
					$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
				}else{
					$Page = new ZQPage($count, $listrows, 1, 0, 3);
				}
				//===============(总页数,每页显示记录数,css样式 0-9)
				$show = $Page->show();//分页变量
				$this->assign('page', $show);//分页变量输出到模板
				$status_rs = ($Page->getPage()-1)*$listrows;
				$list = $bonus -> query("select e_date,did,sum(b0) as b0,sum(b1) as b1,sum(b2) as b2,sum(b3) as b3,sum(b4) as b4,sum(b5) as b5,sum(b6) as b6,sum(b7) as b7,sum(b8) as b8,sum(b9) as b9,sum(b10) as b10 ,sum(b11) as b11 ,sum(b12) as b12 from __TABLE__ ". $sql ." group by did  order by did desc limit ". $status_rs .",". $listrows);
				$this->assign('list',$list);//数据输出到模板
				//=================================================

				//各项奖每页汇总
		$count = array();
		foreach($list as $vo){
			for($b=0;$b<=12;$b++){
				$count[$b] += $vo['b'.$b];
				$count[$b] = $this->_2Mal($count[$b],2);
			}
		}

		//奖项名称与显示
		$b_b = array();
		$c_b = array();
		$b_b[1]  = C('Bonus_B1');
		$c_b[1]  = C('Bonus_B1c');
		$b_b[2]  = C('Bonus_B2');
		$c_b[2]  = C('Bonus_B2c');
		$b_b[3]  = C('Bonus_B3');
		$c_b[3]  = C('Bonus_B3c');
		$b_b[4]  = C('Bonus_B4');
		$c_b[4]  = C('Bonus_B4c');
		$b_b[5]  = C('Bonus_B5');
		$c_b[5]  = C('Bonus_B5c');
		$b_b[6]  = C('Bonus_B6');
		$c_b[6]  = C('Bonus_B6c');
		$b_b[7]  = C('Bonus_B7');
		$c_b[7]  = C('Bonus_B7c');
		$b_b[8]  = C('Bonus_B8');
		$c_b[8]  = C('Bonus_B8c');
		$b_b[9]  = C('Bonus_B9');
		$c_b[9]  = C('Bonus_B9c');
		$b_b[10] = C('Bonus_B10');
		$c_b[10] = C('Bonus_B10c');
		$b_b[11] = C('Bonus_B11');
		$c_b[11] = C('Bonus_B11c');
		$b_b[12] = C('Bonus_B12');
		$c_b[12] = C('Bonus_B12c');
		$b_b[13] = C('Bonus_HJ');   //合计
		$c_b[13] = C('Bonus_HJc');
		$b_b[0]  = C('Bonus_B0');   //实发
		$c_b[0]  = C('Bonus_B0c');
		$b_b[14] = C('Bonus_XX');   //详细
		$c_b[14] = C('Bonus_XXc');
		$this -> assign('b_b',$b_b);
		$this -> assign('c_b',$c_b);
		$this->assign('count',$count);

				//输出扣费奖索引
				$this->assign('ind',7);  //数组索引 +1

				$this->display('adminFinanceTable');
		}else{
			$this->error('错误');
			exit;
		}
	}

	//=====================================================查询这一期得奖会员资金
	public function adminFinanceTableShow(){
		if ($_SESSION['UrlPTPass'] == 'MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
				$bonus = M ('bonus');  //奖金表
				$fee   = M ('fee');    //参数表
				$times = M ('times');  //结算时间表

				$fee_rs = $fee->field('s18')->find();
				$fee_s7 = explode('|',$fee_rs['s18']);
				$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组
				$UserID = $_REQUEST['UserID'];
				$where = array();
				$sql = '';
				$did = (int) $_REQUEST['did'];
				$field  = '*';

				if($UserID !=""){
					$sql =" and user_id like '%".$UserID."%'";
				}
				//=====================分页开始==============================================92607291105
				import ( "@.ORG.ZQPage" );  //导入分页类
				$count = count($bonus -> query("select id from __TABLE__ where did= ". $did .$sql)); //总记录数
       			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
				$page_where = 'did/' . $_REQUEST['did'];//分页条件
				if(!empty($page_where)){
					$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
				}else{
					$Page = new ZQPage($count, $listrows, 1, 0, 3);
				}
				//===============(总页数,每页显示记录数,css样式 0-9)
				$show = $Page->show();//分页变量
				$this->assign('page', $show);//分页变量输出到模板
				$status_rs = ($Page->getPage()-1)*$listrows;
				$list = $bonus -> query("select * from __TABLE__ where did =". $did . $sql ."  order by did desc limit ". $status_rs .",". $listrows);
				$this->assign('list',$list);//数据输出到模板
				//=================================================
				$this->assign('did',$did);
				//查看的这期的结算时间
				$this -> assign('confirm',$list[0]['e_date']);


			$count = array();
			foreach($list as $vo){
				for($b=0;$b<=12;$b++){
					$count[$b] += $vo['b'.$b];
					$count[$b] = $this->_2Mal($count[$b],2);
				}
			}

		//奖项名称与显示
		$b_b = array();
		$c_b = array();
		$b_b[1]  = C('Bonus_B1');
		$c_b[1]  = C('Bonus_B1c');
		$b_b[2]  = C('Bonus_B2');
		$c_b[2]  = C('Bonus_B2c');
		$b_b[3]  = C('Bonus_B3');
		$c_b[3]  = C('Bonus_B3c');
		$b_b[4]  = C('Bonus_B4');
		$c_b[4]  = C('Bonus_B4c');
		$b_b[5]  = C('Bonus_B5');
		$c_b[5]  = C('Bonus_B5c');
		$b_b[6]  = C('Bonus_B6');
		$c_b[6]  = C('Bonus_B6c');
		$b_b[7]  = C('Bonus_B7');
		$c_b[7]  = C('Bonus_B7c');
		$b_b[8]  = C('Bonus_B8');
		$c_b[8]  = C('Bonus_B8c');
		$b_b[9]  = C('Bonus_B9');
		$c_b[9]  = C('Bonus_B9c');
		$b_b[10] = C('Bonus_B10');
		$c_b[10] = C('Bonus_B10c');
		$b_b[11] = C('Bonus_B11');
		$c_b[11] = C('Bonus_B11c');
		$b_b[12] = C('Bonus_B12');
		$c_b[12] = C('Bonus_B12c');
		$b_b[13] = C('Bonus_HJ');   //合计
		$c_b[13] = C('Bonus_HJc');
		$b_b[0]  = C('Bonus_B0');   //实发
		$c_b[0]  = C('Bonus_B0c');
		$b_b[14] = C('Bonus_XX');   //详细
		$c_b[14] = C('Bonus_XXc');

		$this -> assign('b_b',$b_b);
		$this -> assign('c_b',$c_b);
		$this->assign('count',$count);



				$this->assign('int',7);


				$this->display('adminFinanceTableShow');
		}else{
			$this->error('错误');
			exit;
		}
	}

	public function financeDaoChu_ChuN(){
        //导出excel
		set_time_limit(0);

		header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Cashier.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");

		$m_page = (int)$_GET['p'];
		if(empty($m_page)){
			$m_page=1;
		}

        $times = M ('times');
        $Numso = array();
		$Numss = array();
        $map = 'is_count=0';
        //查询字段
        $field   = '*';
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $times->where($map)->count();//总页数
        $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
        $s_p = $listrows*($m_page-1)+1;
        $e_p = $listrows*($m_page);

        $title   =   "当期出纳 第".$s_p."-".$e_p."条 导出时间:".date("Y-m-d   H:i:s");



        echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo   '<tr   bgcolor="#cccccc"><td   colspan="6"   align="center">'   .   $title   .   '</td></tr>';
        //   输出字段名
        echo   '<tr  align=center>';
        echo   "<td>期数</td>";
        echo   "<td>结算时间</td>";
        echo   "<td>当期收入</td>";
        echo   "<td>当期支出</td>";
        echo   "<td>当期盈利</td>";
        echo   "<td>拨出比例</td>";
        echo   '</tr>';
        //   输出内容

        $rs = $times->where($map)->order(' id desc')->find();
		$Numso['0'] = 0;
		$Numso['1'] = 0;
		$Numso['2'] = 0;
		if ($rs){
			$eDate = strtotime(date('c'));  //time()
			$sDate = $rs['benqi'] ;//时间

			$this->MiHouTaoBenQi($eDate, $sDate, $Numso, 0);
		}


        $page_where = '';//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $list = $times ->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();

//		dump($list);exit;

		$occ = 1;
		$Numso['1'] = $Numso['1']+$Numso['0'];
		$Numso['3'] = $Numso['3']+$Numso['0'];
		$maxnn=0;
		foreach ($list as $Roo){

			$eDate          = $Roo['benqi'];//本期时间
            $sDate          = $Roo['shangqi'];//上期时间
			$Numsd          = array();
			$Numsd[$occ][0] = $eDate;
			$Numsd[$occ][1] = $sDate;

			$this->MiHouTaoBenQi($eDate,$sDate,$Numss,1);
			//$Numoo = $Numss['0'];   //当期收入
			$Numss[$occ]['0'] = $Numss['0'];
			$Dopp  = M ('bonus');
			$field = '*';
			$where = " s_date>= '".$sDate."' And e_date<= '".$eDate."' ";
			$rsc   = $Dopp->where($where)->field($field)->select();
			$Numss[$occ]['1'] = 0;
			$nnn=0;
			foreach ($rsc as $Roc){
				$nnn++;
				$Numss[$occ]['1'] += $Roc['b0'] ;  //当期支出
				$Numb2[$occ]['1'] += $Roc['b1'];
				$Numb3[$occ]['1'] += $Roc['b2'];
				$Numb4[$occ]['1'] += $Roc['b3'];
				//$Numoo          += $Roc['b9'];//当期收入
			}
			$maxnn+=$nnn;
			$Numoo              = $Numss['0'];//当期收入
			$Numss[$occ]['2']   = $Numoo - $Numss[$occ]['1'];   //本期赢利
			$Numss[$occ]['3']   = substr( floor(($Numss[$occ]['1'] / $Numoo) * 100) , 0 ,3);  //本期拔比
			$Numso['1']        += $Numoo;  //收入合计
			$Numso['2']        += $Numss[$occ]['1'];           //支出合计
			$Numso['3']        += $Numss[$occ]['2'];           //赢利合计
			$Numso['4']         = substr( floor(($Numso['2'] / $Numso['1']) * 100) , 0 ,3);  //总拔比
			$Numss[$occ]['4']   = substr( ($Numb2[$occ]['1'] / $Numoo) * 100 , 0 ,4);  //小区奖金拔比
			$Numss[$occ]['5']   = substr( ($Numb3[$occ]['1'] / $Numoo) * 100 , 0 ,4);  //互助基金拔比
			$Numss[$occ]['6']   = substr( ($Numb4[$occ]['1'] / $Numoo) * 100 , 0 ,4); //管理基金拔比
			$Numss[$occ]['7']	= $Numb2[$occ]['1'];//小区奖金
			$Numss[$occ]['8'] 	= $Numb3[$occ]['1'] ;  //互助基金
			$Numss[$occ]['9'] 	= $Numb4[$occ]['1'];//管理基金
			$Numso['5']        += $Numb2[$occ]['1'];  //小区奖金合计
			$Numso['6']        += $Numb3[$occ]['1'];  //互助基金合计
			$Numso['7']        += $Numb4[$occ]['1'];  //管理基金合计
			$Numso['8']         = substr( ($Numso['5'] / $Numso['1']) * 100 , 0 ,4);  //小区奖金总拔比
			$Numso['9']         = substr( ($Numso['6'] / $Numso['1']) * 100 , 0 ,4);  //互助基金总拔比
			$Numso['10']        = substr( ($Numso['7'] / $Numso['1']) * 100 , 0 ,4);  //管理基金总拔比
			$occ++;
		}


        $i = 0;
        foreach($list as $row)   {
            $i++;
            echo   '<tr align=center>';
            echo   '<td>'   .   $row['id']   .   '</td>';
            echo   '<td>'   .   date("Y-m-d H:i:s",$row['benqi'])   .   '</td>';
            echo   '<td>'   .   $Numss[$i][0].  '</td>';
            echo   '<td>'   .   $Numss[$i][1]   .   '</td>';
            echo   '<td>'   .   $Numss[$i][2]   .   '</td>';
            echo   '<td>'   .   $Numss[$i][3]   .   ' % </td>';
            echo   '</tr>';
        }
        echo   '</table>';
    }


	public function financeDaoChu_JJCX(){
        //导出excel
		set_time_limit(0);

		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Bonus-query.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");

		$m_page = (int)$_REQUEST['p'];
		if(empty($m_page)){
			$m_page=1;
		}
		$fee   = M ('fee');    //参数表
        $times = M ('times');
        $bonus = M ('bonus');  //奖金表
        $fee_rs = $fee->field('s18')->find();
		$fee_s7 = explode('|',$fee_rs['s18']);

        $where = array();
		$sql = '';
		if(isset($_REQUEST['FanNowDate'])){  //日期查询
			if(!empty($_REQUEST['FanNowDate'])){
				$time1 = strtotime($_REQUEST['FanNowDate']);                // 这天 00:00:00
				$time2 = strtotime($_REQUEST['FanNowDate']) + 3600*24 -1;   // 这天 23:59:59
				$sql = "where e_date >= $time1 and e_date <= $time2";
			}
		}

        $field   = '*';
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = count($bonus -> query("select id from __TABLE__ ". $sql ." group by did")); //总记录数
        $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		$page_where = 'FanNowDate=' . $_REQUEST['FanNowDate'];//分页条件
		if(!empty($page_where)){
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
		}else{
			$Page = new ZQPage($count, $listrows, 1, 0, 3);
		}
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$status_rs = ($Page->getPage()-1)*$listrows;
		$list = $bonus -> query("select e_date,did,sum(b0) as b0,sum(b1) as b1,sum(b2) as b2,sum(b3) as b3,sum(b4) as b4,sum(b5) as b5,sum(b6) as b6,sum(b7) as b7,sum(b8) as b8,sum(b9) as b9,max(type) as type from __TABLE__ ". $sql ." group by did  order by did desc limit ". $status_rs .",". $listrows);
		//=================================================


        $s_p = $listrows*($m_page-1)+1;
        $e_p = $listrows*($m_page);

        $title   =   "奖金查询 第".$s_p."-".$e_p."条 导出时间:".date("Y-m-d   H:i:s");



        echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo   '<tr   bgcolor="#cccccc"><td   colspan="6"   align="center">'   .   $title   .   '</td></tr>';
        //   输出字段名
        echo   '<tr  align=center>';
        echo   "<td>结算时间</td>";
        echo   "<td>".$fee_s7[0]."</td>";
        echo   "<td>".$fee_s7[1]."</td>";
        echo   "<td>".$fee_s7[2]."</td>";
         echo   "<td>".$fee_s7[3]."</td>";
         echo   "<td>".$fee_s7[4]."</td>";
         echo   "<td>".$fee_s7[5]."</td>";
         echo   "<td>".$fee_s7[6]."</td>";
		echo   "<td>".$fee_s7[7]."</td>";
		echo   "<td>".$fee_s7[8]."</td>";
        echo   "<td>合计</td>";
        echo   "<td>实发</td>";
        echo   '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach($list as $row)   {
            $i++;
            $mmm = $row['b1']+$row['b2']+$row['b3']+$row['b4']+$row['b6']+$row['b7']+$row['b8'];
    $shifa = $row['b1']+$row['b2']+$row['b3']+$row['b4']-$row['b5']+$row['b6']+$row['b7']+$row['b8'];
            echo   '<tr align=center>';
            echo   '<td>'   .   date("Y-m-d H:i:s",$row['e_date'])   .   '</td>';
            echo   "<td>"   .   $row['b1'].  "</td>";
            echo   "<td>"   .   $row['b2'].  "</td>";
            echo   "<td>"   .   $row['b3'].  "</td>";
             echo   "<td>"   .   $row['b4'].  "</td>";
			echo   "<td>"   .   $row['b5'].  "</td>";
             echo   "<td>"   .   $row['b6'].  "</td>";
             echo   "<td>"   .   $row['b7'].  "</td>";
			echo   "<td>"   .   $row['b8'].  "</td>";
			echo   "<td>"   .   $row['b9'].  "</td>";
            echo   "<td>"   .   $mmm.  "</td>";
            echo   "<td>"   .   $shifa.  "</td>";
            echo   '</tr>';
        }
        echo   '</table>';
    }

    //会员表
    public function financeDaoChu_MM(){
        //导出excel
		set_time_limit(0);

		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Member.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");



        $fck = M ('fck');  //奖金表
        $open_type = (int)$_GET['open_type'];
        $map = array();

		$map['id'] = array('gt',0);
		$map['is_pay'] = array('gt',0);

		if($_GET['is_agent'] !=''){
			$map['is_agent'] = array('gt',0);
		}



        $field   = '*';
		$list = $fck->where($map)->field($field)->order('pdt asc')->select();

        $title   =   "会员表 导出时间:".date("Y-m-d   H:i:s");

        echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo   '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">'   .   $title   .   '</td></tr>';
        //   输出字段名
        echo   '<tr  align=center>';
        echo   "<td>序号</td>";
        echo   "<td>会员编号</td>";
        echo   "<td>推荐人编号</td>";
        echo   "<td>服务中心编号</td>";
        echo   "<td>姓名</td>";
        echo   "<td>住址省份</td>";
        echo   "<td>会员类型</td>";
        echo   "<td>签约金额</td>";
//        echo   "<td>QQ号</td>";
        echo   "<td>服务中心资格</td>";

        echo   "<td>开通时间</td>";
        echo   "<td>销售奖金</td>";
        echo   "<td>服务佣金</td>";
        echo   "<td>消费积分</td>";
		echo   "<td>市场积分</td>";
		echo   "<td>状态</td>";
		echo   "<td>是否奖金</td>";
        echo   '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach($list as $row)   {
            $i++;
            $num = strlen($i);
            if ($num == 1){
                $num = '000'.$i;
            }elseif ($num == 2){
                $num = '00'.$i;
            }elseif ($num == 3){
                $num = '0'.$i;
            }else{
            	$num = $i;
            }


			if($row['is_agent'] == 2){
				$is_agent ="是";
			}else{
				$is_agent ="否";
			}


			if($row['is_lock'] == 1){
				$is_lock ="已锁定";
			}else{
				$is_lock ="未锁定";
			}


			if($row['is_fenh'] == 1){
				$is_fenh ="关闭奖金";
			}else{
				$is_fenh ="开启奖金";
			}

            echo   '<tr align=center>';
            echo   '<td>'   .  chr(28).$num   .   '</td>';
            echo   "<td>"   .   $row['user_id'].  "</td>";
            echo   "<td>"   .   $row['re_name'].  "</td>";
            echo   "<td>"   .   $row['shop_name'].  "</td>";
            echo   "<td>"   .   $row['user_name'].  "</td>";
            echo   "<td>"   .   $row['province'].$row['city'].$row['address'].  "</td>";
            echo   "<td>"   .   $row['user_tel'].  "&nbsp;</td>";
            echo   "<td>"   .   $row['cpzj'].  "</td>";
//            echo   "<td>"   .   $row['qq'].  "</td>";
            echo   "<td>"   .   $is_agent.  "</td>";
            echo   "<td>"   .   date("Y-m-d H:i:s",$row['pdt']).  "</td>";
            echo   "<td>"   .   $row['agent_use'].  "</td>";
            echo   "<td>"   .   $row['agent_cash'].  "</td>";
            echo   "<td>"   .   $row['agent_xf'].  "</td>";
			echo   "<td>"   .   $row['agent_cf'].  "</td>";
			echo   "<td>"   .   $is_lock.  "</td>";
			echo   "<td>"   .   $is_fenh.  "</td>";
            echo   '</tr>';
        }
        echo   '</table>';
    }







	//会员表
	public function jifen_daochu(){
		//导出excel
		set_time_limit(0);

		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Jifen.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");



		$trans = M('trans');

		if($_REQUEST['start'] && $_REQUEST['end']){
			$map['pdt'] = array(array('egt',strtotime($_REQUEST["start"])),array('elt',strtotime($_REQUEST["end"])));

		}

		if($_REQUEST['user_id']){
			$map['tousername'] = array('eq',$_REQUEST['user_id']);
			$map['fromusername'] = array('eq',$_REQUEST['user_id']);
			$map['_logic'] = 'OR';

		}

	//	$page_where ='start='.$_REQUEST["start"].'&end='.$_REQUEST["end"].'&user_id='.$_REQUEST['user_id'];//分页条件
		$map['id'] = array('gt',0);
		$list = $trans->order('pdt desc')->where($map)->select();

		$title   =   "积分纪录 导出时间:".date("Y-m-d   H:i:s");

		echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
		//   输出标题
		echo   '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">'   .   $title   .   '</td></tr>';
		//   输出字段名
		echo   '<tr  align=center>';
		echo   "<td>序号</td>";
		echo   "<td>uniqueid</td>";
		echo   "<td>转给会员</td>";
		echo   "<td>来自会员</td>";
		echo   "<td>积分数目</td>";
		echo   "<td>datasource</td>";
		echo   "<td>来自IP</td>";
		echo   "<td>完成时间</td>";
		echo   '</tr>';
		//   输出内容

//		dump($list);exit;

		$i = 0;
		foreach($list as $row)   {
			$i++;
			$num = strlen($i);
			if ($num == 1){
				$num = '000'.$i;
			}elseif ($num == 2){
				$num = '00'.$i;
			}elseif ($num == 3){
				$num = '0'.$i;
			}else{
				$num = $i;
			}

			echo   '<tr align=center>';
			echo   '<td>'   .  chr(28).$num   .   '</td>';
			echo   "<td>"   .   $row['uniqueid'].  "</td>";
			echo   "<td>"   .   $row['tousername'].  "</td>";
			echo   "<td>"   .   $row['fromusername'].  "</td>";
			echo   "<td>"   .   $row['pointamount'].  "</td>";
			echo   "<td>"   .   $row['datasource'].  "</td>";
			echo   "<td>"   .   $row['ip'] .  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['pdt']).  "</td>";
			echo   '</tr>';
		}
		echo   '</table>';
	}





	//会员表
	public function jifen_daochus(){
		//导出excel
		set_time_limit(0);

		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Jifen.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");



		$trans = M('trans');

		if($_REQUEST['start'] && $_REQUEST['end']){
			$map['pdt'] = array(array('egt',strtotime($_REQUEST["start"])),array('elt',strtotime($_REQUEST["end"])));

		}

		if($_REQUEST['user_id']){

			$map['fromusername'] = array('eq',$_REQUEST['user_id']);
			$this->assign('user_id',$_REQUEST["user_id"]);
		}

		$map['tousername']=array('eq',$_SESSION['loginUseracc']);

		//	$page_where ='start='.$_REQUEST["start"].'&end='.$_REQUEST["end"].'&user_id='.$_REQUEST['user_id'];//分页条件

		$list = $trans->order('pdt desc')->where($map)->select();

		$title   =   "积分纪录 导出时间:".date("Y-m-d   H:i:s");

		echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
		//   输出标题
		echo   '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">'   .   $title   .   '</td></tr>';
		//   输出字段名
		echo   '<tr  align=center>';
		echo   "<td>转给会员</td>";
		echo   "<td>来自会员</td>";
		echo   "<td>积分数目</td>";
		echo   "<td>datasource</td>";
		echo   "<td>来自IP</td>";
		echo   "<td>完成时间</td>";
		echo   '</tr>';
		//   输出内容

//		dump($list);exit;

		$i = 0;
		foreach($list as $row)   {
			$i++;
			$num = strlen($i);
			if ($num == 1){
				$num = '000'.$i;
			}elseif ($num == 2){
				$num = '00'.$i;
			}elseif ($num == 3){
				$num = '0'.$i;
			}else{
				$num = $i;
			}

			echo   '<tr align=center>';
			echo   '<td>'   .  chr(28).$num   .   '</td>';
			echo   "<td>"   .   $row['tousername'].  "</td>";
			echo   "<td>"   .   $row['fromusername'].  "</td>";
			echo   "<td>"   .   $row['pointamount'].  "</td>";
			echo   "<td>"   .   $row['datasource'].  "</td>";
			echo   "<td>"   .   $row['ip'] .  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['pdt']).  "</td>";
			echo   '</tr>';
		}
		echo   '</table>';
	}







    //报单中心表
    public function financeDaoChu_BD(){
        //导出excel
		set_time_limit(0);

		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Member-Agent.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");



        $fck = M ('fck');  //奖金表

        $map = array();
		$map['id'] = array('gt',0);
		$map['is_agent'] = array('gt',0);
        $field   = '*';
		$list = $fck->where($map)->field($field)->order('idt asc,adt asc')->select();

        $title   =   "报单中心表 导出时间:".date("Y-m-d   H:i:s");

        echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo   '<tr   bgcolor="#cccccc"><td   colspan="9"   align="center">'   .   $title   .   '</td></tr>';
        //   输出字段名
        echo   '<tr  align=center>';
        echo   "<td>序号</td>";
        echo   "<td>会员编号</td>";
        echo   "<td>姓名</td>";
        echo   "<td>联系电话</td>";
        echo   "<td>申请时间</td>";
        echo   "<td>确认时间</td>";
        echo   "<td>类型</td>";
        echo   "<td>报单中心区域</td>";
        echo   "<td>剩余注册积分</td>";
        echo   '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach($list as $row)   {
            $i++;
            $num = strlen($i);
            if ($num == 1){
                $num = '000'.$i;
            }elseif ($num == 2){
                $num = '00'.$i;
            }elseif ($num == 3){
                $num = '0'.$i;
            }else{
            	$num = $i;
            }
            if($row['shoplx']==1){
            	$nnn = '服务中心';
            }elseif($row['shoplx']==2){
            	$nnn = '县/区会员';
            }else{
            	$nnn = '市级会员';
            }


            echo   '<tr align=center>';
            echo   '<td>'   .  chr(28).$num   .   '</td>';
            echo   "<td>"   .   $row['user_id'].  "</td>";
            echo   "<td>"   .   $row['user_name'].  "</td>";
            echo   "<td>"   .   $row['user_tel'].  "</td>";
            echo   "<td>"   .   date("Y-m-d H:i:s",$row['idt']).  "</td>";
            echo   "<td>"   .   date("Y-m-d H:i:s",$row['adt']).  "</td>";
            echo   "<td>"   .   $nnn.  "</td>";
            echo   "<td>"   .   $row['shop_a'].  " / " . $row['shop_b']  .   "</td>";
            echo   "<td>"   .   $row['agent_cash'].  "</td>";
            echo   '</tr>';
        }
        echo   '</table>';
    }


	public function financeDaoChu(){
        //导出excel
//        if ($_SESSION['UrlPTPass'] =='MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
            $title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
            header("Content-Type:   application/vnd.ms-excel");
            header("Content-Disposition:   attachment;   filename=test.xls");
            header("Pragma:   no-cache");
            header("Content-Type:text/html; charset=utf-8");
            header("Expires:   0");
            echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
            //   输出标题
            echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
            //   输出字段名
            echo   '<tr  align=center>';
            echo   "<td>银行卡号</td>";
            echo   "<td>姓名</td>";
            echo   "<td>银行名称</td>";
            echo   "<td>省份</td>";
            echo   "<td>城市</td>";
            echo   "<td>金额</td>";
            echo   "<td>所有人的排序</td>";
            echo   '</tr>';
            //   输出内容
            $did = (int) $_GET['did'];
            $bonus = M ('bonus');
            $map = 'nnld_bonus.b0>0 and nnld_bonus.did='.$did;
             //查询字段
            $field   = 'nnld_bonus.id,nnld_bonus.uid,nnld_bonus.did,s_date,e_date,nnld_bonus.b0,nnld_bonus.b1,nnld_bonus.b2,nnld_bonus.b3';
            $field  .= ',nnld_bonus.b4,nnld_bonus.b5,nnld_bonus.b6,nnld_bonus.b7,nnld_bonus.b8,nnld_bonus.b9,nnld_bonus.b10';
            $field  .= ',nnld_fck.user_id,nnld_fck.user_tel,nnld_fck.bank_card';
            $field  .= ',nnld_fck.user_name,nnld_fck.user_address,nnld_fck.nickname,nnld_fck.user_phone,nnld_fck.bank_province,nnld_fck.user_tel';
            $field  .= ',nnld_fck.user_code,nnld_fck.bank_city,nnld_fck.bank_name,nnld_fck.bank_address';
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $bonus->where($map)->count();//总页数
            $listrows = 5000  ;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $join = 'left join nnld_fck ON nnld_bonus.uid=nnld_fck.id';//连表查询
            $list = $bonus ->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage().','.$listrows)->select();
            $i = 0;
            foreach($list as $row)   {
                $i++;
                $num = strlen($i);
                if ($num == 1){
                    $num = '000'.$i;
                }elseif ($num == 2){
                    $num = '00'.$i;
                }elseif ($num == 3){
                    $num = '0'.$i;
                }
	            echo   '<tr align=center>';
	            echo   '<td>'   .   sprintf('%s',(string)chr(28).$row['bank_card'].chr(28)).      '</td>';
	            echo   '<td>'   .   $row['user_name']   .   '</td>';
	            echo   "<td>"   .   $row['bank_name'] .  "</td>";
	            echo   '<td>'   .   $row['bank_province']   .   '</td>';
	            echo   '<td>'   .   $row['bank_city']   .   '</td>';
	            echo   '<td>'   .   $row['b0']   .   '</td>';
	            echo   '<td>'   .   chr(28).$num    .   '</td>';
	            echo   '</tr>';
	        }
	        echo   '</table>';
//        }else{
//            $this->error('错误!');
//            exit;
//        }
    }


    public function financeDaoChuTwo1(){
        //导出WPS
        if ($_SESSION['UrlPTPass'] =='MyssGuanPaoYingTao' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
            $title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
            header("Content-Type:   application/vnd.ms-excel");
            header("Content-Disposition:   attachment;   filename=test.xls");
            header("Pragma:   no-cache");
            header("Content-Type:text/html; charset=utf-8");
            header("Expires:   0");
            echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
            //   输出标题
            echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
            //   输出字段名
        echo   '<tr  align=center>';
            echo   "<td>会员编号</td>";
            echo   "<td>开会名</td>";
            echo   "<td>开户银行</td>";
            echo   "<td>银行账户</td>";
            echo   "<td>提现金额</td>";
            echo   "<td>提现时间</td>";
            echo   "<td>所有人的排序</td>";
            echo   '</tr>';
            //   输出内容
            $did = (int) $_GET['did'];
            $bonus = M ('bonus');
            $map = 'nnld_bonus.b0>0 and nnld_bonus.did='.$did;
             //查询字段
            $field   = 'nnld_bonus.id,nnld_bonus.uid,nnld_bonus.did,s_date,e_date,nnld_bonus.b0,nnld_bonus.b1,nnld_bonus.b2,nnld_bonus.b3';
            $field  .= ',nnld_bonus.b4,nnld_bonus.b5,nnld_bonus.b6,nnld_bonus.b7,nnld_bonus.b8,nnld_bonus.b9,nnld_bonus.b10';
            $field  .= ',nnld_fck.user_id,nnld_fck.user_tel,nnld_fck.bank_card';
            $field  .= ',nnld_fck.user_name,nnld_fck.user_address,nnld_fck.nickname,nnld_fck.user_phone,nnld_fck.bank_province,nnld_fck.user_tel';
            $field  .= ',nnld_fck.user_code,nnld_fck.bank_city,nnld_fck.bank_name,nnld_fck.bank_address';
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $bonus->where($map)->count();//总页数
            $listrows = 5000  ;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $join = 'left join nnld_fck ON nnld_bonus.uid=nnld_fck.id';//连表查询
            $list = $bonus ->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage().','.$listrows)->select();
            $i = 0;
            foreach($list as $row)   {
                $i++;
                $num = strlen($i);
                if ($num == 1){
                	$num = '000'.$i;
                }elseif ($num == 2){
                	$num = '00'.$i;
                }elseif ($num == 3){
                    $num = '0'.$i;
                }
                $date = date('Y-m-d H:i:s',$row['rdt']);

                echo   '<tr align=center>';
                echo   "<td>'"   .   $row['user_id'].      '</td>';
                echo   '<td>'   .   $row['user_name']   .   '</td>';
                echo   "<td>"   .   $row['bank_name'] .  "</td>";
                echo   '<td>'   .   $row['bank_card']   .   '</td>';
                echo   '<td>'   .   $row['money']   .   '</td>';
                echo   '<td>'. $date .'</td>';
                echo   "<td>'"   .   $num    .   '</td>';
                echo   '</tr>';
            }
            echo   '</table>';
        }else{
            $this->error('错误!');
            exit;
        }
    }


   public function financeDaoChuTwo(){
        //导出WPS
//        if ($_SESSION['UrlPTPass'] =='MyssGuanPaoYingTao' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
            $title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
            header("Content-Type:   application/vnd.ms-excel");
            header("Content-Disposition:   attachment;   filename=test.xls");
            header("Pragma:   no-cache");
            header("Content-Type:text/html; charset=utf-8");
            header("Expires:   0");
            echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
            //   输出标题
            echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
            //   输出字段名
        echo   '<tr  align=center>';
            echo   "<td>银行卡号</td>";
            echo   "<td>姓名</td>";
            echo   "<td>银行名称</td>";
            echo   "<td>省份</td>";
            echo   "<td>城市</td>";
            echo   "<td>金额</td>";
            echo   "<td>所有人的排序</td>";
            echo   '</tr>';
            //   输出内容
            $did = (int) $_GET['did'];
            $bonus = M ('bonus');
            $map = 'nnld_bonus.b0>0 and nnld_bonus.did='.$did;
             //查询字段
            $field   = 'nnld_bonus.id,nnld_bonus.uid,nnld_bonus.did,s_date,e_date,nnld_bonus.b0,nnld_bonus.b1,nnld_bonus.b2,nnld_bonus.b3';
            $field  .= ',nnld_bonus.b4,nnld_bonus.b5,nnld_bonus.b6,nnld_bonus.b7,nnld_bonus.b8,nnld_bonus.b9,nnld_bonus.b10';
            $field  .= ',nnld_fck.user_id,nnld_fck.user_tel,nnld_fck.bank_card';
            $field  .= ',nnld_fck.user_name,nnld_fck.user_address,nnld_fck.nickname,nnld_fck.user_phone,nnld_fck.bank_province,nnld_fck.user_tel';
            $field  .= ',nnld_fck.user_code,nnld_fck.bank_city,nnld_fck.bank_name,nnld_fck.bank_address';
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $bonus->where($map)->count();//总页数
            $listrows = 5000  ;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $join = 'left join nnld_fck ON nnld_bonus.uid=nnld_fck.id';//连表查询
            $list = $bonus ->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage().','.$listrows)->select();
            $i = 0;
            foreach($list as $row)   {
                $i++;
                $num = strlen($i);
                if ($num == 1){
                	$num = '000'.$i;
                }elseif ($num == 2){
                	$num = '00'.$i;
                }elseif ($num == 3){
                    $num = '0'.$i;
                }
                echo   '<tr align=center>';
                echo   "<td>'"   .   sprintf('%s',(string)chr(28).$row['bank_card'].chr(28)).      '</td>';
                echo   '<td>'   .   $row['user_name']   .   '</td>';
                echo   "<td>"   .   $row['bank_name'] .  "</td>";
                echo   '<td>'   .   $row['bank_province']   .   '</td>';
                echo   '<td>'   .   $row['bank_city']   .   '</td>';
                echo   '<td>'   .   $row['b0']   .   '</td>';
                echo   "<td>'"   .   $num    .   '</td>';
                echo   '</tr>';
            }
            echo   '</table>';
//        }else{
//            $this->error('错误!');
//            exit;
//        }
    }

   public function financeDaoChuTXT(){
        //导出TXT
        if ($_SESSION['UrlPTPass'] =='MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
            //   输出内容
            $did = (int) $_GET['did'];
            $bonus = M ('bonus');
            $map = 'nnld_bonus.b0>0 and nnld_bonus.did='.$did;
             //查询字段
            $field   = 'nnld_bonus.id,nnld_bonus.uid,nnld_bonus.did,s_date,e_date,nnld_bonus.b0,nnld_bonus.b1,nnld_bonus.b2,nnld_bonus.b3';
            $field  .= ',nnld_bonus.b4,nnld_bonus.b5,nnld_bonus.b6,nnld_bonus.b7,nnld_bonus.b8,nnld_bonus.b9,nnld_bonus.b10';
            $field  .= ',nnld_fck.user_id,nnld_fck.user_tel,nnld_fck.bank_card';
            $field  .= ',nnld_fck.user_name,nnld_fck.user_address,nnld_fck.nickname,nnld_fck.user_phone,nnld_fck.bank_province,nnld_fck.user_tel';
            $field  .= ',nnld_fck.user_code,nnld_fck.bank_city,nnld_fck.bank_name,nnld_fck.bank_address';
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $bonus->where($map)->count();//总页数
            $listrows = 5000  ;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $join = 'left join nnld_fck ON nnld_bonus.uid=nnld_fck.id';//连表查询
            $list = $bonus ->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage().','.$listrows)->select();
            $i = 0;
			$ko = "";
			$m_ko = 0;
            foreach($list as $row)   {
                $i++;
                $num = strlen($i);
                if ($num == 1){
                	$num = '000'.$i;
                }elseif ($num == 2){
                	$num = '00'.$i;
                }elseif ($num == 3){
                    $num = '0'.$i;
                }
				$ko .= $row['bank_card']."|".$row['user_name']."|".$row['bank_name']."|".$row['bank_province']."|".$row['bank_city']."|".$row['b0']."|".$num."\r\n";
				$m_ko += $row['b0'];
				$e_da = $row['e_date'];
            }
			$m_ko = $this -> _2Mal($m_ko,2);
			$content = $num."|".$m_ko."\r\n".$ko;

			header('Content-Type: text/x-delimtext;');
			header("Content-Disposition: attachment; filename=nnld_".date('Y-m-d H:i:s',$e_da).".txt");
			header("Pragma: no-cache");
			header("Content-Type:text/html; charset=utf-8");
			header("Expires: 0");
			echo $content;
			exit;

        }else{
            $this->error('错误!');
            exit;
        }
    }

	public function adminFinanceTableList(){
		//奖金明细
		if ($_SESSION['UrlPTPass'] == 'MyssPiPa'|| $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){  //MyssShiLiu
			$times   = M('times');
			$history = M('history');

			$UID = (int) $_GET['uid'];
			$did = (int) $_REQUEST['did'];

			$where = array();
			if (!empty($did)){
				$rs = $times -> find($did);
				if($rs){
					$rs_day = $rs['benqi']+24*3600-1;
					$where['pdt'] = array(array('gt',$rs['benqi']),array('elt',$rs_day));  //大于上期,小于等于本期
				}else{
					$this->error('错误!');
					exit;
				}
			}
			$where['uid'] = $UID;
			$where['type'] = 1;

            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $history->where($where)->count();//总页数
//            dump($history);exit;
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'did=' . (int) $_REQUEST['did'];//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $history->where($where)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

            $fee   = M ('fee');    //参数表
			$fee_rs = $fee->field('s18')->find();
			$fee_s7 = explode('|',$fee_rs['s18']);
			$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组

			$this->display ('adminFinanceTableList');
			}else{
			$this->error ('错误!');
			exit;
		}
	}



	

	//===================================保存比例设置
	public function adminParameterSave(){
		if ($_SESSION['UrlPTPass'] == 'MyssPingGuo'){
			$fee = M ('fee');
			$fee -> create();
			$fee -> save();

			$bUrl = __URL__.'/adminParameter';
			$this->_box(1,'比例设置！',$bUrl,1);
			exit;
		}else{
			$this->error('错误');
			exit;
		}
	}
	//参数设置
	public function setParameter(){
		if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP'){
			$fee = M ('fee');
			$fee_rs = $fee -> find();
			$fee_s1  = $fee_rs['s1'];
			$fee_s2  = $fee_rs['s2'];
			$fee_s3  = $fee_rs['s3'];
			$fee_s4  = $fee_rs['s4'];
			$fee_s5  = $fee_rs['s5'];
			$fee_s6  = $fee_rs['s6'];
			$fee_s7  = $fee_rs['s7'];
			$fee_s8  = $fee_rs['s8'];
			$fee_s9  = $fee_rs['s9'];
			$fee_s10 = $fee_rs['s10'];
			$fee_s11 = $fee_rs['s11'];
			$fee_s12 = $fee_rs['s12'];
			$fee_s13 = $fee_rs['s13'];
			$fee_s14 = $fee_rs['s14'];
			$fee_s15 = $fee_rs['s15'];
			$fee_s16 = $fee_rs['s16'];
			$fee_s17 = $fee_rs['s17'];
			$fee_s18 = $fee_rs['s18'];
			$fee_s19 = $fee_rs['s19'];
			$fee_s20 = $fee_rs['s20'];

			$fee_str1 = $fee_rs['str1'];
			$fee_str2 = $fee_rs['str2'];
			$fee_str3 = $fee_rs['str3'];
			$fee_str4 = $fee_rs['str4'];
			$fee_str5 = $fee_rs['str5'];
			$fee_str6 = $fee_rs['str6'];
			$fee_str7 = $fee_rs['str7'];
			$fee_str8 = $fee_rs['str8'];
			$fee_str9 = $fee_rs['str9'];
			$fee_str10 = $fee_rs['str10'];
			$fee_str11 = $fee_rs['str11'];
			$fee_str12 = $fee_rs['str12'];
			$fee_str17 = $fee_rs['str17'];
			$fee_str18 = $fee_rs['str18'];

			$fee_str21 = $fee_rs['str21'];
			$fee_str22 = $fee_rs['str22'];
			$fee_str23 = $fee_rs['str23'];

			$fee_str27 = $fee_rs['str27'];
			$fee_str28 = $fee_rs['str28'];
			$fee_str29 = $fee_rs['str29'];
			$fee_str32 = $fee_rs['str32'];
			$fee_str99 = $fee_rs['str99'];



			$fee_i5 = $fee_rs['i5'];
			$fee_i6 = $fee_rs['i6'];

			$fee_i10 = $fee_rs['i10'];
			$fee_i11 = $fee_rs['i11'];
			$fee_i12 = $fee_rs['i12'];
			$fee_i13 = $fee_rs['i13'];

//			$fee_s20 = explode('|',$fee_rs['s20']);
			$this -> assign('fee_s1',$fee_s1);
			$this -> assign('fee_s2',$fee_s2);
			$this -> assign('fee_s3',$fee_s3);
			$this -> assign('fee_s4',$fee_s4);
			$this -> assign('fee_s5',$fee_s5);
			$this -> assign('fee_s6',$fee_s6);
			$this -> assign('fee_s7',$fee_s7);
			$this -> assign('fee_s8',$fee_s8);
			$this -> assign('fee_s9',$fee_s9);
			$this -> assign('fee_s10',$fee_s10);
			$this -> assign('fee_s11',$fee_s11);
			$this -> assign('fee_s12',$fee_s12);
			$this -> assign('fee_s13',$fee_s13);
			$this -> assign('fee_s14',$fee_s14);
			$this -> assign('fee_s15',$fee_s15);
			$this -> assign('fee_s16',$fee_s16);
			$this -> assign('fee_s17',$fee_s17);
			$this -> assign('fee_s18',$fee_s18);
			$this -> assign('fee_s19',$fee_s19);
			$this -> assign('fee_s20',$fee_s20);

			$this -> assign('fee_i1',$fee_rs['i1']);
			$this -> assign('fee_i2',$fee_rs['i2']);
			$this -> assign('fee_i3',$fee_rs['i3']);
			$this -> assign('fee_i5',$fee_rs['i5']);
			$this -> assign('fee_i6',$fee_rs['i6']);
			$this -> assign('fee_i4',$fee_rs['i4']);
			$this -> assign('fee_i10',$fee_rs['i10']);
			$this -> assign('fee_i11',$fee_rs['i11']);
			$this -> assign('fee_i12',$fee_rs['i12']);
			$this -> assign('fee_i13',$fee_rs['i13']);
			$this -> assign('fee_id',$fee_rs['id']);  //记录ID
			
			$this -> assign('b_money',$fee_rs['b_money']);

			$this -> assign('fee_str1',$fee_str1);
			$this -> assign('fee_str2',$fee_str2);
			$this -> assign('fee_str3',$fee_str3);
			$this -> assign('fee_str4',$fee_str4);
			$this -> assign('fee_str5',$fee_str5);
			$this -> assign('fee_str6',$fee_str6);
			$this -> assign('fee_str7',$fee_str7);
			$this -> assign('fee_str8',$fee_str8);
			$this -> assign('fee_str9',$fee_str9);
			$this -> assign('fee_str10',$fee_str10);
			$this -> assign('fee_str11',$fee_str11);
			$this -> assign('fee_str12',$fee_str12);
			$this -> assign('fee_str17',$fee_str17);
			$this -> assign('fee_str18',$fee_str18);

			$this -> assign('fee_str21',$fee_str21);
			$this -> assign('fee_str22',$fee_str22);
			$this -> assign('fee_str23',$fee_str23);
			$this -> assign('fee_str32',$fee_str32);
			$this -> assign('fee_str27',$fee_str27);
			$this -> assign('fee_str28',$fee_str28);
			$this -> assign('fee_str29',$fee_str29);
			$this -> assign('fee_str99',$fee_str99);

			$this->display('setParameter');
		}else{
			$this->error('错误!');
			exit;
		}
	}
	public function setParameterSave(){
		if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP'){
			$fee = M ('fee');
			$fck = M ('fck');
			$rs = $fee -> find();
			$i1  = $_POST['i1'];
			$i2  = $_POST['i2'];
			$i3  = $_POST['i3'];
			$i4  = $_POST['i4'];
			$i10  = $_POST['i10'];
			$i11  = $_POST['i11'];
			$i12  = $_POST['i12'];
			$b_money  = $_POST['b_money'];

			$where = array();
			$where['id'] = 1;
			$data = array();
			if (empty($b_money)==false||strlen($b_money)>0){
				$data['b_money']  = trim($b_money);
			}
			

			for($j=1;$j<=15;$j++){
                $arr_rs[$j] = $_POST['i'.$j];
            }

            $s_sql2 = "";
            for($j=1;$j<=15;$j++){
                if ($arr_rs[$j] != ''){
                	if(empty($s_sql2)){
                    	$s_sql2 = 'i'.$j . "='{$arr_rs[$j]}'";
                	}else{
                		$s_sql2 .= ',i'.$j . "='{$arr_rs[$j]}'";
                	}
                }
            }


			for($i=1;$i<=35;$i++){
                $arr_s[$i] = $_POST['s'.$i];
            }

            $s_sql = "";
            for($i=1;$i<=35;$i++){
                if (empty($arr_s[$i])==false||strlen($arr_s[$i])>0){
                	if(empty($s_sql2)){
                    	$s_sql = 's'.$i . "='{$arr_s[$i]}'";
                	}else{
                		$s_sql .= ',s'.$i . "='{$arr_s[$i]}'";
                	}

                }
            }

            for($i=1;$i<=40;$i++){
                $arr_sts[$i] = $_POST['str'.$i];
            }
            $str_sql = "";
            for($i=1;$i<=40;$i++){
                if (strlen(trim($arr_sts[$i]))>0){
                	if(empty($s_sql2)&&empty($s_sql)){
                    	$str_sql = 'str'.$i . "='{$arr_sts[$i]}'";
                	}else{
                		$str_sql .= ',str'.$i . "='{$arr_sts[$i]}'";
                	}
                }
            }

            $str99=trim($_POST['str99']);
			$ttst_sql = ',str99="'.$str99.'"';


			$fee->execute("update __TABLE__ SET ".$s_sql2 . $s_sql. $str_sql. $ttst_sql  ."  where `id`=1");
			$fee -> where($where) -> data($data) -> save();
			$this->success('参数设置！');
			exit;
		}else{
			$this->error('错误!'); //12345678901112131417181920s3
			exit;
		}
	}

//参数设置
	public function setParameter_B(){
		if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCPB'){
			$fee = M ('fee');
			$fee_rs = $fee -> find();

			$fee_str21 = $fee_rs['str21'];
			$fee_str22 = $fee_rs['str22'];
			$fee_str23 = $fee_rs['str23'];

			$this -> assign('fee_str21',$fee_str21);
			$this -> assign('fee_str22',$fee_str22);
			$this -> assign('fee_str23',$fee_str23);

			$this->display();
		}else{
			$this->error('错误!');
			exit;
		}
	}
	public function setParameterSave_B(){
		if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCPB'){
			$fee = M ('fee');
			$fck = M ('fck');
			$rs = $fee -> find();

			$where = array();
			$where['id'] = (int) $_POST['id'];
            for($i=1;$i<=40;$i++){
                $arr_sts[$i] = $_POST['str'.$i];
            }
            $str_sql = "";
            for($i=1;$i<=40;$i++){
                if (strlen(trim($arr_sts[$i]))>0){
                	if(empty($str_sql)){
                    	$str_sql = 'str'.$i . "='{$arr_sts[$i]}'";
                	}else{
                		$str_sql .= ',str'.$i . "='{$arr_sts[$i]}'";
                	}
                }
            }


			$fee->execute("update __TABLE__ SET ". $str_sql."  where `id`=1");
			$this->success('首页图片设置！');
			exit;
		}else{
			$this->error('错误!');
			exit;
		}
	}




	public function delTable(){
		//清空数据库===========================
		$this->display();
	}
	public function delTableExe(){
		$fck = M ('fck');
	    if (!$fck->autoCheckToken($_POST)){
            $this->error('页面过期，请刷新页面！');
            exit;
        }
        unset($fck);
		$this->_delTable();
		exit;
	}

	public function adminClearing(){
		if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS'){
			$times = M('times');
			$fck = M('fck');
			$trs = $times->where('type=0')->order('id desc')->find();
			if (!$trs){
				$trs['benqi'] = strtotime('2010-01-01');
			}
			if ($trs['benqi'] == strtotime(date("Y-m-d"))){
				$isPay = 1;
			}else{
				$isPay = 0;
			}
			$this->assign('is_pay',$isPay);
			$this->assign('trs',$trs);

			$fee_rs = M('fee')->field('all_yj,str9,s13,s19')->find(1);
        	$all_yj = $fee_rs['all_yj'];
        	$fen_yj = $all_yj * $fee_rs['str9'] / 100;
  			$this->assign('all_yj',$all_yj);
  			$this->assign('fen_yj',$fen_yj);
  			$this->assign('maxMoney',$fee_rs['s13']); // 每单最多
  			// 未封顶单数
  			$allF4 = $fck->where('`zjj`<`cpzj`*'.$fee_rs['s19'])->sum('f4');
  			if (!$allF4) {
  				$allF4 = 0;
  			}
  			$this->assign('allF4',$allF4);

  			$map = array();
	        $map['get_level'] = 5;
	        $ds_num = $fck->where($map)->count();
	        $this->assign('ds_num',(int)$ds_num);
			// $all_fs2 = $fck->where('u_level=2 and is_lockfh=0')->count();
  			// $this->assign('all_fs2',$all_fs2);

			$this->display();
		}else{
			$this->error('错误!');
		}
	}

	public function adminClearingSave(){  //资金结算
		if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS'){
			set_time_limit(0);//是页面不过期
		    $times = M('times');
		    $fck = D ('Fck');
		    $ydate = mktime();
		    
		    $a1 = $_GET['a1'];
		    if(empty($a1)){
		    	$this->error('分红金额是空的');
		    	eixt;
		    }
		
				//日分红
			$fck->fenhong($a1);
		
			//sleep(1);
			$this->success('结算分红完成！');
//			$bUrl = __URL__.'/adminClearing';
//			$this->_box(1,'结算分红完成！',$bUrl,1);
			exit;
		}else{
			$this->error('错误!');
		}
	}


   




    private function _adminsingleDel($PTid=0){
        //====================================删除加单
        if ($_SESSION['UrlPTPass'] == 'MyssGuansingle'){
            $jdan = M('jiadan');
            //$fck->query("UPDATE `nnld_fck` SET `single_ispay`=0,`single_money`=0 where `ID` in (".$PTid.")");
            $jwhere['id'] = array('in',$PTid);
            $jwhere['is_pay'] = 0;
            $jdan->where($jwhere)->delete();
            $bUrl = __URL__.'/adminsingle';
            $this->_box(1,'删除！',$bUrl,1);
            exit;
        }else{
            $this->error('错误!');
        }
    }

         //获取每周星期一 的时间
    public function getTiem(){
        $nowdate = strtotime(date('Y-m-d'));
        $weekday=date('w',time());
        
        if($weekday == 1){
            $noeTime = $nowdate + 7 * 24*3600;
        }else if($weekday == 2){
            $noeTime = $nowdate + 6 * 24*3600;
        }else if($weekday == 3){
            $noeTime = $nowdate + 5 * 24*3600;
        }else if($weekday == 4){
            $noeTime = $nowdate + 4 * 24*3600;
        }else if($weekday == 5){
            $noeTime = $nowdate + 3 * 24*3600;
        }else if($weekday == 6){
            $noeTime = $nowdate + 2*24*3600 ;
        }else if($weekday == 0){
            $noeTime = $nowdate + 24*3600 ;
        }
        return $noeTime;    
    }

    //清空表数据 参数： 表名， 从id多少开始清除
    private function _delTableDataWithName($tableName='',$map='') {
    	if (!empty($map)) {
    		M($tableName)->where($map)->delete();
    	}
    	else {
    		M($tableName)->execute("TRUNCATE __TABLE__");
    	}
    }

	private function _delTable(){
		if ($_SESSION['UrlPTPass'] == 'MyssQingKong'){
			//删除指定记录
			//$name=$this->getActionName();
			$this->_delTableDataWithName('fck','id>10801');
			$this->_delTableDataWithName('bonus');
			$this->_delTableDataWithName('history');
			$this->_delTableDataWithName('msg');
			$this->_delTableDataWithName('times');
			$this->_delTableDataWithName('tiqu');
			$this->_delTableDataWithName('zhuanj');
			$this->_delTableDataWithName('shop');
			$this->_delTableDataWithName('jiadan');
			$this->_delTableDataWithName('chongzhi');
			$this->_delTableDataWithName('region');
			$this->_delTableDataWithName('orders');
			$this->_delTableDataWithName('huikui');
			$this->_delTableDataWithName('gouwu');
			$this->_delTableDataWithName('xiaof');
			$this->_delTableDataWithName('promo');

			$this->_delTableDataWithName('peng');
			$this->_delTableDataWithName('ulevel');
			$this->_delTableDataWithName('address','id>1');
			$this->_delTableDataWithName('fh');
			$this->_delTableDataWithName('fehlist');
			$this->_delTableDataWithName('yj');
			$this->_delTableDataWithName('card');
			$this->_delTableDataWithName('remit');
			$this->_delTableDataWithName('cash');
			$this->_delTableDataWithName('shouru');
			$this->_delTableDataWithName('change_tree');
			$this->_delTableDataWithName('uplevel');
			$this->_delTableDataWithName('benqi');
			$this->_delTableDataWithName('fahuo');

		//	$this->_delTableDataWithName('fenhong');
			$this->_delTableDataWithName('xiaoshou');
			$this->_delTableDataWithName('fuwu');
			$this->_delTableDataWithName('jifen');
			$this->_delTableDataWithName('yeji');
			$this->_delTableDataWithName('jicha');
			$this->_delTableDataWithName('trans');
			$this->_delTableDataWithName('vap');
			$this->_delTableDataWithName('ip');
			$this->_delTableDataWithName('shifang');
			$nowdate = time();
			//数据清0

			$fee    = M ('fee');
			$fee_rs = $fee ->find();
			$s2 = explode("|",$fee_rs['s2']);
			$str4 = explode("|",$fee_rs['str4']);
			$uLevel = count($s2);
			$f4 = max($s2);
			$nowday=strtotime(date('Y-m-d'));
//			$nowday=strtotime(date('Y-m-d H:i:s'));	//测试 使用

			$sql .= "`l`=0,`r`=0,`shangqi_l`=0,`shangqi_r`=0,`idt`=0,";
			$sql .= "`benqi_l`=0,`benqi_r`=0,`lr`=0,`shangqi_lr`=0,`benqi_lr`=0,";
			$sql .= "`agent_max`=0,`lssq`=0,`agent_use`=0,`is_agent`=2,`shoplx`=2,`agent_cash`=0,";
			$sql .= "`u_level`=10,`zjj`=0,`wlf`=$nowday,`zsq`=0,`re_money`=0,rdt=$nowday,pdt=".$nowday.",";
			$sql .= "`cz_epoint`=0,b0=0,b1=0,b2=0,b3=0,b4=0,";
			$sql .= "`b5`=0,b6=0,b7=0,b8=0,b9=0,b10=0,b11=0,b12=0,re_nums=0,man_ceng=0,";
			$sql .= "re_peat_money=0,cpzj=10000,duipeng=0,_times=0,fanli=0,fanli_time=$nowday,fanli_num=0,day_feng=0,get_date=$nowday,get_numb=0,";
			$sql .= "get_level=0,is_xf=0,xf_money=0,is_zy=0,zyi_date=0,zyq_date=0,down_num=0,agent_xf=0,agent_kt=0,agent_gp=0,gp_num=0,xy_money=0,";
			$sql .= "peng_num=0,re_f4=0,f4={$f4},agent_cf=0,is_aa=0,is_bb=0,tx_num=0,xx_money=0,x_pai=1,x_out=1,x_num=0,fanli_money=0,";
			$sql .= "td_yj=0,gob=0,is_up=0,agent_gc=0,b_point_num=0,is_suo=0,feng_jiandian=0,team_yj=0,xiaoshou_time=0,jifen_time=0,yongjin_time=0,dongshi_time=0";
			//$sql1 .= "`u_level`=3,`down_num`=0,`is_suo`=0,`is_time`=0,`time`=0";

			M('fck2')->execute("UPDATE __TABLE__ SET " . $sql1 );

			M('fck')->execute("UPDATE __TABLE__ SET " . $sql );

			for($i=1; $i<=2; $i++){ //fck1 ~ fck5 表 (清空只留800000)
				$fck_other = M ('fck'. $i);
				$fck_other -> where('id > 1') -> delete();
			}

			M('fck2')->where('id=1')->setField(array('l'=>0,'r'=>0));
			M('fenhong')->where('id=1')->setField('money',0);


			$where = array();
			$where['id']=array('in','10799,10800,10801');
			$data  = array();
			$data['u_level'] = 0;
			$data['is_agent'] = 0;
			M('fck')->where($where)->setField($data);

			$next_time = $this->getTiem();


			//fee表,记载清空操作的时间(时间截)
			
			$where = array();
			$data  = array();
			$data['id'] = $fee_rs['id'];
			$data['create_time'] = time();
			$data['f_time'] = $next_time;
			$data['us_num'] = 1;
			$data['a_money'] = 0;
			$data['b_money'] = 0;
			$data['ff_num'] = 1;
			$data['all_yj'] = 0;
			$rs = $fee -> save($data);

			$bUrl = __URL__.'/delTable';
			$this->_box(1,'清空数据！',$bUrl,1);
			exit;
		}else{
			$bUrl = __URL__.'/delTable';
			$this->_box(0,'清空数据！',$bUrl,1);
			exit;
		}
	}

	public function menber(){

		//列表过滤器，生成查询Map对像
			$fck = M('fck');
			$map = array();
			$id = $PT_id;
			$map['re_id'] = (int) $_GET['PT_id'];
			//$map['is_pay'] = 0;
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				$map['user_id'] = array('like',"%".$UserID."%");
			}

            //查询字段
            $field  = 'id,user_id,nickname,bank_name,bank_card,user_name,user_address,user_tel,rdt,f4,cpzj,is_pay';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID='.$UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('rdt desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck->where($where)->field('agent_cash')->find();
			$this->assign('frs',$fck_rs);//注册积分
			$this->display ('menber');
			exit;
	}

    public function adminmoneyflows(){
        //货币流向
        if ($_SESSION['UrlPTPass'] == 'MyssMoneyFlows'){
        	$fck = M('fck');
            $history = M('history');
            $sDate  = $_REQUEST['S_Date'];
            $eDate  = $_REQUEST['E_Date'];
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int) $_REQUEST['tp'];
			$map['_string'] = "1=1";
			$s_Date = 0;
			$e_Date = 0;
			if(!empty($sDate)){
				$s_Date = strtotime($sDate);
			}else{
				$sDate = "2000-01-01";
			}
			if(!empty($eDate)){
				$e_Date = strtotime($eDate);
			}else{
				$eDate = date("Y-m-d");
			}
			if($s_Date>$e_Date&&$e_Date>0){
				$temp_d = $s_Date;
				$s_Date = $e_Date;
				$e_Date = $temp_d;
			}
			if($s_Date>0){
				$map['_string'] .= " and pdt>=".$s_Date;
			}
			if($e_Date>0){
				$e_Date = $e_Date+3600*24-1;
				$map['_string'] .= " and pdt<=".$e_Date;
			}
			if($ss_type>0){
				if($ss_type==15){
					$map['action_type'] = array('lt',12);
				}else{
					$map['action_type'] = array('eq',$ss_type);
				}
			}
			if (!empty($UserID)){
            	import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }

				unset($KuoZhan);
				$where = array();
				$where['user_id'] = array('eq',$UserID);
				$usrs = $fck->where($where)->field('id,user_id')->find();
				if($usrs){
					$usid = $usrs['id'];
					$usuid = $usrs['user_id'];
					$map['_string'] .= " and (uid=".$usid." or user_id='".$usuid."')";
				}else{
					$map['_string'] .= " and id=0";
				}
				unset($where,$usrs);
				$UserID = urlencode($UserID);
			}
			$this->assign('S_Date',$sDate);
			$this->assign('E_Date',$eDate);
			$this->assign('ry',$ss_type);
			$this->assign('UserID',$UserID);
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $history->where($map)->count();//总页数
            $listrows = 5000  ;//每页显示的记录数
            $page_where = 'UserID=' . $UserID .'&S_Date='. $sDate .'&E_Date='. $eDate . '&tp=' . $ss_type ;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $history->where($map)->field($field)->order('pdt desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
//            dump($history);

            $fee   = M ('fee');    //参数表
			$fee_rs = $fee->field('s18')->find();
			$fee_s7 = explode('|',$fee_rs['s18']);
			$this->assign('fee_s7',$fee_s7);        //输出奖项名称数组

            $this->display ();
        }else{
            $this->error('数据错误!');
            exit;
        }
    }





  


	public function upload_fengcai_aa() {
        if(!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_aa();
        }
    }

    protected function _upload_fengcai_aa()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize  = 1048576 * 20 ;// TODO 50M   3M 3292200 1M 1048576

        //设置上传文件类型
         $upload->allowExts  = explode(',','jpg,gif,png,jpeg');

        //设置附件上传目录
         $upload->savePath =  './Public/Uploads/';

        //设置需要生成缩略图，仅对图像文件有效
       $upload->thumb =  false;

       //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix   =  'm_';  //生产2张缩略图

       //设置缩略图最大宽度
        $upload->thumbMaxWidth =  '800';

       //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

       //设置上传文件规则
       $upload->saveRule = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);

       //删除原图
       $upload->thumbRemoveOrigin = true;

        if(!$upload->upload()) {
            //捕获上传异常
            $error_p=$upload->getErrorMsg();
            echo "<script>alert('".$error_p."');history.back();</script>";
        }else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path=$uploadList[0]['savepath'];
            $U_nname=$uploadList[0]['savename'];
            $U_inpath=(str_replace('./Public/','__PUBLIC__/',$U_path)).$U_nname;

            echo "<script>window.parent.myform.str21.value='".$U_inpath."';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }

	public function upload_fengcai_bb() {
        if(!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_bb();
        }
    }

    protected function _upload_fengcai_bb()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize  = 1048576 * 2 ;// TODO 50M   3M 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath =  './Public/Uploads/';

        //设置需要生成缩略图，仅对图像文件有效
       $upload->thumb =  false;

       //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix   =  'm_';  //生产2张缩略图

       //设置缩略图最大宽度
        $upload->thumbMaxWidth =  '800';

       //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

       //设置上传文件规则
       $upload->saveRule = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);

       //删除原图
       $upload->thumbRemoveOrigin = true;

        if(!$upload->upload()) {
            //捕获上传异常
            $error_p=$upload->getErrorMsg();
            echo "<script>alert('".$error_p."');history.back();</script>";
        }else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path=$uploadList[0]['savepath'];
            $U_nname=$uploadList[0]['savename'];
            $U_inpath=(str_replace('./Public/','__PUBLIC__/',$U_path)).$U_nname;

            echo "<script>window.parent.myform.str22.value='".$U_inpath."';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }

	public function upload_fengcai_cc() {
        if(!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_cc();
        }
    }

    protected function _upload_fengcai_cc()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize  = 1048576 * 2 ;// TODO 50M   3M 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath =  './Public/Uploads/';

        //设置需要生成缩略图，仅对图像文件有效
       $upload->thumb =  false;

       //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix   =  'm_';  //生产2张缩略图

       //设置缩略图最大宽度
        $upload->thumbMaxWidth =  '800';

       //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

       //设置上传文件规则
       $upload->saveRule = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);

       //删除原图
       $upload->thumbRemoveOrigin = true;

        if(!$upload->upload()) {
            //捕获上传异常
            $error_p=$upload->getErrorMsg();
            echo "<script>alert('".$error_p."');history.back();</script>";
        }else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path=$uploadList[0]['savepath'];
            $U_nname=$uploadList[0]['savename'];
            $U_inpath=(str_replace('./Public/','__PUBLIC__/',$U_path)).$U_nname;

            echo "<script>window.parent.myform.str23.value='".$U_inpath."';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }


    public function shopAdd(){
    	$fck = M('fck');

    	$uid = $_GET['uid'];

    	$fck_rs = $fck->where('id='.$uid)->field('id,user_id,is_agent,shoplx')->find();
    	$this->assign('fck_rs',$fck_rs);

    	$shoplx = "";
    	$this->_levelShopConfirm($shoplx);
    	$this->assign('shoplx',$shoplx);

    	$this->display();
    }

    public function shopAc(){
    	$fck = M('fck');
    	$uid = $_POST['uid'];
    	$is_agent = $_POST['is_agent'];
    	$shoplx = $_POST['shoplx'];

    	if($uid == 1){
			$bUrl = __URL__.'/adminMenber';
			$this->_box(0,'该会员是最高管理员,不能更改',$bUrl,1);
			exit;
    	}
    	if($is_agent == 0){
    		$where['id'] = array ('eq',$uid);
			//$where['is_agent'] = array ('lt',2);
			$rs2 = $fck->where($where)->setField('adt',0);
			$rs1 = $fck->where($where)->setField(array('is_agent'=>0,'shoplx'=>0));
			$bz1 = '取消成功';
			$bz2 = '取消失败';
    	}else{
    		$where['id'] = array ('eq',$uid);
			//$where['is_agent'] = array ('lt',2);
			$rs2 = $fck->where($where)->setField('adt',mktime());
			$rs1 = $fck->where($where)->setField(array('is_agent'=>2,'shoplx'=>$shoplx));
			$bz1 = '设置成功';
			$bz2 = '设置失败';
    	}
		
		if ($rs1){
			$bUrl = __URL__.'/adminMenber';
			$this->_box(1,$bz1,$bUrl,1);
			exit;
		}else{
			$bUrl = __URL__.'/adminMenber';
			$this->_box(0,$bz2,$bUrl,1);
			exit;
		}
    }


    public function adminlookfhall(){
    	$fehlist = M('fehlist');
    	$map ='';
    	import ( "@.ORG.ZQPage" );  //导入分页类
		$count = $fehlist->where($map)->count();//总页数
		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板
		$list = $fehlist->where($map)->field($field)->order('id asc')->page($Page->getPage().','.$listrows)->select();
		
		$this->assign('list',$list);//数据输出到模板

		$this->display();
    }




	public function benzhou(){






		$this->display();


	}





}
?>