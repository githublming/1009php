<extend name="Common:add"/>

<block name="mainBody">
    <div id="tabbody-div">
        <form action="{:U('')}" method="post">
            <table width="90%" id="general-table" align="center">
                <?php foreach($fields as $field):?>
                    <tr>
                        <td class="label"><?php echo $field['comment']?></td>
                        <?php if(empty($field['input_type'])):?>
                        <td><input type="text" name="<?php echo $field['field']?>" value="{$<?php echo $field['field']?>}" size="30" />
                        <?php elseif($field['field']=='sort'):?>
                        <td><input type="text" name="<?php echo $field['field']?>" value="{$<?php echo $field['field']?>\|default=20}" size="30" />
                        <?php elseif($field['input_type']=='file'):?>
                        <td><input type="file" name="<?php echo $field['field']?>"/></td>
                        <?php elseif($field['input_type']=='textarea'):?>
                        <td><textarea name="intro" cols="40" rows="3">{$intro}</textarea></td>
                        <?php elseif($field['input_ty pe']=='radio'):?>
                        <td>
                            <?php foreach($field['values'] as $key=>$val):?>
                            <input type="radio" class="status" name="status" value="<?php echo $key?>"/><?php echo $val?>
                            <?php endforeach?>
                        </td>
                        <?php endif?>
                    </tr>
                <?php endforeach?>
            </table>
            <div class="button-div">
                <input type="hidden" name="id" value="{$id}">
                <input type="button" value=" 确定 " class="ajax-post"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</block>