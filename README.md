# Sistema de Comentários em PHP e MySQL

Projeto desenvolvido com PHP, MySQL, HTML, CSS e JavaScript puro para cadastro, listagem, edição e exclusão de comentários.

O objetivo deste projeto é demonstrar conhecimentos básicos de desenvolvimento web utilizando operações CRUD (Create, Read, Update e Delete), boas práticas de organização de código e integração com banco de dados.

## Funcionalidades

* Cadastro de comentários
* Listagem de comentários
* Edição de comentários
* Exclusão de comentários
* Validação de campos obrigatórios
* Validação de e-mail
* Mensagens de sucesso e erro
* Interface responsiva
* Proteção contra SQL Injection utilizando PDO
* Proteção contra XSS utilizando htmlspecialchars()

## Tecnologias Utilizadas

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* PDO

## Estrutura do Projeto

```text
comentarios/
│
├── config/
│   └── conexao.php
│
├── css/
│   └── style.css
│
├── actions/
│   ├── cadastrar.php
│   ├── editar.php
│   └── excluir.php
│
├── index.php
└── banco.sql
```

## Banco de Dados

Crie um banco de dados chamado:

```sql
comentarios_db
```

Execute o script abaixo:

```sql
CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    comentario TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Configuração

Abra o arquivo:

```php
config/conexao.php
```

Configure os dados de acesso ao banco:

```php
$host = "localhost";
$banco = "comentarios_db";
$usuario = "root";
$senha = "";
```

## Como Executar

### 1. Instale o XAMPP

Baixe e instale o XAMPP.

### 2. Inicie os serviços

Inicie:

* Apache
* MySQL

### 3. Copie o projeto

Coloque a pasta do projeto dentro de:

```text
htdocs
```

Exemplo:

```text
C:\xampp\htdocs\comentarios
```

### 4. Crie o banco de dados

Acesse o phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Crie o banco de dados e execute o script SQL.

### 5. Execute o projeto

Abra o navegador e acesse:

```text
http://localhost/comentarios
```

## Segurança Implementada

### Prepared Statements

Todos os comandos SQL utilizam Prepared Statements através do PDO para evitar SQL Injection.

### Escape de Saída

Os dados exibidos na tela utilizam:

```php
htmlspecialchars()
```

para evitar execução de scripts maliciosos.

### Validação de Formulário

Validação realizada tanto no HTML quanto no backend em PHP.

## Objetivo do Projeto

Este projeto foi desenvolvido para fins de estudo e portfólio, com foco em praticar:

* PHP
* CRUD
* Integração com MySQL
* Organização de arquivos
* Manipulação de formulários
* Segurança básica em aplicações web

## Autor

Guilherme Lima Ramos

Desenvolvedor em formação, focado em desenvolvimento web utilizando PHP, JavaScript, HTML, CSS e banco de dados MySQL.

## Licença

Este projeto é de uso livre para fins de estudo e aprendizado.
