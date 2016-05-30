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

        return new ViewModel(array(
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

        return new ViewModel(array(
            'article' => $article,
        ));
    }
}
