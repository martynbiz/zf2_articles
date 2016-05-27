<?php

namespace Article\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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
                return $this->redirect()->toRoute('article');
            }
        }
        return array('form' => $form);

    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
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
