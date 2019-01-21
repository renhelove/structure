<?php
namespace Renhelove\Structure;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/15
 * Time: 10:36
 */
class Node
{
    private $key;
    private $value;
    private $parentKey;


    function __construct($key, $value, $parentKey = null) {
        $this->setKey($key);
        $this->setParentKey($parentKey);
        $this->setValue($value);
    }

    /**
     * @return Node[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Node[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
    /**
     * @var Node[]
     */
    private $children;

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getParentKey()
    {
        return $this->parentKey;
    }

    /**
     * @param mixed $parentKey
     */
    public function setParentKey($parentKey)
    {
        $this->parentKey = $parentKey;
    }

    /**
     * @return bool
     */
    function isRoot() {
        if ($this->getParentKey() === null) {
            return true;
        } else {
            return false;
        }
    }

}

class Tree
{

    /**
     * @var Node[]
     */
    public $originArr;

    /**
     * @var Node[]
     */
    public $levelArr;

    /**
     * @var Node
     */
    public $root;

    public $childrenStr = 'children';

    /**
     * @param $arr Node[]
     * @param $isLevel boolean
     * @return mixed
     */
    function __construct($arr, $isLevel = false)
    {
        $this->originArr = [];
        foreach ($arr as $node) {
            $this->originArr[$node->getKey()] = $node;
        }

        $this->setChildren();
        foreach ($this->originArr as $node) {
            if ($node->isRoot()) {
                $this->root = $node;
                break;
            }
        }
    }

    private function setChildren() {
        foreach ($this->originArr as $k => $node) {
            $this->originArr[$k]->setChildren($this->getChildrenByParent($node));
        }
    }

    /**
     * 根据origin 返回一个以层次level为key的数组
     * @return array
     */
    private function getLevelArr()
    {
        $levelArr = [];
        $level = 1;
        isset($levelArr[$level]) OR $levelArr[$level] = [];
        $this->originArr[$this->root->getKey()]->setLevel($level);
        $this->root->setLevel($level);
        $levelArr[$level][] = $this->root;

        do {
            $level++;
            $lastArr = $levelArr[$level - 1];
            $nowArr = $this->getChildrenByParentArr($lastArr);
            if (!empty($nowArr)) {
                isset($levelArr[$level]) OR $levelArr[$level] = [];
                foreach ($nowArr as $node) {
                    $this->originArr[$node->getKey()]->setLevel($level);
                }
                $levelArr[$level] = $nowArr;
            }
        } while ($nowArr);
        return $levelArr;
    }

    /**
     * 根据传入的结点 获取临近的所有子女
     * @param Node $parentNode
     * @return array
     */
    function getChildrenByParent(Node $parentNode)
    {
//        $key = $parentNode->getKey();
//        $children = [];
//        foreach ($this->originArr as $node) {
//            if ($node->getParentKey() == $key) {
//                $children[] = $node;
//            }
//        }
//        return $children;
        return $this->getChildrenByParentArr([$parentNode]);
    }

    /**
     * 根据传入的结点数组 获取他们临近的所有子女
     * @param  $parentNodeArr Node[]
     * @return array
     */
    function getChildrenByParentArr($parentNodeArr)
    {
        $keyArr = [];
        foreach ($parentNodeArr as $parentNode) {
            $keyArr[] = $parentNode->getKey();
        }
        $children = [];
        foreach ($this->originArr as $node) {
            if (in_array($node->getParentKey(), $keyArr)) {
                $children[] = $node;
            }
        }
        return $children;
    }

    function getTreeArr(Node $node) {
        $treeArr = $this->objToArr($this->getTreeObj($node));
        return $treeArr;
    }

    function getTreeObj(Node $node) {
        $treeObj = $this->originArr[$node->getKey()];
        return $treeObj;
    }

    function objToArr($obj) {
        is_array($obj) OR $obj = [$obj];
        $arr = [];
        foreach ($obj as $o) {
            $tmp = $o->getValue();
            $tmp[$this->childrenStr] = $this->objToArr($o->getChildren());
            $arr[] = $tmp;
        }
        return $arr;
    }
}

class TestNode extends Node
{
    function __construct($node) {
        parent::__construct($node['id'], $node, $node['parentid']);
    }

    function isRoot() {
        return $this->getParentKey() == -1;
    }


    function txt($length) {
        echo str_repeat('#', $length);
        echo sprintf("'id' => '%d', 'parentid' => %d, 'name' => '%s'",$this->getKey(),$this->getParentKey(),$this->getValue()['name']);
        echo "<br>";
    }
}

class TestTree extends Tree {
    /**
     * @param $node Node
     * @param $length
     */
    function showRecursion($node, $length = 0) {
        echo $node->txt($length);
        $length++;
        foreach ($node->getChildren() as $child) {
            $this->showRecursion($child, $length);
        }
    }

    function showIteration(Node $node) {
        $stack = new Stack();
        $stack->add($node);
        $length = 0;
        while(!$stack->isEmpty()) {
            $tmp = $stack->delete();
            $tmp->txt($length);
            $children = $tmp->getChildren();
            if (!empty($children)){
                foreach ($children as $child) {
                    $stack->add($child);
                }
            }
        }
    }


}

$arr = array(
    0 => array('id' => '0', 'parentid' => -1, 'name' => 'moren1'),
    1 => array('id' => '1', 'parentid' => 0, 'name' => '一级栏目二'),
    2 => array('id' => '2', 'parentid' => 1, 'name' => '二级栏目一'),
    3 => array('id' => '3', 'parentid' => 1, 'name' => '二级栏目二'),
    4 => array('id' => '4', 'parentid' => 2, 'name' => '二级栏目三'),
    5 => array('id' => '5', 'parentid' => 0, 'name' => '一级栏目一'),
    6 => array('id' => '6', 'parentid' => 3, 'name' => '三级栏目一'),
    7 => array('id' => '7', 'parentid' => 3, 'name' => '三级栏目二')
);
$newArr = [];
foreach ($arr as $a) {
    $node = new TestNode($a);
    $newArr[] = $node;
}
$tree = new TestTree($newArr, true);
$tmpTree = $tree->getTreeArr(new TestNode(array('id' => '0', 'parentid' => -1, 'name' => 'moren')));

//($tree->showRecursion($tree->root));
//($tree->showIteration($tree->root));

print_r(json_encode($tmpTree));
