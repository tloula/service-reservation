<?php

include("config.php");

$service = $mysqli->real_escape_string($_GET['service']);

/******************** LOAD SERVICES ********************/
class service {
    public $id;
    public $dt;
    public $prettydt;
    public $reserved;

    function __construct($id, $dt, $prettydt, $reserved){
        $this->id = $id;
        $this->dt = $dt;
        $this->prettydt = $prettydt;
        $this->reserved = $reserved;
    }
}

class reservation {
    public $timestamp;
    public $first;
    public $last;
    public $email;
    public $seats;

    function __construct($timestamp, $first, $last, $email, $seats){
        $this->timestamp = $timestamp;
        $this->first = $first;
        $this->last = $last;
        $this->email = $email;
        $this->seats = $seats;
    }
}

$services = array();
$reservations = array();

try {

    // Load service
    $stmt = $mysqli->prepare("SELECT * FROM services");
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $services[$row['dt']] = new service($row['id'], $row['dt'], date( 'l, F j Y, g:i A', strtotime($row['dt'])), $row['reserved']);
    }
    if(!$services) throw new Exception("Critical Error: Cannot find services.");
    $stmt->close();

    // Load service details
    $stmt = $mysqli->prepare("SELECT * FROM reservations WHERE service = ?");
    $stmt->bind_param("i", $service);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $reservations[$row['id']] = new reservation($row['timestamp'], $row['first'], $row['last'], $row['email'], $row['seats']);
    }
    if(!$reservations) throw new Exception("Critical Error: Cannot find reservations.");
    $stmt->close();

} catch (Exception $e){
    $message = $e->getMessage();
}

/******************** SEND JSON RESPONSE ********************/
class json {
    public $services;
    public $reservations;

    function __construct($services, $reservations){
        $this->services = $services;
        $this->reservations = $reservations;
    }
}

echo json_encode(new json($services, $reservations));

?>