<?php

session_start();

$_SESSION["username"] = "benji182";
$_SESSION["userpassword"] = "123awdS%";
echo "Session variables are set <br>";

echo "Username is: " . $_SESSION["username"] . "<br>";
echo "Password is: " . $_SESSION["userpassword"];
