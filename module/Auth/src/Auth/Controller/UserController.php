<?php
namespace Auth\Controller;

use Auth\Form\RegisterForm;
use Auth\Form\ResetPasswordForm;
use Auth\Model\User;

class UserController extends BaseController
{
    public function registerAction()
    {
        $form = new RegisterForm();

        if ($this->getRequest()->isPost()) {

            $sm = $this->getServiceLocator();

            $form->setInputFilter( $sm->get('Auth\Model\User')->getInputFilter() );
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                $article = $sm->get('Auth\Model\User')->save( $form->getData() );

                // Redirect to index page
                return $this->redirect()->toUrl('/');
            }
        }

        return $this->render('auth/user/register', array(
            'form' => $form,
        ));
    }

    public function resetpasswordAction()
    {
        $form = new ResetPasswordForm();

        if ($this->getRequest()->isPost()) {

            $sm = $this->getServiceLocator();

            $form->setInputFilter( $sm->get('Auth\Model\User')->getInputFilter() );
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                $article = $sm->get('Auth\Model\User')->save( $form->getData() );

                // Redirect to index page
                return $this->redirect()->toUrl('/');
            }
        }

        return $this->render('auth/user/resetpassword', array(
            'form' => $form,
        ));
    }
}
