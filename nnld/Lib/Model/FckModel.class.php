<?php
class FckModel extends CommonModel {
	//数据库名称
    //静态变量，$fee表
    protected static $fee = false;
    private function _getFee() {
        if (!self::$fee) {
           self::$fee = M('fee')->field('*')->find();
       }
       return self::$fee;
    }

   public function xiangJiao($Pid=0,$DanShu=1,$fromUserId=0,$op=1){
        //========================================== 往上统计单数【有层碰奖】
        if ($op == 1) {
            $fromUserId = $Pid;
        }
        $pvDan = $DanShu;
        $vo = $this ->where('id='.$Pid)->field('id,treeplace,father_id,p_level')->find();
        if ($vo){
            $Fid = $vo['father_id'];
            $TPe = $vo['treeplace'];
            if ($Fid == 0) {
                return;
            }
            if ($TPe == 0){
                $this->execute("UPDATE __TABLE__ SET `l`=l+{$pvDan}, `shangqi_l`=`shangqi_l`+{$pvDan}  WHERE `id`=".$Fid);
            }elseif($TPe == 1){
                $this->execute("UPDATE __TABLE__ SET `r`=r+{$pvDan},`shangqi_r`=`shangqi_r`+{$pvDan}  WHERE `id`=".$Fid);
            }
             $this->addCengPengData($Fid,$op,$pvDan,$TPe,$fromUserId); // 添加层碰记录
            $op++;
            unset($p_rs);
            if ($Fid > 0) $this->xiangJiao($Fid,$DanShu,$fromUserId,$op);
       }
       unset($vo);
   }

   // 层碰记录
   public function addCengPengData($uid,$ceng,$DanShu,$treeplace,$fromUserId)
   {
        $duipeng = M('peng');
        $where['uid'] = $uid;
        $where['ceng'] = $ceng;
        $re = $duipeng->where($where)->find();
        if ($re) {
            if ($re['is_peng']!=0) return;
            switch ($treeplace) {
                case '0':
                    if ($re['l_from_id'] == 0 || $re['l_from_id'] == $fromUserId) {
                        $re['l'] += $DanShu;
                        $re['l_from_id'] = $fromUserId;
                    }
                    break;
                case '1':
                    if ($re['r_from_id'] == 0 || $re['r_from_id'] == $fromUserId) {
                        $re['r'] += $DanShu;
                        $re['r_from_id'] = $fromUserId;
                    }
                    break;
                default:
                    break;
            }
            $duipeng->save($re);
        }
        else {
            $data['uid'] = $uid;
            $data['ceng'] = $ceng;
            switch ($treeplace) {
                case '0':
                    $data['l'] = $DanShu;
                    $data['l_from_id'] = $fromUserId;
                    break;
                case '1':
                    $data['r'] = $DanShu;
                    $data['r_from_id'] = $fromUserId;
                    break;
                default:
                    break;
            }
            $duipeng->add($data);
        }
   }

   // 层碰奖
   public function cengpeng($pPath,$inUserID){
        $fee_rs = self::_getFee();
     //   $prii = $fee_rs['str8'] / 100;
       // $cpzjArr = explode('|', $fee_rs['s9']);
     //   $f4Arr = explode('|', $fee_rs['s2']);
    //    $maxCengArr = explode("|", $fee_rs['str9']);

     //   $oneMoney = $cpzjArr[0] / $f4Arr[0]; // 每单注册金额，这个其实记金额还好……但不懂为啥记单数

        $cpzj=$fee_rs['s9'];
        $bili=$fee_rs['str3']/100;

        $duipeng = M('peng');
        $where['l'] = array('gt',0);
        $where['r'] = array('gt',0);
        $where['uid'] = array('in',$pPath);
        $where['is_peng'] = array('eq',0);
        $rs = $duipeng->where($where)->select();
        foreach ($rs as $re) {
            $duipeng->where('id='.$re['id'])->setField('is_peng',1);

            // 开始，不同级别有不同的层封
         /*   $user = $this->field('u_level')->find($re['uid']);
            $maxCeng = $maxCengArr[$user['u_level']-1];
            if ($maxCeng < $re['ceng']) {
                continue;
            }  */
            // 结束，不同级别有不同的层封

            $minF4 = $re['l'] > $re['r'] ? $re['r'] : $re['l'];
            $money = $minF4 * $cpzj * $bili;
            if ($money > 0) {
                $this->rw_bonus($re['uid'],$inUserID,1,$money);
            }
        }
    }

    //对碰奖
    private function duipeng(){

        $fee = M ('fee');
        $fee_rs = $fee->field('s2,s3,s9,s4,str5,s20,s14,str4,s1,str3,str7')->find(1);
        $s19 = explode("|",$fee_rs['s14']);      //各级对碰奖金比例
        // $s9 = explode("|",$fee_rs['s9']);       //代理级别费用
      //  $s9 = explode("|",$fee_rs['s1']);       //代理级别费用 PV
        $f4Arr = explode('|', $fee_rs['s2']);   // 各级别单数
        $s5 = $fee_rs['str7'];      //封顶
        $one_mm = $fee_rs['s9']; // 算出一单的费用

        //层碰比例
        $bili=$fee_rs['s3']/100;


        $fck_array = 'is_pay>=1 and ((shangqi_l+benqi_l)>0 or (shangqi_r+benqi_r)>0)';
        $field = 'id,user_id,shangqi_l,shangqi_r,benqi_l,benqi_r,is_fenh,p_path,re_nums,nickname,u_level,re_id,day_feng,re_path,re_level,peng_num,cpzj';
        $frs = $this->where($fck_array)->field($field)->select();

        //BenQiL  BenQiR  ShangQiL  ShangQiR
        foreach ($frs as $vo){
            $L = 0;
            $R = 0;
            $L = $vo['shangqi_l'] + $vo['benqi_l'];
            $R = $vo['shangqi_r'] + $vo['benqi_r'];
            $Encash    = array();
            $NumS      = 0;//碰数
            $money     = 0;//对碰奖金额
            $Ls        = 0;//左剩余
            $Rs        = 0;//右剩余
            $this->touchNtoN($Encash, $L, $R, $NumS,1,1); // 万能对碰
            $Ls = $L - $Encash['0'];
            $Rs = $R - $Encash['1'];
            $myid = $vo['id'];
            $myusid = $vo['user_id'];
            $ss = $vo['u_level']-1;
            $feng = $vo['day_feng'];
            $re_nums = $vo['re_nums'];
            $re_path = $vo['re_path'];
            $re_level = $vo['re_level'];
            $ppath = $vo['p_path'];
            $is_fenh = $vo['is_fenh'];

           // $ul =  $s19[$ss]/100;
            $money = $NumS *$bili*$one_mm;//对碰奖 奖金


            //封顶
            if($money>$s5){
                $money = $s5;
            }
    
            if ($feng>=$s5){
                $money=0;
            }else{
                $jfeng=$feng+$money;
                if ($jfeng>$s5){
                    $money=$s5-$feng;
                }
            }



            $this->query('UPDATE __TABLE__ SET `shangqi_l`='. $Ls .',`shangqi_r`='. $Rs .',`benqi_l`=0,`benqi_r`=0,peng_num=peng_num+'.$NumS.' where `id`='. $vo['id']);


         //   $money_count = $money;
            // var_dump($money_count);
            if($money > 0 && $is_fenh == 0){
                $this->where('id='.$myid)->setInc('day_feng',$money);
                $this->rw_bonus($myid,$myusid,2,$money); // 写奖金
              //  $this->lingdaojiang($re_path,$money_count,$myusid,$myid); // 调用领导奖
            }
        }
        unset($fee,$fee_rs,$frs,$vo);
    }


    //万能对碰
    public function touchNtoN(&$Encash,$xL=0,$xR=0,&$NumS=0,$p1=1,$p2=1){
        if($p1 > $p2){
            $Great=$p1;
            $Samll=$p2;
        }else{
            $Great=$p2;
            $Samll=$p1;
        }
        $ttt=0;
        if ($xL > 0 && $xR > 0){
            if($xL > $xR){
                $L=$xL;
                $S=$xR;
                $ttt=0;
            }else{
                $L=$xR;
                $S=$xL;
                $ttt=1;
            }
            for($NumS=0;$S-$Samll>=0&&$L-$Great>=0;$NumS++){
                if($ttt==0){
                    $Encash['0'] = $Encash['0'] + $Great;
                    $Encash['1'] = $Encash['1'] + $Samll;
                }else{
                    $Encash['0'] = $Encash['0'] + $Samll;
                    $Encash['1'] = $Encash['1'] + $Great;
                }
                $L=$L-$Great;
                $S=$S-$Samll;
                if($L <= $S){
                    $temp = $L;
                    $L=$S;
                    $S=$temp;
                    if($ttt==1){
                        $ttt = 0;
                    }else{
                        $ttt = 1;
                    }
                }
            }
        }else{
            $NumS = 0;
            $Encash['0'] = 0;
            $Encash['1'] = 0;
        }
    }

    // //层碰奖
    // public function duipeng(){
    
    //     $peng = M ('peng');
    //     $fee = M ('fee');
    
    //     $fee_rs = $fee->field('s1,s9,s5,s14,str8')->find(1);
    //     $s1 = explode("|",$fee_rs['s1']);       //各级对碰比例
    //     $s9 = explode("|",$fee_rs['s9']);       //会员级别费用
    //     // $s5 = explode("|",$fee_rs['s5']);       //封顶
    //     $s15 = explode("|", $fee_rs['s14']);    //层封顶 单数
    //     $pengMoney = $fee_rs['str8'];

