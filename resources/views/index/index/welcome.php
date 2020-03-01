
<style>
    .wrap{
        width:300px;
        perspective:1000px;/*景深*/
        position:absolute;
        left:50%;
        top:80%;
        transform: translateX(-50%) translateY(-50%);/*利用位移来处理垂直水平居中*/
    }
    .wrap>.cube{
        width:300px;
        height:300px;
        position:relative;
        transform-style: preserve-3d;
        transform:rotateX(-50deg) rotateY(-50deg) rotateZ(0deg);/*旋转*/
        animation:move 8s infinite linear;/*动画*/
    }
    /*关键帧*/
    @keyframes move{
        0% {
            transform: rotateX(0deg) rotateY(0deg);
        }
        100% {
            transform: rotateX(360deg) rotateY(360deg);
        }
    }
    .cube>.img-out{
        width:100%;
        height:100%;
        border-radius:20px;
        position:absolute;
        background:#000;
        box-shadow:0 0 10px currentColor;/*currentColor关键字的使用值是 color 属性值的计算值*/
        transition: background 0.4s ease-in-out, box-shadow 0.4s ease-in-out;/*过渡 属性 时间 过渡曲线*/
    }
    .cube:hover>.img-out{
        background:currentColor;
        box-shadow:0 0 20px currentColor;
    }
    .cube .out-front{
        color: deeppink;
        transform:translateZ(150px);/*转换  位移*/
    }
    .cube .out-back{
        color: seagreen;
        transform:translateZ(-150px) rotateY(180deg);/*转换 位移 旋转*/
    }
    .cube .out-left{
        color: skyblue;
        transform:translateX(-150px) rotateY(-90deg);
    }
    .cube .out-right{
        color: lightcoral;
        transform:translateX(150px) rotateY(90deg);
    }
    .cube .out-top{
        color: mediumseagreen;
        transform:translateY(-150px) rotateX(90deg);
    }
    .cube .out-bottom{
        color: dodgerblue;
        transform:translateY(150px) rotateX(-90deg);
    }

    .pic {
        width: 100%;height:100%;
    }
</style>

<div style="width:100%;">
    <h2 style="font-size:25px;font-weight:bold;line-height:30px;">小程序学习：包括微信小程序，QQ小程序，支付宝小程序，抖音小程序，头条小程序，百度小程序</h2>

</div>
<div class="wrap" style="z-index:1000;">
    <div class="cube">
        <div class="out-front img-out"><img  src="<?php echo config('local')['imgHost']; ?>index/wx0228.png" class="pic"></div>
        <div class="out-back img-out"><img  src="<?php echo config('local')['imgHost']; ?>index/qq0228.png" class="pic"></div>
        <div class="out-left img-out" ><img src="<?php echo config('local')['imgHost']; ?>index/zfb0228.png" class="pic"></div>
        <div class="out-right img-out"><img src="<?php echo config('local')['imgHost']; ?>index/dy0228.png" class="pic"></div>
        <div class="out-top img-out"><img src="<?php echo config('local')['imgHost']; ?>index/tt0228.png" class="pic"></div>
        <div class="out-bottom img-out"><img src="<?php echo config('local')['imgHost']; ?>index/bd0228.png" class="pic"></div>
    </div>
</div>
<script>
    var imgHost = "<?php echo config('local')['imgHost']; ?>";
    $(function () {
        $('.cube').click(function () {
            var c = ['out-front img-out', 'out-back img-out', 'out-left img-out', 'out-right img-out', 'out-top img-out', 'out-bottom img-out'];
            var items = [imgHost + 'index/wx0228.png', imgHost + 'index/qq0228.png', imgHost + 'index/zfb0228.png', imgHost + 'index/dy0228.png', imgHost + 'index/tt0228.png', imgHost + 'index/bd0228.png'];


            var item = '';
            var tmp = [];
            var tmp2 = [];

            var left = items;
            var i = 0;
            for (var k in c) {
                if (i == 0) {
                    left = items;
                }
                if (left.length > 1) {
                    item = left[Math.floor(Math.random() * left.length)];
                    left = [];
                    tmp.push(item);
                    tmp2.push([c[k], item])
                    for (var k2 in items) {
                        if (!in_array(items[k2], tmp)) {
                            left.push(items[k2]);
                        }
                    }
                } else {
                    tmp.push(left[0]);
                    tmp2.push([c[k], left[0]])
                    break;
                }
                i++;
            }

            //console.log(tmp2);


            var a = '';


            for (var k3 in tmp2) {
                a += '<div class="'+tmp2[k3][0]+'"><img  src="'+tmp2[k3][1]+'" class="pic"></div>';
            }

            $('.cube').html(a);

            function in_array(search,array){
                for(var i in array){
                    if(array[i]==search){
                        return true;
                    }
                }
                return false;
            }
        })
    })
</script>