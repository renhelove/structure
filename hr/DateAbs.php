<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 15:02
 */

namespace Renhelove\Structure\Hr;


abstract class DateAbs implements DateInterface
{
    private $date;
    
    //优先级，优先数字小的吧
    private $priority;
    
    private $type;
    
    function __construct($date)
    {
        if ($date == "0000-00-00") {
            $date = null;
        }
        $this->date = $date;
    }
    
    function getDate() {
        return $this->date;
    }

    function getPriority() {
        return $this->priority;
    }

    abstract function changeStartStatus(Staff $staff);
    
    abstract function changeEndStatus(Staff $staff);
}