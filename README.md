## Instruções de instalação/uso

- Fazer o download do [Xampp](https://www.apachefriends.org/download.html) -> versão 7.4.3
- Depois do Xampp estar instalado fazer o download do [Composer](https://getcomposer.org/download/)
- Colocar o ficheiro 'Composer-Setup.exe' dentro da pasta do xampp e executá-lo aí dentro
- Abrir o terminal -> ir para a pasta htdocs dentro xampp -> executar o comando 'git clone https://github.com/PtrPti/PTI_PTR_1.git'
    (ex: C:\xampp\htdocs> git clone ...)
- Depois de fazer o clone fazer o comando 'composer install' dentro da pasta do projeto
    (ex: C:\xampp\htdocs\PTI_PTR_1> composer install)
- Fazer o migrate da bd 'php artisan migrate' (não esquecer de criar a tabela no phpmyadmin antes disso)
- Depois do migrate fazer seed às tabelas 'php artisan db:seed'
- Correr o projeto 'php artisan serve'