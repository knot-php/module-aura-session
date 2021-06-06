<?php
declare(strict_types=1);

namespace knotphp\module\aurasession\adapter;

use Aura\Session\SessionFactory;
use Aura\Session\Phpfunc;
use Aura\Session\Session;
use Aura\Session\CsrfTokenFactory;
use Aura\Session\Randval;

class ExtendedSessionFactory extends SessionFactory
{
    public function newInstance(array $cookies, $delete_cookie = null)
    {
        $phpfunc = new Phpfunc;
        return new Session(
            new ExtendedSegmentFactory,
            new CsrfTokenFactory(new Randval($phpfunc)),
            $phpfunc,
            $cookies,
            $delete_cookie
        );
    }
}