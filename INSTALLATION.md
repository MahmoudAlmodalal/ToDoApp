# Installation Guide - Laravel Task Management System

This comprehensive guide will walk you through the complete installation process of the Laravel Task Management System, from system requirements to final deployment.

## System Requirements

### Minimum Requirements

- **Operating System**: Linux, macOS, or Windows
- **PHP**: Version 8.1 or higher
- **Memory**: 512MB RAM minimum (1GB recommended)
- **Storage**: 100MB free disk space
- **Database**: MySQL 5.7+ or PostgreSQL 9.6+

### Required PHP Extensions

Ensure the following PHP extensions are installed and enabled:

```bash
# Check PHP version
php --version

# Check installed extensions
php -m | grep -E "(bcmath|ctype|curl|dom|fileinfo|json|mbstring|openssl|pcre|pdo|tokenizer|xml)"
```

Required extensions:
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

### Installing Missing Extensions

#### Ubuntu/Debian
```bash
sudo apt update
sudo apt install php8.1-bcmath php8.1-ctype php8.1-curl php8.1-dom php8.1-fileinfo php8.1-json php8.1-mbstring php8.1-openssl php8.1-pcre php8.1-pdo php8.1-tokenizer php8.1-xml
```

#### CentOS/RHEL
```bash
sudo yum install php-bcmath php-ctype php-curl php-dom php-fileinfo php-json php-mbstring php-openssl php-pcre php-pdo php-tokenizer php-xml
```

#### Windows (using XAMPP)
Most extensions are included by default. Enable them in `php.ini` by uncommenting the relevant lines.

## Installation Methods

### Method 1: Using Composer (Recommended)

#### Step 1: Install Composer

**Linux/macOS:**
```bash
# Download and install Composer globally
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verify installation
composer --version
```