    //     $max_ac = $s15;
    //     sort($max_ac);
    //     $ceng = $max_ac[count($max_ac)-1];
    //     $pwhere['r1']=array('lt',$ceng);
    //     $pwhere['r']=array('gt','r1');
    //     $a_rs = $peng ->where($pwhere)->order('uid asc,ceng asc')->select();
    //     foreach($a_rs as $a){
    //         $where = array();
    //         $where['id'] = $a['uid'];
    //         $rs = $this ->where($where)->select();//找出产生对碰的人
    //         foreach($rs as $a1){
    //             $urs = $a1['u_level'] - 1;
    //             $ceng1 = floor($s15[$urs]);//每个级别的层封
    //         }
    //         $tceng = $a['ceng'];
    //         $R = floor($a['r']);
    //         $R1 = floor($a['r1']);
    //         $zR = $R-$R1;//可碰50
    //         $zR1=$ceng1-$R1;//还能碰30
    //         $xYou =0;
    //         if($zR>$zR1){
    //             $cR=$zR1;
    //         }else{
    //             $cR=$zR;
    //         }
    //         $cR1=$cR;
    //         if($cR>0){
    //             $where = array();
    //             $where['uid'] = $a['uid'];
    //             $where['l'] = array('gt','l1');
    //             $where['l1'] = array('lt',$ceng1);
    //             //              $where['ceng'] = array('eq',$tceng);
    //             $rs = $peng ->where($where)->order('ceng asc')->select();
    //             if($rs && $cR1>0){
    //                 foreach($rs as $k=>$a2){
    //                     $L = floor($a2['l']);
    //                     $L1 = floor($a2['l1']);
    //                     $zL =$L-$L1;
    //                     $zL1 = $ceng1-$L1;
    //                     if($zL>$zL1){
    //                         $cL=$zL1;
    //                     }else{
    //                         $cL=$zL;
    //                     }
    //                     if($cR>$cL){
    //                         $xYou=$cL;
    //                     }else{
    //                         $xYou=$cR;
    //                     }
    //                     if($cR1>=$xYou){
    //                         $cR1=$cR1-$xYou;
    //                         $xLd=$xYou;
    //                     }else{
    //                         $xLd=$cR1;
    //                         $cR1=0;
    //                     }
    //                     $peng->execute("UPDATE __TABLE__ SET `l1`=l1+{$xLd}  WHERE id=".$a2['id']);
    //                 }
    //             }
    //         }
    //         $cR2=$cR-$cR1;
    //         $peng->execute("UPDATE __TABLE__ SET `r1`=r1+{$cR2}  WHERE id=$a[id]");
    //         if($cR2>0){
    //             $c_info = $this->where("id=".$a['uid']." and is_fenh=0")->field('id,u_level,user_id,re_id,re_path,re_level,day_feng')->find();
    //             $this->execute("UPDATE __TABLE__ SET `shangqi_r`=shangqi_r-{$cR2},`shangqi_l`=shangqi_l-{$cR2}  WHERE id=".$a['uid']);
    //             //$tYou=$cR2*$s3[0]*($s12[$urs]/100);
    //             // $tYou=$s1[$urs] / 100 * $s9[1] * $cR2;//$s2[0]这是一碰的钱
    //             $tYou = $pengMoney * $cR2;//$s2[0]这是一碰的钱
    //             // $my_wm = $c_info['day_feng'];
    //             // $all_get = $my_wm+$tYou;
    //             // $mmylv = $c_info['u_level']-1;
    //             // $myff = $s5[$mmylv];
    //             // if($all_get>$myff){
    //             //     $tYou = $myff-$my_wm;
    //             // }
    //             if($tYou>0){
    //                 $this->rw_bonus($c_info['id'],$c_info['user_id'],2,$tYou);
    //                 //领导奖
    //                 $this->lingdaojiang($c_info['user_id'],$c_info['re_id'],$tYou);
    //                 // $this->lingdaojiang($c_info['re_path'],$c_info['id'],$c_info['user_id'],$c_info['re_level'],$tYou);
    //             }
    //             unset($c_info);
    //         }
    //     }
    //     unset($fee,$peng);
    // }

    // 领导奖
    public function lingdaojiang($re_path='',$money,$inUserID,$id)
    {
        $fee_rs = self::_getFee();
        $blArr = explode("|", $fee_rs['s7']);
        $daiArr = explode("|",$fee_rs['s20']);
        $limit = max($daiArr);
        $map = array();
        $map['id'] = array('in',$re_path);
        $fck_rs = $this->where($map)->field('id,u_level')->order('re_level desc')->limit($limit)->select();
        foreach ($fck_rs as $key => $re) {
            $level = $re['u_level'] - 1;
            $dai = $daiArr[$level];
            if ($dai <= $key) {
                continue;
            }
            $bl = $blArr[$key];
            $money_count = $money * $bl / 100;
            if ($money_count > 0) {
                $this->rw_bonus($re['id'],$inUserID,3,$money_count);
            }
        }
    }

    public function addencAdd($ID=0,$inUserID=0,$money=0,$name=null,$UID=0,$time=0,$acttime=0,$bz="",$k=0){
        //添加 到数据表


//        if ($UID > 0) {
//            $where = array();
//            $where['id'] = $UID;
//            $frs = $this->where($where)->field('nickname')->find();
//            $name_two = $name;
//            $name = $frs['nickname'] . ' 开通会员 ' . $inUserID ;
//            $inUserID = $frs['nickname'];
//        }else{
//            $name_two = $name;
//        }
        $name_two = $name;
        $data = array();
        $history = M ('history');

        $data['user_id']		= $inUserID;
        $data['uid']			= $ID;
        $data['action_type']	= $name;
        if($time >0){
        	$data['pdt']		= $time;
        }else{
        	$data['pdt']		= mktime();
        }
        $data['epoints']		= $money;
        if(!empty($bz)){
        	$data['bz']			= $bz;
        }else{
        	$data['bz']			= $name;
        }
        $data['did']			= 0;
        $data['type']			= 1;
        $data['allp']			= 0;
        $data['des']			= $k;
        if($acttime>0){
        	$data['act_pdt']	= $acttime;
        }
        $history ->add($data);
        unset($data,$history);
    }

    public function huikuiAdd($ID=0,$tz=0,$zk,$money=0,$nowdate=null){
        //添加 到数据表

        $data                   = array();
        $huikui                = M ('huikui');
        $data['uid']            = $ID;
        $data['touzi']    = $tz;
        $data['zhuangkuang']            = $zk;
        $data['hk']        = $money;
        $data['time_hk']             = $nowdate;
        $huikui ->add($data);
        unset($data,$huikui);
    }


    //计算奖金
    public function getusjjs($uid,$money){
        set_time_limit(0);
        $mrs = $this->where('id='.$uid)->find();
        if($mrs && $money > 0){
            $fee_rs = self::_getFee();

            //配股票
            $this->gupiao($mrs['user_id'], $money);
            $this->tuijj($mrs['re_path'],$mrs['re_id'],$mrs['user_id'],$money); // 直推奖
            $this->xiezhu($mrs['re_path'],$mrs['user_id'],$money); // 直推奖

            $this->checkLevel($mrs['re_path']);

            $this->jiChaJiang($mrs['re_path'],$mrs['user_id'],$money);

            $this->dongshi($mrs['user_id'],$money);

            $this->ShouRu($uid,$mrs['user_id'],$money);

            //添加团队业绩
            $map = array();
            $map['id'] = array('in',$mrs['p_path']);
            $this->where($map)->setInc('team_yj',$money);




        }
        unset($mrs);
    }




//手动结算奖金

/*************T050业务逻辑代码开始****************/

public function xiaoshoujiang($id,$user_id,$cpzj,$cpzj_level,$money,$u_level,$father_id,$re_id,$re_path,$p_path,$pdt){

    $xiaoshou = M ('xiaoshou');
    $cunzai=$xiaoshou->where('id='.$id)->find();
    if($cunzai){
        return;
    }
    $data['id'] = $id;
    $data['user_id'] = $user_id;
    $data['cpzj'] = $cpzj;
    $data['cpzj_level'] = $cpzj_level;
    $data['money'] = $money;
    $data['u_level'] = $u_level;
    $data['father_id'] = $father_id;
    $data['re_id'] = $re_id;
    $data['re_path'] = $re_path;
    $data['p_path'] = $p_path;
    //  $data['pdt'] = $pdt;
    $data['pdt'] = '1461081600';

    $xiaoshou->add($data);

}



    public function fuwuyj($id,$user_id,$cpzj,$cpzj_level,$money,$u_level,$father_id,$re_id,$re_path,$p_path,$pdt){

        $fuwu = M ('fuwu');
        $data['uid'] = $id;
        $data['user_id'] = $user_id;
        $data['cpzj'] = $cpzj;
        $data['cpzj_level'] = $cpzj_level;
        $data['money'] = $money;
        $data['u_level'] = $u_level;
        $data['father_id'] = $father_id;
        $data['re_id'] = $re_id;
        $data['re_path'] = $re_path;
        $data['p_path'] = $p_path;
        //  $data['pdt'] = $pdt;
        $data['pdt'] = '1461081600';

        $fuwu->add($data);

    }


    public function jifen($id,$user_id,$cpzj,$cpzj_level,$money,$u_level,$father_id,$re_id,$re_path,$p_path,$pdt){

        $jifen = M ('jifen');
        $cunzai=$jifen->where('id='.$id)->find();
        if($cunzai){
            return;
        }
        $data['id'] = $id;
        $data['user_id'] = $user_id;
        $data['cpzj'] = $cpzj;
        $data['cpzj_level'] = $cpzj_level;
        $data['money'] = $money;
        $data['u_level'] = $u_level;
        $data['father_id'] = $father_id;
        $data['re_id'] = $re_id;
        $data['re_path'] = $re_path;
        $data['p_path'] = $p_path;
        //  $data['pdt'] = $pdt;
        $data['pdt'] = '1461081600';

        $jifen->add($data);

    }



    public function shichangyj($id,$user_id,$cpzj,$cpzj_level,$money,$u_level,$father_id,$re_id,$re_path,$p_path,$pdt){


        $yeji = M ('yeji');

        $cunzai=$yeji->where('id='.$id)->find();
        if($cunzai){
          return;
        }

        $data['id'] = $id;
        $data['user_id'] = $user_id;
        $data['cpzj'] = $cpzj;
        $data['cpzj_level'] = $cpzj_level;
        $data['money'] = $money;
        $data['u_level'] = $u_level;
        $data['father_id'] = $father_id;
        $data['re_id'] = $re_id;
        $data['re_path'] = $re_path;
        $data['p_path'] = $p_path;
      //  $data['pdt'] = $pdt;
        $data['pdt'] = '1461081600';
        $yeji->add($data);

    }



