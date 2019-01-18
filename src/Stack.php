<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 17:40
 */
namespace Renhelove\Structure;
class Stack {
    public $top;
    public $stack;
    public $maxSize;

    function __construct($max = 9999) {
        $this->stack = [];
        $this->maxSize = $max;
        $this->top = -1;
    }

    function add($item) {
        if (!$this->isFull()) {
            $this->top++;
            $this->stack[$this->top] = $item;
            return true;
        } else {
            return false;
        }
    }
    function delete() {
        if (!$this->isEmpty()) {
            $result = $this->stack[$this->top];
            unset($this->stack[$this->top]);
            $this->top--;
            return $result;
        }else {
            return false;
        }
    }

    function isFull() {
        return $this->top == $this->maxSize-1;
    }

    function isEmpty() {
        return $this->top == -1;
    }

    function getData() {
        if (!$this->isEmpty()){
            return $this->stack[$this->top];
        } else {
            return false;
        }
    }
}