<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\ModuleEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function init($moduleManager)
    {
        $moduleManager->getEventManager()
            ->attach(ModuleEvent::EVENT_MERGE_CONFIG, [$this, 'onMergeConfig'], -10000);
    }

    public function onMergeConfig(ModuleEvent $e)
    {
        $configListener = $e->getConfigListener();
        $config         = $configListener->getMergedConfig(false);

        $locale = \Locale::getDefault();

        if (isset($config[$locale])) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, $config[$locale]);
        }

        if (isset($config[APPLICATION_ENV])) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, $config[APPLICATION_ENV]);
        }

        if (isset($config[APPLICATION_ENV][$locale])) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, $config[APPLICATION_ENV][$locale]);
        }

        $configListener->setMergedConfig($config);
    }
}
