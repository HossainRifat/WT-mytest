<?php
session_start();

echo $_SESSION["fname"];
$_POST["fname"] = $_SESSION["fname"];

?>