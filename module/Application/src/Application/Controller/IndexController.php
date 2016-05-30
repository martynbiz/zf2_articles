<?php
namespace Application\Controller;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $sm = $this->getServiceLocator();

        // find all articles by query
        $articles = $sm->get('Article\Model\Article')->find( array(
            //...
        ) );

        return $this->render('application/index/index', array(
            'articles' => $articles,
        ));
    }
}
