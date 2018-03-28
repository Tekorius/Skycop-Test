Skycop Homework Task
====================

This is a simple login thingy made with Symfony 4.

You won't find anything fancy here, everything is done according to
Symfony's specification.

Getting Started
---------------

1. Clone the repository to your desired location
2. Install third party dependencies with Composer

        composer install
        
3. Copy `.env.dist` file
    and rename it to `.env`. This file is ignored by git.
    
        cp .env.dist .env

4. Edit `.env` to fit your configuration needs (more on this in Symfony's
    documentation)
    
    For example, my user is root without a password and database is called skycop,
    I change my database line to this
    
        DATABASE_URL=mysql://root@127.0.0.1:3306/skycop

5. Create database and force schema update. This is not a fancy production project,
    let's not bother with migrations
    
        ./c d:d:c
        ./c d:s:u --force
        
6. You can now open the website, create an account and log in
        
Tools Used
----------

### Generic

Very standard tools that you should already have

* [Git](https://git-scm.com/)
* [Composer](https://getcomposer.org/)
* And of course some kind of an XAMP stack

### Flex Packages

* [apache-pack](https://symfony.com/doc/current/setup/web_server_configuration.html)
* [annotations](https://symfony.com/doc/current/routing.html)
* [twig](https://symfony.com/doc/current/templating.html)
* [asset](https://symfony.com/doc/current/best_practices/web-assets.html)
* [doctrine](https://symfony.com/doc/current/doctrine.html)
* [maker](http://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html)
* [profiler](https://symfony.com/doc/current/profiler.html)
* [security](https://symfony.com/doc/current/security.html#security-user-providers)
* [form](https://symfony.com/doc/current/forms.html)
* [validator](http://symfony.com/doc/current/validation.html)

### CSS

Thanks for keeping an unminified version of your css on your servers :)

Interesting choice on using 24 columns

A bit of explanation
--------------------

As mentioned before, this example does not include anything super fancy.

Some key points:

* Default Symfony 4 login flow was used
* Users are provided by database
* User passwords are hashed with bcrypt of course
* Event listeners are listening for login/logout events and logging
    the actions
* Default Symfony validation is used to validate the forms
* Template is stolen from Skycop's website
* Vanilla JS was used for city picker just for fun

Mostly Symfony documentation was followed. More explanations can be found
in their respective class documentation.
