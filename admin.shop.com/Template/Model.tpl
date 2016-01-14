
namespace Admin\Model;



class <?php echo $name?>Model extends BaseModel
{
    //>>定义数据的自动验证
protected $_validate = array(
<?php  foreach($fields as $field){
               //id和可以为空的内容不生成验证规则
              if($field['field']=='id' || $field['null']=='YES'){
                    continue;
              }
             echo "array('{$field['field']}','require','{$field['comment']}不能够为空'),\r\n";
        }   ?>
);
}