<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2016/1/10
 * Time: 11:09
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class BaseModel extends Model
{
    //>>开启数据的批量验证
    protected $patchValidate = true;

    //重新定义select方法
    public function getList($wheres = array())
    {
        //查询条件为数据状态大于 -1  的数据
        if (!empty($wheres)) {
            $wheres['status'] = array('gt', -1);
        } else {
            $wheres['status'] = array('gt', -1);
        }
        //获取分页的工具条
        $totalRows = $this->where($wheres)->count();      //准备数数据状态大于-1的总条数
        $listRows = 2;                    //确定每一页显示的数据条数
        //实例化分页工具条的对像

        $page = new Page($totalRows, $listRows);
        //>>判断是否要修改主题
        if ($totalRows > $listRows) {
            $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }

        //存储分页的条件
        $pageHtml = $page->show();

        //>>每一页的数据删除完之后显示这页数据的上一页

        //查询出每一页需要显示的数据
        $this->limit($page->firstRow, $page->listRows)->where($wheres);
        $rows = parent::select();
        return array('rows' => $rows, 'pageHtml' => $pageHtml);
    }

    public function changeStatus($id, $status = -1)
    {
        //>>判断数据为-1的时候   修改数据的名字
        $data['id'] = array('in', $id);
        $data['status'] = $status;
        if ($status == -1) {
            //>>状态为-1移除数据时修改数据的名字
            $data['name'] = array('exp', "concat(`name`,'_del')");
            return $this->save($data);
        } else {
            //根据id修改数据的状态
            return $this->save($data);
        }

    }
}