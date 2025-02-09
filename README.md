# VelezCRM - Sistema de Gestão para Desenvolvedores

Sistema CRM desenvolvido especialmente para desenvolvedores de sites, permitindo o gerenciamento de clientes, contratos, serviços e projetos através de um Kanban.

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Apache com mod_rewrite habilitado
- Composer (para gerenciamento de dependências)

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/velezcrm.git
```

2. Configure o banco de dados:
- Crie um banco de dados MySQL
- Importe o arquivo `config/database.sql`
- Configure as credenciais do banco no arquivo `config/config.php`

3. Configure o Apache:
- Certifique-se que o mod_rewrite está habilitado
- Aponte o DocumentRoot para a pasta `public` do projeto

4. Acesse o sistema:
```
http://localhost/velezcrm
```

## Estrutura do Projeto

```
velezcrm/
├── app/
│   ├── Controllers/
│   ├── Models/
│   └── Router.php
├── config/
│   ├── config.php
│   └── database.sql
├── public/
│   ├── index.php
│   └── .htaccess
├── src/
├── views/
│   ├── layouts/
│   └── dashboard/
└── assets/
```

## Funcionalidades

- Dashboard com visão geral do sistema
- Gestão de Clientes
- Gestão de Serviços
- Gestão de Contratos
- Kanban para gerenciamento de projetos
- Configurações do sistema

## Segurança

- Autenticação de usuários
- Controle de acesso baseado em perfis
- Proteção contra SQL Injection
- Proteção contra XSS
- Senhas criptografadas

## Contribuição

Para contribuir com o projeto:

1. Faça um fork do repositório
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
