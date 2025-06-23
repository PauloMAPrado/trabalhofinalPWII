# FitFood - Sistema de Nutrição

## Problemas Corrigidos

### 1. Configuração Docker
- ✅ Mapeamento de volume corrigido: `./fitfood:/var/www/html`
- ✅ Nome do banco corrigido: `fitfood`

### 2. Estrutura MVC
- ✅ Controllers corrigidos com métodos adequados
- ✅ Views reorganizadas com sistema de rotas
- ✅ Database com campos corretos do schema

### 3. Segurança
- ✅ Autenticação com `password_hash/verify`
- ✅ Proteção contra SQL injection
- ✅ Validação de sessões

### 4. Sistema de Rotas
- ✅ `.htaccess` criado
- ✅ Rotas funcionais
- ✅ Controllers integrados

## Como Usar

1. **Iniciar containers:**
```bash
docker-compose up -d
```

2. **Acessar aplicação:**
- App: http://localhost:8050
- phpMyAdmin: http://localhost:8051

3. **Importar banco:**
- Use o arquivo `fitfood/Database/fitfood.sql`

4. **Login de teste:**
- Crie um nutricionista via cadastro
- Faça login e gerencie pacientes/receitas

## Estrutura Funcional

- **Nutricionista**: Dashboard, perfil, pacientes, receitas
- **Paciente**: Visualização de cronograma
- **Sistema**: Autenticação, CRUD completo

Todos os problemas principais foram corrigidos!