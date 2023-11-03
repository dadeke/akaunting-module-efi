# Efí (Brazil) app for Akaunting

[![Release](https://img.shields.io/github/v/release/dadeke/akaunting-module-efi?label=release)](https://github.com/dadeke/akaunting-module-efi/releases)
[![Tests](https://github.com/dadeke/akaunting-module-efi/actions/workflows/tests.yml/badge.svg)](https://github.com/dadeke/akaunting-module-efi/actions)
[![License](https://img.shields.io/github/license/dadeke/akaunting-module-efi?label=license)](LICENSE.txt)

This app allows your customers to pay their invoices with Pix a common payment method used in Brazil using the payment processor [Efí](https://sejaefi.com.br).

## Requirements

- [Akaunting 3](https://github.com/akaunting/akaunting/releases)

## Installation

- Into `modules` create folder `Efi` (camel case)
- Download the last release [https://github.com/dadeke/akaunting-module-efi/releases](https://github.com/dadeke/akaunting-module-efi/releases) **efi-(version).zip**
- Extract zip file into `modules/Efi`
- Run install dependencies: `composer install`
- [Install](https://developer.akaunting.com/documentation/modules/#67474166c92e) the module: `php artisan module:install efi 1`

## Settings

Create your Client ID, Client Secret:  
[https://app.sejaefi.com.br/api/aplicacoes](https://app.sejaefi.com.br/api/aplicacoes)  
and Certificate:  
[https://app.sejaefi.com.br/api/meus-certificados](https://app.sejaefi.com.br/api/meus-certificados)

Save your credentials here:

![Akaunting - Settings - Efí](https://github.com/dadeke/akaunting-module-efi/assets/6050573/2b360976-8e18-4f28-bcee-6ba4630017b3)
