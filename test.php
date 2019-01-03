<?php

$a = '66.10';
echo intval(round($a,2)*100);

echo '-';
echo intval(round($a*100,2));

exit;
header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Headers:x-requested-with,content-type');
sleep(1);
echo 'success';

