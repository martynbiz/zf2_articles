<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
            'Auth\Controller\User' => 'Auth\Controller\UserController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'admin-users' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/user',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Admin\User',
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
            'users' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\User',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'register' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/register',
                            'defaults' => array(
                                'action'     => 'register',
                            ),
                        ),
                    ),
                    'resetpassword' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/resetpassword',
                            'defaults' => array(
                                'action'     => 'resetpassword',
                            ),
                        ),
                    ),
                ),
            ),
            'login' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'logout',
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
