# Installation Guide

 1. Clone the repository `git clone https://github.com/jmprns/library.git`
 2. Go to the downloaded folder repository `cd library`
 3. Run `composer install` to download necessary libraries
 4. Make an **.env** file `cp .env.example .env`
 5. Configure your **.env** file
 6. Generate key for application by running `php artisan key:generate`
 7. Migrate the database `php artisan:migrate`
 8. Run the server `php artisan serve`
 9. Go to the IP address. Default `127.0.0.1:8000`
