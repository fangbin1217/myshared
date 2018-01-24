/**
 * Created by binfang on 18/1/24.
 */
window.URL = window.URL || window.webkitURL;
var fileElem = document.getElementById("fileElem"),
    fileList = document.getElementById("fileList");
function handleFiles(obj) {
    var files = obj.files,
        img = new Image();
    if(window.URL){
        //File API
        var myTips = getTips(files[0].size);
        document.getElementById("myTip").innerHTML="图片大小：" + myTips;
        //alert(files[0].name + "," + files[0].size + " bytes 1");
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
            var myTips = getTips(e.total);
            document.getElementById("myTip").innerHTML="图片大小：" + myTips;
            //alert(files[0].name + "," +e.total + " bytes 2");
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
            var myTips = getTips(img.fileSize);
            document.getElementById("myTip").innerHTML="图片大小："+myTips;
            //alert(nfile+","+img.fileSize + " bytes 3");
        }
        fileList.appendChild(img);
    }
}

function getTips(mySize) {
    var myTips = '';
    if (mySize > 1024 && mySize < 1048576) {
        myTips = (mySize/1024).toFixed(2)+'KB';
    } else if (mySize >= 1048576) {
        myTips = (mySize/1048576).toFixed(2)+'M '+"<span style='color:#ff2939;font-size:13px;'>您的图片超过1M，建议在WIFI下操作</span>";
    } else {
        myTips = Math.round(mySize)+'bytes';
    }
    return myTips;
}
