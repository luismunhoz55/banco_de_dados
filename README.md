## Setup do projeto

No Windows, primeiro temos que instalar o php 8.3, composer e o laravel installer

-   No Powershell, rodar:

```bash
  # Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.3'))
```

-   E depois instalar o laravel:

```bash
composer global require laravel/installer
```

##

-   Agora, faça o clone do projeto , entre na pasta e rode:

```bash
npm install
composer install
```

-   Agora, faça uma cópia do .env.example e remova o .example

-   Rode:

```bash
php artisan key:generate
php artisan migrate --seed
```

##

-   Agora, para rodar o projeto, rode:

```bash
composer run dev
```

-   E entre em http://127.0.0.1:8000/
