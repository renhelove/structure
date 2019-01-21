<?php
namespace Renhelove\Structure\Hr;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 14:58
 */
Interface DateInterface
{
    public function changeStartStatus(Staff $staff);

    public function changeEndStatus(Staff $staff);
}