SENIOR SOFTWARE ENGINEER - PHP/LARAVEL (SOHAIL AHMAD)

Setup steps:

1. clone project
2. composer install
3. cp .env.example .env
4. php artisan migrate
5. php artisan db:seed
6. ./vendor/bin/phpunit


Documentation of Code

1. products table is created for storing products data, have written a seeder for products so at first there will be 1 product which is burger.
2. ingredients table is created for storing ingredients data, have written a seeder for ingredients so at first there will be 3 ingredients with total and consumed amounts
3. product_ingredients bridge table is created for storing ingredients of a product
4. orders table is created to store basic information of order like id and creation dates
5. order_products table is created to store order details like products, quantity etc.
6. OrderController, OrderService and OrderRepository have a create method for handling order request
7. OrderRepository interacts with the database and store order, update ingredients amount consumed and checks if ingredient level reaches below 50% then send one-time email to merchant
8. OrderRequest is injected in create method of OrderController to apply validations on request payload like checking if mentioned product_ids exists in the system, quantity is greater than equal to 1, and payload is okay
9. OrderControllerTest and BaseTestCase classes are created for handling unitTests of OrderController
