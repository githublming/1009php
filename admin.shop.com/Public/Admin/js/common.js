$(function(){
    //页面加载完毕  执行jquery代码
    //>>实现选中的批量移除

    //实现复选框的全选与反选
    $('.selectAll').click(function(){
        $('.ids').prop('checked',$(this).prop('checked'));
    });
    $('.ids').click(function(){
        $('.selectAll').prop('checked',$('.ids:not(:checked)').length==0);
    });


    //使用get方式处理数据

  $('.ajax-get').click(function(){            //给 .ajax-get添加上点击事件

    //使用ajax的get方式提交数据进行处理   实现数据的异步交互
    var url=$(this).attr('href');
    $.get(url,jump);
    //结束代码的默认事件
    return false;
  });

    /**
     * 使用post方式处理数据
     */
  $('.ajax-post').click(function(){
    //使用closest获取指定的父级标签
    var form=$(this).closest('form');
      //提交form表单里面的值
    if(form.length!=0){
        //序列化表单的数据
        var formData=form.serialize();
        //获取表达的数据
        var url=form.attr('action');
        //post  里面的参数   url   传递的参数   回调函数 (注意回调函数使用的时候不需要加括号)
        $.post(url,formData,jump);
    }else{
        //post提交非表单里面的值
        var url=$(this).attr('url');
        var formData=$('.ids:checked').serialize();
        $.post(url,formData,jump);
    }
      //取消事件的默认行为
      return false;
  });


    /**
     * 把共同的方法抽取出来   作为回调函数
     * @param data  回调函数里面接收到的参数
     */
    function jump(data){
        var icon;
        if(data.status){
            icon=1;
        }else{
            icon=2;
        }
        //操作成功  提示信息  并跳转
        layer.msg(data.info, {
                icon:icon,    //提示框中的图标
                time:1000,    //提示框关闭的时间
                offset: 0,    //设置弹出框的上下距离
                shift: 6     //弹出时的动画效果
            },function(){   //动画关闭的时候进行页面的跳转
                if(data.url){
                    location.href=data.url;
                };
            }
        );
    }
});