
# Benue State Integrated Document Management System.

<-- Brief intro about the project here -->

## Installation

To set up the application locally, follow these steps:

1. **Clone the Repository**:

   ```bash
   [git clone https://github.com/Paul-Ben/dms.git]
   cd project folder
   ```

2. **Install Composer Dependencies**:

   Make sure you have [Composer](https://getcomposer.org/) installed, then run:

   ```bash
   composer install
   ```

3. **Install NPM Dependencies if required**:

   Make sure you have [Node.js](https://nodejs.org/) installed, then run:

   ```bash
   npm install
   ```

4. **Create a Copy of the .env File**:

   ```bash
   cp .env.example .env
   ```

5. **Generate an Application Key**:

   ```bash
   php artisan key:generate
   ```

6. **Configure the .env File**:

   Open the `.env` file and update the necessary environment variables, such as database configuration, mail settings, etc.

   Example:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. **Run Migrations**:

   This will create the necessary database tables.

   ```bash
   php artisan migrate
   ```
8. **Seed the Database**:

   This will auto populate the User and UserDetail tables with test data.

   ```bash
   php artisan db:seed
   ```


9. **Build node requirements if required**:

   Build node dependencies.

   ```bash
   npm run build
   ```

10. **Run the Application**:

    Start the local development server:

    ```bash
    php artisan serve
    ```
    
    The application should now be running at `http://localhost:8000`   🚀 🚀 🚀

# API Endpoints

## Public Routes (No Authentication Required)
> Endpoint: **GET** `https://efiling.bdic.ng/api/ministries`

> Endpoint: **GET** `https://efiling.bdic.ng/api/agencies`
## Authentication 
> Endpoint: **POST** `https://efiling.bdic.ng/api/register`

> Endpoint: **POST** `https://efiling.bdic.ng/api/login`


## Private Routes (Authentication Required)

## User Management 
> Endpoint: **GET** `https://efiling.bdic.ng/api/dashboard/users/` - List all users.

> Endpoint: **GET** `https://efiling.bdic.ng/api/dashboard/users/create` -  Get data for creating a new user. 

> Endpoint: **POST** `https://efiling.bdic.ng/api/dashboard/users` - Store a new user. 

> Endpoint: **GET** `https://efiling.bdic.ng/api/dashboard/users/{user}/edit` - Get data for editing a user

> Endpoint: **POST** `https://efiling.bdic.ng/api/dashboard/users/{user}` - Update a user.

> Endpoint: **DELETE** `https://efiling.bdic.ng/api/dashboard/users/{user}` - Delete a user

## Organisation Management

> Endpoint: **GET** `https://efiling.bdic.ng/api/dashboard/superadmin/organisations` - List all Organisations.

> Endpoint: **POST** `https://efiling.bdic.ng/api/dashboard/superadmin/organisations/create` - Create Organisation.

> Endpoint: **GET** `https://efiling.bdic.ng/api/dashboard/superadmin/organisations/{tenant}/edit` - Get Organisation Details.

> Endpoint: **PUT** `https://efiling.bdic.ng/api/dashboard/superadmin/organisations/{tenant}/edit` - Update Organisation.

> Endpoint: **DELETE** `https://efiling.bdic.ng/api/dashboard/superadmin/organisations/{tenant}/delete` - Delete Organisation.






