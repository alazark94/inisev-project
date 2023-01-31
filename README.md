# Inisev-Project

This is a show case of coding skill for Inisev. To run the project first clone the repo.

```
git clone https://github.com/alazark94/inisev-project.git
```

After doing so you should copy the `.env.example` to `.env`

After that please edit the database configuration and email configuration as per your details.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inisev_project
DB_USERNAME=alazar
DB_PASSWORD=password

MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@inisev.com"
MAIL_FROM_NAME="${APP_NAME}"
```

After filling the variables with your database and mail server details run the database migration and seeder

```
php artisan migrate --seed
```

After that your database will be migrated and filled with dummy data.

Now that everything is ready test it using

```
php artisan test
```

To subscribe new user to a website you should hit the `/api/websites/{websiteId}/subscribe` endpoint with `POST` request.

_Attributes_

| Field   | Type   | Required | Note                |
| ------- | ------ | -------- | ------------------- |
| `name`  | string |          | -                   |
| `email` | string | &check;  | Unique, Valid Email |

To Create a new post for a website you should hit the `/api/websites/{websiteId}/posts` with a `POST` request.

_Attributes_

| Field   | Type   | Required | Note                           |
| ------- | ------ | -------- | ------------------------------ |
| `title` | string | &check;  | Must be at least 15 characters |
| `body`  | text   | &check;  | Must be at least 50 characters |
