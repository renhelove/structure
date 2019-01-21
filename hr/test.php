<?php
namespace Renhelove\Structure\Hr;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 16:11
 */
require_once "../vendor/autoload.php";
$arr = [
    'accountId' => 23,
    'practiceDate' => "2019-01-02",
    'tryDate' => "2019-01-03",
];

$staff = new Staff($arr);
$staff->getStatus("2019-01-01", "2019-01-03");
var_dump($staff);