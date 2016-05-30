<?php
namespace Auth\Controller;

use Auth\Form\LoginForm;

class AuthController extends BaseController
{
    public function loginAction()
    {
        $sm = $this->getServiceLocator();
        $authService = $sm->get('AuthenticationService');
        $request = $this->getRequest();
        $errors = array();

        //if already login, redirect to home page
        if ($authService->hasIdentity()){
            return $this->redirect()->toUrl('/');
        }

        $form = new LoginForm();

        if ($request->isPost()){

            $form->setData($this->getRequest()->getPost());

            //check authentication...
            $authService->getAdapter()
               ->setIdentity($request->getPost('username'))
               ->setCredential($request->getPost('password'));

            $result = $authService->authenticate();
            if ($result->isValid()) {
                $authService->getStorage()->write($request->getPost('username'));
                var_dump($authService->getStorage()->read()); exit;
                return $this->redirect()->toUrl($request->getPost('returnTo', '/'));
            } else {
                $errors = $result->getMessages();
            }
        }

        return $this->render('auth/auth/login', array(
            'errors' => $errors,
            'form' => $form,
        ));
    }

    public function logoutAction()
    {
        $sm = $this->getServiceLocator();
        $authService = $sm->get('AuthenticationService');

        // logout
        $authService->clearIdentity();

        return $this->redirect()->toUrl('/');
    }
}
