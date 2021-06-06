<?php
declare(strict_types=1);

namespace knotphp\module\aurasession\adapter;

use knotlib\kernel\session\SessionBucketInterface;

class AuraSessionBucketAdapter implements SessionBucketInterface
{
    /** @var ExtendedSegment  */
    private $segment;
    
    /**
     * AuraSessionBucketAdapter constructor.
     *
     * @param ExtendedSegment $segment
     */
    public function __construct(ExtendedSegment $segment)
    {
        $this->segment = $segment;
    }
    
    /**
     * Returns element of session object
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key) : bool
    {
        return $this->segment->has($key);
    }
    
    /**
     * Returns element of session object
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->segment->get($key, $default);
    }
    
    /**
     * Set element of session object
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function set(string $key, $value)
    {
        $this->segment->set($key, $value);
    }
    
    /**
     * Clear element of session object
     *
     * @param string $key
     *
     * @return void
     */
    public function unset(string $key)
    {
        $this->segment->set($key, null);
    }
    
    /**
     *
     * Clear all data from the segment.
     *
     * @return void
     *
     */
    public function clear()
    {
        $this->segment->clear();
    }
    
    /**
     *  ArrayAccess interface : offsetGet() implementation
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->segment->get($key);
    }
    
    /**
     *  ArrayAccess interface : offsetSet() implementation
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->segment->set($key, $value);
    }
    
    /**
     *  ArrayAccess interface : offsetExists() implementation
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->segment->has($key);
    }
    
    /**
     *  ArrayAccess interface : offsetUnset() implementation
     *
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        $this->segment->unset($key);
    }
}