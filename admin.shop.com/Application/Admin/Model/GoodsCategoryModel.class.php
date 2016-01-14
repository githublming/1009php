<?php
namespace Admin\Model;



use Admin\Service\NestedSetsService;

class GoodsCategoryModel extends BaseModel
{
    //>>定义数据的自动验证
    protected $_validate = array(
    array('name','require','分类名称不能够为空'),
    array('parent_id','require','父分类不能够为空'),
    array('status','require','是否显示@radio|1=是&0=否不能够为空'),
    );
    //获取表里面的数据   判断返回的数据时json数据   还是普通的数据
    public function getTreeList($isJson=false,$field='*'){
        $rows=$this->where(array('status'=>array('egt',0)))->order('lft')->select();
        if($isJson){
            return json_encode($rows);
        }
        return $rows;
    }

    //重写add方法
    public function add(){
        //>>创建能够执行sql的对象
        $dbMysql=new DbMysqlInterfaceImpModel();
        //>>重新计算表里面数据的边界
        $nestedSetsService=new NestedSetsService($dbMysql,'goods_category','lft','rgt','parent_id','id','level');

        $nestedSetsService->insert($this->data['parent_id'],$this->data,$position = 'bottom');
        //>>保存计算边界之后的数据
    }

    public function sava(){
        //>>创建能够执行sql的对象
        $dbMysql=new DbMysqlInterfaceImpModel();
        //>>重新计算表里面数据的边界
        $nestedSetsService=new NestedSetsService($dbMysql,'goods_category','lft','rgt','parent_id','id','level');
        //>>实现数据的编辑移动  这个方法仅实现了数据的移动
        $nestedSetsService->moveUnder($this->data['parent_id'],$this->data);
        //调用父类的方法对数据进行保存
        return parent::sava();
    }

    public function changeStatus($id, $status = -1)
    {
        //商品页面编辑显示  和移除的的时候  寻找下面的儿子节点
        $sql="select child.id from goods_category as child,goods_category as parent where parent.id='{$id}' and child.lft>=parent.lft and child.rgt<=parent.rgt";
        $rows=$this->query($sql);
        $id=array();
        foreach($rows as $row){
            $id[]=$row['id'];
        }
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