    public function dsfenhong($cpzj){
        $fenhong = M ('fenhong');
        $fenhong =$fenhong->where('id=1')->setInc('money',$cpzj);


    }


/****结算销售奖***/
    public function xiaoshou(){
        set_time_limit(0);
        $dangtian = strtotime(date('Y-m-d'));
        $fee_rs = self::_getFee();
        $map = array();
        $map['is_jiesuan']=array('eq',0);
        $mrs = M('xiaoshou')->where($map)->select();
        foreach($mrs as $v){
            $qiantian = strtotime(date('Y-m-d',$v['pdt']));
            $days=round(($dangtian-$qiantian)/3600/24);
            if($days > $fee_rs['str6']){
                $caozuo= M('xiaoshou')->where('id='.$v['id'])->setField('is_jiesuan',1);
                if($caozuo){
                    $fee_rs = self::_getFee();
                    $str3 = explode('|',$fee_rs['str3']);

                    $user = M('fck')->find($v['re_id']);
                    $priiArr = $str3[$user['cpzj_level']]/100; //奖金
                    if (!$user) {
                        return;
                    }
                    $money_count = $v['money'] * $priiArr;
                    if ($money_count>0){
                        $this->rw_bonus($v['re_id'],$v['user_id'],1,$money_count);
                        $this->total($v['id']); //统一操作数据
                        $this->defenhong(); //检查是否爱心基金
                        $this->dailiLevel($v['p_path']); //检查代理级别
                        $this->dongshiLevel($v['p_path']);  //检查董事级别
                        $tj = M('fck')->find($v['re_id']);
                        $this->fuwuyj($tj['id'],$tj['user_id'],$tj['cpzj'],$tj['cpzj_level'],$money_count,$tj['u_level'],$tj['father_id'],$tj['re_id'],$tj['re_path'],$tj['p_path'],time());  //服务佣金
                    }
                }

            }
        }
    }



    /****结算服务佣金***/
    public function fuwuyongjin(){
         set_time_limit(0);
         $fee_rs = self::_getFee();
         $str9 = explode('|',$fee_rs['str9']);
         $str12 = explode('|',$fee_rs['str12']);
         $str29 = explode('|',$fee_rs['str29']);


        $map = array();
        $map['is_jiesuan']=array('eq',0);
        $mrs = M('fuwu')->where($map)->select();
        foreach($mrs as $v) {
            $map = array();
            $map['id']=array('in',$v['re_path']);
            $re = $this->where($map)->order('id desc')->select();
            $money = $v['money'];
            foreach($re as $r){
                $benren = $this->find($r['id']);
                if ($benren['re_nums'] >= 5 && $benren['$cpzj_level'] == 0) {
                    $bili = $str9[4];
                } else {
                    $bili = $str9[$benren['re_nums'] - 1];
                }

                if ($benren['re_nums'] >= 5 && $benren['$cpzj_level'] == 1) {
                    $bili = $str12[4];
                } else {
                    $bili = $str12[$benren['re_nums'] - 1];
                }

                if ($benren['re_nums'] >= 5 && $benren['$cpzj_level'] == 2) {
                    $bili = $str29[4];
                } else {
                    $bili = $str29[$benren['re_nums'] - 1];
                }

                $money_count = $money * $bili / 100;

                if ($money_count > 0) {
                    $money = $money_count;
                    $gai = M('fuwu')->where('id=' . $v['id'])->setField('is_jiesuan', 1);
                    if ($gai) {
                        $this->rw_bonus($benren['id'], $v['user_id'], 2, $money_count);

                        $this->fengei($benren['father_id'],$benren['user_id'],$money_count);

                        $this->defenhong(); //检查是否爱心基金
                        $this->dailiLevel($v['p_path']); //检查代理级别
                        $this->dongshiLevel($v['p_path']);  //检查董事级别
                    }
                }


            }

        }

    }




    public function fengei($father_id,$user_id,$money,$k=0){

        if($k >8){
          return;
        }

        set_time_limit(0);
        $fee_rs = self::_getFee();
        $str9 = explode('|',$fee_rs['str9']);
        $str12 = explode('|',$fee_rs['str12']);
        $str29 = explode('|',$fee_rs['str29']);

        $benren = $this->find($father_id);
        if ($benren['re_nums'] >= 5 && $benren['$cpzj_level'] == 0) {
            $bili = $str9[4];
        } else {
            $bili = $str9[$benren['re_nums'] - 1];
        }

        if ($benren['re_nums'] >= 5 && $benren['$cpzj_level'] == 1) {
            $bili = $str12[4];
        } else {
            $bili = $str12[$benren['re_nums'] - 1];
        }

        if ($benren['re_nums'] >= 5 && $benren['$cpzj_level'] == 2) {
            $bili = $str29[4];
        } else {
            $bili = $str29[$benren['re_nums'] - 1];
        }

        $money_count = $money * $bili / 100;

        if ($money_count > 0) {
            $money = $money_count;
            $this->rw_bonus($father_id, $user_id, 2, $money);
            $this->fengei($benren['father_id'],$benren['user_id'],$money,$k+1);

        }


    }



    /****结算市场积分***/
    public function shjifen($user_id,$re_path,$money){
        set_time_limit(0);
        $dangtian = strtotime(date('Y-m-d'));
        $fee_rs = self::_getFee();
        $map = array();
        $map['is_pay']=array('gt',0);
        $map['re_path']=array('in',$re_path);
        $mrs = M('fck')->where($map)->order('id desc')->select();

        foreach($mrs as $v){

                    $fee_rs = self::_getFee();
                    $blArr = explode("|", $fee_rs['s6']);
                    //  $pingJiBlArr = explode("|", $fee_rs['s4']);

                    $fen = 0; // 已分金额
                    $level = 0; // 分到的级别数
                    $is_pingji = 0; // 是否分了平级奖
                    // $maxPingji = count($pingJiBlArr); // 这个是为了可以处理多个平级
                    $lastMoneyCount = 0; // 最后一次拿的级差奖，用这个金额分平级奖


                        $thisLevel = $v['u_level'];
                        if ($thisLevel < $level) { // 当前级别太小，平级都拿不到
                            continue;
                        }
                        if ($thisLevel == $level) { // 平级奖

                            $maps = array();
                            $maps['re_id'] = $v['id'];
                            $maps['is_pay'] = array('gt', 0);
                            $maps['u_level'] = array('eq', 6);
                            $liangge = $this->where($maps)->count();
                            if($liangge < 2){
                                continue;
                            }

                            $map = array();
                            $map['re_id'] = $v['id'];
                            $map['is_pay'] = array('gt', 0);
                            $field = "team_yj+cpzj_pv as yj";
                            $res = $this->where($map)->field($field)->order('yj desc')->select();

                            $user=$this->find($v['id']);

                            $bing = 0;
                            $small= 0;
                            foreach($res as $k => $vs){
                                if($k==0){
                                    $bing= $vs['yj'];

                                }else{
                                    $small = $vs['yj'];

                                    if($small < $user['team_yj']  && $vs['u_level']==6){
                                        $money_counts = $v['money'] *0.01;
                                    //    $this->rw_bonus($vs['id'], $user_id, 3, $money_counts);
                                        $this->total($v['id']); //统一操作数据
                                        $this->defenhong(); //检查是否爱心基金
                                     //   $this->dailiLevel($v['re_path']); //检查代理级别
                                     //   $this->dongshiLevel($v['re_path']);  //检查董事级别
                                        $this->jicha($v['id'],$user_id,$money_counts,time());  //级差
                                    }
                                }
                            }
                        }
                        else { // 新级差

                            $bl = $blArr[$thisLevel - 3];

                            $bl -= $fen;
                            $fen += $bl;
                            $money_count = $money * $bl / 100;

                            if ($money_count > 0) {

                             //   $this->rw_bonus($v['id'], $user_id, 3, $money_count);

                                $this->jicha($v['id'],$user_id,$money_count,time());  //级差

                                //  $this->fuwufei($re['id'],$inUserID,$money_count);
                                $this->total($v['id']); //统一操作数据
                                $this->defenhong(); //检查是否爱心基金
                             //   $this->dailiLevel($v['re_path']); //检查代理级别
                             //   $this->dongshiLevel($v['re_path']);  //检查董事级别
                            //    $this->fuwuyj($v['id'],$v['user_id'],$v['cpzj'],$v['cpzj_level'],$money_count,$v['u_level'],$v['father_id'],$v['re_id'],$v['re_path'],$v['p_path'],time());  //服务佣金
                            }
                            $lastMoneyCount = $money_count;
                            $is_pingji = 0;
                        }
                        $level = $thisLevel;
                        if ($level >= count($blArr)) { // 级差分完了，平级也分完了，不继续算了
                            continue;
                        }
                    }

                }




    /*******/

    public function jicha($id,$user_id,$money,$pdt){
        $ji=M('jicha');
        $data['uid']=$id;
        $data['user_id']=$user_id;
        $data['money']=$money;
        $data['is_jiesuan']=0;
        $data['pdt']='1461081600';
        $ji->add($data);

    }


/*******/

    /****检查代理级别***/
    public function dailiLevel($re_path)
    {
        $fee_rs = self::_getFee();
        $str8 = explode('|',$fee_rs['str8']);
        $s12 = explode('|',$fee_rs['s12']);
        $map['id']=array('in',$re_path);
        $re = M('fck')->where($map)->select();


        foreach($re as $v){
            for($i=0;$i<count($str8);$i++){
                if($v['team_yj'] >= $str8[$i]*10000){

                 $map = array();
                    $map['re_id'] = $v['id'];
                    $map['is_pay'] = array('gt', 0);
                    $field = "team_yj+cpzj_pv as yj";
                    $res = $this->where($map)->field($field)->order('yj desc')->select();  //最大区业绩


                   

                    $red = $this->where($map)->field($field)->order('yj asc')->select();  //最小区业绩
                    $bing = 0;
		             $small= 0;
		            foreach($res as $k => $vs){
                     if($k==0){
                    $bing= $vs['yj'];

		              }else{
			        $small += $vs['yj'];
		            }
		            } 

                   
                     if($res && count($res)>1){

                         if($small >= $s12[$i]*10000){

                             if($i+3 > $v['u_level'] && $i <= 3){

                                 $gai = M('fck')->where('id='.$v['id'])->setField('u_level',$i+3);
                             }
                         }

                     }

                }
            }
        }
    }


