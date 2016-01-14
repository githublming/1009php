<extend name="Common:index"/>

<block name="mainBody">

    <table cellpadding="3" cellspacing="1">
        <tr>
            <th width="80px">ID<input type="checkbox" class="selectAll"/></th>
            <?php foreach($fields as $field):?>
            <th><?php echo $field['comment']?></th>
            <?php endforeach?>
            <th>操作</th>
        <tr>
            <volist name="rows" id="row">
                <tr>
                    <td>{$row.id}<input type="checkbox" class="ids" name="id[]" value="{$row.id}"/></td>
                    <?php foreach($fields as $field){
                            if($field['field']=='name'){
                              echo '<td class="first-cell">{$row.name}</td>';
                    }elseif($field['field']=='status'){
                    echo "<td align=\"center\"><a class=\"ajax-get\" href=\"{:U('changeStatus',array('id'=>\$row['id'],'status'=>(1-\$row['status'])))}\"><img src=\"__IMG__/{\$row.status}.gif\"/></a></td>";
                    }else{
                    echo "<td align=\"center\">{\$row.{$field['field']}}</td>";
                    }
                    }
                    ?>
                    <td>
                        <a href="{:U('edit',array('id'=>$row['id']))}">编辑</a> <a class="ajax-get" href="{:U('changeStatus',array('id'=>$row['id']))}">移除</a>
                    </td>
                </tr>
            </volist>
    </table>

</block>