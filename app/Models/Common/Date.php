<?php
namespace App\Models\Common;


class Date {

    static public function getDateToString($date) {
        $compDate = strtotime($date);
        $nowDate = time();
        $cha = $nowDate - $compDate;
        //秒
        if ($cha < 60) {
            return $cha.'秒前';
            //分
        } else if ($cha >= 60 && $cha < 3600) {
            return intval($cha/60).'分钟前';
            //时
        } else if ($cha >= 3600 && $cha < 86400) {
            return intval($cha/3600).'小时前';
            //天
        } else if ($cha >= 86400 && $cha < 86400*30) {
            return intval($cha/86400).'天前';
            //月
        }  else if ($cha >= 86400*30 && $cha < 86400*30*365) {
            return intval($cha/(86400*30)).'个月前';
            //年
        }  else if ($cha >= 86400*30*365) {
            return intval($cha/(86400*30*365)).'年前';
        }
    }

    static public function getTip() {
        $tip = '晚上好';
        if (in_array(date('H'), ['06','07','08','09','10','11','12'])) {
            $tip = '上午好';
        } else if (in_array(date('H'), ['13','14','15','16','17','18'])) {
            $tip = '下午好';
        }
        return $tip;
    }
}