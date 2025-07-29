# Laravel Task Management System

A comprehensive task management application built with Laravel 10, featuring user authentication, category management, and task tracking with status updates and reporting capabilities.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Database Schema](#database-schema)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Features

### Core Functionality
- **User Authentication**: Complete authentication system with registration, login, password reset
- **Task Management**: Create, read, update, and delete tasks with detailed information
- **Category Management**: Organize tasks into categories with proper relationship handling
- **Status Tracking**: Track task progress with three states (completed, uncompleted, failed)
- **Reporting**: Generate comprehensive reports with statistics and PDF export
- **Responsive Design**: Mobile-friendly interface using Bootstrap

### Enhanced Features
- **Secure Delete Operations**: Proper authorization and error handling for all delete operations
- **Data Integrity**: Database transactions ensure data consistency
- **User Isolation**: Users can only access and modify their own data
- **Validation**: Comprehensive input validation with user-friendly error messages
- **Error Handling**: Graceful error handling with informative feedback

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or PostgreSQL 9.6+
- Node.js 16+ (for asset compilation)
- Web server (Apache/Nginx)

### PHP Extensions Required
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

### Step 1: Clone or Extract the Project



```bash
# If you have the zip file, extract it
unzip laravel_project.zip
cd laravel_project

# Or if cloning from repository
git clone <repository-url>
cd laravel_project
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies (if using Vite for asset compilation)
npm install
```

### Step 3: Environment Configuration

```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Configuration

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Database Migration

```bash
# Run database migrations
php artisan migrate

# (Optional) Seed the database with sample data
php artisan db:seed
```

### Step 6: Asset Compilation

```bash
# Compile assets for development
npm run dev

# Or compile for production
npm run build
```

### Step 7: Start the Development Server

```bash
# Start the Laravel development server
php artisan serve

# The application will be available at http://localhost:8000
```

## Configuration

### Environment Variables

The application uses the following key environment variables:

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | Laravel |
| `APP_ENV` | Environment (local, production) | local |
| `APP_DEBUG` | Debug mode | true |
| `APP_URL` | Application URL | http://localhost |
| `DB_CONNECTION` | Database driver | mysql |
| `DB_HOST` | Database host | 127.0.0.1 |
| `DB_PORT` | Database port | 3306 |
| `DB_DATABASE` | Database name | laravel |
| `DB_USERNAME` | Database username | root |
| `DB_PASSWORD` | Database password | |

### Mail Configuration

For password reset functionality, configure mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Usage

### User Registration and Authentication

1. **Registration**: Navigate to `/sign-up` to create a new account
2. **Login**: Use `/sign-in` to access your account
3. **Password Reset**: Use `/forget-password` if you forget your password

### Task Management

#### Creating Tasks

1. Navigate to the main dashboard
2. Click "Add Task" button
3. Fill in the required information:
   - Task name (required)
   - Category (must exist)
   - End date (required)
   - Description (optional)
4. Click "Save" to create the task

#### Managing Tasks

- **View Tasks**: All tasks are displayed in a paginated table
- **Filter by Category**: Use the category tabs to filter tasks
- **Update Status**: Click on the status badge to cycle through states
- **Edit Task**: Use the dropdown menu to edit task details
- **Delete Task**: Use the dropdown menu to delete tasks (with confirmation)

#### Task Status States

- **Uncompleted**: Default state for new tasks
- **Completed**: Task has been finished successfully
- **Failed**: Task was not completed successfully

### Category Management

#### Creating Categories

1. Navigate to `/categorys/create`
2. Enter a unique category name
3. Click "Save" to create the category

#### Managing Categories

- **View Categories**: Navigate to `/categorys` to see all categories
- **Edit Category**: Click "Edit" to modify category name
- **Delete Category**: Click "Remove" to delete (only if no tasks are assigned)

### Reporting and Analytics

#### Dashboard Reports

The main dashboard provides:
- Total task count
- Completion statistics
- Monthly progress tracking
- Recent task activity

#### PDF Reports

1. Navigate to the main dashboard
2. Click the "PDF" button
3. A comprehensive PDF report will be generated with:
   - Task statistics
   - Category breakdown
   - Visual charts
   - Detailed task listings

## API Documentation

### Authentication Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/sign-in` | Show login form |
| POST | `/sign-in/store` | Process login |
| GET | `/sign-up` | Show registration form |
| POST | `/sign-up/store` | Process registration |
| GET | `/sign-in/logout` | Logout user |

### Task Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/` | Dashboard/Report | Yes |
| GET | `/tasks/{category}` | List tasks by category | Yes |
| GET | `/tasks/create` | Show create form | Yes |
| POST | `/tasks/store` | Create new task | Yes |
| GET | `/tasks/edit/{task}` | Show edit form | Yes |
| PUT | `/tasks/update/{task}` | Update task | Yes |
| DELETE | `/tasks/destroy/{task}` | Delete task | Yes |
| GET | `/tasks/update-status/{task}` | Toggle task status | Yes |
| GET | `/tasks/print` | Generate PDF report | Yes |

### Category Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/categorys` | List categories | Yes |
| GET | `/categorys/create` | Show create form | Yes |
| POST | `/categorys/store` | Create category | Yes |
| GET | `/categorys/edit/{category}` | Show edit form | Yes |
| POST | `/categorys/update/{category}` | Update category | Yes |
| DELETE | `/categorys/destroy/{category}` | Delete category | Yes |

## Database Schema

### Users Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar(255) | User's full name |
| email | varchar(255) | Unique email address |
| email_verified_at | timestamp | Email verification time |
| password | varchar(255) | Hashed password |
| remember_token | varchar(100) | Remember me token |
| created_at | timestamp | Creation time |
| updated_at | timestamp | Last update time |

### Categories Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar(255) | Category name (unique per user) |
| user_id | bigint | Foreign key to users table |
| created_at | timestamp | Creation time |
| updated_at | timestamp | Last update time |

### Tasks Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar(255) | Task name |
| status | enum | Task status (completed, uncompleted, failed) |
| description | text | Task description (nullable) |
| end_date | date | Task deadline |
| category_id | bigint | Foreign key to categories table (nullable) |
| user_id | bigint | Foreign key to users table |
| created_at | timestamp | Creation time |
| updated_at | timestamp | Last update time |

### Relationships

- **User → Categories**: One-to-Many (A user can have multiple categories)
- **User → Tasks**: One-to-Many (A user can have multiple tasks)
- **Category → Tasks**: One-to-Many (A category can have multiple tasks)
- **Foreign Key Constraints**:
  - Tasks.category_id → Categories.id (SET NULL on delete)
  - Tasks.user_id → Users.id (CASCADE on delete)
  - Categories.user_id → Users.id (CASCADE on delete)

## Security Features

### Data Protection

1. **User Isolation**: All queries are scoped to the authenticated user
2. **CSRF Protection**: All forms include CSRF tokens
3. **SQL Injection Prevention**: Using Eloquent ORM and prepared statements
4. **XSS Protection**: Input sanitization and output escaping
5. **Password Security**: Bcrypt hashing with salt

### Authorization

- Users can only access their own data
- All controllers verify user ownership before operations
- Middleware ensures authentication for protected routes

### Input Validation

- Server-side validation for all forms
- Custom validation rules for business logic
- User-friendly error messages
- Input sanitization and filtering

## Error Handling

### Delete Operation Safeguards

The application implements comprehensive error handling for delete operations:

#### Task Deletion
- Verifies user ownership before deletion
- Uses database transactions for data integrity
- Provides clear success/error messages
- Graceful handling of non-existent tasks

#### Category Deletion
- Prevents deletion of categories with associated tasks
- Clear error messages explaining why deletion failed
- Suggests alternative actions (delete tasks first)
- Maintains referential integrity

### Error Response Format

All errors are handled gracefully with:
- User-friendly error messages
- Proper HTTP status codes
- Redirect to appropriate pages
- Session flash messages for feedback

## Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Categories

1. **Feature Tests**: End-to-end functionality testing
2. **Unit Tests**: Individual component testing
3. **Database Tests**: Data integrity and relationships
4. **Authentication Tests**: Security and access control

## Performance Optimization

### Database Optimization

- Proper indexing on foreign keys
- Eager loading for relationships
- Query optimization with pagination
- Database transactions for consistency

### Caching Strategy

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### Asset Optimization

- CSS/JS minification in production
- Image optimization
- Lazy loading for large datasets
- CDN integration ready

## Deployment

### Production Deployment

1. **Environment Setup**:
   ```bash
   # Set production environment
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize for Production**:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

3. **Web Server Configuration**:
   - Point document root to `/public` directory
   - Configure URL rewriting
   - Set proper file permissions

### Server Requirements

- PHP 8.1+ with required extensions
- MySQL 5.7+ or PostgreSQL 9.6+
- Web server (Apache/Nginx)
- SSL certificate (recommended)

## Troubleshooting

### Common Issues

1. **Database Connection Error**:
   - Verify database credentials in `.env`
   - Ensure database server is running
   - Check firewall settings

2. **Permission Errors**:
   ```bash
   # Fix storage permissions
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

3. **Asset Loading Issues**:
   ```bash
   # Clear and rebuild assets
   npm run build
   php artisan view:clear
   ```

4. **Delete Operations Not Working**:
   - Check JavaScript console for errors
   - Verify CSRF tokens are included
   - Ensure proper route definitions

### Debug Mode

Enable debug mode for development:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## Contributing

### Development Workflow

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write/update tests
5. Submit a pull request

### Code Standards

- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Add comments for complex logic
- Write comprehensive tests

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/new-feature

# Make commits with descriptive messages
git commit -m "Add: New feature description"

# Push and create pull request
git push origin feature/new-feature
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions:
- Create an issue in the repository
- Check the documentation
- Review existing issues for solutions

## Changelog

### Version 1.0.0
- Initial release with core functionality
- User authentication system
- Task and category management
- Reporting and PDF generation
- Responsive design implementation
