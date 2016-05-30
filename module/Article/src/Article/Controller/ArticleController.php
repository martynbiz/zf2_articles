<?php
namespace Article\Controller;

class ArticleController extends BaseController
{
    // protected $articleTable;

    public function indexAction()
    {
        $sm = $this->getServiceLocator();

        // find all articles by query
        $articles = $sm->get('Article\Model\Article')->find( array(
            //...
        ) );

        return $this->render('article/article/index', array(
            'articles' => $articles,
        ));
    }

    public function getAction()
    {
        $sm = $this->getServiceLocator();
        $id = (int) $this->params()->fromRoute('id', 0);

        // find the article by "id"
        $article = $sm->get('Article\Model\Article')->findOne(array(
            'id' => $id,
        ));

        return $this->render('article/article/get', array(
            'article' => $article,
        ));
    }
}
