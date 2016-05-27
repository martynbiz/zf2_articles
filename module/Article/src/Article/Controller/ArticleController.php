<?php

namespace Article\Controller;

use Zend\Mvc\Controller\AbstractActionController;
// use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Article\Form\ArticleForm;
use Article\Model\Article;

class ArticleController extends AbstractActionController
{
    protected $articleTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'articles' => $this->getArticleTable()->fetchAll(),
        ));
    }

    public function getAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        return new ViewModel(array(
            'article' => $this->getArticleTable()->getArticle($id),
        ));
    }

    public function addAction()
    {
        $form = new ArticleForm();

        if ($this->getRequest()->isPost()) {
            $article = new Article();
            $form->setInputFilter($article->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $article->exchangeArray($form->getData());
                $this->getArticleTable()->saveArticle($article);

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
        $id = $this->params()->fromRoute('id', 0);
        $article = $this->getArticleTable()->getArticle($id);

        // initiate the form with the values from article
        $form = new ArticleForm();
        $form->setData($article->toArray());

        if ($this->getRequest()->isPost()) {
            $form->setInputFilter($article->getInputFilter());
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $article->exchangeArray($form->getData());
                $this->getArticleTable()->saveArticle($article);

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
        $id = $this->params()->fromRoute('id', 0);
        $article = $this->getArticleTable()->getArticle($id);

        $form = new ArticleForm();
        $form->setData($article->toArray());

        if ($this->getRequest()->isPost()) {
            $this->getArticleTable()->deleteArticle($article);

            // Redirect to list of articles
            return $this->redirect()->toUrl('/article/' . $id);
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function getArticleTable()
    {
        if (!$this->articleTable) {
            $sm = $this->getServiceLocator();
            $this->articleTable = $sm->get('Article\Model\ArticleTable');
        }
        return $this->articleTable;
    }
}
