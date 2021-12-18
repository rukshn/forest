# Forest

<img src="https://imgur.com/2uXFVSJ.png" height="256" />

Forest is a simple project management tool for small teams. Forest was developed to be used as a free project management tool to manage the development of the National Covid Health Information System in Sri Lanka.

Forest is based or the Laravel PHP framework. Laravel was used because of easy hosting of PHP and ability to quickly develop with existing Laravel features.

## Features
* Simple user interface
* Create posts and comments using **markdown** 
* Kanban board
* Issue tracker
* Task allocation
* Reviews
* Announcements
* Track your teams progress and work they have done

## Screenshot

<img src="https://i.imgur.com/PXgYapg.png" />

It's still under development and lot of bugs to be fixed and improvements to be done.

Even though we used it for the development of NCHIS, I don't think it's production ready.

Feel free to contribute. Any help is welcomed. 

## Setup

### First install all the dependancies 
`$ composer install`
`$ npm install`

### Connect MySQL your database
* First rename `.envexample` to `.env`
* Change the environment variables to store your *mysql* connection details, by providing the database name, username, password.
* Run `php artisan migrate` this will automatically create the tables in the selected database.

### Run
`$ php arisan serve`

Open `127.0.0.1:5000` on your browser


Rukshan
