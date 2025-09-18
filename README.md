# Laravel Project

This is a Laravel application, powered by Laravel Sail for a seamless local development experience using Docker.

## Getting Started

Follow these steps to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

You need to have **Docker** installed on your system to run the application with Laravel Sail.

### Installation

1. **Duplicate the Environment File:**
   First, copy the example environment file to a new `.env` file where you can configure your specific settings. Also DO NOT forget to register WEBHOOK_URL_TOKEN 

2. **Start Sail and Docker Containers:**
    Bring up all the Docker containers required by the application in the background.

    ```bash
    ./vendor/bin/sail up -d
    ```
3. **App Key and migration commands:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate
    ./vendor/bin/sail artisan db:seed
    ```

4. **Queue And Command**
    ```bash
    ./vendor/bin/sail artisan queue:work
    ./vendor/bin/sail artisan process:messages
    ```

5. **Swagger**
    ```bash
    ./vendor/bin/sail artisan qartisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
    ./vendor/bin/sail artisan l5-swagger:generate
    ```

5. **Test**
    ```bash
    ./vendor/bin/sail phpunit --filter MessageServiceTest
    ```
    
