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
<div>
    <form method="post" action="<?php echo config('local')['website']; ?>/admin/savetravelfirst" enctype="multipart/form-data">
        <div>
            <textarea name="title" class="content" placeholder="添加标题" rows="1"></textarea>
            <textarea name="content" class="content" placeholder="添加描述" rows="2"></textarea>
            <textarea name="mydate" class="content" placeholder="时间" rows="1"><?php echo date('Y-m-d H:i:s');?></textarea>
        </div>
        <input type="file" id="fileElem" name="myfile" multiple accept="image/*"  onchange="handleFiles(this)">
        <div id="fileList" style="width:200px;height:200px;"></div>
        <div id="change_margin_3">
            <input class="content-form-signup" type="submit" value="发布" />
        </div>
    </form>
</div>
<script>
    window.URL = window.URL || window.webkitURL;
    var fileElem = document.getElementById("fileElem"),
        fileList = document.getElementById("fileList");
    function handleFiles(obj) {
        var files = obj.files,
            img = new Image();
        if(window.URL){
            //File API
            alert(files[0].name + "," + files[0].size + " bytes");
            img.src = window.URL.createObjectURL(files[0]); //创建一个object URL，并不是你的本地路径
            img.width = 200;
            img.onload = function(e) {
                window.URL.revokeObjectURL(this.src); //图片加载后，释放object URL
            }
            fileList.appendChild(img);
        }else if(window.FileReader){
            //opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onload = function(e){
                alert(files[0].name + "," +e.total + " bytes");
                img.src = this.result;
                img.width = 200;
                fileList.appendChild(img);
            }
        }else{
            //ie
            obj.select();
            obj.blur();
            var nfile = document.selection.createRange().text;
            document.selection.empty();
            img.src = nfile;
            img.width = 200;
            img.onload=function(){
                alert(nfile+","+img.fileSize + " bytes");
            }
            fileList.appendChild(img);
        }
    }
</script>

