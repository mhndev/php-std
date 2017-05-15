<?php
namespace mhndev\phpStd;

use JsonSerializable;
use mhndev\phpStd\Exceptions\CollectionInvalidKeyException;
use mhndev\phpStd\Exceptions\CollectionInvalidValueException;
use Traversable;

/**
 * Class Collection
 * @package mhndev\phpStd
 */
class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{

    /**
     * @var array
     */
    protected $items;

    /**
     * Collection constructor.
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $this->getArrayableItems($items);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }


    /**
     * @return mixed
     */
    public function first()
    {
        return $this->nth(0);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return $this->nth($this->count() - 1);
    }


    /**
     * @param $n
     * @return array
     */
    public function nth($n)
    {
        return array_slice($this->items, $n, 1)[0];
    }


    /**
     * @return mixed
     */
    public function second()
    {
        return $this->nth(1);
    }

    /**
     * @return mixed
     */
    public function third()
    {
        return $this->nth(2);
    }

    /**
     * @param $object
     * @param null $key
     * @return $this
     */
    function add($object, $key = null)
    {
        if($key == null){
            $this->items[] = $object;
        }else{
            $this->items[$key] = $object;
        }

        return $this;
    }

    /**
     * @param string $key
     * @throws CollectionInvalidKeyException
     */
    function del($key)
    {
        if (!isset($this->items[$key])) {
            throw new CollectionInvalidKeyException(sprintf(
                "Invalid key : %s .", $key
            ));
        }

        array_splice($this->items, $key, 1);

    }


    /**
     * @param $object
     * @throws CollectionInvalidValueException
     */
    function delByValue($object)
    {
        if(($key = array_search($object, $this->items, true)) !== FALSE) {
            $this->del($key);
        }
        else{
            throw new CollectionInvalidValueException();
        }
    }

    /**
     * @param string $key
     * @return mixed
     * @throws CollectionInvalidKeyException
     */
    function get($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
        else{
            throw new CollectionInvalidKeyException(sprintf(
                "Invalid key %s$.", $key
            ));
        }
    }


    /**
     * @param array| \ArrayAccess $items
     * @return static
     */
    function merge($items)
    {
        $arrayable = $this->getArrayableItems($items);

        return new static(array_merge($this->items, $arrayable));
    }


    /**
     * Results array of items from Collection or Arrayable.
     *
     * @param  mixed  $items
     * @return array
     */
    protected function getArrayableItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        }  elseif ($items instanceof JsonSerializable) {
            return $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
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
        return new \ArrayIterator($this->items);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }


    /**
     * @return array
     * @throws \Exception
     */
    public function toArray()
    {
        $ar = [];

        foreach ($this->items as $item){

            if(! method_exists($item, 'toArray')){
                throw new \Exception('item class has not method toArray');
            }
            else{
                $ar[] = $item->toArray();
            }

        }

        return $ar;
    }

    public function preview()
    {
        $ar = [];

        foreach ($this->items as $item){

            if(! method_exists($item, 'preview')){
                throw new \Exception('item class has not method preview');
            }
            else{
                $ar[] = $item->preview();
            }

        }

        return $ar;
    }

}
