<?php
// fitfood/routes.php

return [
    // Rota               => ['Controller',                 'Método']

    // GET: Mostra páginas e formulários
    'GET' => [
        '/'                     => ['Auth', 'showLogin'],
        '/login'                => ['Auth', 'showLogin'],
        '/logout'               => ['Auth', 'logout'],
        '/cadastro'             => ['Cadastro', 'showForm'],
        
        '/nutricionista/dashboard' => ['Nutricionista', 'dashboard'],
        '/nutricionista/perfil'    => ['Nutricionista', 'showPerfil'],
        
        '/pacientes'               => ['Paciente', 'index'],
        '/pacientes/novo'          => ['Paciente', 'showForm'],
        '/pacientes/editar/{id}'   => ['Paciente', 'edit'],
    ],

    // POST: Processa o envio de formulários (salvar, atualizar, etc.)
    'POST' => [
        '/login/auth'           => ['Auth', 'authenticate'],
        '/cadastro/save'        => ['Cadastro', 'save'],
        '/nutricionista/perfil/save' => ['Nutricionista', 'savePerfil'],
        '/pacientes/salvar'        => ['Paciente', 'save'],
        '/pacientes/editar/save'   => ['Paciente', 'update'],
        '/pacientes/deletar'       => ['Paciente', 'delete'], 
    ]
];