<?php

$id = $_GET['id'];
$sql = "DELETE FROM expenses WHERE id = $id";

$db = new PDO('mysql:dbhost=localhost;dbname=expenses_db', 'root', '');
$db->query($sql);

header('Location: ../main.php');

