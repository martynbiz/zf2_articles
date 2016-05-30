<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // bootstrap session
        $this->bootstrapSession($e);
    }

    public function bootstrapSession($e)
    {
        $session = $e->getApplication()
                     ->getServiceManager()
                     ->get('Zend\Session\SessionManager');
        $session->start();

        $container = new Container('initialized');
        // if (!isset($container->init)) {
        //     $serviceManager = $e->getApplication()->getServiceManager();
        //     $request        = $serviceManager->get('Request');
        //
        //     $session->regenerateId(true);
        //     $container->init          = 1;
        //     $container->remoteAddr    = $request->getServer()->get('REMOTE_ADDR');
        //     $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');
        //
        //     $config = $serviceManager->get('Config');
        //     if (!isset($config['session'])) {
        //         return;
        //     }
        //
        //     $sessionConfig = $config['session'];
        //     if (isset($sessionConfig['validators'])) {
        //         $chain   = $session->getValidatorChain();
        //
        //         foreach ($sessionConfig['validators'] as $validator) {
        //             switch ($validator) {
        //                 case 'Zend\Session\Validator\HttpUserAgent':
        //                     $validator = new $validator($container->httpUserAgent);
        //                     break;
        //                 case 'Zend\Session\Validator\RemoteAddr':
        //                     $validator  = new $validator($container->remoteAddr);
        //                     break;
        //                 default:
        //                     $validator = new $validator();
        //             }
        //
        //             $chain->attach('session.validate', array($validator, 'isValid'));
        //         }
        //     }
        // }
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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Session\SessionManager' => function ($sm) {
                    $config = $sm->get('config');
                    var_dump($config); exit;
                    $sessionConfig = new SessionConfig();
                    $sessionConfig->setOptions($config);
                    $sessionManager = new SessionManager($sessionConfig);
                    $sessionManager->start();
                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
            ),
        );
    }
}
