# auctionchain
Online auctions on blockcain

## Installation
1. You must have [composer](https://getcomposer.org/) installed.
2. Clone this repository and cd to the folder created:
'git clone https://github.com/aggeloskar/auctionchain.git'
'cd auctionchain'
3. Create an '.env' file by edditing '.env.example' where you conenct tou your database
4. Install composer dependancies
'composer install'
5. Run the database migrations and seeds
'php artisan migrate'
'php artisan db:seed' (optional)
6. Optional
'php artisan storage:link'
'composer dump-autoload'
'npm install' (not needed)
Because voyager admin panel is used, create an admin
'php artisan voyager:admin your@email.com --create'
or set an existing user as admin
'php artisan voyager:admin your@email.com'
7. Run the local server
'php artisan serve'
