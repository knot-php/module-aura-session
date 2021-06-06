<?php
declare(strict_types=1);

namespace knotphp\module\aurasession\adapter;

use Aura\Session\SegmentFactory;
use Aura\Session\Session;

class ExtendedSegmentFactory extends SegmentFactory
{
    public function newInstance(Session $session, $name)
    {
        return new ExtendedSegment($session, $name);
    }
}