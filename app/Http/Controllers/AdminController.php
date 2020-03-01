<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    //首页缩略图
    private $indexImagePre = 'I';
    //原图
    private $sourceImagePre = 'S';
    //副页缩略图
    private $thumbnailImagePre = 'T';

    public function __construct() {
        parent::__contract();

    }

    private function noLogin() {
        if (!$this->result['login']) {
            //跳转到login
            header('location:'.config('local')['website'].'login');exit;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $this->noLogin();
        $nav = config('local')['nav']['admin'];
        $this->result['sidebar'] = ['now' => date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
        $this->result['data'] = ['loginInfo'=> $this->result['login']];
        $this->result['myview'] = 'index.admin';

        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function addbaby() {
        $this->noLogin();
        if ($this->result['login']['isAdmin']) {

            $tip = '晚上好';
            if (in_array(date('H'), ['06','07','08','09','10','11','12'])) {
                $tip = '上午好';
            } else if (in_array(date('H'), ['13','14','15','16','17','18'])) {
                $tip = '下午好';
            }

            $nav = config('local')['nav']['adminAddBaby'];
            $this->result['sidebar'] = ['now' => date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
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
        $this->noLogin();
        $result = ['success'=>false,'code'=>0, 'msg'=>'error'];

        if (!$this->result['login']['isAdmin']) {
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

            if (isset($_FILES["myfile"]["size"]) && $_FILES["myfile"]["size"] > 3145728) {
                $result['code'] = 1011;
                $result['msg'] = '上传图片尺寸不能大于3M';
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
                $data = $file;
                $newFile = fopen($newFilePath, "w"); //打开文件准备写入
                fwrite($newFile, $data); //写入二进制流到文件
                fclose($newFile); //关闭文件
                if ($imageEnd == 'jpg') {
                    /***********图片旋转问题修正************/
                    $image = imagecreatefromstring(file_get_contents($image));
                    $exif = @exif_read_data($newFilePath);
                    if (isset($exif['Orientation'])) {
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
                    }
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
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
        if ($result['success']) {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '宝宝照片墙', 'jumpUrl' => config('local')['website'] . '/baby'];
        } else {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '添加宝宝操作页', 'jumpUrl' => config('local')['website'] . '/admin/addbaby'];
        }
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }


    public function mytravel() {
        $this->noLogin();
        $where = [];
        if ($this->result['login']['isAdmin']) {
            $travelList = \App\Models\Travel\Travel::getList2($where);
        } else {
            $where['user_id'] = $this->result['login']['uid'];
            $travelList = \App\Models\Travel\Travel::getList2($where);
        }

        $nav = config('local')['nav']['adminMyTravel'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['loginInfo'=> $this->result['login'], 'list'=>$travelList];
        $this->result['myview'] = 'index.admin.mytravel';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function addtravelfirst() {
        $this->noLogin();
        $nav = config('local')['nav']['adminMyTravel'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
        $this->result['data'] = ['loginInfo'=> $this->result['login']];
        $this->result['myview'] = 'index.admin.addtravelfirst';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function savetravelfirst() {
        $this->noLogin();
        $result = ['success'=>false,'code'=>0, 'msg'=>'error'];

        $state = 2;
        if ($this->result['login']['isAdmin']) {
            $state = 0;
        }

        if (!$_POST['title']) {
            $_POST['title'] = '这个家伙有点懒，什么都没留下';
        }
        if (!$_POST['mydate']) {
            $_POST['mydate'] = date('Y-m-d H:i:s');
        }

        if (!$_POST['content']) {
            $_POST['content'] = '这个家伙有点懒，什么都没留下';
        }

        $title = trim($_POST['title']);
        $mydate = trim($_POST['mydate']);
        $content = trim($_POST['content']);
        $uid = isset($this->result['login']['uid']) ? $this->result['login']['uid'] : 0;
        $myImage = '';

        if (!isset($_FILES['myfile'])) {
            $result['code'] = 1003;
            $result['msg'] = '上传图片失败，无效的FILES';
        }

        if (isset($_FILES['myfile'])) {

            if (isset($_FILES["myfile"]["size"]) && $_FILES["myfile"]["size"] > 3145728) {
                $result['code'] = 1011;
                $result['msg'] = '上传图片尺寸不能大于3M';
            }


            //获取图片的临时路径
            $image = $_FILES["myfile"]['tmp_name'];
            //只读方式打开图片文件
            $fp = fopen($image, "r");
            //读取文件（可安全用于二进制文件）
            $file = fread($fp, $_FILES["myfile"]["size"]); //二进制数据流

            $relativePath = 'static/image/upload/travel/';
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

            $TravelCount = \App\Models\Travel\Travel::whereRaw('state in(0,2) and user_id = ?', [$uid])->count();
            if ($TravelCount >= 20 && !$this->result['login']['isAdmin']) {
                $result['code'] = 1021;
                $result['msg'] = '您只能分享二十次旅行记录噢';
            }
            if ($result['code'] == 0) {


                $randImageName = date('YmdHis') . '-' . rand(100, 999) . '.' . $imageEnd;

                $filename = $this->sourceImagePre . $randImageName;
                //新图片的路径
                $newFilePath = $imgDir . $filename;
                $data = $file;
                $newFile = fopen($newFilePath, "w"); //打开文件准备写入
                fwrite($newFile, $data); //写入二进制流到文件
                fclose($newFile); //关闭文件
                if ($imageEnd == 'jpg') {
                    /***********图片旋转问题修正************/

                    $image = imagecreatefromstring(file_get_contents($image));
                    $exif = @exif_read_data($newFilePath);
                    if (isset($exif['Orientation'])) {
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
                    }
                }

                if (file_exists($newFilePath)) {
                    $mySourceImage = $relativePath . $filename;//原图

                    //320缩略图
                    $imgCompess = new \App\Models\Common\Imgcompress($newFilePath, 320);
                    $sfilename = $this->thumbnailImagePre.$randImageName;
                    $snewFilePath = $imgDir.$sfilename;
                    $imgCompess->compressImg($snewFilePath);
                    $myImage = $relativePath . $sfilename;//320缩略图
                    //80缩略图
                    $imgCompess = new \App\Models\Common\Imgcompress($newFilePath, 80);
                    $ifilename = $this->indexImagePre.$randImageName;
                    $inewFilePath = $imgDir.$ifilename;
                    $imgCompess->compressImg($inewFilePath);
                    $myImageIndex = $relativePath . $ifilename;//80缩略图

                    $isSave = 0;

                    DB::beginTransaction();
                    try {
                        $Travel = new \App\Models\Travel\Travel();
                        $Travel->title = $title;
                        $Travel->content = $content;
                        $Travel->index_image = $myImageIndex;
                        $Travel->state = $state;
                        $Travel->ctime = date('Y-m-d H:i:s', strtotime($mydate));
                        $Travel->utime = date('Y-m-d H:i:s', strtotime($mydate));
                        $Travel->user_id = $uid;
                        $isSave = $Travel->save();

                        $TravelDetail = new \App\Models\Travel\TravelDetail();
                        $TravelDetail->title = $title;
                        $TravelDetail->content = $content;
                        $TravelDetail->image = $myImage;
                        $TravelDetail->source_image = $mySourceImage;
                        $TravelDetail->ctime = date('Y-m-d H:i:s', strtotime($mydate));
                        $TravelDetail->utime = date('Y-m-d H:i:s', strtotime($mydate));
                        $TravelDetail->travel_id = $Travel->id;
                        $isSave = $TravelDetail->save();
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                    }
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
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
        if ($result['success']) {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '我的旅行', 'jumpUrl' => config('local')['website'] . 'admin/mytravel'];
        } else {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '添加旅行操作页', 'jumpUrl' => config('local')['website'] . 'admin/addtravelfirst'];
        }
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }


    public function addtraveldetail($id) {
        $this->noLogin();
        $nav = config('local')['nav']['adminMyTravel'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
        $this->result['data'] = ['loginInfo'=> $this->result['login'], 'travelId'=>$id];
        $this->result['myview'] = 'index.admin.addtraveldetail';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function savetraveldetail()
    {
        $this->noLogin();
        $result = ['success' => false, 'code' => 0, 'msg' => 'error'];

        $state = 2;
        if ($this->result['login']['isAdmin']) {
            $state = 0;
        }

        if (!$_POST['travelId']) {
            $result['code'] = 1021;
            $result['msg'] = '旅行ID不能为空';
        }

        if (!$_POST['title']) {
            $_POST['title'] = '这个家伙有点懒，什么都没留下';
        }
        if (!$_POST['mydate']) {
            $_POST['mydate'] = date('Y-m-d H:i:s');
        }

        if (!$_POST['content']) {
            $_POST['content'] = '这个家伙有点懒，什么都没留下';
        }
        $travelId = (int)$_POST['travelId'];
        $title = trim($_POST['title']);
        $mydate = trim($_POST['mydate']);
        $content = trim($_POST['content']);
        $uid = isset($this->result['login']['uid']) ? $this->result['login']['uid'] : 0;
        $myImage = '';

        if (!isset($_FILES['myfile'])) {
            $result['code'] = 1003;
            $result['msg'] = '上传图片失败，无效的FILES';
        }

        if (isset($_FILES['myfile'])) {

            if (isset($_FILES["myfile"]["size"]) && $_FILES["myfile"]["size"] > 3145728) {
                $result['code'] = 1011;
                $result['msg'] = '上传图片尺寸不能大于3M';
            }


            //获取图片的临时路径
            $image = $_FILES["myfile"]['tmp_name'];
            //只读方式打开图片文件
            $fp = fopen($image, "r");
            //读取文件（可安全用于二进制文件）
            $file = fread($fp, $_FILES["myfile"]["size"]); //二进制数据流

            $relativePath = 'static/image/upload/travel/';
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
                $data = $file;
                $newFile = fopen($newFilePath, "w"); //打开文件准备写入
                fwrite($newFile, $data); //写入二进制流到文件
                fclose($newFile); //关闭文件
                if ($imageEnd == 'jpg') {
                    /***********图片旋转问题修正************/

                    $image = imagecreatefromstring(file_get_contents($image));
                    $exif = @exif_read_data($newFilePath);
                    if (isset($exif['Orientation'])) {
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
                    }
                }

                if (file_exists($newFilePath)) {
                    //保存到数据库
                    //$myImage = $relativePath . $filename;
                    $imgCompess = new \App\Models\Common\Imgcompress($newFilePath, 320);

                    $sfilename = $this->thumbnailImagePre . $randImageName;
                    $snewFilePath = $imgDir . $sfilename;
                    $imgCompess->compressImg($snewFilePath);

                    $mySourceImage = $relativePath . $filename;
                    $myImage = $relativePath . $sfilename;
                    $isSave = 0;

                    try {
                        $TravelDetail = new \App\Models\Travel\TravelDetail();
                        $TravelDetail->title = $title;
                        $TravelDetail->content = $content;
                        $TravelDetail->image = $myImage;
                        $TravelDetail->source_image = $mySourceImage;
                        $TravelDetail->ctime = date('Y-m-d H:i:s', strtotime($mydate));
                        $TravelDetail->utime = date('Y-m-d H:i:s', strtotime($mydate));
                        $TravelDetail->travel_id = $travelId;
                        $isSave = $TravelDetail->save();
                    } catch (\Exception $e) {
                        //
                    }
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
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
        if ($result['success']) {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '我的旅行', 'jumpUrl' => config('local')['website'] . 'admin/mytravel'];
        } else {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2' => '添加旅行操作页', 'jumpUrl' => config('local')['website'] . 'admin/addtraveldetail/'.$travelId];
        }
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function look($id) {
        $this->noLogin();
        $where = [];
        if ($this->result['login']['isAdmin']) {

        } else {
            $where['user_id'] = $this->result['login']['uid'];
        }
        $travelList = \App\Models\Travel\Travel::getOne($where, $id);
        $nav = config('local')['nav']['adminMyTravel'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];
        $this->result['data'] = ['loginInfo'=> $this->result['login'], 'list'=>$travelList];
        $this->result['myview'] = 'index.admin.look';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function checktravel($id) {
        $isUpd = 0;
        if ($this->result['login']['isAdmin']) {
            $isUpd = \App\Models\Travel\Travel::where(['id'=>$id])->update(['state'=>0]);
        }
        $nav = config('local')['nav']['adminTip'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>0, 'totalCounts' => 0];

        if ($isUpd) {
            $this->result['data'] = ['msg' => '审核成功', 'msg2' => '旅行查看页', 'jumpUrl' => config('local')['website'] . 'admin/look/'.$id];
        } else {
            $this->result['data'] = ['msg' => '审核失败', 'msg2' => '旅行查看页', 'jumpUrl' => config('local')['website'] . 'admin/look/'.$id];
        }
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }
}
