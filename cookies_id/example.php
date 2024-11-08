<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];

    // Display the received data
    echo "First Name: " . $firstname . "<br>";
    echo "Last Name: " . $lastname . "<br>";
}
