<?php
namespace ArticleTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ArticleControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include realpath(APPLICATION_PATH . '/config/application.config.php')
        );
        parent::setUp();
    }

    public function test_index_route()
    {
        $articleTableMock = $this->getMockBuilder('Article\Model\ArticleTable')
                        ->disableOriginalConstructor()
                        ->getMock();

        $articleTableMock->expects($this->once())
                        ->method('fetchAll')
                        ->will($this->returnValue(array()));

        $sm = $this->getApplicationServiceLocator();
        $sm->setAllowOverride(true);
        $sm->setService('Article\Model\ArticleTable', $articleTableMock);

        // dispatch
        $this->dispatch('/article');

        // assertions
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Article');
        $this->assertControllerName('Article\Controller\Article');
        $this->assertControllerClass('ArticleController');
        $this->assertMatchedRouteName('article');
    }

    public function test_add_action_redirects_when_valid_post()
    {
        $articleTableMock = $this->getMockBuilder('Article\Model\ArticleTable')
                                ->disableOriginalConstructor()
                                ->getMock();

        $articleTableMock->expects($this->once())
                        ->method('saveArticle')
                        ->will($this->returnValue(null));

        $sm = $this->getApplicationServiceLocator();
        $sm->setAllowOverride(true);
        $sm->setService('Article\Model\ArticleTable', $articleTableMock);

        // dispatch
        $this->dispatch('/article/add', 'POST', array(
            'title'  => 'Led Zeppelin III',
            'id'     => '',
        ));

        // assertions
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/article');
    }
}
