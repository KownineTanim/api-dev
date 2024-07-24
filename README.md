1. Clone the repository:
   git clone https://github.com/your-username/laravel-api-jwt.git
   cd api-dev
2. Install all the dependencies using composer:
    composer install
3. Copy the `.env.example` file to `.env`:
    cp .env.example .env
4. Generate the application key:
    php artisan key:generate
6. Run the database migrations:
    php artisan migrate
7. Install the `php-open-source-saver/jwt-auth` package (if needed):
    composer require php-open-source-saver/jwt-auth
8. Publish the package configuration (if needed):
    php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
9. Generate the JWT secret key (if needed):
    php artisan jwt:secret
10. Start the local development server:
    php artisan serve
Now you can run the application via postman
Before checking all endpoints please register first as below route
POST /api/v1/register: Register a new user.
POST /api/v1/login: Authenticate a user and get a token and use this token as Headers Key named Authorization, Value Bearer token  to check all endpoints
