<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdb";

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    echo "coulnt connect";
}

$sql = "INSERT INTO person(fname,lastname,age,salary,address) VALUES('Md. Rifat','Hossain',21,1000000,'Dhaka, Bangladesh')";
if($conn->query($sql)===TRUE){
    echo "Data inserted";
}
else{
    echo "data cant be inserted".$conn->error;
}



?>