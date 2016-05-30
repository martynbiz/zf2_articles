<?php
namespace Article\Controller\Admin;

use Article\Controller\BaseController;
use Article\Form\ArticleForm;
use Article\Model\Article;

class ArticleController extends BaseController
{
    public function indexAction()
    {
        $sm = $this->getServiceLocator();

        // find all articles by query
        $articles = $sm->get('Article\Model\Article')->find( array(
            //...
        ) );

        return $this->render('article/article/admin/index', array(
            'article' => $article,
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

        return $this->render('article/article/admin/get', array(
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

                // Redirect to index page
                return $this->redirect()->toUrl('/admin/article');
            }
        }

        return $this->render('article/article/admin/add', array(
            'form' => $form,
        ));
    }

    public function editAction()
    {
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
                $article = $article->save( $form->getData() );

                // Redirect to article page
                return $this->redirect()->toUrl('/admin/article/' . $id);
            }
        }

        return $this->render('article/article/admin/edit', array(
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

        return $this->render('article/article/admin/delete', array(
            'article' => $article,
        ));
    }
}
