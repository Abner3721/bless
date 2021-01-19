<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/*表单控制类型*/
function get_parent_son_all($code){
    $MetadataGroupsModel= new \app\common\model\MetadataGroups();
    $cateall = $MetadataGroupsModel::get(array('code'=>$code));
    $MetadatasModel = new \app\common\model\Metadatas();
    $cate =$MetadatasModel::all(array('group_id'=>  $cateall['id']));
    return $cate;
}
/*反序列化数组*/
function get_unserialize_on($array,$field){
    if(!empty($array[$field])){
    $array[$field]=unserialize($array[$field]);
            foreach ($array[$field] as $k => $v) {
                if(strstr($v['input_values'],"\n") != FALSE ){
                    $array[$field][$k]['input_values'] = str_replace("\n",',',$v['input_values']);

                }}};
    return $array;
}


function getstatus($type){
    if($type==1){
        $str='开启';
    }
    if($type==0){
        $str='关闭';
    }
    return $str;
}
function bannertype($typ){
    if($typ=='image'){
        $strs='图片';
    }else if($typ=='language'){
        $strs='文字';
    }else if($typ=='code'){
        $strs='代码';
    }else if($typ ==""){
        $strs=$typ;
    }
    return $strs;
}
/*分类管理类别*/
function jointype($type){
    if($type=='article'){
        $str ='文章';
    }
    return $str;
}

/*表单生成前构建的数组*/
function html_input_array($tuoz){
    $data=unserialize($tuoz['properties']);
    /*循环构建数组*/
    if(!empty($data)){
    foreach( $data as $k=> $v){
        //$tuoz['properties'][$v['code']]=$v;
        /*判断input_values是否有,*/
        if(strstr($v['input_values'],"\n") !==false){
            $values=explode("\n",$v['input_values']);
            foreach($values as $key =>$val){
              if(strstr($val,"=") !==false){
                 $val=explode('=',$val);
                  $data[$k]['__input_values'][$val[0]]=$val[1];
              }else{
                  $data[$k]['__input_values'][$val]=$val;
              }
            }
        }else{
            $data[$k]['__input_values'][$v['input_values']]=$v['input_values'];
        }
    }
    $tuoz['properties']=$data;
    }
    return  $tuoz;
}


