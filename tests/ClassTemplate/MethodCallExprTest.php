<?php
use ClassTemplate\Raw;

class MethodCallExprTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $call = new ClassTemplate\MethodCallExpr;
        $call->method('doSomething');
        $call->addArgument(123);
        $call->addArgument('foo');
        $call->addArgument(new Raw('new SplObjectStorage'));
        $call->addArgument(array( 'name' => 'hack' ));
        $str = $call->render();
        ok($str);
        is("\$this->doSomething(123, 'foo', new SplObjectStorage, array (\n  'name' => 'hack',\n))",$str);
    }
}
