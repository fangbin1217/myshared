<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <!-- header start -->
    <?php echo view('index.header', $header); ?>
    <!-- header end -->
</head>
<body class="home blog custom-background">
<div id="page" class="hfeed site">

    <!-- 这里是导航模块 -->
    <header id="masthead" class="site-header">
        <div id="header-main" class="header-main">
            <nav id="top-header">
                <div class="top-nav">
                    <div id="user-profile">
                        <div class="user-login">欢迎光临【花好月圆的个人经验】！</div>
                        <div class="nav-set">
                            <div class="nav-login">
                                <?php if ($login) { ?>
                                    <a href="<?php echo config('local')['website'].'/admin'; ?>" id="login-main">您好！<span><?php echo $login['uname']; ?></span></a>
                                <?php  } else {?>
                                    <a href="<?php echo config('local')['website'].'/login'; ?>" id="login-main">登录</a>
                                <?php  }?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="menu-menutop-container"><ul id="menu-menutop" class="top-menu">
                        </ul></div> </div>
            </nav>
            <div id="menu-box">
                <div id="top-menu">
                    <div class="logo-site">
                        <h1 class="site-title">
                            <a href="<?php echo config('local')['website']; ?>"><img src="<?php echo config('local')['website']; ?>/static/image/logo.png" title="花好月圆的个人经验" alt="花好月圆的个人经验" rel="home" /><span class="site-name">花好月圆的个人经验</span></a>
                        </h1>
                    </div>
                    <div id="site-nav-wrap">
                        <div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close">X</a></div>
                        <div id="sidr-menu"><div class="toggle-sidr-menu">MENU</a></div></div>
                        <nav id="site-nav" class="main-nav">
                            <a href="#sidr-main" id="navigation-toggle" class="bars" ><i class="be be-menu"></i></a>
                            <div class="menu-menu-container"><ul id="menu-menu" class="down-menu nav-menu">
                                    <li id="menu-item-481" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-481"><a title="花好月圆的个人经验" href="<?php echo config('local')['website']; ?>/">首页</a></li>
                                    <li id="menu-item-12" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-12"><a title="旅行分享的个人经验！" href="javascript:;">旅行分享</a>
                                        <ul class="sub-menu">
                                            <li id="menu-item-4141" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-4141"><a href="<?php echo config('local')['website']; ?>/travel">浪迹天涯</a></li>
                                        </ul>
                                    </li>
                                    <li  class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-12"><a title="宝宝的个人经验！" href="javascript:;">文章分类</a>
                                        <ul class="sub-menu">
                                            <li  class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-4141"><a href="<?php echo config('local')['website']; ?>/article/study">学习心得</a></li>
                                            <li  class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-4141"><a href="<?php echo config('local')['website']; ?>/article/babystory">宝宝故事</a></li>
                                        </ul>
                                    </li>
                                    <li id="menu-item-3673" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-3673"><a href="javascript:;">关于我</a>
                                        <ul class="sub-menu">
                                            <li id="menu-item-958" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-958"><a href="<?php echo config('local')['website']; ?>/resume">个人简介</a></li>
                                            <li id="menu-item-958" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-958"><a href="<?php echo config('local')['website']; ?>/baby">宝宝成长</a></li>
                                        </ul>
                                    </li>
                                </ul></div> </nav>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </header>
    <div id="search-main">
        <div class="clear"></div>
    </div>

    <!-- 这里是公告模块 -->
    <nav class="breadcrumb" id="breadcrumb">
    <?php if($myview == 'index.index.welcome') { ?>

        <div class="bull"><i class="be"><img src="static/image/common/speaker16.png"/></i></div><div id="scrolldiv">
            <div class="scrolltext" >
                <ul id="myWeather">

                </ul>
            </div>
        </div>
        <script type="text/javascript">$(document).ready(function() {$("#scrolldiv").textSlider({line:1,speed:300,timer:6000});})</script>
    <!-- 这里是公告模块 -->
    <?php } else { ?>
        <div class="bull"><i class="be" style="font-weight:bold;color:#777;"><a href="<?php echo config('local')['website']; ?>"><img src="/static/image/common/house16.png"/></a>&nbsp;<?php echo $navName; ?></i></div>
    <?php } ?>
    </nav>
    <!-- 这里是公告模块 -->

    <!-- 这里是中间内容模块 -->
    <div id="content" class="site-content">
        <!-- 左内容 start -->
        <div id="primary" class="content-area">
            <?php echo view($myview, $data); ?>
        </div>
        <!-- 左内容 end -->


        <!-- 右导航 start -->
        <div id="sidebar" class="widget-area all-sidebar">
            <?php echo view('index.sidebar', $sidebar); ?>
        </div>
        <!-- 右导航 end -->
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <!-- 这里是中间内容模块 -->

    <!-- 这里是版权说明模块 -->
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-info">
            <strong>Copyright © 2017-<?php echo date('Y');?>年 Myshared.top 花好月圆  版权所有.<a href="javascript:;">浙ICP备17059682号-1</a> </strong> <span class="add-info">
        </div>
    </footer>
    <!-- 这里是版权说明模块 -->

    <!-- 这里是版权说明模块 -->
    <ul id="scroll">
        <li style="padding:0 0 5px;"><a style="width:36px;height:36px;" class="scroll-home" href="<?php if ($login) { echo config('local')['website'].'/admin';}else{echo config('local')['website'].'/login';}?>" title="MY" rel="home"><i class="be">L</i></a></li>
        <li style="padding:0 0 5px;"><a style="width:36px;height:36px;" class="scroll-h" title="返回顶部"><i class="be"><img src="/static/image/common/up16.png" style="width:24px;height:16px;" /></i></a></li>
        <li class="qqonline" id="qqonline" style="padding:0 0 5px;"><div class="online"><a href="javascript:void(0)" style="width:36px;height:36px;"><i class="be be-qq"></i></a></div>
            <div class="qqonline-box" style="display: none;" id="qqonline-box">
                <div class="qqonline-main">
                    <div class="nline-wiexin">
                        <h4>微信</h4>
                        <img title="微信" alt="微信" src="<?php echo config('local')['website']; ?>/static/image/mywx.png">
                    </div>
                    <div class="nline-qq"><a target="_blank" rel="external nofollow" href="http://wpa.qq.com/msgrd?v=3&amp;uin=475543064&amp;site=qq&amp;menu=yes"><i class="be be-qq"></i>在线咨询</a></div>
                </div>
                <span class="qq-arrow"></span>
            </div>
        </li>
        <script type="text/javascript">
            $(document).ready(function(){
                if(!+[1,]){present="table";} else {present="canvas";}$('#output').qrcode({render:present,text:window.location.href,width:"150",height:"150"});
            });</script>
    </ul>
    <!-- 这里是版权说明模块 -->
</div>



<!-- footer start -->
<?php echo view('index.footer', $footer); ?>
<!-- footer end -->
<script>

    $(function () {
        $.ajax({
            type: "GET",
            url: "weather",
            data: {},
            dataType: "json",
            success: function(data){
                console.log(data);
                //let ret = ("("+data+")");
                let weather = data.weathers;
                console.log(weather);
                if (weather) {
                    let aa = '';
                    for (var k in weather) {
                        aa += '<li class="scrolltext-title"><a href="javascript:;" rel="bookmark" style="color:#777;font-size:13px;">'+ weather[k].ymd + ' '+ weather[k].week+ ' ' + weather[k].type+ ' '+ weather[k].low + '~'+ weather[k].high+ '</a></li>';
                    }
                    $('#myWeather').html(aa);
                }
            }
        });
    });
</script>