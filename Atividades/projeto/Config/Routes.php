<?php


return [
    '/projeto' => ['Home', 'index'],
    '/projeto/home' => ['Home', 'index'],
    '/projeto/home/index' => ['Home', 'index'],
    '/projeto/home/precos' => ['Home', 'precos'],
    '/projeto/home/vender' => ['Home', 'vendar'],
    '/projeto/home/anuncios' => ['Home', 'anuncios'],
    '/projeto/home/contato' => ['Home', 'contato'],

    '/projeto/cidades' => ['Cidades', 'index'],
    '/projeto/cidades/new' => ['Cidades', 'new'],
    '/projeto/cidades/index' => ['Cidades', 'index'],
    '/projeto/cidades/edit/{id}' => ['Cidades', 'edit'],
    '/projeto/cidades/delete/{id}' => ['Cidades', 'delete'],
    '/projeto/cidades/save' => ['Cidades', 'save'],
    '/projeto/cidades/edit_save' => ['Cidades', 'edit_save'],
    '/projeto/cidades/search' => ['Cidades', 'search'],

    '/projeto/categorias' => ['Categorias', 'index'],
    '/projeto/categorias/new' => ['Categorias', 'new'],
    '/projeto/categorias/index' => ['Categorias', 'index'],
    '/projeto/categorias/edit/{id}' => ['Categorias', 'edit'],
    '/projeto/categorias/delete/{id}' => ['Categorias', 'delete'],
    '/projeto/categorias/save' => ['Categorias', 'save'],
    '/projeto/categorias/edit_save' => ['Categorias', 'edit_save'],
    
    '/projeto/usuarios' => ['Usuarios', 'index'],
    '/projeto/usuarios/new' => ['Usuarios', 'new'],
    '/projeto/usuarios/index' => ['Usuarios', 'index'],
    '/projeto/usuarios/edit/{id}' => ['Usuarios', 'edit'],
    '/projeto/usuarios/delete/{id}' => ['Usuarios', 'delete'],
    '/projeto/usuarios/save' => ['Usuarios', 'save'],
    '/projeto/usuarios/edit_save' => ['Usuarios', 'edit_save'],

    '/projeto/login' => ['Login', 'index'],
    '/projeto/login/index' => ['Login', 'index'],
    '/projeto/login/auth' => ['Login', 'auth'],
    '/projeto/login/logout' => ['Login', 'logout'],
    
    '/projeto/admin' => ['Admin', 'index'],
    '/projeto/admin/index' => ['Admin', 'index'],
    
    '/projeto/user' => ['User', 'index'],
    '/projeto/user/index' => ['User', 'index'],
    
    '/sobre' => ['HomeController', 'sobre'],
];

