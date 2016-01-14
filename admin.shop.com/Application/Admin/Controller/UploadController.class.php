<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2016/1/13
 * Time: 0:38
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    public function index(){
    $dir=I('post.dir');
    $config = array(
        'rootPath'     => './Uploads/', //保存根路径
        'savePath'     => $dir.'/', //保存路径
        'driver'       => '', // 文件上传驱动
        'driverConfig' => array(), // 上传驱动配置
    );
    $upLoader=new Upload($config);
    $result=$upLoader->uploadOne($_FILES['Filedata']);
    if($result!==false){
        echo $result['savepath'].$result['savename'];
    }else{
        echo $upLoader->getError();
    }
}
}