    // 检查董事级别
    public function dongshiLevel($re_path)
    {
        $fee_rs = self::_getFee();
        $str7 = explode('|',$fee_rs['str7']);
        $str4 = explode('|',$fee_rs['str4']);
        $map['id']=array('in',$re_path);
        $re = M('fck')->where($map)->select();
        foreach($re as $v){
            for($i=0;$i<count($str7);$i++){
                if($v['team_yj'] >= $str7[$i]*100000000){
                    $map = array();
                    $map['re_id'] = $v['id'];
                    $map['is_pay'] = array('gt', 0);
                    $field = "team_yj+cpzj_pv as yj";
                    $res = $this->where($map)->field($field)->order('yj desc')->select();

                    $red = $this->where($map)->field($field)->order('yj asc')->select();

					 $bing = 0;
		             $small= 0;
		            foreach($res as $k => $vs){
                     if($k==0){
                    $bing= $vs['yj'];

		              }else{
			        $small += $vs['yj'];
		            }
		            } 

                    if ($res && count($res)>1) {

                        if($small >= $str4[$i]*100000000){
                            if($i+7 > $v['u_level'] && $i <= 3){
                                $gai = M('fck')->where('id='.$v['id'])->setField('u_level',$i+7);
                            }
                        }
                    }
                }
            }
        }
    }





    // 董事加权分红
    public function jiaquanFh()
    {
        $fee_rs = self::_getFee();
        $str17 = explode('|',$fee_rs['str17']);
        $fh=M('fenhong')->where('id=1')->find();
        $map['u_level']=array('egt',7);
        $re = M('fck')->where($map)->select();
        foreach($re as $v){
            for($i=7;$i<$v['u_level']+1;$i++){
                $money_count = $fh['money']*$str17[$i-7]/100;
                $where['u_level']=array('eq',$v['u_level']);
                $where['is_pay']=array('gt',0);
                $ren = M('fck')->where($where)->count();

                $dmoney = $money_count/$ren;

                if($dmoney>0){
                    $this->rw_bonus($v['id'], $v['user_id'],4,$dmoney);
                    $fhs=M('fenhong')->where('id=1')->setField('money',0);
                 //   $this->fuwuyj($v['id'],$v['user_id'],$v['cpzj'],$v['cpzj_level'],$dmoney,$v['u_level'],$v['father_id'],$v['re_id'],$v['re_path'],$v['p_path'],time());  //服务佣金
                }
            }
        }
    }


    public function defenhong(){
        $fee_rs = self::_getFee();
        $str10 = $fee_rs['str10']*10000;
        $where['agent_max']=array('egt',$str10);
        $where['is_aa']=array('eq',0);
        $re=M('fck')->where($where)->select();
        foreach($re as $v){
            $res=M('fck')->where('id='.$v['id'])->setField('is_aa',1);
        }
    }



    // 检查职位级别
    public function benqi($uid,$shop_id,$money)
    {

        $re = M('benqi');
        $data['uid']=$uid;
        $data['shop_id']=$shop_id;
        $data['money']=$money;
        $data['adt']=time();
        $re->add($data);

    }


  //统一统计推荐人数,统一统计业绩,统一累团队业绩  is_re_nums是否为0,为0都要全部统计
    public function total($id){
        $cun=M('xiaoshou')->where('id='.$id)->find();
        $cunx=M('fuwu')->where('id='.$id)->find();
        $cunj=M('jifen')->where('id='.$id)->find();
        $cunb=M('benqi')->where('id='.$id)->find();
      if($cun['is_re_nums']==0 || $cunx['is_re_nums']==0 || $cunj['is_re_nums']==0 || $cunb['is_re_nums']==0){
          $gai=M('xiaoshou')->where('id='.$id)->setField('is_re_nums',1);
          $gaix=M('fuwu')->where('id='.$id)->setField('is_re_nums',1);
          $gaij=M('jifen')->where('id='.$id)->setField('is_re_nums',1);
          $gaib=M('benqi')->where('id='.$id)->setField('is_re_nums',1);
          if($gai || $gaix|| $gaij|| $gaib){

            //  $map = array();
            //  $map['id'] = array('eq',$cun['re_id']);
            //  $this->where($map)->setInc('re_nums',1);
              $u = $this->where('id='.$id)->find();
              $this->benqi($cun['id'],$u['shop_id'],$cun['money']);
            //  $this->dsfenhong($cun['money']);
              $this->ShouRu($cun['id'],$cun['user_id'],$cun['cpzj']);

          }

      }

    }



    public function ShouRu($uid,$user_id,$cpzj){

        $shouru = M ('shouru');
        $data['uid'] = $uid;
        $data['user_id'] = $user_id;
        $data['in_money'] = $cpzj;
        $data['in_time'] = time();
        $data['in_bz'] = "新会员加入";
        $shouru->add($data);

    }





/*
    public function shouru(){

        $data = array();
        $data['uid'] = $voo['id'];
        $data['user_id'] = $voo['user_id'];
        $data['in_money'] = $voo['cpzj'];
        $data['in_time'] = time();
        $data['in_bz'] = "新会员加入";
        $shouru->add($data);

    }*/





/************T050业务逻辑代码结束*****************/







    public function is_shoudong()
    {
      set_time_limit(0);
      $dangtian = strtotime(date('Y-m-d'));
      $fee_rs = self::_getFee();
      $map = array();
      $map['is_jiesuan']=array('eq',1);
      $map['is_pay']=array('gt',0);
      $mrs = $this->where($map)->select();
      foreach($mrs as $v){
          $qiantian = strtotime(date('Y-m-d',$v['pdt']));
          $days=round(($dangtian-$qiantian)/3600/24);
          $caozuo=$this->where('id='.$v['id'])->setField('is_jiesuan',0);
          if($caozuo && $days > $fee_rs['str6']){
          $money = $v['cpzj']*$fee_rs['s2']/100;
          //添加团队业绩
          $map = array();
          $map['id'] = array('in',$v['p_path']);
          $this->where($map)->setInc('team_yj',$money);

          $this->tuijj($v['cpzj_level'],$v['re_id'],$v['user_id'],$money); // 销售奖
          $this->yongjin($v['re_id'],$v['user_id'],$money); // 服务佣金

          $this->dailiLevel($v['p_path']);
          $this->jiChaJiang($v['p_path'],$v['user_id'],$money);  // 级差奖


          $this->dongshiLevel($v['p_path']);

          $this->jiaquanFh($money);
          $this->defenhong();
          $this->benqi($v['id'],$v['shop_id'],$v['cpzj']);

          }

      }

    }





    //计算奖金
    public function getusjj($uid,$type){
        set_time_limit(0);
        $mrs = $this->where('id='.$uid)->find();





    	if($mrs && $mrs['cpzj'] > 0){
            $fee_rs = self::_getFee();

      /*   if($type == 1) {
             //报单奖
             $this->baodanfei($mrs['shop_id'], $mrs['user_id'], $mrs['cpzj']);

         }  */

            //配股票
          //  $this->gupiao($mrs['user_id'], $mrs['cpzj']);

            $money = $mrs['cpzj']*$fee_rs['s2']/100;

            $this->tuijj($mrs['cpzj_level'],$mrs['re_id'],$mrs['user_id'],$money); // 销售奖
            $this->yongjin($mrs['re_id'],$mrs['user_id'],$money); // 服务佣金

            $this->dailiLevel($mrs['p_path']);
            $this->jiChaJiang($mrs['p_path'],$mrs['user_id'],$money);  // 级差奖


            $this->dongshiLevel($mrs['p_path']);

            $this->jiaquanFh($money);
            $this->defenhong();

            //添加团队业绩
            $map = array();
            $map['id'] = array('in',$mrs['p_path']);
            $this->where($map)->setInc('team_yj',$money);

           // $this->xiezhu($mrs['re_path'],$mrs['user_id'],$money); // 直推奖





          //  $this->dongshi($mrs['user_id'],$money);




         /*   $pvArr = explode("|",$fee_rs['s1']);
            $pv = $pvArr[$mrs['u_level'] - 1]; // pv值
            M('fee')->where('id=1')->setInc('all_yj',$pv);
            if ($type != 2) { // 50%的报单币加50%的复投币，是没有直推奖的

            }
          */


         //  $this->duipeng();
        //   $this->jiandianjiang($mrs['p_path'],$mrs['user_id']);
         //   $this->cengpeng($mrs['p_path'],$mrs['user_id']);
      //      $this->jiChaJiang($mrs['re_path'],$mrs['user_id'],$pv);

    	/*	if($type>=1 && $mrs['open_id'] == $mrs['shop_id']){ // 在前台开通且是报单中心才有报单奖
  			   //报单奖
               $this->baodanfei($mrs['shop_id'],$mrs['user_id'],$pv);
    		}

   */


      //       // 添加公司业绩
      //       M('fee')->where('id=1')->setInc('all_yj',$mrs['cpzj']);
      //       //检测职位
      //       $this->checkGetLevel($mrs['re_path']);
      //       // 检测重复消费
      //       $this->checkXfMoney();





        }
        unset($mrs);
    }




