# VelezCRM

Sistema de CRM desenvolvido com PHP, MySQL e Bootstrap, utilizando o tema Phoenix.

## Requisitos

- PHP 8.0 ou superior
- MySQL 5.7 ou superior
- Composer
- Apache/Nginx com mod_rewrite habilitado

## Instalação

1. Clone o repositório:
```bash
git clone [url-do-repositorio]
cd velezcrm
```

2. Instale as dependências via Composer:
```bash
composer install
```

3. Configure o ambiente:
```bash
cp .env.example .env
```
Edite o arquivo `.env` com suas configurações de banco de dados e aplicação.

4. Importe o banco de dados:
```bash
mysql -u seu_usuario -p < database/schema.sql
```

5. Configure o servidor web:
- Aponte o DocumentRoot para a pasta `public/`
- Certifique-se que o mod_rewrite está habilitado
- Dê as permissões necessárias para as pastas do projeto

## Estrutura do Projeto

```
velezcrm/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   └── Core/
├── config/
├── database/
├── public/
│   ├── assets/
│   ├── css/
│   ├── js/
│   └── index.php
└── vendor/
```

## Acesso ao Sistema

Após a instalação, acesse o sistema com as credenciais padrão:
- Email: admin@velezcrm.com
- Senha: admin123

**Importante:** Altere a senha do administrador após o primeiro acesso.

## Funcionalidades

- Gestão de Clientes
- Gestão de Serviços
- Gestão de Contratos
- Kanban de Tarefas
- Sistema de Usuários com Níveis de Acesso
- Interface Responsiva com Bootstrap

## Segurança

O sistema implementa diversas medidas de segurança:
- Proteção contra SQL Injection
- Proteção contra CSRF
- Proteção contra XSS
- Senhas criptografadas com Bcrypt
- Controle de Acesso baseado em Roles

## Suporte

Para suporte ou dúvidas, entre em contato através do email: [seu-email]
