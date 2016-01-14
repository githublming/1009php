<?php
header('content-type: text/html;charset=utf-8');


/**
 * 获取模型中的错误信息
 * @param $model   传入一个对象
 * @return string  返回拼接后的错误信息
 */
function show_model_error($model)
{
    //获取验证后的错误信息
    $errors = $model->getError();
    $errorMsg = '<ul>';
    //判断是个数组就进行拼接
    if (is_array($errors)) {
        foreach ($errors as $error) {
            $errorMsg .= "<li>$error</li>";
        }
    } else {
        //不是数组的时候直接拼接
        $errorMsg .= "<li>$errors</li>";
    }
    $errorMsg .= '</ul>';
    return $errorMsg;
}