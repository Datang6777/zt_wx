<?php

$openid = $_GET['openid'];

require('../connect_db.php');

$query1 = "select * from  p_pyq_fxall where openid = '$openid'";
$identy1 = $pdo->query($query1);
$info = $identy1->fetchAll();

$uid = $info[0]['uid'];
$uid = substr($uid,0,-1);
$query = "select *  from dede_p_pinglun as n inner join dede_p_pd  as d on n.uid = d.uid  where n.uid in($uid)  order by n.uid desc ;";
$identy = $pdo->query($query);
$rows = $identy->fetchAll();

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gbk">
    <meta charset="UTF-8">
    <title>朋友圈</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="moments.css">
    <script src="http://bm.huatu.com/zt/bm/js/jquery-1.7.1.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" ></script>
</head>
<body avalonctrl="moments">





<div class="loading"></div>
<div class="cover" style="background-image: url(images/4.jpg);">
    <span class="name"><?= $info[0]['nickname']  ?></span>
    <img class="avatar" src="<?= $info[0]['headimgurl'] ?>">
</div>
<?php foreach ($rows as $row) {
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
                <span class="time">刚刚</span>
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
                            <?php  if (!empty($row['huiname1'])){echo $row['huiname1'].'回复'.$row['name1'].':';}?>
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
                            <?php  if (!empty($row['huiname2'])){echo $row['huiname2'].'回复'.$row['name2'].':';}?>
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
                            <?php  if (!empty($row['huiname3'])){echo $row['huiname3'].'回复'.$row['name3'].':';}?>
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
                            <?php  if (!empty($row['huiname4'])){echo $row['huiname4'].'回复'.$row['name4'].':';}?>
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
                            <?php  if (!empty($row['huiname5'])){echo $row['huiname5'].'回复'.$row['name5'].':';}?>
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
                            <?php  if (!empty($row['huiname6'])){echo $row['huiname6'].'回复'.$row['name6'].':';}?>
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

<button><a href="index.html">生成我的朋友圈</a></button>
<div>（纯属虚构，仅供娱乐）</div>
