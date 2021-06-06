<?php
declare(strict_types=1);

namespace knotphp\module\aurasession\adapter;

use Aura\Session\Segment;

class ExtendedSegment extends Segment
{
    /**
     * @param string $key
     */
    public function unset(string $key)
    {
        $this->resumeOrStartSession();
        unset($_SESSION[$this->name][$key]);
    }
    
    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key) : bool
    {
        $this->resumeOrStartSession();
        return isset($_SESSION[$this->name][$key]);
    }
}