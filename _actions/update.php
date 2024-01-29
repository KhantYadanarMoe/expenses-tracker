<?php

$id = $_POST['id'];
$title = $_POST['title'];
$category = $_POST['category'];
$date = $_POST['date'];
$income = $_POST['income'];
$expenses = $_POST['expenses'];
$balance = $_POST['balance'];

$db = new PDO('mysql:dbhost=localhost;dbname=expenses_db', 'root', '');
$db->query("UPDATE expenses SET title='$title', category='$category' , date='$date', income='$income', expenses='$expenses' WHERE id='$id'");

header("Location: ../main.php");

?>