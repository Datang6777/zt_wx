<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk">
    <meta charset="UTF-8">
    <title>����Ȧ</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="moments.css">
    <script src="http://bm.huatu.com/zt/bm/js/jquery-1.7.1.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" ></script>
</head>
<body avalonctrl="moments">
<?php

require('../connect_db.php');
$query = "select *  from dede_p_pinglun as n inner join dede_p_pd  as d on n.uid = d.uid  order by n.uid desc  ";
$identy = $pdo->query($query);
$rows = $identy->fetchAll();

//��ѯuid
$uidquery = "select n.uid from dede_p_pinglun as n inner join dede_p_pd  as d on n.uid = d.uid    ";
$identy2 = $pdo->query($uidquery);
$uidmap= $identy2->fetchAll();
$uid = '';
foreach ($uidmap as $v)
{
    $uid .= $v['uid'].',';
}




//��ȡ������urll
$nowurl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
//�������
$appid = 'wx59a5019fbc282cb0';
$secret = 'f360712b887814e4f292b9926700b0e6';
//$nowurl = 'http://bm.huatu.com/zt/2016/nmg/callback.php';
$mem = new Memcache();
$mem->connect('192.168.200.134', 11211);// or die ("Could not connect");
$num = $mem->get("nmgnum");
if (empty($num)) $num = 0;
$num++;
$mem->set("nmgnum", $num);
//��ȡ token
$token = $mem->get("fenxiangnmg");
$ticket = $mem->get("fxnmgtick");
if (empty($token)) {
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
    $str = file_get_contents($url);
    $aa = json_decode($str, true);
    $token = $aa['access_token'];
    $mem->set("fenxiangnmg", $token, 0, 5000);

    $url = sprintf("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi", $token);
    $str2 = file_get_contents($url);
    $aaa = json_decode($str2, true);

//��ȡ ticket
    $ticket = $aaa['ticket'];
    $mem->set("fxnmgtick", $ticket, 0, 5000);
}
// echo $token."--".$ticket ;
$t = time(); //����ǩ����ʱ���
$s = 'Wm3WZYTPz0wzccnW'; //����ǩ���������
// $str2 = 'jsapi_ticket='.$ticket.'&noncestr=zdsgfdgDFGEFGJ&timestamp='.$t.'&url='.$nowurl;
$strr = "jsapi_ticket=$ticket&noncestr=Wm3WZYTPz0wzccnW&timestamp=$t&url=$nowurl";
$qm = sha1($strr);
//��ȡ�û���
//2 redirect_uri  ҳ����ܴ���
$code = $_GET['code'];
//��ȡ token
$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
$str = file_get_contents($url);
$arr = json_decode($str, true);

$tokena = $arr['access_token'];
$openid = $arr['openid'];
//3 ��ӡ�û���Ϣ
$info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token=' . $tokena . '&openid=' . $openid . '&lang=zh_CN');
$arruser = json_decode($info, true);

$username = $arruser['nickname'];
$openid = $arruser['openid'];
$imghead = $arruser['headimgurl'];
$imghead = rtrim($imghead, 0);

$imghead132 = $imghead . '132';
//echo "<script>location.href='http://bm.huatu.com/zt/2016/nmg/callback.php?uname=".$username."';</script>";
// echo rand();
// ���û�����Ϣ�������ݿ�
$username = iconv('utf-8','gb2312',$username);

$query2 ="insert into p_pyq_fxall (openid,nickname,headimgurl,uid) VALUES ('$openid','$username','$imghead','$uid');";

$identy3 = $pdo->query($query2);




?>
<div class="loading"></div>
<div class="cover" style="background-image: url(images/4.jpg);">
    <span class="name"><?= $username; ?></span>
    <input type="hidden" name="openid" id = "openid" value="<?=  $openid;?>">
    <img class="avatar" src="<?= $imghead ?>">
