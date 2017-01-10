<?php

namespace mhndev\phpStd;

use Closure;
use mhndev\phpStd\Exceptions\InvalidArgumentException;
use mhndev\phpStd\Exceptions\RunTimeException;

/**
 * Class mixinTrait
 * @package mhndev\phpStd
 */
trait mixinTrait
{
    /**
     * @var array
     */
    private $methods = array();


    /**
     * @param $methodName
     * @param $methodCallable
     */
    public function addMethod($methodName, $methodCallable)
    {
        if (!is_callable($methodCallable)) {
            throw new InvalidArgumentException('Second param must be callable');
        }

        $this->methods[$methodName] = Closure::bind($methodCallable, $this, get_class());
    }

    /**
     * @param $methodName
     * @param array $args
     * @return mixed
     */
    public function __call($methodName, array $args)
    {
        if (isset($this->methods[$methodName])) {
            return call_user_func_array($this->methods[$methodName], $args);
        }

        throw new RunTimeException('There is no method with the given name to call');
    }

}
