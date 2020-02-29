<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace KnotPhp\Module\AuraSession;

use Throwable;

use KnotLib\Kernel\Module\AbstractModule;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;
use KnotLib\Kernel\Module\ComponentTypes;
use KnotPhp\Module\AuraSession\Adapter\AuraSessionAdapter;
use KnotPhp\Module\AuraSession\Adapter\ExtendedSessionFactory;

class AuraSessionModule extends AbstractModule
{
    /**
     * Declare dependent on components
     *
     * @return array
     */
    public static function requiredComponents() : array
    {
        return [
            ComponentTypes::EVENTSTREAM,
        ];
    }

    /**
     * Declare component type of this module
     *
     * @return string
     */
    public static function declareComponentType() : string
    {
        return ComponentTypes::SESSION;
    }

    /**
     * Install module
     *
     * @param ApplicationInterface $app
     *
     * @throws ModuleInstallationException
     */
    public function install(ApplicationInterface $app)
    {
        try{
            $session = (new ExtendedSessionFactory())->newInstance($_COOKIE);
            $session = new AuraSessionAdapter($session);
            $app->session($session);

            // fire event
            $app->eventstream()->channel(Channels::SYSTEM)->push(Events::SESSION_ATTACHED, $session);
        }
        catch(Throwable $e){
            throw new ModuleInstallationException(self::class, $e->getMessage(), 0, $e);
        }
    }
}