<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2016/1/10
 * Time: 20:27
 */

namespace Admin\Controller;


use Think\Controller;

class GiiController extends Controller
{
    //>>这个控制器的主要作用就是用来生成表对应的控制器  和  模型
    public function index(){
        if(IS_POST){
            //>>1.先创建控制器    设置字符集的编码
            header('Content-type:text/html;charset=utf-8');

            //>>获取表的名字 处理表名  brand-->> Brand  brand_type-->>BrandType
            $tableName=I('post.table_name');
            //使用Thinkphp里面的自定义函数   处理成需要的表的名字
            $name=parse_name($tableName,1);

            //>>获取表字段的注释  comment'商品'  或者   comment'供应商'
            $sql="select `TABLE_COMMENT` from information_schema.`TABLES` where `TABLE_SCHEMA`='shop1009' and `TABLE_NAME`='$name'";
            $model=M();
            $result=$model->query($sql);
            $mate_title=$result[0]['table_comment'];

            //>>定义模板的路径常量
            defined('TPL_PATH') or define('TPL_PATH',ROOT_PATH.'Template/');
            //>>引入控制器的模板名字
            require TPL_PATH."Controller.tpl";
            $controller_content='<?php'.ob_get_clean();

            //把缓存的文件放到控制里面  使用file_put_contents();
            $controller_path=APP_PATH.'Admin/Controller/'.$name.'Controller.class.php';
            file_put_contents($controller_path,$controller_content);

            //>>2.创建一张表的模型
            //>>获取一张表的所有结构
            $sql="show full columns from "."`$tableName`";
            $fields=$model->query($sql);


            //再次开启缓存机制
            ob_start();
            //引入模型的模板文件
            require TPL_PATH.'Model.tpl';
            //获取缓存的文件
            $model_content='<?php'.ob_get_clean();
            //模型存放的路径
            $model_path=APP_PATH.'Admin/Model/'.$name.'Model.class.php';
            file_put_contents($model_path,$model_content);

            //>>对表结构里面的数据进行处理
            foreach($fields as $k=>&$field){
                $comment=$field['comment'];
                //id这一列数据使用不到可以在保存的时候直接删除
                if($field['field']=='id'){
                    unset($fields[$k]);
                }
                //判断数据里面有  @ 的时候对数据进行修改
                if(strpos($comment,'@')){
                    //使用正则表达式进行数据的匹配
                    preg_match('/(.*)@([a-z]*)\|?(.*)/',$comment,$result);
                    $field['comment']=$result[1];
                    $field['input_type']=$result[2];
                    $values=$result[3];
                    if(!empty($values)){
                        parse_str($values,$value);
                        $field['values']=$value;
                    }
                }
                //使用正则表达式对数据进行匹配
            }
            unset($field);

//            dump($fields);
//            exit;
            //>>3.创建一张表单的显示列表
            ob_start();
            require TPL_PATH."index.tpl";
            $index_dir=APP_PATH.'Admin/View/'.$name;
            $index_content=ob_get_clean();
            //判断路径是否存在
            if(!is_dir($index_dir)){
                mkdir($index_dir,0777,true);
            }
            $index_path=APP_PATH.'Admin/View/'.$name.'/index.html';
            file_put_contents($index_path,$index_content);


            //>>4.创建一张表的编辑页面
            ob_start();     //开启缓存机制
            require TPL_PATH."add.tpl";
            $add_content=ob_get_clean();
            $add_path=APP_PATH.'Admin/View/'.$name.'/add.html';
            file_put_contents($add_path,$add_content);

        }else{
            //>>get方式提交的时候用来显示页面
            $this->display('edit');
        }
    }
}