</div>
<?php
    $pyq_time = 0;
    foreach ($rows as $row) {
    ?>
    <li>
        <dl class="event">
            <dt><img src="images/<?php echo $row['touxiang'];?>"></dt>
            <dd>
                <strong><?php echo $row['username'];?></strong><!--ms-if-->
                <div class="content"><?php echo $row['p_contents'];?></div>
                <!--ms-repeat-->
<!--                <img src="images/11.11.jpg" class="picture-1">-->
                <!--ms-repeat-end-->
                <?php
                $mapall =  explode(';',$row['p_images']);
                $map= array_splice($mapall,1);

                $i = '';
                foreach ($map as $v){
                    if($v){
                        $i .='<img  class="picture-1" src="images/'.$v.'">';
                    }
                }
                echo $i;
                ?>
                <span class="time">
                    <?php
                    $times = array('�ո�', 'ʮ����ǰ', '��Сʱǰ', 'һСʱǰ', '��Сʱǰ', '��Сʱǰ', '��Сʱǰ', '��Сʱǰ', 'ʮСʱǰ', '����', '����֮ǰ');
                     echo $times[$pyq_time];
                     $pyq_time++;
                    ?>
                </span>
                <div class="comments">
                    <i class="arrow"></i>
                    <span class="votes">
                    <img src="images/votes@2x.png" class="heart">
                        <?php  if (!empty($row['d_name'])){echo $row['d_name'];}?>
                     </span>
                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['name1'])){echo $row['name1'];}?>
                        </strong>:
                            <?php  if (!empty($row['i_content1'])){echo $row['i_content1'];}?>
                    </div>
                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['huiname1'])){echo $row['huiname1'].'�ظ�'.$row['name1'].':';}?>
                        </strong>
                            <?php  if (!empty($row['i_hui1'])){echo $row['i_hui1'];}?>

                    </div>

                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['name2'])){echo $row['name2'];}?>
                        </strong>:
                        <?php  if (!empty($row['i_content2'])){echo $row['i_content2'];}?>
                    </div>
                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['huiname2'])){echo $row['huiname2'].'�ظ�'.$row['name2'].':';}?>
                        </strong>

                            <?php  if (!empty($row['i_hui2'])){echo $row['i_hui2'];}?>

                    </div>

                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['name3'])){echo $row['name3'].':';}?>
                        </strong>
                        <?php  if (!empty($row['i_content3'])){echo $row['i_content3'];}?>
                    </div>
                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['huiname3'])){echo $row['huiname3'].'�ظ�'.$row['name3'].':';}?>
                        </strong>

                            <?php  if (!empty($row['i_hui3'])){echo $row['i_hui3'];}?>

                    </div>

                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['name4'])){echo $row['name4'].':';}?>
                        </strong>
                        <?php  if (!empty($row['i_content4'])){echo $row['i_content4'];}?>
                    </div>
                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['huiname4'])){echo $row['huiname4'].'�ظ�'.$row['name4'].':';}?>
                        </strong>
                            <?php  if (!empty($row['i_hui4'])){echo $row['i_hui4'];}?>

                    </div>


                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['name5'])){echo $row['name5'].':';}?>
                        </strong>
                        <?php  if (!empty($row['i_content5'])){echo $row['i_content5'];}?>
                    </div>
                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['huiname5'])){echo $row['huiname5'].'�ظ�'.$row['name5'].':';}?>
                        </strong>

                            <?php  if (!empty($row['i_hui5'])){echo $row['i_hui5'];}?>

                    </div>


                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['name6'])){echo $row['name6'].':';}?>
                        </strong>
                        <?php  if (!empty($row['i_content6'])){echo $row['i_content6'];}?>
                    </div>
                    <div class="comment-content">
                        <strong>
                            <?php  if (!empty($row['huiname6'])){echo $row['huiname6'].'�ظ�'.$row['name6'].':';}?>
                        </strong>

                            <?php  if (!empty($row['i_hui6'])){echo $row['i_hui6'];}?>
                     </div>

                </div>


            </dd>
        </dl>

        <div class="line"></div>
    </li>


