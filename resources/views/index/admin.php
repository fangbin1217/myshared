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
    <div style="text-align: left;padding: 5px 10px 5px;color:#777;"><?php echo $loginInfo['uname'].'，'.$tip; ?><a href="<?php echo config('local')['website']; ?>/login/loginout" style="float:right;padding: 0 10px;color:#777;">退出</a></div>
    <div class="content-form">

        <a href="javascrip:;">敬请期待！</a><br/>
        <?php if($loginInfo['isAdmin']){ ?>
            <a href="<?php echo config('local')['website']; ?>/admin/addbaby">添加宝宝照</a><br/>
        <?php } ?>
    </div>
</div>
