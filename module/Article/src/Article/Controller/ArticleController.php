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
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $article = new Article();
            $form->setInputFilter($article->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $article->exchangeArray($form->getData());
                $this->getArticleTable()->saveArticle($article);

                // Redirect to list of articles
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

        $form = new ArticleForm();
        $form->get('submit')->setValue('Update');
        $form->setData($article->toArray());

        $request = $this->getRequest();
        if ($request->isPut()) {
            $form->setInputFilter($article->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $article->exchangeArray($form->getData());
                $this->getArticleTable()->saveArticle($article);

                // Redirect to list of articles
                return $this->redirect()->toUrl('article/' . $id);
            }
        }

        return new ViewModel(array(
            'article' => $this->getArticleTable()->getArticle($id),
            'form' => $form,
        ));
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        return new ViewModel(array(
            'article' => $this->getArticleTable()->getArticle($id),
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
