<?php

include("config.php");

function seat($x){
    if($x > 1){
        return " seats";
    } else {
        return " seat";
    }
}

/******************** PROCESS REGISTRATION REQUEST ********************/
$service = $mysqli->real_escape_string($_POST['service']);
$first = $mysqli->real_escape_string($_POST["first"]);
$last = $mysqli->real_escape_string($_POST["last"]);
$email = $mysqli->real_escape_string($_POST["email"]);
$requested = $mysqli->real_escape_string($_POST["seats"]);

// Select service
switch($service){
    case 1:
        $service = date("Y-m-d H:i:s", strtotime(SERVICE1));
    break;
    case 2:
        $service = date("Y-m-d H:i:s", strtotime(SERVICE2));
    break;
    case 3:
        $service = date("Y-m-d H:i:s", strtotime(SERVICE3));
    break;
}

try {
    $stmt = $mysqli->prepare("SELECT id FROM services WHERE dt = ?");
    $stmt->bind_param("s", $service);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows === 0) throw new Exception("Critical Error: Cannot find service.");
    $stmt->bind_result($service);
    $stmt->fetch();
    $stmt->close();
    
    // Init vars
    $status = 1;
    $message = "Critical Error: Default Message";

    // Check availablity
    $stmt = $mysqli->prepare("SELECT dt, reserved FROM services WHERE id = ?");
    $stmt->bind_param("i", $service);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows === 0) throw new Exception('Critical Error: Empty services table.');
    $stmt->bind_result($time, $reserved);
    $stmt->fetch();
    $stmt->close();

    $serviceTime = date( 'l, F j Y, g:i A', strtotime($time));
    $available = CAPACITY - $reserved;
    if($available < $requested){
        if($available == 0){
            throw new Exception("There are no seats available in the selected service. Please try a different service.");
        } else {
            throw new Exception("Only " . $available . seat($available) . " are available in the selected service. Please try a different service.");
        }
    }

    // Check email, allow office email to register multiple people
    if ($email != EMAIL){
        $stmt = $mysqli->prepare("SELECT seats FROM reservations WHERE email = ? AND service = ?");
        $stmt->bind_param("ss", $email, $service);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows != 0){
            $stmt->bind_result($seats);
            $stmt->fetch();
            $stmt->close();
            throw new Exception("You have aleady reserved " . $seats . seat($seats) . " for the " . $serviceTime ." service.");
        }
        $stmt->close();
    }

} catch (Exception $e){
    $status = 0;
    $message = $e->getMessage();
}

if($status){
    // Add registration to table
    $stmt = $mysqli->prepare("INSERT INTO reservations (service, first, last, email, seats) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $service, $first, $last, $email, $requested);
    $stmt->execute();
    $stmt->close();

    // Update service reserved seats
    $new = $reserved + $requested;
    $stmt = $mysqli->prepare("UPDATE services SET reserved = ? WHERE id = ?");
    $stmt->bind_param("ii", $new, $service);
    $stmt->execute();
    $stmt->close();

    // Success
    $status = 1;
    $message = "Sucessfully reserved your " . $requested . seat($requested) . " for the " . $serviceTime . " service.";
}

$mysqli->close();

/******************** SEND JSON RESPONSE ********************/
class json {
    public $status;
    public $message;

    function __construct($status, $message){
        $this->status = $status;
        $this->message = $message;
    }
}

echo json_encode(new json($status, $message));

?>