/*自动生成表单提交选项*/
function html_input_tag($element) {
   $tagCode = isset ($element['code']) ? $element['code'] : '__form_element';
    $tagName = isset ($element['name']) ? $element['name'] : '';
    $tagType =  isset ($element['input_type']) ? $element['input_type'] : 'text';
    $value =  isset ($element['default_value']) ? $element['default_value'] : '';
    $attrs = isset ($element['attrs']) ? $element['attrs'] : array ();
    $options = array();
    if(isset ($element['__input_values'])){
        $options = $element['__input_values'];
    }elseif( isset($element['input_values']) ){
        $options = $element['input_values'];
    }
    $br = "\n";
    $tagName = empty($tagName) ? $tagName : $tagCode;

    //将属性数组转成字符串
    if(is_array($attrs)){
        foreach ($attrs as $k => $v) {
            if (is_int($k)) {
                $attrs[$k] = $v;
            } else {
                $attrs[$k] = $k . '="' . $v . '"';
            }
        }
        $attrs = !empty ($attrs) ? implode(' ', $attrs) : '';
    }
    $html = '';
    $id = md5($tagName);
    switch($tagType){
        case 'text':
        case 'password':
        case 'hidden' :
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $id = md5($tagName.$k);
                    $html .= " <input type='{$tagType}'   name='{$tagName}[$k]' value='{$v}' {$attrs} /> ".$br;
                }
            } else {
                $html .= " <input type='{$tagType}'   name='{$tagName}' value='{$value}' {$attrs} /> ".$br;
            }
            break;
        case 'file':
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $id = md5($tagName.$k);
                    $html .= " <input type='{$tagType}' style=' margin-top: 20px;height: 25px;'  name='{$tagName}' {$attrs} />" .
                        "<input type='hidden'  name='{$tagName}'  value='{$v}' />" . " ".$br.
                        "<a href='".get_upload_url($v)."'><img src='".get_upload_url($v)."' width=50 height=50>" . " </a>" ;
                }
            } else {

                $html .= " <input type='{$tagType}' style=' margin-top: 20px;height: 25px;'  name='{$tagName}' {$attrs} />" .
                    "<input type='hidden'  name='{$tagName}'  value='{$value}' />";

                if($value)$html .=  " ".$br.  "<a href='".get_upload_url($value)."'><img src='".get_upload_url($value)."' width=50 height=50>" . " </a>" ;
            }
            break;
        case 'textarea':
        case 'editor':
            $value = is_array($value) ? implode("\n", $value) : $value;
            $html .= " <textarea id=\"textarea_{$id}\" name=\"{$tagName}\" {$attrs}>{$value}</textarea> " . $br;
            break;
        case 'select':
            if (!is_array($value)) $value = explode(',', $value);
            $html .= ' <select id="select_' . $id . '" class="zidongselect" name="' . $tagName . '"' . $attrs . '>' . $br;
            if (is_string($options)) {
                $html .= $options;
            } else {
                $html .= '<option value="">'.__('field.btn_select').'</option>';
                foreach ( $options as $_value => $_lable ) {
                    if ( in_array(trim($_value), $value ) ) {
                        $html .= "<option value=\"{$_value}\" selected=\"selected\">{$_lable}</option>" . $br;
                    } else {
                        $html .= "<option value=\"{$_value}\">{$_lable}</option>" . $br;
                    }
                }
            }
            $html .= '</select> ' . $br;
            break;
        case 'radio':
        case 'checkbox':
            if (!is_array($value)) $value = explode(',', $value);
            $html = " ";
            foreach( $options as $_value=>$_lable ){
                $check = '';
                if ( in_array(trim($_value), $value ) ) {
                    $check = ' checked="checked" ';
                }
                $name = $tagType=='checkbox' ? $tagName . '[' . $_value . ']' : $tagName;
                $id = md5( $tagName.$_value);
                $html .= " <label><input type='{$tagType}' id='input_{$id}' name='{$name}' value='{$_value}' {$check} $attrs  /><span class='raidotu' for='{$id}'>{$_lable}</span></label> ". $br;
            }

            break;
        case 'singleselector':
            $html = "";
            $html .= "<input type='hidden' name='{$tagName}' value='{$value}' />";
            $html .= "<a class='singleselectorBtn' href='javascript:singleSelector(\"{$id}\")'>".__('field.btn_select')."</a>";

            break;
        case 'multiselector':
            $html = "";
            $html .= "<input type='hidden' id='input_hidden_{$id}' name='{$tagName}' value='{$value}' />";
            $html .= "<a class='multiselectorBtn' href='javascript:multiSelector(\"{$id}\")'>".__('field.btn_select')."</a>";

            break;
        case 'metadata':
            $group = $element['metadata_group_id'];
            $html = "";
            $metaValue = $metaName = null;
            //$value = '17,19';
            $btn = __('field.btn_select');
            if(!empty($value) ){
                if(is_array($value)){
                    $metaValue = $value['meta_value'];
                    $metaName = $value['name'];
                }else{
                    $values = explode(',',$value);
                    $result = Itbeing::loadModel('metadatas')->findById($values);
                    $metaName = array();
                    foreach($result as $key=>$item ){
                        $metaName[] = $item['name'];
                    }
                    $metaName = implode(',',$metaName);
                    $metaValue = $value;
                }
            }
            $html .= "<input type='hidden' id='input_hidden_{$id}' name='{$tagName}' value='{$metaValue}' />";

            if($metaName){
                $btn = __('field.btn_update');
                $html .= "<span class='metadata_value'>{$metaName}</span>";
            }
            $html .= "<a class='metadataBtn' href='javascript:selectMetadata({$group},\"{$id}\")'>".$btn."</a>";

            break;
    }
    return $html;
}
/*全路径*/
function get_upload_url($file)
{
        return $file;

}
function __()
{
    static $langs;
    $args = func_get_args();
    $msg = array_shift($args);
    $language ='language';
    $file = 'system';
    $code = $msg;
    $codes = explode('.', $msg, 2);
    if (count($codes) > 1) {
        $file = strtolower($codes[0]);
        $code = strtolower($codes[1]);
    }
    if (!isset ($langs[$file])) {
        $langPath = null;
        $dir = 'lang_dir';

        if (file_exists(ROOT_PATH. DS . $dir . DS . $language . DS . $file . EXT)) {
            $langPath = ROOT_PATH . DS . $dir . DS . $language . DS . $file . EXT;
        }
        if ($langPath) {
            $langs[$file] = include($langPath);
        }
    }
    $msg = isset ($langs[$file][$code]) ? $langs[$file][$code] : $code;
    if ($msg && ($count = count($args))) {
        if ($count == 1 && is_array($args[0])) {
            extract($args[0]);
            $msg = addslashes($msg);
            eval("\$msg = \"$msg\";");
            return $msg;
        } else {
            array_unshift($args, $msg);
            return call_user_func_array('sprintf', $args);
        }
    }
    return $msg;
}


/**
 * 整理菜单树方法
 * @param $param
 * @return array
 */
