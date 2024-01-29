<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Role</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <?php 
        $id = $_GET['id'];
        $db = new PDO('mysql:dbhost=localhost;dbname=expenses_db', 'root', '');
        $result = $db->query("SELECT * FROM expenses WHERE id=$id");
        $role = $result->fetch();
    ?>

    <div class="container">
        <h1 class="text-center m-3 h3 text-primary">Edit Form</h1>
        <form action="update.php" method="post" class="mb-3">
            <input type="hidden" name="id" value=<?= $role['id'] ?>> <br>
            <input type="text" name="title" placeholder="Title" class="form-control mb-3" value="<?= $role['title'] ?>"> <br>
            <input type="text" name="category" placeholder="Category" class="form-control mb-3" value="<?= $role['category'] ?>"> <br>
            <input type="text" name="date" placeholder="Date" class="form-control mb-3" value="<?= $role['date'] ?>"> <br>
            <input type="text" name="income" placeholder="Income" class="form-control mb-3" value="<?= $role['income'] ?>"> <br>
            <input type="text" name="expenses" placeholder="Expenses" class="form-control mb-3" value="<?= $role['expenses'] ?>"> <br>
            <input type="hidden" name="balance" placeholder="Balance" value="<?= $role['balance'] ?>"> <br>
            <button class="btn btn-primary w-100">Edit</button>
        </form>
    </div>
</body>
</html>
