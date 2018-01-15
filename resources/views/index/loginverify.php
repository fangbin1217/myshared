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
}
.content-logo {
width: 80px;
height: 80px;
}
.content-title {
margin: 10px 0 25px 0;
font-size: 2em;
color: #747474;
font-weight: normal;
}
.content-form {
width: 100%;
padding: 36px 0 20px;
border: 1px solid  #dedede;
text-align: center;
background: #fff;
}
.content-form form div {
margin-bottom: 19px;
}
.content-form form .user,
.content-form form .password {
width: 77%;
height: 40px;
padding: 10px;
font-size: 1em;
border: 1px solid  #cccbcb;
border-radius: 7px;
letter-spacing: 1px;
}
.content-form form input:focus {
outline: none;
-webkit-box-shadow: 0 0 5px #0dbfdd;
box-shadow: 0 0 5px #0dbfdd;
}
.content-form-signup {
width: 84%;
margin: 0 auto;
padding: 10px;
border: 1px solid  #cccbcb;
border-radius: 7px;
font-size: 1em;
font-weight: bold;
color: #fff;
background: #0dbfdd;
cursor: pointer;
}
.content-form-signup:hover {
background: #0cb3d0;
}
.content-form-signup:focus {
outline: none;
border: 1px solid  #0cb3d0;
}
.content-login-description {
margin-top: 25px;
line-height: 1.63636364;
color: #747474;
font-size: .91666667rem;
}
.content-login-link {
font-size: 16px;
color: #0dbfdd;
text-decoration: none;
}
</style>
<div class="content">
    <div class="content-form">
        <?php echo $msg; ?>
        <a href="<?php echo config('local')['website']; ?>/login"><span id="timer">3</span>秒后自动（或点击）跳转登录页面</a>
    </div>
</div>
<script type="text/javascript">
    function run(){
        var s = document.getElementById("timer");
        if(s.innerHTML == 0){
            window.location.href='<?php echo config('local')['website']; ?>/login';
            return false;
        }
        s.innerHTML = s.innerHTML * 1 - 1;
    }
    window.setInterval("run();", 1000);
</script>