function prepareMenu($param)
{
//    dump($param);die;
    $parent = []; //父类
    $child = [];  //子类
    foreach($param as $key=>$vo) {
        if ( $vo[ 'pid' ] == 0 && $vo[ 'name' ] == '#' ) {
            $vo[ 'href' ] = '#';
            $parent[] = $vo;
        }else if($vo[ 'pid' ] == 0 && $vo[ 'name' ] != '#' ){
            if(!preg_match ("/^((https|http|ftp|rtsp|mms){0,1}(:\/\/){0,1})www\.(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/",$vo['name'])){
                $vo[ 'href' ] = url($vo['name']); //跳转地址
            }else{
                $vo[ 'href' ] = $vo['name']; //跳转地址
            }
            $parent[] = $vo;
        }else{
            if(!preg_match ("/^((https|http|ftp|rtsp|mms){0,1}(:\/\/){0,1})www\.(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/",$vo['name'])){
                $vo[ 'href' ] = url($vo['name']); //跳转地址
            }else{
                $vo[ 'href' ] = $vo['name']; //跳转地址
            }
            $child[] = $vo;
        }
    }

    foreach($parent as $key=>$vo){
        foreach($child as $k=>$v){
            if($v['pid'] == $vo['id']){
                $parent[$key]['child'][] = $v;
            }
        }
    }

    for($i=0;$i<count($parent);$i++){
        if(isset($parent[$i]['child'])){
            for($j=0;$j<count($parent[$i]['child']);$j++){
                if($parent[$i]['child'][$j]['name'] == '##'){
                    for($a=0;$a<count($child);$a++){
                        if($child[$a]['pid'] == $parent[$i]['child'][$j]['id']){
                            $parent[$i]['child'][$j]['child'][] = $child[$a];
                        }
                    }
                }
            }
        }
    }
    unset($child);
    return $parent;
}
//后台列表图片展示
function getimgurl($img){
    if(empty($img)){
        $str='无图片';
    }else{
        $str='<img  src="'.$img.'" style="width:50px;height:50px;" />';
    }
    return $str;
}
/*订单状态*/
function getordersstatus($status){
    if($status == -1){
        $str= '取消订单';
    }else if($status == 0){
        $str= '未付款';
    }else if($status == 1){
        $str= '已付款,待确定';
    }else if($status == 2){
        $str= '已确定,待发货';
    }else if($status == 3){
        $str= '已发货,待收货';
    }else if($status == 4){
        $str= '已收货,待评价';
    }else if($status == 5){
        $str= '订单完成';
    }else if($status == 6){
        $str= '未发货,申请退款';
    }else if($status == 7){
        $str= '已发货,申请退款';
    }else if($status == 8){
        $str= '申请换货';
    }else if($status == 9){
        $str= '退款中';
    }else if($status == 10){
        $str= '换货中';
    }
    return  $str;
}
function getPostMsg($msg,$url=''){
    $data_msg='layer.alert("'.$msg.'", {skin: "layui-layer-lan",closeBtn: 0,anim: 4 });';
    if($url){
        $data_msg.='window.location.href='.$url;
    }
    return $data_msg;
}

function cc_format($name){
    $temp_array = array();
    for($i=0;$i<strlen($name);$i++){
        $ascii_code = ord($name[$i]);
        if($ascii_code >= 65 && $ascii_code <= 90){
            if($i == 0){
                $temp_array[] = chr($ascii_code + 32);
            }else{
                $temp_array[] = '_'.chr($ascii_code + 32);
            }
        }else{
            $temp_array[] = $name[$i];
        }
    }
    return implode('',$temp_array);
}
function cutimg($img,$width,$height){
    $imgs=$_SERVER['DOCUMENT_ROOT'].$img;
    $imgs=str_replace('/',DS,$imgs);
    $imgs=str_replace('\\',DS,$imgs);

    $image = \think\Image::open($imgs);

    $cutimg=$_SERVER['DOCUMENT_ROOT'].'/cutimg'.substr($img,8);
    $explode=explode('.',$cutimg);
    $cutimg=$explode[0].$width.'_'.$height.'.'.$explode['1'];
    $cutimg=str_replace('/',DS,$cutimg);
    $cutimg=str_replace('\\',DS,$cutimg);

    if(file_exists($cutimg)){
        list($width1, $height1, $type, $attr) = getimagesize($cutimg);
        if($width1 !=$width || $height1!=$height){
            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
            $cutimgs= $image->thumb($width,$height,\think\Image::THUMB_CENTER)->save($cutimg);
        }
    }else{
        mkdirs($cutimg);
        $cutimgs = $image->thumb($width,$height,\think\Image::THUMB_CENTER)->save($cutimg);
    }
    $cutimgss='/cutimg'.substr($img,8);
    $cutimgss=str_replace('/',DS,$cutimgss);
    $cutimgss=str_replace('\\',DS,$cutimgss);
    $explodes=explode('.',$cutimgss);
    $cutimgss=$explodes[0].$width.'_'.$height.'.'.$explodes['1'];
    return $cutimgss;
}

function mkdirs($filename)
{
    $position = strrpos($filename, DS);
    $path = substr($filename, 0, $position);
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

/**
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
function curl_get($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}


function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}

function showError($status, $message="error", $data = [], $httpStatus = 403,$boole=false){

    $result = [
        'status' => $status,
        'msg'    => $message,
        'boole'  => $boole,
        'result' => $data,
        'time'   => date('Y-m-d H:i:s', time()),
    ];
    return json($result,$httpStatus);
}


function success($status, $message="ok", $data = [], $httpStatus = 200, $boole = true){
    $result = [
        'status' => $status,
        'msg'    => $message,
        'boole'  => $boole,
        'result' => $data,
        'time'   => date('Y-m-d H:i:s', time()),
    ];
    return json($result,$httpStatus);
}





