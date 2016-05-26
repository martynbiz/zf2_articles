<?php
namespace Article;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Article\Model\Article;
use Article\Model\ArticleTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            // 'Zend\Loader\ClassMapAutoloader' => array(
            //      __DIR__ . '/autoload_classmap.php',
            //  ),
            //  'Zend\Loader\StandardAutoloader' => array(
            //      'namespaces' => array(
            //          __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
            //      ),
            //  ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Article\Model\ArticleTable' =>  function($sm) {
                    $tableGateway = $sm->get('ArticleTableGateway');
                    $table = new ArticleTable($tableGateway);
                    return $table;
                },
                'ArticleTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Article());
                    return new TableGateway('article', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
