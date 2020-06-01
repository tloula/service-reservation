# Church Service Seat Reservation API

HTML | JavaScript | jQuery | PHP | MySQL

## About
As churches begin to reopen for in-person services following COVID-19, many churches are choosing to impose a limit on their service capacity in order to stay well within their government guidelines. This simple web API provides a means for individuals to reserve seats for their group and records expected attendence for each service. If a particular service is full, it alerts the user and recommends that they reserve seats in a different service.

<a href="https://westchesterbiblechurch.org/service-reservation" target="_blank">
<img src="https://github.com/tloula/service-reservation/blob/master/screenshot.png" /></a>

### Referrals
The system also has a referral feature: regular attenders who are referred to the form through a church communication are asked to reserve the main service for visitors.

<a href="https://westchesterbiblechurch.org/service-reservationn?ref=bulletin" target="_blank">
<img src="https://github.com/tloula/service-reservation/blob/master/screenshot-ref.png" /></a>

### Admin Panel
A simple admin panel shows an overview of total service reservations, as well as details of who registered for each particular service.

<img src="https://github.com/tloula/service-reservation/blob/master/screenshot-admin.png" />

## Install

### User Form
* Copy and paste the code from the form.html file onto the desired webpage and update the `action=""` link. May need to customize the CSS.
* Add the referral div: `div id="ref"></div>`
* Include the required JavaScript: `script src="process.js"></script>`

### Admin Panel
* Add the services div: `<div id="services"></div>`
* Add the reservations div: `<div id="details"></div>`
* Include the required JavaScript `<script src="../apps/service-registration/admin.js"></script>`

### Backend
* Setup the database using the [tables.sql](tables.sql) file
* Setup the [config.php](config.php) file
  * The email constant denotes an email that bypasses the registration limit filter
* Customize the CSS classes of the alerts in [process.js](process.js)
* Change the path the the admin.php file in [admin.js](admin.js)