<?php }
?>


<button>�����ҵ�����Ȧ</button>
<div>�������鹹���������֣�</div>
<script>
    wx.config({
        debug: false, // ��������ģʽ,���õ�����api�ķ���ֵ���ڿͻ���alert��������Ҫ�鿴����Ĳ�����������pc�˴򿪣�������Ϣ��ͨ��log���������pc��ʱ�Ż��ӡ��
        appId: '<?=$appid?>', // ������ںŵ�Ψһ��ʶ
        timestamp:<?=$t?>, // �������ǩ����ʱ���
        nonceStr: '<?=$s?>', // �������ǩ���������
        signature: '<?=$qm?>',// ���ǩ��������¼1
        jsApiList: ['onMenuShareAppMessage','onMenuShareTimeline','checkJsApi'] // �����Ҫʹ�õ�JS�ӿ��б�����JS�ӿ��б����¼2
    });

//��������Ȧ
    var openid = document.getElementById('openid').value;

    wx.ready(function(){

        //console.log(123);
        wx.onMenuShareTimeline({
            title: '<?php echo $username;?>������Ȧ', // �������
            desc: '�ٶ���Χ������ߴ��ϵ�����Ȧ����������������۾��Ѿ�����Ϲ��ԭ������ôţ������ô��֪����', // ��������
            link: 'http://nmg.huatu.com/zt/pyq/pyq_fenxiang.php?openid='+openid,
            // ��������
            imgUrl: '<?php echo $imghead;?>', // ����ͼ��
            success: function () {
                // �û�ȷ�Ϸ����ִ�еĻص�����

            },
            cancel: function () {
                // �û�ȡ�������ִ�еĻص�����
                }
        });
//�������
        wx.onMenuShareAppMessage({
            title: '<?php echo $username;?>������Ȧ', // �������
            desc: '�ٶ���Χ������ߴ��ϵ�����Ȧ����������������۾��Ѿ�����Ϲ��ԭ������ôţ������ô��֪����', // ��������
            link: 'http://nmg.huatu.com/zt/pyq/pyq_fenxiang.php?openid='+openid,
            // ��������
            imgUrl: '<?php echo $imghead;?>', // ����ͼ��
            type: '', // ��������,music��video��link������Ĭ��Ϊlink
            dataUrl: '', // ���type��music��video����Ҫ�ṩ�������ӣ�Ĭ��Ϊ��
            success: function () {
                //colog('');
                //console.log();
            },
            cancel: function () {
                // �û�ȡ�������ִ�еĻص�����
            }
        });
    });


    wx.error(function(res){
        alert('fail');
        // config��Ϣ��֤ʧ�ܻ�ִ��error��������ǩ�����ڵ�����֤ʧ�ܣ����������Ϣ���Դ�config��debugģʽ�鿴��Ҳ�����ڷ��ص�res�����в鿴������SPA�������������ǩ����

    });

    wx.checkJsApi({
        jsApiList: ['chooseImage'], // ��Ҫ����JS�ӿ��б�����JS�ӿ��б����¼2,
        success: function(res) {
            alert(res);
            // �Լ�ֵ�Ե���ʽ���أ����õ�apiֵtrue��������Ϊfalse
            // �磺{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
        }
    });
</script>
<div style="display:none">

    <!--�ٶ�ͳ��-->
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?cbb2cda06c7e5ff71056c0304fad4722";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>

    <!--�ٶ�ͳ�ƽ���-->

    <script src='http://s78.cnzz.com/stat.php?id=443728&web_id=443728&show=pic' language='JavaScript'
            charset='gb2312'></script>
    <script src="http://s13.cnzz.com/stat.php?id=4865596&web_id=4865596&show=pic" language="JavaScript"></script>
    <script type="text/javascript" src=" http://www.huatu.com/images/2012js/pvzz.js"></script>

    <script>
        (function () {
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
</div>

</body>
</html>