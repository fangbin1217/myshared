<?php if ($detail['id'] === '1.html') {  ?>
<div style="color:#000000;font-size:200%;margin-top:15px;">QQ小程序实现大转盘抽奖----踩坑之路</div>
<div style="color:#000000;margin-top:10px;">需求：现在有一个小程序抽奖页面如下，此类抽奖方式为大转盘</div>
<div style="color:#000000;margin-top:10px;"><img src="<?php echo config('local')['imgHost'].'index/index0301.png'; ?>"  style="width:350px;height:500px;"/></div>
<div style="color:#000000;margin-top:10px;">思路：由服务端获取抽奖次数和奖品，根据服务端的中奖概率来决定是否中奖，最后利用小程序动画将转盘转起来，结果如下：</div>
<div style="color:#000000;margin-top:10px;"><img src="<?php echo config('local')['imgHost'].'index/result0301.png'; ?>"  style="width:350px;height:500px;"/></div>
<div style="color:#000000;margin-top:10px;">小程序核心代码：</div>
<div style="color:#000000;margin-top:10px;"><img src="<?php echo config('local')['imgHost'].'index/code0303.png'; ?>"  style="width:800px;height:665px;"/></div>
<div style="color:#000000;margin-top:10px;">通过用户观看视频来获取抽奖机会，演示请移步到QQ小程序观看，QQ小程序搜索  <span style="font-size:20px;">文具大转盘</span>   或者QQ扫如下二维码：</div>
<div style="color:#000000;margin-top:10px;text-align:center;"><img src="<?php echo config('local')['imgHost'].'index/dzp0301.png'; ?>"  style="width:200px;height:200px;border-radius:10px;"/></div>
<div style="color:#000000;margin-top:10px;">最后，欢迎广大网友和小程序爱好者加我微信或者QQ，一起交流下技术及心得体会（微信或QQ见网站右下角）。</div>

<?php } else {  ?>

站长很懒，什么都没有留下
<?php }  ?>