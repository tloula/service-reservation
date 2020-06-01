<?php

/******************** CONSTANTS ********************/
const CAPACITY = 50;
const EMAIL = "office@westchesterbiblechurch.org";
const SERVICE1 = "Thursday 7:00 PM";
const SERVICE2 = "Sunday 9:00 AM";
const SERVICE3 = "Sunday 10:45 AM";
const OFFSET = "-1 hour";   // Offset from ETC

/******************** CONNECT TO DATABASE ********************/
const DB_SERVER = '';
const DB_USERNAME = '';
const DB_PASSWORD = '';
const DB_DATABASE = '';
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die ("Database connection error");

?>