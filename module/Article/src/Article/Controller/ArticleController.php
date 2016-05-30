<?php

namespace Article\Controller;

use Zend\Mvc\Controller\AbstractActionController;
// use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Article\Form\ArticleForm;
use Article\Model\Article;

class ArticleController extends AbstractActionController
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

    public function addAction()
    {
        $form = new ArticleForm();

        if ($this->getRequest()->isPost()) {

            $sm = $this->getServiceLocator();

            $form->setInputFilter( $sm->get('Article\Model\Article')->getInputFilter() );
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                $article = $sm->get('Article\Model\Article')->save( $form->getData() );

                // $article->exchangeArray($form->getData());
                // $this->getArticleTable()->saveArticle($article);

                // Redirect to index page
                return $this->redirect()->toUrl('/article');
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'errors' => $form->getInputFilter()->getMessages(),
        ));
    }

    public function editAction()
    {
        // $id = $this->params()->fromRoute('id', 0);
        // $article = $this->getArticleTable()->getArticle($id);

        $sm = $this->getServiceLocator();
        $id = (int) $this->params()->fromRoute('id', 0);

        // find the article by "id"
        $article = $sm->get('Article\Model\Article')->findOne(array(
            'id' => $id,
        ));

        // initiate the form with the values from article
        $form = new ArticleForm();
        $form->setData( $article->toArray() );

        if ($this->getRequest()->isPost()) {
            $form->setInputFilter( $sm->get('Article\Model\Article')->getInputFilter() );
            $form->setData( $this->getRequest()->getPost() );

            if ($form->isValid()) {
                // $article->exchangeArray($form->getData());
                // $this->getArticleTable()->saveArticle($article);

                $article = $article->save( $form->getData() );

                // Redirect to article page
                return $this->redirect()->toUrl('/article/' . $id);
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $article = $this->getServiceLocator()->get('Article\Model\Article')->findOne(array(
            'id' => $id,
        ));

        if ($this->getRequest()->isPost()) {
            $article->delete();

            // Redirect to list of articles
            return $this->redirect()->toUrl('/article/' . $id);
        }

        return new ViewModel(array(
            'article' => $article,
        ));
    }

    // public function getArticleTable()
    // {
    //     if (!$this->articleTable) {
    //         $sm = $this->getServiceLocator();
    //         $this->articleTable = $sm->get('Article\Model\ArticleTable');
    //     }
    //     return $this->articleTable;
    // }
}
