## Installation

* Clone this repo to your PC
* Run ```composer install```
* Fill .env file
* Run ```php artisan migrate```
* Run ```php artisan db:seed```
* Run ```php artisan serve```
* Open new terminal window
* Run ```npm i```
* Run ```npm run dev```
* Install and run stripe CLI to recieve webhoks [https://stripe.com/docs/stripe-cli](https://stripe.com/docs/stripe-cli)
* Run stripe listen --forward-to http://localhost:8000/stripe/webhook

## Stripe Integration

For stripe integration Laravel Cashier was choosen because it meets requirements for this project(handles webhooks (signature verification, events), creates migrations etc) and it is official Laravel package.