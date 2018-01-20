<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    private $sourceImagePre = 'S';

    private $thumbnailImagePre = 'T';

    public function __construct() {
        parent::__contract();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        if ($this->result['login']) {

            $tip = '晚上好';
            if (in_array(date('H'), ['06','07','08','09','10','11','12'])) {
                $tip = '上午好';
            } else if (in_array(date('H'), ['13','14','15','16','17','18'])) {
                $tip = '下午好';
            }

            $nav = config('local')['nav']['admin'];
            $this->result['sidebar'] = ['now' => date('Y-m-d H:i:s', strtotime('-1 days'))];
            $this->result['data'] = ['travelInfo' => '', 'loginInfo'=> $this->result['login'], 'tip'=>$tip];
            $this->result['myview'] = 'index.admin';

            $this->result['navName'] = $nav;
            return view('index.index', $this->result);
        } else {
            //跳转到login
            header('location:'.config('local')['website'].'/login');
        }

    }

    public function addbaby() {
        if ($this->result['login'] && $this->result['login']['isAdmin']) {

            $tip = '晚上好';
            if (in_array(date('H'), ['06','07','08','09','10','11','12'])) {
                $tip = '上午好';
            } else if (in_array(date('H'), ['13','14','15','16','17','18'])) {
                $tip = '下午好';
            }

            $nav = config('local')['nav']['adminAddBaby'];
            $this->result['sidebar'] = ['now' => date('Y-m-d H:i:s', strtotime('-1 days'))];
            $this->result['data'] = ['travelInfo' => '', 'loginInfo'=> $this->result['login'], 'tip'=>$tip];
            $this->result['myview'] = 'index.admin.addbaby';

            $this->result['navName'] = $nav;
            return view('index.index', $this->result);
        } else {
            //跳转到login
            header('location:'.config('local')['website'].'/login');
        }
    }

    public function savebaby()
    {
        $result = ['success'=>false,'code'=>0, 'msg'=>'error'];
        if (!$this->result['login']) {
            $result['code'] = 1001;
            $result['msg'] = '请先登录';
        }

        if ($this->result['login'] && !$this->result['login']['isAdmin']) {
            $result['code'] = 1002;
            $result['msg'] = '非管理员不能操作';
        }

        if (!$_POST['title']) {
            $_POST['title'] = '这个家伙有点懒，什么都没留下';
        }
        if (!$_POST['mydate']) {
            $_POST['mydate'] = date('Y-m-d');
        }

        $title = trim($_POST['title']);
        $mydate = trim($_POST['mydate']);
        $isPrivate = (int) $_POST['isPrivate'];

        $uid = isset($this->result['login']['uid']) ? $this->result['login']['uid'] : 1;
        $myImage = '';

        if (!isset($_FILES['myfile'])) {
            $result['code'] = 1003;
            $result['msg'] = '上传图片失败，无效的FILES';
        }

        if (isset($_FILES['myfile'])) {

            if (isset($_FILES["myfile"]["size"]) && $_FILES["myfile"]["size"] > 2097152) {
                $result['code'] = 1011;
                $result['msg'] = '上传图片尺寸不能大于2M';
            }


            //获取图片的临时路径
            $image = $_FILES["myfile"]['tmp_name'];






            //只读方式打开图片文件
            $fp = fopen($image, "r");
            //读取文件（可安全用于二进制文件）
            $file = fread($fp, $_FILES["myfile"]["size"]); //二进制数据流

            $relativePath = 'static/image/upload/baby/';
            //保存地址
            $imgDir = $_SERVER['DOCUMENT_ROOT'] . '/' . $relativePath;
            if (!is_dir($imgDir)) {
                mkdir($imgDir);
                chmod($imgDir, 0777);
            }
            //要生成的图片名字
            $imageEnd = '';
            $imageType = '';
            if (isset($_FILES["myfile"]['type'])) {
                $imageType = $_FILES["myfile"]['type'];
            }
            if (isset(config('local')['image_type'][$imageType])) {
                $imageEnd = config('local')['image_type'][$imageType];
            }
            if (!$imageEnd) {
                $result['code'] = 1004;
                $result['msg'] = '图片格式非法，仅支持JPG,PNG,GIF';
            }

            if ($result['code'] == 0) {


                $randImageName = date('YmdHis') . '-' . rand(100, 999) . '.' . $imageEnd;

                $filename = $this->sourceImagePre . $randImageName;
                //新图片的路径
                $newFilePath = $imgDir . $filename;

                if ($imageEnd == 'jpg') {

                    $data = $file;
                    $newFile = fopen($newFilePath, "w"); //打开文件准备写入
                    fwrite($newFile, $data); //写入二进制流到文件
                    fclose($newFile); //关闭文件
                    /***********图片旋转问题修正************/

                    $image = imagecreatefromstring(file_get_contents($image));
                    $exif = @exif_read_data($newFilePath);
                    $orientation = $exif['Orientation'];
                    switch ($orientation) {
                        case 8://需要顺时针旋转90°
                            $image = imagerotate($image, 90, 0);
                            break;
                        case 3://需要旋转180°
                            $image = imagerotate($image, 180, 0);
                            break;
                        case 6: //需要逆时针旋转90°
                            $image = imagerotate($image, -90, 0);
                            break;
                    }
                    imagejpeg($image, $newFilePath);//将旋转后的图像保存到文件，$destination为图片路径。

                    /***********************/
                } else {

                    $data = $file;
                    $newFile = fopen($newFilePath, "w"); //打开文件准备写入
                    fwrite($newFile, $data); //写入二进制流到文件
                    fclose($newFile); //关闭文件
                }

                if (file_exists($newFilePath)) {
                    //保存到数据库
                    //$myImage = $relativePath . $filename;
                    $imgCompess = new \App\Models\Common\Imgcompress($newFilePath, 320);

                    $sfilename = $this->thumbnailImagePre.$randImageName;
                    $snewFilePath = $imgDir.$sfilename;
                    $imgCompess->compressImg($snewFilePath);

                    $mySourceImage = $relativePath . $filename;
                    $myImage = $relativePath . $sfilename;
                    $family = new \App\Models\Family\Family();
                    $family->title = $title;
                    $family->image = $myImage;
                    $family->source_image = $mySourceImage;
                    $family->ctime = date('Y-m-d H:i:s', strtotime($mydate));
                    $family->utime = date('Y-m-d H:i:s', strtotime($mydate));
                    $family->user_id = $uid;
                    $family->is_private = $isPrivate;
                    $isSave = $family->save();
                    if ($isSave) {
                        $result['success'] = true;
                        $result['code'] = 0;
                        $result['msg'] = '上传成功';
                    }
                }

                if (!$result['success']) {
                    $result['code'] = 1005;
                    $result['msg'] = '上传图片失败';
                }
            }
        }


        $nav = config('local')['nav']['adminTip'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        if ($result['success']) {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '宝宝照片墙', 'jumpUrl' => config('local')['website'] . '/baby'];
        } else {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '添加宝宝操作页', 'jumpUrl' => config('local')['website'] . '/admin/addbaby'];
        }
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }
}
