# Banking System 


#### Setup Project
```bash
# clone the repo
git clone https://github.com/tarikulIslamNahid/banking.git

# install composer dependency
composer install

# create a environment file
cp .env.example .env

# set the Application key
php artisan key:generate

# set your APP_BASE_URL path in .env
APP_BASE_URL = 127.0.0.1:8000


# setup the database credentials and migrate database
php artisan migrate

# run the application
php artisan serve

# swagger api documentation url
${APP_BASE_URL}/api/documentation
