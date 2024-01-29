<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$id = $_POST['id'];
$table = new UsersTable(new MySQL);
$table->add([
    "title" => $_POST['title'],
    "category" => $_POST['category'],
    "date" => $_POST['date'],
    "income" => $_POST['income'],
    "expenses" => $_POST['expenses'],
]);

HTTP::redirect('/main.php');