**Windows:**
Download and run the Composer installer from [getcomposer.org](https://getcomposer.org/download/)

#### Step 2: Create New Laravel Project

```bash
# Create project directory
mkdir laravel-task-management
cd laravel-task-management

# Extract the provided project files
unzip laravel_project.zip
cd laravel_project

# Install dependencies
composer install
```

### Method 2: Manual Installation

#### Step 1: Extract Project Files

```bash
# Create project directory
mkdir /var/www/laravel-task-management
cd /var/www/laravel-task-management

# Extract project files
unzip laravel_project.zip
cd laravel_project

# Set proper permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache
```

#### Step 2: Install Dependencies

```bash
# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies (if needed)
npm install --production
```

## Database Setup

### MySQL Setup

#### Step 1: Install MySQL

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install mysql-server
sudo mysql_secure_installation
```

**CentOS/RHEL:**
```bash
sudo yum install mysql-server
sudo systemctl start mysqld
sudo systemctl enable mysqld
sudo mysql_secure_installation
```

#### Step 2: Create Database

```bash
# Login to MySQL
mysql -u root -p

# Create database and user
CREATE DATABASE laravel_tasks;
CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON laravel_tasks.* TO 'laravel_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### PostgreSQL Setup (Alternative)

#### Step 1: Install PostgreSQL

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install postgresql postgresql-contrib
```

#### Step 2: Create Database

```bash
# Switch to postgres user
sudo -u postgres psql

# Create database and user
CREATE DATABASE laravel_tasks;
CREATE USER laravel_user WITH PASSWORD 'secure_password';
GRANT ALL PRIVILEGES ON DATABASE laravel_tasks TO laravel_user;
\q
```

## Environment Configuration

### Step 1: Copy Environment File

```bash
# Copy the example environment file
cp .env.example .env
```

### Step 2: Generate Application Key

```bash
# Generate unique application key
php artisan key:generate
```

### Step 3: Configure Environment Variables

Edit the `.env` file with your specific settings:

```env
# Application Settings
APP_NAME="Laravel Task Management"
APP_ENV=local
APP_KEY=base64:generated_key_here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_tasks
DB_USERNAME=laravel_user
DB_PASSWORD=secure_password

# Database Configuration (PostgreSQL Alternative)
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=laravel_tasks
# DB_USERNAME=laravel_user
# DB_PASSWORD=secure_password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Session Configuration
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Cache Configuration
CACHE_DRIVER=file

# Queue Configuration
QUEUE_CONNECTION=sync
```

## Database Migration

### Step 1: Run Migrations

```bash
# Run database migrations
php artisan migrate

# If you encounter any issues, you can reset and migrate
php artisan migrate:fresh
```

### Step 2: Verify Migration

```bash
# Check migration status
php artisan migrate:status

# Expected output should show all migrations as "Ran"
```

### Step 3: Seed Database (Optional)

```bash
# Run database seeders for sample data
php artisan db:seed

# Or run specific seeder
php artisan db:seed --class=UserSeeder
```

## Asset Compilation

### Step 1: Install Node.js

**Ubuntu/Debian:**
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

**CentOS/RHEL:**
```bash
curl -fsSL https://rpm.nodesource.com/setup_18.x | sudo bash -
sudo yum install -y nodejs
```

**Windows:**
Download and install from [nodejs.org](https://nodejs.org/)

### Step 2: Install Dependencies

```bash
# Install Node.js dependencies
npm install

# For production
npm install --production
```

### Step 3: Compile Assets

```bash
# For development
npm run dev

# For production
npm run build

# Watch for changes (development)
npm run watch
```

## Web Server Configuration

### Apache Configuration

#### Step 1: Enable Required Modules

```bash
# Enable mod_rewrite
sudo a2enmod rewrite

# Restart Apache
sudo systemctl restart apache2
```

#### Step 2: Create Virtual Host

Create `/etc/apache2/sites-available/laravel-tasks.conf`:

```apache
<VirtualHost *:80>
    ServerName laravel-tasks.local
    DocumentRoot /var/www/laravel-task-management/laravel_project/public

    <Directory /var/www/laravel-task-management/laravel_project/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/laravel-tasks_error.log
    CustomLog ${APACHE_LOG_DIR}/laravel-tasks_access.log combined
</VirtualHost>
```

#### Step 3: Enable Site

```bash
# Enable the site
sudo a2ensite laravel-tasks.conf

# Disable default site (optional)
sudo a2dissite 000-default.conf

# Restart Apache
sudo systemctl restart apache2
```

### Nginx Configuration

Create `/etc/nginx/sites-available/laravel-tasks`:

```nginx
server {
    listen 80;
    server_name laravel-tasks.local;
    root /var/www/laravel-task-management/laravel_project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/laravel-tasks /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

## File Permissions

### Set Proper Permissions

```bash
# Navigate to project directory
cd /var/www/laravel-task-management/laravel_project

# Set ownership
sudo chown -R www-data:www-data .

# Set directory permissions
sudo find . -type d -exec chmod 755 {} \;

# Set file permissions
sudo find . -type f -exec chmod 644 {} \;

# Set special permissions for storage and cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# Make artisan executable
sudo chmod +x artisan
```

## Testing Installation

### Step 1: Start Development Server

```bash
# Navigate to project directory
cd /var/www/laravel-task-management/laravel_project

# Start Laravel development server
php artisan serve

# Or specify host and port
php artisan serve --host=0.0.0.0 --port=8000
```

### Step 2: Access Application

Open your web browser and navigate to:
- Development server: `http://localhost:8000`
- Virtual host: `http://laravel-tasks.local`

### Step 3: Verify Functionality

1. **Registration**: Create a new user account
2. **Login**: Sign in with your credentials
3. **Create Category**: Add a new task category
4. **Create Task**: Add a new task
5. **Test Delete**: Try deleting a task and category

## Production Deployment

### Step 1: Optimize for Production

```bash
# Set production environment
sed -i 's/APP_ENV=local/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env

# Install production dependencies
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compile production assets
npm run build
```

### Step 2: Security Hardening

```bash
# Set restrictive permissions
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache

# Hide sensitive files
echo "deny from all" | sudo tee storage/.htaccess
echo "deny from all" | sudo tee .env.htaccess
```

### Step 3: SSL Configuration

For production, configure SSL:

```nginx
server {
    listen 443 ssl http2;
    server_name your-domain.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    # ... rest of configuration
}

server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}
```

## Troubleshooting

### Common Issues and Solutions

#### 1. Permission Denied Errors

```bash
# Fix storage permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

#### 2. Database Connection Failed

```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check database credentials in .env file
# Verify database server is running
sudo systemctl status mysql
```

#### 3. Composer Install Fails

```bash
# Clear Composer cache
composer clear-cache

# Update Composer
composer self-update

# Install with verbose output
composer install -vvv
```

#### 4. Assets Not Loading

```bash
# Clear view cache
php artisan view:clear

# Rebuild assets
npm run build

# Check file permissions
ls -la public/
```

#### 5. 500 Internal Server Error

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check web server error logs
sudo tail -f /var/log/apache2/error.log
# or
sudo tail -f /var/log/nginx/error.log
```

### Debug Mode

For troubleshooting, enable debug mode:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

Remember to disable debug mode in production!

## Performance Optimization

### Caching

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Clear all caches
php artisan optimize:clear
```

### Database Optimization

```sql
-- Add indexes for better performance
CREATE INDEX idx_tasks_user_id ON tasks(user_id);
CREATE INDEX idx_tasks_category_id ON tasks(category_id);
CREATE INDEX idx_categories_user_id ON categories(user_id);
```

## Backup and Maintenance

### Database Backup

```bash
# Create backup script
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u laravel_user -p laravel_tasks > backup_$DATE.sql
```

### Log Rotation

```bash
# Add to crontab for log rotation
0 0 * * * cd /var/www/laravel-task-management/laravel_project && php artisan log:clear
```

This completes the comprehensive installation guide. Follow these steps carefully, and you should have a fully functional Laravel Task Management System running on your server.

