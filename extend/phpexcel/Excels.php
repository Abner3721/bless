<?php
namespace  phpexcel;

use think\Loader;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2020/4/14
 * Time: 17:58
 */
class Excels{
    /**
     *
     * execl数据导出
     */
   public function exportOrderExcel2($title, $cellName, $data) {
        //引入核心文件
        Loader::import('phpexcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        //定义配置
        $topNumber = 2;//表头有几行占用
        $xlsTitle = iconv('utf-8', 'gb2312', $title);//文件名称
        $fileName = $title.date('_YmdHis');//文件名称
        $cellKey = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM',
            'AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );

        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);//所有单元格（列）默认宽度

        //垂直居中
       $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //处理表头标题
        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$cellKey[count($cellName)-1].'1');//合并单元格（如果要拆分单元格是需要先合并再拆分的，否则程序会报错）
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$title);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //处理表头
        foreach ($cellName as $k=>$v)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellKey[$k].$topNumber, $v);//设置表头数据
//            $objPHPExcel->getActiveSheet()->freezePane($cellKey[$k].($topNumber+1));//冻结窗口
//            $objPHPExcel->getActiveSheet()->getStyle($cellKey[$k].$topNumber)->getFont()->setBold(true);//设置是否加粗
//            $objPHPExcel->getActiveSheet()->getStyle($cellKey[$k].$topNumber)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
//            if($v[3] > 0)//大于0表示需要设置宽度
//            {
//                $objPHPExcel->getActiveSheet()->getColumnDimension($cellKey[$k])->setWidth($v[3]);//设置列宽度
//            }
        }

        //处理数据
        $start = $topNumber+1;
        $j = $topNumber+1;
        foreach ($data as $k=>$v)
        {
//            $j = $start;
            foreach ($v['sku'] as $k1=>$v1)
            {
                if($k1==0){
                    //计算初步当前单元格标识，以及 需要合并的单元格标识 A B C D E F G M
                    $end = $start+count($v['sku'])-1;
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$start.':'."A".$end);
                    $objPHPExcel->getActiveSheet()->mergeCells("B".$start.':'."B".$end);
                    $objPHPExcel->getActiveSheet()->mergeCells("C".$start.':'."C".$end);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$start.':'."D".$end);

                    $objPHPExcel->getActiveSheet()->setCellValue("A".$start, $v['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("B".$start, $v['phone']);
                    $objPHPExcel->getActiveSheet()->setCellValue("C".$start, $v['comony']);
                    $objPHPExcel->getActiveSheet()->setCellValue("D".$start, $v['email']);
                }
                $j++;
            }

            $start += count($v['sku']);
        }

        //导出execl
        ob_end_clean();//防止乱码
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}