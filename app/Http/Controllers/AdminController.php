<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{

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
            $result['msg'] = '请先登录';
        }

        if ($this->result['login'] && !$this->result['login']['isAdmin']) {
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
            $result['msg'] = '上传图片失败，无效的FILES';
        }

        if (isset($_FILES['myfile'])) {
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
            $imageEnd = 'jpg';
            $imageType = '';
            if (isset($_FILES["myfile"]['type'])) {
                $imageType = $_FILES["myfile"]['type'];
            }
            if (isset(config('local')['image_type'][$imageType])) {
                $imageEnd = config('local')['image_type'][$imageType];
            }
            $filename = 'B' . date('YmdHis') . '-' . rand(100, 999) . '.' . $imageEnd;
            //新图片的路径
            $newFilePath = $imgDir . $filename;
            $data = $file;

            $newFile = fopen($newFilePath, "w"); //打开文件准备写入
            fwrite($newFile, $data); //写入二进制流到文件
            fclose($newFile); //关闭文件

            if (file_exists($newFilePath)) {
                //保存到数据库
                $myImage = $relativePath . $filename;
                $datas = [
                    'title' => $title,
                    'image' => $myImage,
                    'ctime' => date('Y-m-d H:i:s', strtotime($mydate)),
                    'utime' => date('Y-m-d H:i:s', strtotime($mydate)),
                    'user_id' => $uid,
                    'is_private' => $isPrivate,
                ];
                $family = new \App\Models\Family\Family();
                $isSave = $family->saveData($datas);
                if ($isSave) {
                    $result['success'] = true;
                    $result['msg'] = '上传成功';
                }
            }
        }
        if (!$myImage) {
            $result['msg'] = '上传图片失败';
        }

        $nav = config('local')['nav']['adminAddBaby'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['saveResult' => $result];
        $this->result['myview'] = 'index.admin.savetip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);

    }
}
