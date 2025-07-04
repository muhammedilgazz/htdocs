# Development Guidelines

## Build/Configuration Instructions

This is a Laravel 11 application with Vite for asset compilation and Tailwind CSS for styling.

### Setup Instructions:

1. Install PHP dependencies: composer install
2. Install Node.js dependencies: npm install
3. Copy environment file: cp .env.example .env
4. Generate application key: php artisan key:generate
5. Configure database in .env file (default is SQLite)
6. Run migrations: php artisan migrate
7. Build assets: npm run build (for production) or npm run dev (for development)

### Development Server:

- Laravel: php artisan serve
- Vite dev server: npm run dev (for hot reloading)

## Testing Information

### Running Tests:

- All tests: php artisan test
- Specific test file: php artisan test tests\Unit\PromptModelTest.php
- Feature tests only: php artisan test tests\Feature
- Unit tests only: php artisan test tests\Unit

### Adding New Tests:

- Create unit test: php artisan make:test TestName --unit
- Create feature test: php artisan make:test TestName

### Test Example:

The project includes working test examples:

- tests\Unit\ExampleTest.php - Basic unit test
- tests\Feature\ExampleTest.php - HTTP response test
- tests\Unit\PromptModelTest.php - Model test example

## Additional Development Information

### Project Structure:

- Models: app\Models\ - Eloquent models (Prompt, Category, User, Blog)
- Controllers: app\Http\Controllers\ - HTTP controllers
- Views: resources\views\ - Blade templates
- Routes: routes\web.php - Web routes definition
- Assets: resources\css\, resources\js\ - Source assets compiled by Vite

### Key Models and Relationships:

- Prompt Model: Main entity with relationships to Category and User
    - Fillable: title, main_cat_id, other_cats, picture, prompt_agent, used_times, prompt_text, publisher, keywords
    - Casts: keywords as array, used_times as integer
    - Relationships: belongsTo Category, belongsTo User

### Database:

- Default configuration uses SQLite
- Migrations located in database\migrations\
- Key tables: prompts, categories, users, blogs

### Frontend:

- Tailwind CSS for styling
- Vite for asset compilation
- Bootstrap grid system used in Blade templates
- Custom CSS in public\assets\css\style.css

### Blade Components:

- Reusable components in resources\views\components\
- Partials in resources\views\partials\
- Main layout: resources\views\layouts\app.blade.php

### Routes Structure:

- Home: / - HomeController@index
- Prompts: /prompts - PromptController@index
- Categories: /category/{slug} - PromptController@category
- Prompt creation: /prompts/create - PromptController@create/store

### Environment Configuration:

- Copy .env.example to .env
- Default database is SQLite (no additional setup required)
- Configure APP_URL, APP_NAME as needed
- Mail driver set to 'log' for development

### Code Style Notes:

- Turkish language used in UI text and comments
- Follows Laravel conventions
- Uses Eloquent ORM for database interactions
- Blade templating with component-based architecture
