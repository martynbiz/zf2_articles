<?php
namespace Article\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BaseController extends AbstractActionController
{
    /**
     * Render function to create ViewModel
     * @param string $template
     * @param array $data
     * @return ViewModel
     */
    public function render($template, $data=array())
    {
        $view = new ViewModel($data);
        $view->setTemplate($template);

        return $view;
    }
}
