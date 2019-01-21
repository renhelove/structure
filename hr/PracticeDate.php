<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 15:41
 */

namespace Renhelove\Structure\Hr;
require_once "../vendor/autoload.php";

//实习开始日期
class PracticeDate extends DateAbs
{
    private $priority = 1;

    private $type = 1;

    function changeStartStatus(Staff $staff)
    {
        $staff->setStartStatus($this->type);
    }

    function changeEndStatus(Staff $staff)
    {
        $lastStatus = $staff->getEndStatus() ? $staff->getEndStatus() : $staff->getStartStatus();
        
        $staff->addChangeRecord([
            'lastStatus' => $lastStatus,
            'nowStatus' => $this->type,
            'date' => $this->getDate(),
        ]);
        $staff->setEndStatus($this->type);
    }

}