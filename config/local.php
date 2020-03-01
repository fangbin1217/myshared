<?php
/**
 * Created by PhpStorm.
 * User: binfang
 * Date: 17/12/8
 * Time: 下午1:59
 */

$localConfig = [
    'title' => '抽奖小程序--微信小程序、QQ小程序引流神器，助力推广营销！', //首页相关配置
    'keywords' => '微信引流、微信游戏、微信抽奖、微信营销软件、QQ活动推广、QQ引流、QQ抽奖、QQ营销软件、QQ活动推广',
    'description' => '一个免费的微信、QQ引流神器，低成本的营销推广，高回报的增加粉丝。',
];

$localConfig['nav'] = [
    'resume' => '关于我 > 个人简介',
    'baby' => '关于我 > 宝宝成长',
    'travel' => '旅游分享 > 浪迹天涯',
    'articleBabyStory' => '文章分类 > 宝宝故事',
    'articleStudy' => '文章分类 > 学习心得',
    'admin' => '后台管理 > 首页',
    'adminAddBaby' => '后台管理 > 添加宝宝',
    'adminTip' => '后台管理 > 提示页',
    'adminMyTravel' => '后台管理 > 我的旅行',
    'login' => '用户管理 > 登录',
    'register' => '用户管理 > 注册',
];

$localConfig['image_type'] = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
];

$localConfig['travel_tag'] = [
    1 => '1A级',
    2 => '2A级',
    3 => '3A级',
    4 => '4A级',
    5 => '5A级',
];

$localConfig['menu'] = [
    ['id'=>1, 'name'=>'QQ小程序'],['id'=>2, 'name'=>'微信小程序'],['id'=>3, 'name'=>'支付宝小程序'],['id'=>4, 'name'=>'抖音小程序'],
    ['id'=>5, 'name'=>'头条小程序'],['id'=>6, 'name'=>'百度小程序']
];

if (ENVIRONMENT == 'development') {
    $localConfig['website'] = 'http://www.myshared.fb/';
    $localConfig['imgHost'] = 'http://image.fyy6.com/';

} else {
    $localConfig['website'] = 'http://www.fyy6.com/';
    $localConfig['imgHost'] = 'http://image.fyy6.com/';
}
 return $localConfig;