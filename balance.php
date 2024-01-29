<?php
// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'expenses_db';


$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

// // Get the total balance from the database
// $sql = 'SELECT SUM(balance) AS total_balance FROM expenses';
// $result = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);
// $total_balance = $row['total_balance'];

// Function to get total income
function getTotalIncome($conn) {
    $sql = 'SELECT SUM(income) AS total_income FROM expenses';
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_income'];
}

// Function to get total expenses
function getTotalExpenses($conn) {
    $sql = 'SELECT SUM(expenses) AS total_expenses FROM expenses';
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_expenses'];
}

// Function to calculate total balance
function calculateTotalBalance($income, $expenses) {
    return $income - $expenses;
}

$total_income = getTotalIncome($conn);
$total_expenses = getTotalExpenses($conn);
$total_balance = calculateTotalBalance($total_income, $total_expenses);

// Update the balance in the expenses table
$sql = "UPDATE expenses SET balance = balance - expenses + income WHERE id = LAST_INSERT_ID()";
mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);

?>