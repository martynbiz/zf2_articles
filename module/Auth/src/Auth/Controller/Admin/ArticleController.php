<?php
namespace Auth\Controller\Admin;

use Auth\Controller\BaseController;
use Auth\Form\AuthForm;
use Auth\Model\Auth;

class AuthController extends BaseController
{
    public function indexAction()
    {
        $sm = $this->getServiceLocator();

        // find all users by query
        $users = $sm->get('Auth\Model\Auth')->find( array(
            //...
        ) );

        return $this->render('auth/user/admin/index', array(
            'user' => $user,
        ));
    }

    public function getAction()
    {
        $sm = $this->getServiceLocator();
        $id = (int) $this->params()->fromRoute('id', 0);

        // find the user by "id"
        $user = $sm->get('Auth\Model\Auth')->findOne(array(
            'id' => $id,
        ));

        return $this->render('auth/user/admin/get', array(
            'user' => $user,
        ));
    }

    public function addAction()
    {
        $form = new AuthForm();

        if ($this->getRequest()->isPost()) {

            $sm = $this->getServiceLocator();

            $form->setInputFilter( $sm->get('Auth\Model\Auth')->getInputFilter() );
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                $user = $sm->get('Auth\Model\Auth')->save( $form->getData() );

                // Redirect to index page
                return $this->redirect()->toUrl('/admin/user');
            }
        }

        return $this->render('auth/user/admin/add', array(
            'form' => $form,
        ));
    }

    public function editAction()
    {
        $sm = $this->getServiceLocator();
        $id = (int) $this->params()->fromRoute('id', 0);

        // find the user by "id"
        $user = $sm->get('Auth\Model\Auth')->findOne(array(
            'id' => $id,
        ));

        // initiate the form with the values from user
        $form = new AuthForm();
        $form->setData( $user->toArray() );

        if ($this->getRequest()->isPost()) {
            $form->setInputFilter( $sm->get('Auth\Model\Auth')->getInputFilter() );
            $form->setData( $this->getRequest()->getPost() );

            if ($form->isValid()) {
                $user = $user->save( $form->getData() );

                // Redirect to user page
                return $this->redirect()->toUrl('/admin/user/' . $id);
            }
        }

        return $this->render('auth/user/admin/edit', array(
            'form' => $form,
        ));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getServiceLocator()->get('Auth\Model\Auth')->findOne(array(
            'id' => $id,
        ));

        if ($this->getRequest()->isPost()) {
            $user->delete();

            // Redirect to list of users
            return $this->redirect()->toUrl('/user/' . $id);
        }

        return $this->render('auth/user/admin/delete', array(
            'user' => $user,
        ));
    }
}
