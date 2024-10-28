
# Lumen Task Management API

This is a RESTful API built with Lumen that allows users to manage tasks. It supports basic CRUD operations, task filtering, searching, and pagination.

## Features
- Create, read, update, and delete tasks.
- Filter tasks by `status` and `due_date`.
- Paginate task listings.
- Search tasks by `title`.
- Data validation for all incoming requests.

## Requirements
- PHP >= 8.1
- Composer
- PostgreSQL
- Git

## Getting Started

### Clone the Repository
Clone the repository using Git:
```bash
git clone https://github.com/your-username/lumen-task-api.git
cd lumen-task-api
```

### Install Dependencies
Install PHP dependencies using Composer:
```bash
composer install
```

### Environment Configuration
Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```

Update the `.env` file with your PostgreSQL database details:
```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tasks_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

Replace `your_db_user` and `your_db_password` with your PostgreSQL credentials.

### Generate Application Key
Generate an application key:
```bash
php artisan key:generate
```

### Run Database Migrations
Run the database migrations to create the `tasks` table:
```bash
php artisan migrate
```

### Start the Server
Start the Lumen development server:
```bash
php -S localhost:8000 -t public
```

The API is now available at `http://localhost:8000`.

## API Endpoints

| Method | Endpoint            | Description                      |
| ------ | ------------------- | -------------------------------- |
| POST   | `/api/tasks`        | Create a new task                |
| GET    | `/api/tasks`        | Get all tasks with filtering, search, and pagination |
| GET    | `/api/tasks/{id}`   | Get a specific task by ID        |
| PUT    | `/api/tasks/{id}`   | Update a task by ID              |
| DELETE | `/api/tasks/{id}`   | Delete a task by ID              |

### Example Requests
**Create a Task:**
```http
POST /api/tasks
Content-Type: application/json

{
    "title": "New Task",
    "description": "This is a new task.",
    "due_date": "2024-12-31"
}
```

**Get All Tasks with Filters and Search:**
```http
GET /api/tasks?status=pending&due_date=2024-12-31&search=task&page=1
```

**Update a Task:**
```http
PUT /api/tasks/1
Content-Type: application/json

{
    "title": "Updated Task Title",
    "status": "completed"
}
```

**Delete a Task:**
```http
DELETE /api/tasks/1
```

## Testing
To run tests, use PHPUnit:
```bash
php artisan test
```

Make sure you have a testing database configured in your `.env` file:
```dotenv
DB_DATABASE=tasks_db_testing
```

You can run specific tests with:
```bash
php artisan test --filter=TaskControllerTest
```

## Git Workflow
To keep your repository up-to-date with the latest changes, use:
```bash
git pull origin main
```

Make sure to pull before making any changes to avoid conflicts.

## Common Issues
- **Database Connection Issues**: Ensure your PostgreSQL server is running and your `.env` credentials are correct.
- **Migrations Fail**: Make sure the database specified in `.env` exists and is properly set up.

## Deployment
To deploy the application to a production environment:
1. Use a web server like Nginx or Apache.
2. Set up SSL/TLS certificates for HTTPS.
3. Use a process manager like Supervisor for handling the Lumen process.

### Example Nginx Configuration
```nginx
server {
    listen 80;
    server_name your-domain.com;

    root /path/to/lumen-task-api/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## Contributing
Feel free to submit a pull request if you'd like to contribute. Ensure your code follows PSR-12 coding standards and includes relevant tests.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Acknowledgements
- [Lumen Documentation](https://lumen.laravel.com/docs)
- [Composer](https://getcomposer.org/)
- [PostgreSQL](https://www.postgresql.org/)
