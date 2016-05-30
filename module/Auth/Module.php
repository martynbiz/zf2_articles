<?php
namespace Auth;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Auth\Model\User;
use Auth\Adapter\Mongo as Adapter;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
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
                'Auth\Model\User' =>  function($sm) {
                    return new User();
                },
                'Auth\Adapter' =>  function($sm) {
                    return new Adapter();
                },
                'AuthenticationService' => function($sm) {

                    $authService = new AuthenticationService();

                    // set the adapter
                    $adapter = $sm->get('Auth\Adapter');
                    $authService->setAdapter($adapter);

                    return $authService;
                },
                'Zend\Session\SessionManager' => function ($sm) {
                    $config = $sm->get('config');
                    $sessionConfig = new SessionConfig();
                    $sessionConfig->setOptions($config);
                    $sessionManager = new SessionManager($sessionConfig);
                    $sessionManager->start();
                    Container::setDefaultManager($sessionManager);
                    var_dump(get_class($sessionManager)); exit;
                    return $sessionManager;
                },
            ),
        );
    }
}
