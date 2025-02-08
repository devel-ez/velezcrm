# VelezCRM

## Descrição
O VelezCRM é um sistema de gerenciamento de relacionamento com clientes (CRM) desenvolvido em PHP, MySQL e Bootstrap, seguindo o padrão MVC. Este projeto tem como objetivo facilitar a gestão de clientes, serviços e contratos.

## Requisitos

- PHP 8.0 ou superior
- MySQL 5.7 ou superior
- Composer
- Apache/Nginx com mod_rewrite habilitado

## Estrutura do Projeto
A estrutura do projeto é organizada da seguinte forma:

```
velezcrm/
├── app/
│   ├── Core/                  # Classes base para controllers e models
│   │   ├── BaseController.php  # Classe base para todos os controllers
│   │   └── BaseModel.php       # Classe base para todos os models
│   ├── Http/
│   │   └── Controllers/       # Controllers específicos da aplicação
│   ├── Models/                 # Models específicos da aplicação
│   └── Views/                  # Views da aplicação
│       ├── components/         # Componentes reutilizáveis (navbar, sidebar)
│       ├── layouts/            # Layouts base do sistema
│       ├── auth/               # Views de autenticação
│       ├── clients/            # Views do módulo de clientes
│       ├── errors/             # Páginas de erro
│       └── home/               # Views da página inicial
├── config/
├── database/
│   ├── migrations/             # Migrações do banco de dados
│   ├── seeds/                  # Seeds para dados iniciais
│   ├── import.sql              # Script para importar dados
│   └── schema.sql              # Estrutura do banco de dados
├── public/
│   ├── assets/
│   ├── css/
│   ├── js/
│   └── index.php
└── vendor/
```

## Instalação
1. Clone o repositório:
   ```bash
   git clone https://github.com/devel-ez/velezcrm.git
   cd velezcrm
   ```
2. Instale as dependências usando o Composer:
   ```bash
   composer install
   ```
3. Configure o arquivo `.env` com as credenciais do banco de dados.
4. Importe o banco de dados usando o arquivo `import.sql`.
5. Configure o servidor web:
   - Aponte o DocumentRoot para a pasta `public/`
   - Certifique-se que o mod_rewrite está habilitado
   - Dê as permissões necessárias para as pastas do projeto

## Acesso ao Sistema

Após a instalação, acesse o sistema com as credenciais padrão:
- Email: admin@velezcrm.com
- Senha: admin123

**Importante:** Altere a senha do administrador após o primeiro acesso.

## Funcionalidades
- Sistema de autenticação
- Gerenciamento de clientes, serviços e contratos
- Dashboard com informações resumidas
- Páginas de erro personalizadas
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

## Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests.
