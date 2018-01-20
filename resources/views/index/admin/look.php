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
        <?php if ($list) { ?>
            <div  style="padding:10px 10px;">
                <div><?php echo mb_substr($list['title'], 0, 7, 'utf-8');?>&nbsp;<?php echo date('Y-m-d H',strtotime($list['utime'])); ?>&nbsp;<?php  if ($list['state'] == 0) {echo "<span style='color:green;'>已审核</span>";} else {echo "<span style='color:red;'>未审核</span>";}?></div>
                <div>首图：<img src="<?php echo config('local')['website'].'/'.$list['index_image'];?>" style="height:240px;" /></div>
                <div>

                    <?php  if ($list['state'] == 2) { ?>
                        <?php if ($loginInfo['isAdmin'])  { ?>
                        <a href="<?php echo config('local')['website'].'/admin/checktravel/'.$list['id'];?>" style="color:green;">点 击 审 核</a>
                        <?php } else { ?>
                        提醒管理员审核<img src="<?php echo config('local')['website'].'/static/image/call.png';?>" />
                    <?php }} ?>
                </div>
            </div>
        <?php  } ?>

    </div>
    <span style="color:red;font-size:13px;"><?php  if(!$loginInfo['isAdmin']) {echo '照片审核后可以在首页展示噢';} ?></span>
</div>
