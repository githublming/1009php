<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2016/1/10
 * Time: 10:49
 */

namespace Admin\Controller;


use Think\Controller;

class BaseController extends Controller
{
    protected $model;

    public function _initialize()
    {
        $this->model = D(CONTROLLER_NAME);
    }


    /**
     * 显示供货商列表页面
     * 实现页面的分页和分页数据
     */
    public function index()
    {
        //>>获取搜索的参数  作为查询条件  传递给model进行查询
        $name = I('get.checkName');
        for ($i = 1000; $i > 0; --$i) {
            $name = urldecode("$name");
        }
        $wheres = array();
        $wheres['name'] = array('like', "%{$name}%");
        //>>获取供货商的数据
        $arr = $this->model->getList($wheres);
        //>>展示供货商的数据  $arr是一个具有键名的二维数组  直接分配到页面
        dump($arr);
        $this->assign($arr);
        //>>获取展示页面的时候保存  当前请求的url地址到cookie里面
        cookie('__url__', $_SERVER['REQUEST_URI']);
        $this->assign('mate_title','添加'.$this->mate_title);
        $this->assign('name', $name);
        $this->display('index');
    }

    /**
     * @param $id       修改数据的id
     * @param $status   修改数据的状态
     */
    public function changeStatus($id, $status = -1)
    {
        //>>调用对象里面的方法修改数据
        if ($this->model->changeStatus($id, $status) !== false) {
            $this->success('操作成功', cookie('__url__'));
        } else {
            $this->error('修改数据失败' . show_model_error($this->model));
        }
    }

    /**
     * 添加一条数据
     */
    public function add()
    {
        //>>判断post方式提交
        if (IS_POST) {
            //>>使用对象里面的create方法获取提交的数据  并进行自动验证和自动过滤
            if ($this->model->create() !== false) {
                if ($this->model->add() !== false) {
                    $this->success('添加供货商成功', U('index'));
                    return;
                }
            }
            $this->error('操作失败' . show_model_error($this->model));
        } else {
            $this->assign('mate_title', '添加' . $this->mate_title);
            $this->display('add');
        }
    }

    /**
     * 数据的编辑方法
     * @param $id 参数绑定
     */
    public function edit($id)
    {
        if (IS_POST) {
            if ($this->model->create() !== false) {
                if ($this->model->save() !== false) {
                    $this->success('修改成功', cookie('__url__'));
                    return;
                }
            }
            $this->error('操作失败' . show_model_error($this->model));
        } else {
            //>>获取一行数据  回显
            $row = $this->model->where(array('id' => $id))->find();
            $this->assign($row);
            $this->assign('mate_title', '编辑' . $this->mate_title);
            $this->display('add');
        }
    }

}