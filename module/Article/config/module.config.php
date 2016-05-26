<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Article\Controller\Article' => 'Article\Controller\ArticleController',
        ),
    ),

    // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'article' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/article[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Article\Controller\Article',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

    'view_manager' => array(
        'template_path_stack' => array(
            'article' => __DIR__ . '/../view',
        ),
    ),
);
