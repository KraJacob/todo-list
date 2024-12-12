
# Todo List Application

A modern task management application built with Laravel and Vue.js.

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- PostgreSQL

## Installation Steps

1. Clone the repository:
```bash
git clone https://github.com/KraJacob/todo-list.git
cd todo-list

2. Install PHP dependencies:
composer install

3. Install JavaScript dependencies:
npm install

4. Environment setup:
cp .env.example .env

5. Generate application key:
php artisan key:generate

6. Set up database connection in .env file:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=todo_list
DB_USERNAME=postgres
DB_PASSWORD=password

7. Run database migrations:
php artisan migrate

## Running the Application
1. Start the development server:
php artisan serve

2. Start the Vite development server:
npm run dev

3. Access the application in your browser at http://localhost:8000.

## Features
. Create, read, update, and delete tasks
. Set task priorities
. Mark tasks as completed

## Building With
. Laravel
. Vue.js 3
. Tailwind CSS
. PostgreSQL


