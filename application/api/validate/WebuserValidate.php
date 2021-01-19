<?php
/**
 * Explanation:
 * Author: Abner
 * Date: 2021/1/18 17:16
 */

namespace app\api\validate;
class WebuserValidate extends BaseValidate
{
    protected $rule = [
        'phone' => 'require|isMobile',
    ];

    protected $message = [
        'phone'             => '手机号不能为空',
        'phone.isMobile'    => '手机格式不对',
    ];

    protected $scene = [
        'bindPhone'     => ['phone'],
    ];


}