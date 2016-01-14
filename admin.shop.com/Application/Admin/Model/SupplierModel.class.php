<?php
namespace Admin\Model;



class SupplierModel extends BaseModel
{
    //>>定义数据的自动验证
protected $_validate = array(
array('name','require','供应商名称不能够为空'),
array('sort','require','排序不能够为空'),
array('status','require','是否显示@radio|1=是&0=否不能够为空'),
);
}