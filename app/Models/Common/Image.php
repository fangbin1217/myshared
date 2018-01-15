<?php
namespace App\Models\Common;


class Image {

    /**
     * 根据城市获取限行规则
     * @param $city string 城市名
     * @return array
     */
    static public function randImage() {
        $x = rand(0,2);
        $images = ['cd-icon-movie.svg', 'cd-icon-picture.svg', 'cd-icon-location.svg'];
        if (isset($images[$x])) {
            return $images[$x];
        }
        return $images[1];
    }
}