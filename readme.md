Api Rest Lumen com TDD

Projeto desenvolvido para servir com base em meus projetos pessoais.Também, estou começando a escrever testes usando o PHPUnit. Utilizei o Postman para auxiliar nos testes.

# Como instalar ?

1 - Clone o repositório git clone https://github.com/Wesleydno/api-lumen-tdd.git
2 - Rode o comando "composer install" para instalar os pacotes necessários
3 - Rode o comando "php artisan key:generate" gerar uma chave para sua aplicação. 
4 - Informe as configurações do banco de dados no arquivo .env
5 - Rode o comando "./artisan migrate" para criar as tabelas no banco

# Como rodar os testes ?
1 - Crie um usuário na base de dados
2 - Rode o comando "vendor/phpunit/phpunit/phpunit"


# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
