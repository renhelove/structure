<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 15:41
 */

namespace Renhelove\Structure\Hr;

//试用开始日期
class TryDate extends DateAbs
{
    private $priority = 2;

    private $type = 2;

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