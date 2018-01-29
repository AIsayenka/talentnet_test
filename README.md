# Rest api

To get it up and running

### Dependencies

    composer install

### Create the database

    php bin/console doctrine:database:create

### Import the database

    php bin/console doctrine:database:import ./_DB_DUMP/db_dump.sql

### Create SSH KEYS with the passphrase you used while downloading the dependancies

``` bash
  $ mkdir var/jwt
  $ openssl genrsa -out var/jwt/private.pem -aes256 4096
  $ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```

#That's it. Now explanation of the login and routes

The whole idea is that the data was got from https://github.com/TalentNet/coding-challenges/blob/master/roles/senior-php.md

All the actions, which require authorization, you will need to set up "Authorization" header with "Bearer " prefix with the JWT token value following it.

### To get the token, please create a post request, such as this one

    curl -X POST http://localhost:8000/api/getToken -d _username=bobby_fischer -d _password=testo


#Routes list:
  - /api/getToken - POST route for acquiring JWT tokens

  ## Products
  - /api/products/all - GET route for getting the information about all the products in the DB
  - /api/products/{id} - GET route for getting the information about specific product
  - /api/products/create - POST route for creating a record about a product (Requires JWT authorization token)
  - /api/products/{id}/update - PATCH or PUT route for updating information in a record related to a product (Requires JWT authorization token)
  - /api/products/{id}/delete - DELETE route for removal of a record related to a product (Requires JWT authorization token)

  ## Categories
  - /api/categories/all - GET route for getting the information about all the categories in the DB
  - /api/categories/{id} - GET route for getting the information about specific category_id

  P.S. Test cases are in development at the moment
