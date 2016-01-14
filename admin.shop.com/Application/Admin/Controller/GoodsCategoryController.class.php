<?php
namespace Admin\Controller;


use Think\Controller;

class GoodsCategoryController extends BaseController
{
    //提供编辑页面的mate_title信息
    protected $mate_title='商品信息';
    public function index()
    {
        $rows=$this->model->getTreeList();
        $this->assign('mate_title','添加'.$this->mate_title);
        $this->assign('rows',$rows);
        $this->display('index');
    }

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
            $rows=$this->model->getTreeList(true,'id,name,parent_id');
            $this->assign('rows',$rows);
            $this->assign('mate_title', '编辑' . $this->mate_title);
            $this->display('add');
        }
    }

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
            $rows=$this->model->getTreeList(true,'id,name,parent_id');
            $this->assign('rows',$rows);
            $this->assign('mate_title', '添加' . $this->mate_title);
            $this->display('add');
        }
    }
}