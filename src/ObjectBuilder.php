<?php
namespace mhndev\phpStd;

use Traversable;

/**
 * Class EntityBuilderTrait
 * @package mhndev\order\traits
 */
trait ObjectBuilder
{

    /**
     * @param $name
     * @param $value
     */
    function __set($name, $value)
    {
        $this->$name = $value;
    }


    /**
     * @param $name
     */
    function __unset($name)
    {
        unset($this->$name);
    }

    /**
     * @param array $array
     */
    function __unsetArray(array $array)
    {
        foreach ($array as $property){
            if (Str::contains($property, '.')){
                $array = explode('.', $property);
                if (array_key_exists($array[1], $this->{$array[0]}) && !empty($this->{$array[0]}[$array[1]])){
                    unset($this->{$array[0]}[$array[1]]);
                }
            }
            unset($this->$property);
        }
    }

    /**
     * @param array $options
     * @return static
     */
    static function fromOptions(array $options)
    {
        $instance = new static();

        foreach ($options as $key => $value){

            if(method_exists($instance, $method = 'set'.ucfirst($key) )){
                $instance->{$method}($value);
            }else{
                $instance->$key = $value;
            }
        }

        return $instance;
    }

    /**
     * @param array $options
     * @return $this
     */
    function buildByOptions(array $options)
    {
        foreach ($options as $key => $value){
            $this->$key = $value;
        }

        return $this;
    }


    /**
     * @return array
     */
    function toArray()
    {
        return get_object_vars($this);
    }


    /**
     * @param $array
     * @return array
     */
    private function cleanArray($array)
    {
        $result = [];

        foreach ($array as $key => $value){
            $newKey = $key;

            if(strpos($key, '*') > 0){
                $newKey = substr($key, 3, strlen($key));

            }

            if(is_array($value)){
                $result[$newKey] = $this->cleanArray($value);
            }else{
                $result[$newKey] = $value;
            }

        }
        return $result;
    }


    /**
     * @param $obj
     * @return array
     */
    private function object_to_array($obj)
    {
        if(is_object($obj)) {
            $obj = (array) $obj;
        }

        if(is_array($obj)) {
            $new = array();
            foreach($obj as $key => $val) {
                $new[$key] = $this->object_to_array($val);
            }
        }

        else $new = $obj;

        return $new;
    }


    /**
     * @param $object
     * @return array
     */
    function objectToArray($object)
    {
        return $this->cleanArray($this->object_to_array($object));
    }



    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        $result = $this->objectToArray($this);

        return new \ArrayIterator($result);
    }


    /**
     * @param $className
     * @return mixed
     */
    public function castTo($className)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($className),
            $className,
            strstr(strstr(serialize($this), '"'), ':')
        ));
    }

}
