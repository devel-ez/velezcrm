# VelezCRM 🗂️

Bem-vindo ao VelezCRM! 🎉

Este é um sistema de cadastro de clientes desenvolvido em PHP e MySQL, projetado para gerenciar informações de clientes de forma eficiente e segura. 🔒

## Funcionalidades 🚀
- Cadastro de clientes 📝
- Edição e exclusão de registros ✏️❌
- Validação de dados para evitar duplicatas 🔍
- Interface amigável e responsiva 📱💻

## Tecnologias Utilizadas 🛠️
- PHP 💻
- MySQL 🗄️
- JavaScript 📜
- HTML/CSS 🎨

## Como Usar 📖
1. Clone o repositório: `git clone https://github.com/devel-ez/velezcrm`
2. Navegue até a pasta do projeto: `cd velezcrm`
3. Configure seu ambiente local com XAMPP ou similar.
4. Acesse o sistema pelo navegador.

## Como Instalar e Configurar 📦

Para instalar o projeto em outro computador e garantir que as tabelas sejam migradas automaticamente para o MySQL, siga estes passos:

1. **Clone o Repositório**:
   Use o comando:
   ```bash
   git clone https://github.com/devel-ez/velezcrm.git
   ```

2. **Instale as Dependências**:
   Se você estiver usando Composer, execute:
   ```bash
   composer install
   ```

3. **Configuração do Banco de Dados**:
   - Certifique-se de configurar o arquivo de configuração do banco de dados (geralmente `config.php` ou similar) com as credenciais do novo ambiente.

4. **Executar as Migrações**:
   Para criar as tabelas no banco de dados, você deve executar as migrações. Se você estiver usando um framework como Laravel, o comando seria:
   ```bash
   php artisan migrate
   ```
   Se estiver usando outro sistema, verifique a documentação para o comando correspondente.

5. **Popule o Banco de Dados (se necessário)**:
   Se houver dados iniciais ou seeders, você também pode precisar executar:
   ```bash
   php artisan db:seed
   ```

Após seguir esses passos, as tabelas devem ser criadas automaticamente no MySQL.

## Contribuições 🤝
Contribuições são bem-vindas! Se você deseja colaborar, sinta-se à vontade para abrir um pull request.

## Licença 📄
Este projeto é licenciado sob a MIT License.

## Contato 📫
Para dúvidas ou sugestões, entre em contato: [seu-email@example.com](mailto:seu-email@example.com)
