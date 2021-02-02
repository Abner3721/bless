<?php

/**
 * Explanation:祝福语验证类
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2021/1/19 11:34
 **/

namespace app\api\validate;
class Blessing extends BaseValidate
{
    protected $rule = [
        'content' 	=> 'require|isNotEmpty',
        'uid'       => 'require',
        'id'        => 'require',
        'like'      => 'require',
        'one'       => 'require',
        'two'       => 'require',
        'three'     => 'require',
        'four'      => 'require',
    ];

    protected $message = [
        'content' 	=> '请输入祝福语',
        'uid'       => '请先登录！',
        'id'        => 'id号不能为空',
        'like'      => '点赞量不能为空',
        'one'       => '第一阶段不能为空',
        'two'       => '第二阶段不能为空',
        'three'     => '第三阶段不能为空',
        'four'      => '第四阶段不能为空',

    ];

    protected $scene = [
        'add'   => ['content','uid'],
        'like'  => ['id'],
        'show'  => ['id'],
        'adminLike' => ['id','like'],
        'config'    => ['one','two','three','four'],

    ];

}