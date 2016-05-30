<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Article\Controller\Article' => 'Article\Controller\ArticleController',
            'Article\Controller\Admin\Article' => 'Article\Controller\Admin\ArticleController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'admin-article' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/article',
                    'defaults' => array(
                        'controller' => 'Article\Controller\Admin\Article',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'action'     => 'add',
                            ),
                        ),
                    ),
                    'get' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '[/:id][/:action]',
                            'defaults' => array(
                                'action'     => 'get',
                            ),
                            'constraints' => array(
                                'id'     => '[0-9]+',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),
            'article' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/article',
                    'defaults' => array(
                        'controller' => 'Article\Controller\Article',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'get' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '[/:id][/:slug]',
                            'defaults' => array(
                                'action'     => 'get',
                            ),
                            'constraints' => array(
                                'id'     => '[0-9]+',
                                'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
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
