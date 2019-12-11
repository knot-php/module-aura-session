<?php
declare(strict_types=1);

namespace KnotPhp\Module\AuraSession\Adapter;

use Aura\Session\Session;

use KnotLib\Kernel\Session\SessionInterface;
use KnotLib\Kernel\Session\SessionBucketInterface;

class AuraSessionAdapter implements SessionInterface
{
    /** @var Session */
    private $session;
    
    /**
     * AuraSessionAdapter constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    
    /**
     * Clear all session variables
     *
     * @return void
     */
    public function clear()
    {
        $this->session->clear();
    }
    
    /**
     * Writes all session data and finishes session
     *
     * @return void
     */
    public function commit()
    {
        $this->session->commit();
    }
    
    /**
     * Destroy session entirely
     *
     * @return bool
     */
    public function destroy() : bool
    {
        return $this->session->destroy();
    }
    
    /**
     * Returnes session bucket object
     *
     * @param string $name
     *
     * @return SessionBucketInterface
     */
    public function getBucket(string $name) : SessionBucketInterface
    {
        /** @var ExtendedSegment $segment */
        $segment = $this->session->getSegment($name);
        if (!$segment) {
            return null;
        }
        return new AuraSessionBucketAdapter($segment);
    }
}