    //销售奖
    private function tuijj($cpzj_level,$re_id,$inUserID,$cpzj){
        $fee_rs = self::_getFee();
        $str3 = explode('|',$fee_rs['str3']);
        $priiArr = $str3[$cpzj_level]/100; //奖金


        $user = $this->field('u_level')->find($re_id);
        if (!$user) {
            return;
        }
        $money_count = $cpzj * $priiArr;
         if ($money_count>0){
            $this->rw_bonus($re_id,$inUserID,1,$money_count);
         //   $this->fuwufei($re_id,$inUserID,$money_count);
         }
    }
    //服务佣金
    public function yongjin($re_id,$inUserID,$cpzj){
        $fee_rs = self::_getFee();
        $str9 = explode('|',$fee_rs['str9']);
        $str12 = explode('|',$fee_rs['str12']);
        $str29 = explode('|',$fee_rs['str29']);
        $s9 = explode('|',$fee_rs['s9']);
        $level  = array_search($cpzj,$s9);
        $re = $this->find($re_id);
        if($re['re_nums']>=5 && $level==0){
           $bili =$str9[4];
        }else{
            $bili =$str9[$re['re_nums']-1];
        }

        if($re['re_nums']>=5 && $level==1){
            $bili =$str12[4];
        }else{
            $bili =$str12[$re['re_nums']-1];
        }

        if($re['re_nums']>=5 && $level==2){
            $bili =$str29[4];
        }else{
            $bili =$str29[$re['re_nums']-1];
        }

       $money_count = $cpzj*$bili/100;

        if ($money_count>0){
            $this->rw_bonus($re_id,$inUserID,2,$money_count);
            //   $this->fuwufei($re_id,$inUserID,$money_count);
        }

    }
    // 级差奖
    public function jiChaJiang($p_path,$inUserID,$cpzj)
    {
        $fee_rs = self::_getFee();
        $blArr = explode("|", $fee_rs['s6']);
        //  $pingJiBlArr = explode("|", $fee_rs['s4']);
        $map = array();
        $map['id'] = array('in',$p_path);
        $map['u_level'] = array('egt',1);
        $fck_rs = $this->where($map)->field('id,u_level')->order('re_level desc')->select();
        $fen = 0; // 已分金额
        $level = 0; // 分到的级别数
        $is_pingji = 0; // 是否分了平级奖
        // $maxPingji = count($pingJiBlArr); // 这个是为了可以处理多个平级
        $lastMoneyCount = 0; // 最后一次拿的级差奖，用这个金额分平级奖
        foreach ($fck_rs as $key => $re) {
            $thisLevel = $re['u_level'];
            if ($thisLevel <= $level) { // 当前级别太小，平级都拿不到
                continue;
            }
            if ($thisLevel == $level) { // 平级奖

                $maps = array();
                $maps['father_id'] = $re['id'];
                $maps['is_pay'] = array('gt', 0);
                $maps['u_level'] = array('eq', 4);
                $liangge = $this->where($maps)->count();
                if($liangge < 2){
                   return;
                }

                $map = array();
                $map['father_id'] = $re['id'];
                $map['is_pay'] = array('gt', 0);
                $field = "team_yj+cpzj as yj";
                $res = $this->where($map)->field($field)->order('yj desc')->select();

                $user=$this->find($re['id']);

                $bing = 0;
                $small= 0;
                foreach($res as $k => $vs){
                    if($k==0){
                        $bing= $vs['yj'];

                    }else{
                        $small = $vs['yj'];

                        if($small < $user['team_yj']){
                            $money_counts = $cpzj *0.01;
                            $this->rw_bonus($re['id'], $inUserID, 3, $money_counts);
                        }
                    }
                }
            }
            else { // 新级差
                $bl = $blArr[$thisLevel - 1];
                $bl -= $fen;
                $fen += $bl;
                $money_count = $cpzj * $bl / 100;
                if ($money_count > 0) {
                    $this->rw_bonus($re['id'], $inUserID, 3, $money_count);
                  //  $this->fuwufei($re['id'],$inUserID,$money_count);
                }
                $lastMoneyCount = $money_count;
                $is_pingji = 0;
            }
            $level = $thisLevel;
            if ($level >= count($blArr)) { // 级差分完了，平级也分完了，不继续算了
                return;
            }
        }
    }
    // 检查代理级别






    public function get_real_ip(){

        $ip=false;if(!empty($_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip = $_SERVER["HTTP_CLIENT_IP"];

        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){

            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);

            if ($ip){

                array_unshift($ips, $ip); $ip = FALSE;

            }

            for ($i = 0; $i < count($ips); $i++){

                if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])){

                    $ip = $ips[$i];

                    break;


                }

            }


        }


        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);


    }





    //配股
    private function gupiao($inUserID,$cpzj){
        $fee_rs = self::_getFee();
        $priiArr = $fee_rs['s2']/100; //配股比例

        $map['user_id']=array('eq',$inUserID);
        $jia=M('fck')->where($map)->setInc('agent_gp',$priiArr*$cpzj);

    }


    //协助奖
    private function xiezhu($re_path,$inUserID,$cpzj){
        $fee_rs = self::_getFee();
        $priiArr = $fee_rs['s3']/100; //奖金

        $newstr = substr($re_path,0,strlen($re_path)-1);
        $newstr1 = substr($newstr,1,strlen($newstr )-1);
        $renren=explode(',',$newstr1);
        rsort($renren);
        array_splice($renren,3);
        $shangji=$renren[1];

        if ($shangji == '') {
            return;
        }
        $money_count = $cpzj * $priiArr;
        if ($money_count>0){
            $this->rw_bonus($shangji,$inUserID,2,$money_count);
          //  $this->fuwufei($shangji,$inUserID,$money_count);
        }
    }


    //服务费
    private function fuwufei($id,$inUserID,$money){
        $fee_rs = self::_getFee();
        $priiArr = $fee_rs['str7']; //比例
        $str7 = explode('|',$priiArr);

        $re_p=M('fck')->where('id='.$id)->find();
        $re_path = $re_p['re_path'];
        $newstr = substr($re_path,0,strlen($re_path)-1);
        $newstr1 = substr($newstr,1,strlen($newstr )-1);
        $renren=explode(',',$newstr1);
        rsort($renren);
        array_splice($renren,3);
        foreach($renren as $k=>$v){
            $money_count = $money * $str7[$k]/100;
            if($v == ''){
              return;
            }
            if ($money_count>0){
                $this->rw_bonus($v,$inUserID,3,$money_count,$k+1);

            }
        }
    }






    // 检查职位级别
    public function dongshi($inUserID,$cpzj)
    {
        $fee_rs = self::_getFee();
        $str4 = $fee_rs['str4']/100;
        $map['u_level']=array('eq',5);
        $re = M('fck')->where($map)->select();
        $count = M('fck')->where($map)->count();
        $cp = ($cpzj*$str4)/$count;
        foreach($re as $v){
            $this->rw_bonus($v['id'], $inUserID, 7, $cp);
        }

    }







    //见点奖
    public function jiandianjiang($pPath='',$inUserID=0,$cpzj=0){
        // 无限层见点0.5% 。备注：推荐1到9人且投资金额必须大于等于本人的投资金额。见点奖励累积为本人投资金额的1到9倍
        $fee_rs = self::_getFee();
        $prii = $fee_rs['s4'] / 100;
        $money = $cpzj * $prii;
        if ($money <= 0) {
            return;
        }
        $cengArr = explode("|", $fee_rs['str8']);
        $fengArr = explode("|", $fee_rs['str2']);
        $limit = max($cengArr);
        $maxReNum = count($cengArr);
        $map = array();
        $map['id'] = array('in',$pPath);
        $fck_rs = $this->where($map)->field('id,feng_jiandian,u_level,cpzj')->order('p_level desc')->limit($limit)->select();
        foreach ($fck_rs as $key => $re) {
            // 怕他到时要升级，那推荐多少个高于自身以前的处理就比较麻烦，直接在这里查
            $reNum = $this->where("is_pay>0 and re_id={$re['id']} and u_level>={$re['u_level']}")->count(); // 空单也算
            if (!$reNum) {
                continue;
            }
            if ($reNum > $maxReNum) {
                $reNum = $maxReNum;
            }
            $ceng = $cengArr[$reNum - 1];
            if ($ceng <= $key) { // 拿不到这么多层
                continue;
            }
            // 进行封顶
            $feng = $fengArr[$reNum - 1] * $re['cpzj'];
            $money_count = $money; // 封顶操作会影响金额，给新变量
            if ($re['feng_jiandian'] + $money_count > $feng) {
                $money_count = $feng - $re['feng_jiandian'];
            }
            // 封顶结束
            if ($money_count > 0) {
                $this->where('id='.$re['id'])->setInc('feng_jiandian',$money_count);
                $this->rw_bonus($re['id'],$inUserID,4,$money_count);
            }
        }
    }

    // // 检测重复消费
    // public function checkXfMoney()
    // {
    //     $fee_rs = self::_getFee();
    //     $mustMoney = $fee_rs['s6'];
    //     $map = array();
    //     $map['agent_cf'] = array('egt',$mustMoney);
    //     $map['id'] = array('gt',1);
    //     $fck_rs = $this->where($map)->field('id,user_id,b_point_num')->order('id asc')->select();
    //     foreach ($fck_rs as $key => $re) {
    //         $dec = $this->where('id='.$re['id'])->setDec('agent_cf',$mustMoney);
    //         if ($dec) {
    //             $addNewPoint = $this->getNetBPoint($re['id'],$re['user_id'],$re['b_point_num']);
    //             if (!$addNewPoint) {
    //                 $this->where('id='.$re['id'])->setInc('agent_cf',$mustMoney);
    //             }
    //             else {
    //                 $this->where('id='.$re['id'])->setInc('agent_kt',$mustMoney);
    //                 $this->where('id='.$re['id'])->setInc('b_point_num',1);
    //             }
    //         }
    //     }
    // }

    // // 给B网点位
    // public function getNetBPoint($uid,$user_id,$num=0)
    // {
    //     $netB = M('fck2');
    //     ++$num;
    //     $field = 'id,treeplace,p_path,p_level,l,r';
    //     $nowUser = $netB->field($field)->find(1);
    //     $father = false;
    //     do{
    //         $children = $netB->where('father_id='.$nowUser['id'])->field($field)->order('treeplace asc')->select();
    //         if (!$children) {
    //             $treeplace = 0;
    //             $father = $nowUser;
    //         }
    //         elseif (count($children) == 1) {
    //             $treeplace = 1;
    //             $father = $nowUser;
    //         }
    //         else {
    //             $nowUser = $nowUser['l'] > $nowUser['r'] ? $children[1] : $children[0];
    //         }
    //     }while(!$father);
    //     $newUserData = array();
    //     $newUserData['uid'] = $uid;
    //     $newUserData['user_id'] = $user_id;
    //     $newUserData['father_id'] = $father['id'];
    //     $newUserData['treeplace'] = $treeplace;
    //     $newUserData['p_path'] = $father['p_path'].$father['id'].',';
    //     $newUserData['p_level'] = $father['p_level'] + 1;
    //     $newUserData['num'] = $num;
    //     $newUser = $netB->add($newUserData);
    //     if ($newUser) {
    //         $this->bNetXiaoJiao($newUserData['father_id'],1,$newUserData['treeplace']);
    //         $this->bNetJianDian($newUserData['p_path'],$user_id);
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }

    public function bNetXiaoJiao($id,$f4=1,$tp)
    {
        if ($id<=0) {
            return;
        }
        $fck = M('fck2');
        if ($tp == 0) {
            $fck->where('id='.$id)->setInc('l',$f4);
        }
        else {
            $fck->where('id='.$id)->setInc('r',$f4);
        }
        $father = $fck->field('id,treeplace,father_id')->find($id);
        $this->bNetXiaoJiao($father['father_id'],1,$father['treeplace']);
    }

    // B网见点
    public function bNetJianDian($pPath,$inUserID)
    {
        $fee_rs = self::_getFee();
        $cengAndMoney = explode("-", $fee_rs['s15']); // 层-￥
        $ceng = (int)$cengAndMoney[0];
        $money = (int)$cengAndMoney[1];
        if ($money <= 0 || $ceng<=0) {
            return;
        }
        $map = array();
        $map['id'] = array('in',$pPath);
        $fck_rs = M('fck2')->where($map)->field('uid')->order('p_level desc')->limit($ceng)->select();
        foreach ($fck_rs as $key => $re) {
            $this->rw_bonus($re['uid'],$inUserID,7,$money);
        }
    }



    // 职位极差
