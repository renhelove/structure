<?php
namespace Renhelove\Structure\Hr;
require_once "../vendor/autoload.php";

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/21
 * Time: 15:01
 */
class Staff
{
    const dateClassArr = [
        'PracticeDate',
        'TryDate'
    ];
    /**
     * @var DateAbs[]
     */
    private $dateArr = [];

    private $key;
    private $arr;

    private $startStatus;
    private $endStatus;

    private $changeRecord = [];

    /**
     * @return mixed
     */
    public function getStartStatus()
    {
        return $this->startStatus;
    }

    /**
     * @param mixed $startStatus
     */
    public function setStartStatus($startStatus)
    {
        $this->startStatus = $startStatus;
    }

    /**
     * @return mixed
     */
    public function getEndStatus()
    {
        return $this->endStatus;
    }

    /**
     * @param mixed $endStatus
     */
    public function setEndStatus($endStatus)
    {
        $this->endStatus = $endStatus;
    }

    public function addChangeRecord($changeRecord) {
        $this->changeRecord[] = $changeRecord;
    }

    public function __construct($arr)
    {
        $this->arr = $arr;
        $this->key = $arr['accountId'];

        foreach (self::dateClassArr as $className) {
            $this->newObjDate($className);
        }

        $this->sortDateArr();
    }

    private function newObjDate($className) {
        $paramName = lcfirst($className);
        $className  = 'Renhelove\Structure\Hr\\' . $className;
        $date = $this->arr[$paramName];
        if (isset($date) && $date !== '0000-00-00') {
            $this->dateArr[] = new $className($this->arr[$paramName]);
        }
    }

    function sortDateArr() {
        usort($this->dateArr,
            function (DateAbs $date1, DateAbs $date2) {
                $dateTmp1 = $date1->getDate();
                $dateTmp2 = $date2->getDate();
                if ($date1->getDate() == $date2->getDate()) {
                    $priority1 = $date1->getPriority();
                    $priority2 = $date2->getPriority();
                    return ($priority1 >= $priority2) ? +1 : -1;
                }
                return ($dateTmp1 > $dateTmp2) ? +1 : -1;
            });
    }


    function getStatus($startDate, $endDate) {
        foreach ($this->dateArr as $date) {
            $dateTmp = $date->getDate();
            if ($dateTmp <= $startDate) {
                $date->changeStartStatus($this);
            }else if ($dateTmp<=$endDate) {
                $date->changeEndStatus($this);
            }
        }
    }
}
