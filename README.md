## Instruções de instalação

- Fazer download do [XAMPP](https://www.apachefriends.org/download.html) - versão 7.4.3
- Fazer download do [Composer](https://getcomposer.org/download/)
- Depois de instalar o Xampp colocar o ficheiro 'Composer-Setup.exe' dentro da pasta do xampp e executar o composer aí dentro
- Fazer clone do repositório dentro da pasta htdocs no xampp - 'git clone link_repositorio'
- Abrir a linha de comandos/terminal dentro da pasta do projeto e fazer 'composer install'
- Fazer 'php artisan migrate'
- Fazer 'php artisan db:seed'
- Já se pode correr o projeto - não esquecer de verificar os ficheiros '.env' e 'database.php' na pasta config e ver se as configs e passwords da bd estão bem