<h1>Laravel API with Invite-Only Sign-Up, Task Management, and Admin Controls</h1>
<b>Project Overview</b>
This Laravel-based project is designed to provide a robust API for user management, featuring invite-only sign-up, task management, and administrative controls. It includes user authentication via Laravel Sanctum, invitation management, and a comprehensive CRUD system for task management. The project is also equipped with API documentation through Swagger and uses several other powerful Laravel packages.

Key Features
User Authentication:

Login and sign-up functionality powered by Laravel Sanctum.
Seeder to create the initial Admin User in the database.
Invite-Only Sign-Up:

Only Admins can send out user invitations.
Invites are time-sensitive, with the ability to resend and reset expiration.
Invitation management without integration with any mailer service; tokens are logged to the console.
Task Management:

CRUD operations for tasks that are associated with users.
Admins can view their own tasks as well as tasks of other users.
API Documentation:

Swagger integration for API documentation via darkaonline/l5-swagger.
Project Setup
Requirements
PHP 8.0+
Composer
Node.js & npm
Laravel 10.x
Installation Steps
Clone the repository

composer install

npm install


Copy .env.example to .env and update the necessary environment variables such as database credentials, app URL, etc.
php artisan migrate:fresh --seed

php artisan db:seed

Generate Swagger Documentation:

To generate API documentation using Swagger
php artisan l5-swagger:generate


Packages Used
darkaonline/l5-swagger: For API documentation.
guzzlehttp/guzzle: HTTP client for making requests.
laravel/framework: The Laravel framework.
laravel/sanctum: For API authentication.
laravel/ui: Provides simple UI scaffolding.
laraveldaily/larastarters: Starter kit with additional Laravel features.
tymon/jwt-auth: For JSON Web Token (JWT) authentication.
yajra/laravel-datatables: For server-side processing of DataTables.



This project provides a comprehensive system for managing user authentication, invite-only access, and task management. With powerful Laravel packages and robust API documentation, it offers an efficient and scalable solution for managing users and tasks within an application.