Chatroom
========================

A PHP chat room 
--------------
Users will be able to register under a username and interact with other users. User will be stored in a database using MySQL

Features:
- create rooms where user a ability to moderate 
- logs of conversations will be saved

how to start:
- clone the repsitory 
- change your directory 
- run in terminal: composer install 
- start by creating the database and run: php bin/console doctrine:database:create
- create the user table by running: php bin/console doctrine:schema:update --force 
- and finally run php bin/console server:start to start the server and php bin/console chat:socket to start the socket 

- you can change the role of one user you chose to be the admin by running: 
php bin/console fos:user:promote "chosen_username" and then set the role to be ROLE_ADMIN
