<?php
declare(strict_types=1);

namespace KnotPhp\Module\AuraSession\Adapter;

use Aura\Session\SegmentFactory;
use Aura\Session\Session;

class ExtendedSegmentFactory extends SegmentFactory
{
    public function newInstance(Session $session, $name)
    {
        return new ExtendedSegment($session, $name);
    }
}