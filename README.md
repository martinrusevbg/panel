#LaravelPanel

[![Total Downloads](https://poser.pugx.org/serverfireteam/panel/downloads.svg)](https://packagist.org/packages/serverfireteam/panel)
[![Latest Stable Version](https://poser.pugx.org/serverfireteam/panel/v/stable.svg)](https://packagist.org/packages/serverfireteam/panel)
[![License](https://poser.pugx.org/serverfireteam/panel/license.svg)](https://packagist.org/packages/serverfireteam/panel)

**LaravelPanel** is a modern Laravel Admin package. 

This package provides an easily configurable admin panel for Laravel 5  applications with a CRUD system, UI and more.

## Main features

- **Crud**, With just few lines of code, you'll have Add, Edit, Delete and Search actions for your models.
- **Clean Admin**, Based on bootstrap 3 and sb-admin-2 
- **Dashboard**, It shows how many records you have in every model added in menu.
- **Preconfigured**, It has default users and models you need.
- **Powerful**, It offers a Login section, Admin settings, forgot password and all other features you need for admin panel.

## Screen shot 

- This is a custom CRUD with few lines of code :
![dashboard of panel](https://raw.githubusercontent.com/serverfireteam/panel/master/public/img/serverfire-panel-dashboard.jpg)
![List of Pages](https://raw.githubusercontent.com/serverfireteam/panel/master/public/img/serverfire-panel-crud.jpg)
![Edit Pages](https://raw.githubusercontent.com/serverfireteam/panel/master/public/img/serverfire-panel-crud-edit.jpg)

## Demo 
You can check the [live demo here](http://demo.serverfire.net/panel) .
User: admin@change.me
Pass: 12345 

##Installations 
Note: if you face any problem in any of the steps you should report it at [github](https://github.com/serverfireteam/panel/issues/new)

1. First you need to create a laravel 5  project.

2. Add our package to require section of composer 

    ```json
    {
        "require": {
            "serverfireteam/panel": "1.2.*"
        },
    }
    ```

And run the composer update command, the package and its dependencies will be installed.

3. Add the ServiceProvider of the package to the list of providers in the config/app.php file

    ```php
    'providers' => array(
        'Serverfireteam\Panel\PanelServiceProvider'
    )
    ```

4. Run the following command in order to publish configs, views and assets.  

    ```bash
    php artisan panel:install

    ```
5. Go to your domain.com/public/panel and you can login with the following username and password :
    user : admin@change.me
    password : 12345


## Documents    
[laravelpanel.com/docs/master](http://laravelpanel.com/docs/master) 


#Credits 
[SB-admin](http://startbootstrap.com/template-overviews/sb-admin/) for admin template.
A forked repo of [rapyd](http://rapyd.com) for CRUD system.


We are going to develop this package every day and new ideas are welcome.
Thank you for using our package 

