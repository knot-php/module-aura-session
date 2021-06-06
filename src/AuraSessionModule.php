<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace knotphp\module\aurasession;

use Throwable;

use knotlib\kernel\module\ModuleInterface;
use knotlib\kernel\kernel\ApplicationInterface;
use knotlib\kernel\exception\ModuleInstallationException;
use knotlib\kernel\eventstream\Channels;
use knotlib\kernel\eventstream\Events;
use knotlib\kernel\module\ComponentTypes;
use knotphp\module\aurasession\adapter\AuraSessionAdapter;
use knotphp\module\aurasession\adapter\ExtendedSessionFactory;

class AuraSessionModule implements ModuleInterface
{
    /**
     * Declare dependency on another modules
     *
     * @return array
     */
    public static function requiredModules() : array
    {
        return [];
    }

    /**
     * Declare dependent on components
     *
     * @return array
     */
    public static function requiredComponentTypes() : array
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