# Laravel CRM Project

This is a Customer Relationship Management (CRM) application built using Laravel. It's designed to help businesses manage customer data, interactions, and more. This project serves as a practical application of Laravel's features and best practices, and was created to improve my Laravel skills.

![](./public/images/dashboard_screen.png)

## **Table of Contents**

* [Project Overview](#project-overview)
* [Requirements](#requirements)
* [Installation](#Installation)
* [Getting Started](#getting-started)
* [Project Structure](#project-structure)
* [Dependencies](#dependencies)
* [Database Schema](#database-schema)
* [MVC Pattern](#mvc-pattern)
* [Testing](#testing)
* [Purpose of the Project](#purpose-of-the-project)
* [Contributing](#contributing)
* [License](#license)

## **Project Overview**

This Laravel project provides a foundation for building a CRM application. The project is designed to be modular and extensible, allowing you to easily add new features and functionality.

## **Requirements**

* PHP >= 8.1
* Composer
* MySQL
* Node.js and npm

## **Installation**

1. Clone the project repository:

```sh
git clone https://github.com/smlrods/CRM.git
```

2. Enter the project directory:

```sh
cd CRM
```

3. Install the Composer dependencies:

```sh
composer install
```

4. Install the npm dependencies:

```sh
npm install
```

5. Create a [`.env`](command:_github.copilot.openRelativePath?%5B%22.env%22%5D ".env") file from the provided [`.env.example`](command:_github.copilot.openRelativePath?%5B%22.env.example%22%5D ".env.example") file:

```sh
cp .env.example .env
```

6. Generate the application key:

```sh
php artisan key:generate
```

7. Migrate the database:

```sh
php artisan migrate
```

8. Seed the database with sample data (optional):

```sh
php artisan db:seed
```

## **Getting Started**

1. Start the development server:

```sh
php artisan serve
```

2. The application will be available at `http://localhost:8000`

## **Project Structure**

The project is organized into the following directories:

* [`app`](command:_github.copilot.openRelativePath?%5B%22app%22%5D "app"): This directory contains the application logic, including models, controllers, and services.
* [`config`](command:_github.copilot.openRelativePath?%5B%22config%22%5D "config"): This directory contains configuration files for the application.
* [`database`](command:_github.copilot.openRelativePath?%5B%22database%22%5D "database"): This directory contains database migrations and seeds.
* [`public`](command:_github.copilot.openRelativePath?%5B%22public%22%5D "public"): This directory contains the web server's public files, including the front-end assets.
* [`resources`](command:_github.copilot.openRelativePath?%5B%22resources%22%5D "resources"): This directory contains resources used by the application, such as views and language files.
* [`routes`](command:_github.copilot.openRelativePath?%5B%22routes%22%5D "routes"): This directory contains the routing definitions for the application.
* [`storage`](command:_github.copilot.openRelativePath?%5B%22storage%22%5D "storage"): This directory contains application storage, such as logs and uploaded files.
* [`tests`](command:_github.copilot.openRelativePath?%5B%22tests%22%5D "tests"): This directory contains unit and feature tests for the application.
* [`vendor`](command:_github.copilot.openRelativePath?%5B%22vendor%22%5D "vendor"): This directory contains third-party dependencies managed by Composer.

## **Dependencies**

This project relies on several dependencies for its functionality:

### PHP and Composer Dependencies

* **Laravel**: This is the main framework used for this project. Laravel is a web application framework with expressive, elegant syntax.

* **PHPUnit**: This is the testing framework used for writing unit tests in this project.

* **laravel-permission**: This package allows you to manage user permissions and roles in a database.

Please refer to the `composer.json` file for a full list of PHP and Composer dependencies.

### JavaScript and Node.js Dependencies

* **Node.js and npm**: These are used for managing JavaScript dependencies and running tasks. Node.js is a JavaScript runtime built on Chrome's V8 JavaScript engine, and npm is the package manager for Node.js.

* **Vite**: This is a build tool that provides faster and leaner development experience for modern web projects. It is used in this project for managing and bundling the JavaScript resources.

* **Tailwind CSS**: This is a utility-first CSS framework for rapidly building custom user interfaces.

* **Flowbite React**: Flowbite is a set of utility classes for Tailwind CSS that helps you build web interfaces faster.

* **PostCSS**: This is a tool for transforming CSS with JavaScript, and it is used in this project in conjunction with Tailwind CSS and Flowbite.

* **ReactJS**: React is the library for web and native user interfaces. Build user interfaces out of individual pieces called components written in JavaScript.

* **InertiaJS**: Inertia.js is a JavaScript tool that allows users to build modern single-page apps using classic server-side routing and controllers.

Please refer to the `package.json` file for a full list of JavaScript and Node.js dependencies.

## Database Schema

[![Database Schema](./assets/db-schema.svg)](https://dbdiagram.io/d/NEW-CRM-6577200d56d8064ca0cd099a)

## **MVC Pattern**

The project follows the MVC (Model-View-Controller) pattern. Models represent the data of the application, controllers handle user interaction and business logic, and views render the user interface.

## **Testing**

The project includes unit and feature tests for the application logic. You can run the tests using the following command:

```sh
cp .env.testing.example .env.testing
```

```sh
php artisan test
```

## **Purpose of the Project**

This project was created as a means to improve my Laravel skills. It serves as a practical application of Laravel's features and best practices. While building this CRM application, I've had the opportunity to explore various aspects of Laravel including routing, middleware, Eloquent ORM, Blade templates, and more. This hands-on experience has significantly contributed to my understanding and proficiency in Laravel.

## **Contributing**

We welcome contributions to this project.

## **License**

This project is licensed under the MIT License. Please see the LICENSE file for more information.
