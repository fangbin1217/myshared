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
text-align: center;
background: #fff;
}
</style>
<div class="content">
    <div style="text-align: left;padding: 5px 10px 5px;color:#777;"><?php echo $loginInfo['uname'].'，'.$loginInfo['tip']; ?><a href="<?php echo config('local')['website']; ?>/login/loginout" style="float:right;padding: 0 10px;color:#777;">退出</a></div>
    <div class="content-form">

        <div  style="padding:10px 0;">
            <a href="<?php echo config('local')['website']; ?>/admin/mytravel"><img src="<?php echo config('local')['website']; ?>/static/image/mytravel.png" />&nbsp;我的旅行照</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo config('local')['website']; ?>/admin/addtravelfirst"><img src="<?php echo config('local')['website']; ?>/static/image/add.png" />&nbsp;分享新的旅行照</a>
        </div>
        <?php if($loginInfo['isAdmin']){ ?>
        <div  style="padding:10px 0;"><a href="<?php echo config('local')['website']; ?>/admin/addbaby"><img src="<?php echo config('local')['website']; ?>/static/image/add.png" />&nbsp;分享宝宝照</a></div>
        <?php } ?>
    </div>
</div>
