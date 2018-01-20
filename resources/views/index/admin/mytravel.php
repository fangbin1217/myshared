<style>

    body {
        font-family: "微软雅黑";
        background: #f4f4f4;
    }

    /*header*/
    .header-line {
        width: 100%;
        height: 4px;
        background: #0dbfdd;
    }

    /*content*/
    .content {
        width: 98%;
        margin: 1px auto 0;
        text-align: center;
        background: #fff;
    }
    .content-form {
        width: 100%;
        padding: 36px 0 20px;
        text-align: left;
        background: #fff;
    }
</style>
<div class="content">
    <div style="text-align: left;padding: 5px 10px 5px;color:#777;"><?php echo $loginInfo['uname'].'，'.$loginInfo['tip']; ?><a href="<?php echo config('local')['website']; ?>/login/loginout" style="float:right;padding: 0 10px;color:#777;">退出</a></div>
    <div class="content-form">
        <?php if ($list) {foreach ($list as $val) { ?>
        <div  style="padding:10px 10px;">
            <a href="<?php echo config('local')['website'].'/admin/look/'.$val['id']; ?>">
                <span> <?php  if($loginInfo['isAdmin']) { echo '用户：'.$val['user_id'];}?></span>&nbsp;
                <span><?php echo mb_substr($val['title'], 0, 5, 'utf-8');?></span>&nbsp;
                <?php  if ($val['state'] == 0) {echo "<span style='color:green;'>已审核</span>";} else {echo "<span style='color:red;'>未审核</span>";}?>&nbsp;
            </a>
            <?php  if($loginInfo['uid'] == $val['user_id']) { ?>
            <a style="padding:0 15px;" href="<?php echo config('local')['website'].'/admin/addtraveldetail/'.$val['id']; ?>">
                <img src="<?php echo config('local')['website']; ?>/static/image/add.png" />追加照片&nbsp;&nbsp;
            </a>
            <?php } ?>
        </div>
        <?php  }} else { ?>
        <div  style="padding:10px 0;"><a href="<?php echo config('local')['website']; ?>/admin/addtravelfirst"><img src="<?php echo config('local')['website']; ?>/static/image/add.png" />您还没有分享过照片噢，点击分享</a></div>
        <?php  } ?>
    </div>
    <span style="color:red;font-size:13px;"><?php  if(!$loginInfo['isAdmin']) {echo '照片审核后可以在首页展示噢';} ?></span>
</div>
