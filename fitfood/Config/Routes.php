<?php
// fitfood/routes.php

return [
    // Rota               => ['Controller',                 'Método']

    // GET: Mostra páginas e formulários
    'GET' => [
        '/'                     => ['Auth', 'showLogin'],
        '/install'              => ['Install', 'show'],
        '/login'                => ['Auth', 'showLogin'],
        '/logout'               => ['Auth', 'logout'],
        '/cadastro'             => ['Cadastro', 'showForm'],
        
        '/nutricionista/dashboard' => ['Nutricionista', 'dashboard'],
        '/nutricionista/perfil'    => ['Nutricionista', 'showPerfil'],
        
        '/pacientes'               => ['Paciente', 'index'],
        '/pacientes/novo'          => ['Paciente', 'showForm'],
        '/pacientes/editar/{id}'   => ['Paciente', 'edit'],
        '/pacientes/receitas/{id}' => ['PacienteReceita', 'atribuir'],
        '/receitas/novo' => ['Receita', 'showForm'],
    ],

    // POST: Processa o envio de formulários (salvar, atualizar, etc.)
    'POST' => [
        '/install'              => ['Install', 'install'],
        '/login/auth'           => ['Auth', 'authenticate'],
        '/cadastro/save'        => ['Cadastro', 'save'],
        '/nutricionista/perfil/save' => ['Nutricionista', 'savePerfil'],
        '/pacientes/salvar'        => ['Paciente', 'save'],
        '/pacientes/editar/save'   => ['Paciente', 'update'],
        '/pacientes/deletar'       => ['Paciente', 'delete'], 
        '/receitas/salvar' => ['Receita', 'save'],
        '/pacientes/receitas/salvar' => ['PacienteReceita', 'salvar'],
    ],



];