/*    public function jiChaJiang($re_path,$inUserID,$cpzj)
    {
        $fee_rs = self::_getFee();
        $blArr = explode("|", $fee_rs['s3']);
        $map = array();
        $map['id'] = array('in',$re_path);
        $map['get_level'] = array('gt',0);
        $fck_rs = $this->where($map)->field('id,get_level')->order('re_level desc')->select();
        $fen = 0;
        $level = 0;
        foreach ($fck_rs as $key => $re) {
            if ($level >= count($blArr)) {
                return;
            }
            if ($re['get_level'] <= $level) {
                return;
            }
            $bl = $blArr[$re['get_level']-1] / 100 - $fen;
            if ($bl <= 0) {
                continue;
            }
            $fen += $bl;
            $money_count = $cpzj * $bl;
            if ($money_count > 0) {
                $this->rw_bonus($re['id'],$inUserID,6,$money_count);
            }

        }
    }


*/

    // 检测级别
    public function checkGetLevel($re_path='')
    {
        $fee_rs = self::_getFee();
        $numArr = explode("|", $fee_rs['s19']);
        $minYj = $fee_rs['s5'];
        $maxLevel = count($numArr);
        $map = array();
        $map['get_level'] = array('lt',$maxLevel); // 已经是最高级就不理了
        $map['id'] = array('in',$re_path);
        $fck_rs = $this->where($map)->field('id,get_level')->order('p_level desc')->select();
        foreach ($fck_rs as $key => $re) {
            for ($i=$maxLevel; $i > $re['get_level']; $i--) { 
                if ($i == 1) { // 第一个级别与众不同
                    // $map = array();
                    // $map['re_id'] = $re['id'];
                    // $map['cpzj+team_yj'] = array('egt',$minYj);
                    $childrenNum = $this->where("`re_id`={$re['id']} and (`cpzj`+`team_yj`>={$minYj})")->count();
                    if ($childrenNum >= $numArr[$i-1]) {
                        $this->where('id='.$re['id'])->setField('get_level',$i);
                        continue 2; // 这里不用这句也一样，只是为了好理解
                    }
                }
                else { // 其它级别
                    $map = array();
                    $map['re_id'] = $re['id'];
                    $map['get_level'] = array('egt',$i-1);
                    $childrenNum = $this->where($map)->count();
                    if ($childrenNum >= $numArr[$i-1]) {
                        $this->where('id='.$re['id'])->setField('get_level',$i);
                        continue 2; // 这个注意一下，是2
                    }
                }
            }
        }
    }

    public function getBonus(){
        $bonus = M('bonus');
        return $bonus;
    }

    //报单中心平级奖
    private function pingji($shop_id,$inUserID,$cpzj){
        $fee_rs = $this->getFee();
        $blArr = explode("|", $fee_rs['s6']);
        $shop = $this->where('id='.$shop_id)->field('shop_id')->find();
        $shop_id = $shop['shop_id'];
        foreach ($blArr as $bl) {
            $shop = $this->where('id='.$shop_id)->field('shop_id')->find();
            if($shop){
                $money = $cpzj * $bl / 100;
                if($money > 0){
                    $this->rw_bonus($shop_id,$inUserID,3,$money);
                }
                $shop_id = $shop['shop_id'];
            }
            else{
                return;
            }
        }    
        
    }
    
    // //对碰奖
    // private function duipeng(){
    // 	$fee = M ('fee');
    // 	$fee_rs = $fee->field('s1,s9,s13,str5')->find(1);
    // 	$s19 = explode("|",$fee_rs['s13']);		//各级对碰比例
    // 	$s9 = explode("|",$fee_rs['s9']);		//代理级别费用
    // 	$s5 = explode("|",$fee_rs['s1']);		//封顶
    // 	$one_mm = $s9[0];
    // 	$fck_array = 'is_pay>=1 and ((shangqi_l+benqi_l)>0 or (shangqi_r+benqi_r)>0)';
    // 	$field = 'id,user_id,shangqi_l,shangqi_r,benqi_l,benqi_r,is_fenh,p_path,re_nums,nickname,u_level,re_id,day_feng,re_path,re_level,peng_num';
    // 	$frs = $this->where($fck_array)->field($field)->select();
    // 	//BenQiL  BenQiR  ShangQiL  ShangQiR
    // 	foreach ($frs as $vo){
    // 		$L = 0;
    // 		$R = 0;
    // 		$L = $vo['shangqi_l'] + $vo['benqi_l'];
    // 		$R = $vo['shangqi_r'] + $vo['benqi_r'];
    // 		$Encash    = array();
    // 		$NumS      = 0;//碰数
    // 		$money     = 0;//对碰奖金额
    // 		$Ls        = 0;//左剩余
    // 		$Rs        = 0;//右剩余
    // 		$this->touch1to1($Encash, $L, $R, $NumS);
    // 		$Ls = $L - $Encash['0'];
    // 		$Rs = $R - $Encash['1'];
    // 		$myid = $vo['id'];
    // 		$myusid = $vo['user_id'];
    // 		$ss = $vo['u_level']-1;
    // 		$feng = $vo['day_feng'];
    // 		$re_nums = $vo['re_nums'];
    // 		$re_path = $vo['re_path'];
    // 		$re_level = $vo['re_level'];
    // 		$ppath = $vo['p_path'];
    // 		$is_fenh = $vo['is_fenh'];
    
    // 		$ul =  $s19[$ss]/100;
    // 		$money = $one_mm* $NumS *$ul;//对碰奖 奖金
    // 		if($money>$s5[$ss]){
    // 			$money = $s5[$ss];
    // 		}
    
    // 		if ($feng>=$s5[$ss]){
    // 			$money=0;
    // 		}else{
    // 			$jfeng=$feng+$money;
    // 			if ($jfeng>$s5[$ss]){
    // 				$money=$s5[$ss]-$feng;
    // 			}
    // 		}
    // 		$this->query('UPDATE __TABLE__ SET `shangqi_l`='. $Ls .',`shangqi_r`='. $Rs .',`benqi_l`=0,`benqi_r`=0,peng_num=peng_num+'.$NumS.' where `id`='. $vo['id']);
    // 		$money_count = $money;
    // 		if($money_count>0&&$is_fenh==0){
    // 			$this->rw_bonus($myid,$myusid,2,$money_count);
    // 		}
    // 	}
    // 	unset($fee,$fee_rs,$frs,$vo);
    // }
    
     //对碰1：1
    public function touch1to1(&$Encash,$xL=0,$xR=0,&$NumS=0){
        $xL = floor($xL);
        $xR = floor($xR);

        if ($xL > 0 && $xR > 0){
            if ($xL > $xR){
                $NumS = $xR;
                $xL = $xL - $NumS;
                $xR = $xR - $NumS;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            if ($xL < $xR){
                $NumS = $xL;
                $xL   = $xL - $NumS;
                $xR   = $xR - $NumS;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            if ($xL == $xR){
                $NumS = $xL;
                $xL   = 0;
                $xR   = 0;
                $Encash['0'] = $Encash['0'] + $NumS;
                $Encash['1'] = $Encash['1'] + $NumS;
            }
            $Encash['2'] = $NumS;
        }else{
            $NumS = 0;
            $Encash['0'] = 0;
            $Encash['1'] = 0;
        }
    }
    
    //网络费
    public function wlf($uid,$inUserID) {
        $bonus = $this->getBonus();
         $fee_rs = $this->getFee();
         $money = $fee_rs['s5']; //金额
         $zhouqi = $fee_rs['s3'] * 86400; //收费周期，秒数
         $nowday = strtotime(date('Y-m-d'));
         $lt_time = $nowday - $zhouqi;
         
         if($uid>0){    //开通成功时单收
             $bid = $this->_getTimeTableList($uid);
            $bonus->execute("UPDATE __TABLE__ SET b0=b0-".$money.",b4=b4-".$money." WHERE id={$bid}"); //加到记录表
            $this->execute("update __TABLE__ set agent_use=agent_use-".$money.",`wlf`=".$nowday." where id=".$uid);//加到fck
            $this->addencAdd($uid,$inUserID,-$money,4,0,0,$wlf + $zhouqi);
            return;
         }
         
         $where = array();
         $where['is_pay'] = array('gt',0);
         $where['wlf'] = array('elt',$lt_time);
         
         $rs = $this->where($where)->field('id,user_id,wlf')->select();
         
         foreach ($rs as $re) {
             $myid = $re['id'];
             $inUserID = $myid['user_id'];
             $wlf = $re['wlf'];
             $bid = $this->_getTimeTableList($myid);
             while($nowday - $wlf >= $zhouqi) {
                 if($money > 0){
                    $bonus->execute("UPDATE __TABLE__ SET b0=b0-".$money.",b4=b4-".$money." WHERE id={$bid}"); //加到记录表
                    $this->execute("update __TABLE__ set agent_use=agent_use-".$money.",`wlf`=wlf+".$zhouqi." where id=".$myid);//加到fck
                    $this->addencAdd($myid,$inUserID,-$money,4,0,0,$wlf + $zhouqi);
                }
                $wlf += $zhouqi;
                if($zhouqi <=0) break;
             }
         }
    }

    public function fenhong($money=0)
    {
        if ($money <= 0) {
            return;
        }
        $fee_rs = self::_getFee();
        // $all_yj = $fee_rs['all_yj'];
        // $fen_yj = $all_yj * $fee_rs['str9'] / 100; // 用来分的

        $maxMoney = $fee_rs['s13'];
        $bei = $fee_rs['s19'];

        $allF4 = $this->where('`zjj`<`cpzj`*'.$bei)->sum('f4');
        $everyMoney = $money / $allF4;
        if ($everyMoney <= 0) {
            return;
        }
        elseif ($everyMoney > $maxMoney) {
            $everyMoney = $maxMoney;
        }
        $fck_rs = $this->where('`zjj`<`cpzj`*'.$bei)->field('id,cpzj,zjj,f4,user_id')->select();
        foreach ($fck_rs as $key => $re) {
            $money_count = $everyMoney * $re['f4'];
            $feng = $re['cpzj'] * $bei;
            if ($money_count + $re['zjj'] > $feng) {
                $money_count = $feng - $re['zjj'];
            }
            if ($money_count > 0) {
                $this->rw_bonus($re['id'],$re['user_id'],5,$money_count);
            }
        }

        M('fee')->where('id=1')->setField('all_yj',0);

    }

    // public function fenhong()
    // {
    //     $fee_rs = self::_getFee();
    //     $money = $fee_rs['str4'];
    //     if ($money<=0) return;
    //     $fanli_max_num = $fee_rs['s4']; //最大数
    //     $fanli_time = strtotime(date('Y-m-d'));
    //     $fanli_time = time(); //测试
    //     $where['fanli_time'] = array('lt',$fanli_time);
    //     $where['is_lockfh'] = array('eq',0);
    //     $where['fanli_num'] = array('lt',$fanli_max_num);

    //     $count = $this->where($where)->count();
    //     $pageSize = 100;
    //     $pageNum = ceil($count / $pageSize);
    //     for ($p=0; $p < $pageNum; $p++) { 
    //         $fck_rs = $this->where($where)->order('id asc')->page($p.','.$pageSize)->field('id,user_id')->select();
    //         foreach ($fck_rs as $re) {
    //             $re['fanli_time'] = $fanli_time;
    //             $s = $this->where('id='.$re['id'].' and fanli_time<'.$fanli_time)->setField('fanli_time',$fanli_time);
    //             if ($s) {
    //                 $this->where('id='.$re['id'])->setInc('fanli_num',1);
    //                 $this->rw_bonus($re['id'],$re['user_id'],3,$money);
    //             }
    //         }
    //     }

    // }

    //层碰(回本奖)
//    private function cengpeng($inUserID,$ppath,$plevel=0){
//        $fee_rs = $this->getFee();
//        $s13 = explode('|', $fee_rs['s13']);
//        $cha_c = $fee_rs['s19'];  //层数
//
//        $la_plv = $plevel-$cha_c;
//
//        $lirs = $this->where('id in (0'.$ppath.'0) and p_level>='.$la_plv)->order('p_level desc')->field('id,user_id,u_level,is_fenh')->select();
//        $i = 0;
//        foreach($lirs as $lrs){
//            $ttid = $lrs['id'];
//            $ttlv = $lrs['u_level'];
//            $ssss = $ttlv-1;
//            $is_fenh = $lrs['is_fenh'];
//            $l_nn = 0;
//            $r_nn = 0;
//            $l_rs = $this->where('father_id='.$ttid.' and treeplace=0')->field('id')->find();
//            if($l_rs){
//                $l_id = $l_rs['id'];
//                $l_ss = $this->where('(p_path like "%,'.$l_id.',%" or id='.$l_id.') and p_level='.$plevel.' and is_pay>0')->count();
//               
//                // $l_nn = (int)$l_ss['mypv'];
//            }
//            unset($l_rs);
//            $r_rs = $this->where('father_id='.$ttid.' and treeplace=1')->field('id')->find();
//            if($r_rs){
//                $r_id = $r_rs['id'];
//                $r_ss = $this->where('(p_path like "%,'.$r_id.',%" or id='.$r_id.') and p_level='.$plevel.' and is_pay>0')->count();
//                
//                // $r_nn = (int)$r_ss['mypv'];
//            }
//            unset($r_rs);
//
//            if($l_ss>0&&$r_ss>0){
//                // if($l_nn>$r_nn){
//                //     $money_count = $s1*$r_nn;
//                // }else{
//                //     $money_count = $s1*$l_nn;
//                // }
//                // $maxc = $s5[$ssss];
//                // if($money_count>$maxc){
//                    $money_count = $s13[$i];
//                // }
//                if($money_count>0&&$is_fenh==0){
//                    $this->rw_bonus($ttid,$inUserID,1,$money_count);
//                }
//                break;
//            }
//            $i++;
//        }
//        unset($fee,$fee_rs,$lirs,$lrs,$r_ss,$l_ss);
//    }

   //重消见点奖
   public function gwJiandianjiang($ppath,$inUserID=0){
        $fee_rs = self::_getFee();
        $money = $fee_rs['s15']; //见点奖百分比
        if($money <= 0) return;
        $limit = $fee_rs['str5']; //最大层

        $fck_rs = $this->where('id in (0'.$ppath.'0)')->field('id,is_xf')->order('p_level desc')->limit($limit)->select();
        foreach ($fck_rs as $re) {
            if ($re['is_xf'] == 0) {
                continue;
            }
            $this->rw_bonus($re['id'],$inUserID,5,$money);
        }
       unset($fee_rs,$fck_rs);
   }

   
    //领导奖
//    public function ldj($uid,$re_path,$inUserID,$cpzj){
//
//        $bonus = $this->getBonus();
//        $fee_rs = $this->getFee();
//
//        $s6 = explode ( "|", $fee_rs ['s6'] ); //代数
//        $s3 = $fee_rs ['s3'] /100; //金额
//
//        $where = "id in (0".$re_path."0)";
//        $list = $this->where($where)->field('id,user_id,u_level,re_nums')->order('re_level desc')->limit($s6[2])->select();
//   
//        $i = 0;
//        foreach ($list as $vo) {
//            $i++;
//            $money = $s3*$cpzj;
//            
//            $re_nums = $vo['re_nums'];
//            if($re_nums == 0){
//                continue;
//            }
//
//            $lev = 0;
//            if($re_nums == 1 or $re_nums == 2){
//                $lev = 1;
//            }elseif($re_nums>=3 && $re_nums<5){
//                $lev = 2;
//            }elseif($re_nums>=5){
//                $lev = 3;
//            }
//
//            if($i > $s6[$lev-1]){
//                $money = 0;
//            }
//
//            if ($money > 0) {
//                $this->rw_bonus($vo['id'],$inUserID,3,$money);
//            }  
//        }
//
//        unset($fee_rs,$bonus,$frs,$vo,$money,$list);
//
//    }

    //分红奖
//    public function fhj($inUserID,$p_path,$treeplace=0,$cpzj=0){
//        $this->emptyTime();
//
//        $fee_rs = $this->getFee();
//        $s12 = $fee_rs['s12']; //分红奖百分比
//        $s11 = $fee_rs['s11'];//分红奖封顶
//
//        $s15 = $fee_rs['s15']+0;   //层数
//        $str5 = $fee_rs['str5']+0; //收入值
//        $str1 = $fee_rs['str1']+0; //人数
//
//        // $where = "id in (0".$p_path."0) and re_nums>=".$str1." and xy_money>=".$str5;
//        $where = "id in (0".$p_path."0)";
//        $list = $this->where($where)->field('id,user_id,p_level,l,r,treeplace,re_nums,xy_money')->order('p_level desc')->select();
//       
//        foreach ($list as $vaoo) {
//
//            $man  = 0;
//            $l = $vaoo['l'];
//            $r = $vaoo['r'];
//            $man = $this->chenkMan($vaoo['id'],$vaoo['p_level'],$s15);
//
//            if($man == 1 && $vaoo['re_nums']>=$str1 && $vaoo['xy_money']>= $str5){
//                $tt = 0;
//                if($l > $r){
//                    $tt = 1;
//                }
//
//                if($treeplace == $tt){
//                    $money_count = $s12 * $cpzj/100;
//                    $money_count = $this->zfd_jj($vaoo['id'],$money_count );
//                    if($money_count > 0){
//                        $this->rw_bonus($vaoo['id'],$inUserID,4,$money_count);
//                    }  
//                }
//            }
//            
//            $treeplace =  $vaoo['treeplace'];
//        }
//
//        unset($fee_rs, $list,$where,$vaoo,$treeplace);
//    }

    //检测第n层是否排满
    public function chenkMan($uid,$p_level,$ceng){
        $get_level = $p_level + $ceng;
        $man = 0;

        $where = "p_path like '%".$uid."%' and p_level=".$get_level." and is_pay>0";
        $menber_nums = $this->where($where)->count();

        $nums = pow(2,$ceng);
        if($menber_nums == $nums){
            $man = 1;
        }

        return $man;

    }

    //封顶
//    public function zfd_jj($uid,$money=0){
//        $fee_rs = $this->getFee();
//        $s11 = $fee_rs['s11'];//分红奖封顶      
//
//        $rs = $this->where('id='.$uid)->field('day_feng')->find();
//        if($rs){
//            $day_feng = $rs['day_feng'];
//            if($money > $s11){
//                $money = $s11;
//            }
//
//            if($day_feng >= $s11){
//                $money = 0;
//            }else{
//                $tt_money = $money + $day_feng;
//                if( $tt_money > $s11){
//                    $money = $s11-$day_feng;
//                }
//            }
//        }
//
//        return $money;
//    } 


    //报单费
    public function baodanfei($shop_id,$inUserID,$cpzj){
        $fee_rs = self::_getFee();
        $prii = $fee_rs['s1'];
        $money_count = $cpzj * $prii / 100;
        if($money_count > 0){
             $this->rw_bonus($shop_id,$inUserID,5,$money_count);
        }
    }

    //报单费 分公司所得
    public function baodanfei2($company_id,$inUserID,$cpzj=0,$cp_time){
        $fee_rs = $this->getFee();

        $levelArr = explode("|", $fee_rs['s9']); //投资时间级别
        $i=0;   //对应级别
        for(;$i<count($levelArr); $i++){
            if($levelArr[$i] == $cp_time) break;
        }
        if($i == count($levelArr)) return;
        
        $s14Arr = explode("|", $fee_rs ['str2']);
        $s14 = $s14Arr[$i];
        $money = $s14 * $cpzj /100;
        // $uid = $_SESSION[C('USER_AUTH_KEY')];
        
        if($money > 0){
             $this->rw_bonus($company_id,$inUserID,3,$money);       
        }
        unset($fee,$fee_rs,$frs,$s14,$list,$bonus);
    }


    

    public function addfh($uid,$money,$fhid,$pdt){
        $fehlist = M('fehlist');
        $data = array();
        $data['uid'] = $uid;
        $data['bankid'] = $fhid;
        $data['money'] = $money;
        $data['pdt'] = $pdt;

        $fehlist->add($data);
        unset($data,$fehlist);
    }





    public function jiandian($inUserID)
    {
        $fee_rs = self::_getFee();
        $money = $fee_rs['str4'];
        $rs = $this->where('is_pay>0')->field('id,b6')->order('pdt desc')->select();
        foreach ($rs as $key => $re) {
            if ($key < 10) {
                continue;
            }
            if ($re['b6'] >= $fee_rs['str9']) {
                continue;
            }
          //  $this->where('id='.$re['id'])->setInc('b6',$money);
            $this->rw_bonus($re['id'],$inUserID,6,$money);
        }
    }



    //各种扣税
    public function rw_bonus($myid,$inUserID=0,$bnum=0,$money_count=0,$k=0){
        $fee_rs = self::_getFee();
        $user = $this->field('id,day_feng,u_level,is_fenh')->find($myid);
        if ($user['is_fenh'] != 0) { // 奖金关闭
            return;
        }

        if($myid == 10799 || $myid == 10800 || $myid == 10801 ){

            return;
        }



        $suishou = $fee_rs['s19'] / 100; //扣税收
        $xiaofei = $fee_rs['s1'] / 100; //扣消费基金
        $aixin = $fee_rs['str11'] / 100; //扣消费基金


        if($user['is_aa']==1){

            $aixinqian=$money_count*$aixin;
        }else{
            $aixinqian=0;
        }
        $suiqian=$money_count*$suishou;
        $xiaofeiqian=$money_count*$xiaofei;
        $last_m = $money_count-$suiqian-$xiaofeiqian-$aixinqian;


     /*   $prii_ds = $fee_rs['s12'] / 100; // 扣除董事基金
        $prii_cs = $fee_rs['s15'] / 100; // 扣除慈善基金
        $prii_cf = $fee_rs['s6'] / 100; // 进入复投帐户

        $kou_ds = $money_count * $prii_ds;
        $kou_cs = $money_count * $prii_cs;
        $last_m = $money_count - $kou_ds - $kou_cs;
        $agent_cf = $last_m * $prii_cf;
        $agent_use = $last_m * (1 - $prii_cf);
        $agent_kt = 0;
    */








        $bonus = M('bonus');
        $bid = $this->_getTimeTableList($myid);
        $inbb = "b".$bnum;
        $usqla = "";
       // if($bnum==2){
           // $usqla = ",day_feng=day_feng+".$money_count.""; 
       // }
     /*   if ($bnum == 7) {
            $agent_cf = 0;
            $agent_use = 0;
            $agent_kt = $last_m;
        }  */

        // $kousql = ",b9=b9-".$agent_cf.",b10=b10-".$gl.",b11=b11-".$ax.",b12=b12-".$agent_gc;
        $kousql = ",b9=b9-".$suiqian.",b5=b5-".$xiaofeiqian.",b8=b8+".$aixinqian;

        $bonus->execute("UPDATE __TABLE__ SET b0=b0+".$last_m.",".$inbb."=".$inbb."+".$money_count."".$kousql." WHERE id={$bid}"); //加到记录表

        

        $this->execute("update __TABLE__ set agent_use=agent_use+".$last_m.",agent_gp=agent_gp-".$xiaofeiqian.",agent_max=agent_max+".$last_m." where id=".$myid);//加到fck
        
        unset($bonus);


        if($money_count>0){
            $this->addencAdd($myid,$inUserID,$money_count,$bnum,$k);
        }



               if ($suiqian > 0) {
                   $this->addencAdd($myid,$inUserID,-$suiqian,9);
               }

                if ($xiaofeiqian > 0) {
                    $this->addencAdd($myid,$inUserID,-$xiaofeiqian,5);
                }

                if ($aixinqian > 0) {
                    $this->addencAdd($myid,$inUserID,$aixinqian,8);
                }



        /*     if ($wangqian > 0) {
                 $this->addencAdd($myid,$inUserID,-$wangqian,3);
             }

           if ($kou_cs > 0) {
                 $this->addencAdd($myid,$inUserID,-$kou_cs,9);
             }  */

        // if ($agent_cf > 0) {
        //     $this->addencAdd($myid,$inUserID,-$agent_cf,9);
        // }
        // if ($agent_cf > 0) {
        //     $this->addencAdd($myid,$inUserID,-$agent_cf,9);
        // }

        unset($fee,$fee_rs,$s9,$mrs,$rss);
    }





    //各种扣税
    public function rw_bonuss($myid,$inUserID=0,$bnum=0,$money_count=0){
        $fee_rs = self::_getFee();
        $user = $this->field('id,day_feng,u_level,is_fenh')->find($myid);
        if ($user['is_fenh'] != 0) { // 奖金关闭
            return;
        }


        $suishou = $fee_rs['s19'] / 100; //扣税收
        $wang = $fee_rs['s1'] / 100; //扣网络费

        $suiqian=$money_count*$suishou;
        $wangqian=$money_count*$wang;
        $last_m = $money_count - $suiqian - $wangqian;


        /*   $prii_ds = $fee_rs['s12'] / 100; // 扣除董事基金
           $prii_cs = $fee_rs['s15'] / 100; // 扣除慈善基金
           $prii_cf = $fee_rs['s6'] / 100; // 进入复投帐户

           $kou_ds = $money_count * $prii_ds;
           $kou_cs = $money_count * $prii_cs;
           $last_m = $money_count - $kou_ds - $kou_cs;
           $agent_cf = $last_m * $prii_cf;
           $agent_use = $last_m * (1 - $prii_cf);
           $agent_kt = 0;
       */



        $bonus = M('bonus');
        $bid = $this->_getTimeTableList($myid);
        $inbb = "b".$bnum;
        $usqla = "";
        // if($bnum==2){
        // $usqla = ",day_feng=day_feng+".$money_count."";
        // }
        /*   if ($bnum == 7) {
               $agent_cf = 0;
               $agent_use = 0;
               $agent_kt = $last_m;
           }  */

        // $kousql = ",b9=b9-".$agent_cf.",b10=b10-".$gl.",b11=b11-".$ax.",b12=b12-".$agent_gc;
        $kousql = ",b3=b3-".$wangqian.",b4=b4-".$suiqian;

        $bonus->execute("UPDATE __TABLE__ SET b0=b0+".$last_m.",".$inbb."=".$inbb."+".$money_count."".$kousql." WHERE id={$bid}"); //加到记录表



        $this->execute("update __TABLE__ set agent_cf=agent_cf+".$last_m." where id=".$myid);//加到fck

        unset($bonus);



        if($money_count>0){
            $this->addencAdd($myid,$inUserID,$money_count,$bnum);
        }



        if ($suiqian > 0) {
            $this->addencAdd($myid,$inUserID,-$suiqian,4);
        }

        if ($wangqian > 0) {
            $this->addencAdd($myid,$inUserID,-$wangqian,3);
        }

        /*   if ($kou_cs > 0) {
               $this->addencAdd($myid,$inUserID,-$kou_cs,9);
           }  */

        // if ($agent_cf > 0) {
        //     $this->addencAdd($myid,$inUserID,-$agent_cf,9);
        // }
        // if ($agent_cf > 0) {
        //     $this->addencAdd($myid,$inUserID,-$agent_cf,9);
        // }

        unset($fee,$fee_rs,$s9,$mrs,$rss);
    }









    //清空时间
	public function emptyTime(){

        // if (date('w') != 1) {
        //     return;
        // }
		$nowdate = strtotime(date('Y-m-d'));
		$this->query("UPDATE `nnld_fck` SET `day_feng`=0,_times=".$nowdate." WHERE _times !=".$nowdate."");

	}








    public  function _getTimeTableList($uid)
    {
        $times = M ('times');
        $bonus = M ('bonus');
        $boid = 0;
        $nowdate = strtotime(date('Y-m-d'));
        $settime_two['benqi'] = $nowdate;
        $settime_two['type']  = 0;
        $trs = $times->where($settime_two)->find();
        if (!$trs){
            $rs3 = $times->where('type=0')->order('id desc')->find();
            if ($rs3){
                $data['shangqi']  = $rs3['benqi'];
                $data['benqi']    = $nowdate;
                $data['is_count'] = 0;
                $data['type']     = 0;
            }else{
                $data['shangqi']  = strtotime('2010-01-01');
                $data['benqi']    = $nowdate;
                $data['is_count'] = 0;
                $data['type']     = 0;
            }
            $shangqi = $data['shangqi'];
            $benqi   = $data['benqi'];
            unset($rs3);
            $boid = $times->add($data);
            unset($data);
        }else{
            $shangqi = $trs['shangqi'];
            $benqi   = $trs['benqi'];
            $boid = $trs['id'];
        }
        $_SESSION['BONUSDID'] = $boid;
        $brs = $bonus->where("uid={$uid} AND did={$boid}")->find();
        if ($brs){
            $bid = $brs['id'];
        }else{
            $frs = $this->where("id={$uid}")->field('id,user_id')->find();
            $data = array();
            $data['did'] = $boid;
            $data['uid'] = $frs['id'];
            $data['user_id'] = $frs['user_id'];
            $data['e_date'] = $benqi;
            $data['s_date'] = $shangqi;
            $bid = $bonus->add($data);
        }
        return $bid;
    }





}
?>