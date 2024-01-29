<?php
    include("vendor/autoload.php");
    include 'balance.php';

    use Helpers\Auth;
    $auth = Auth::check();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Tracker</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a href="#" class="navbar-brand d-none d-lg-block">Expenses Tracker</a>
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav"> -->
                <form action="" method="get" class="ml-auto mr-2">
                    <div class="input-group mb-2 mt-2">
                        <input type="text" class="form-control" placeholder="Search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary text-light" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a href="add.php" class="nav-link">
                        <span class="nav-item text-light" id="clear">Add</span>
                    </a>
                    </li>
                </ul>
            <!-- </div> -->
        </div>
    </nav>

    <div class="container mt-3">
        <h5 class="float-end">
            Total Balance: <?php echo $total_balance; ?>
        </h5>
    </div>

    <?php

    // Get the search query from the URL
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'expenses_db');
    // Build the SQL query
    $sql = "SELECT * FROM expenses WHERE title LIKE '%$search%' OR category LIKE '%$search%' OR date LIKE '%$search%'";

    // Execute the query and fetch the results
    $result = mysqli_query($conn, $sql);
    $expenses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[] = $row;
    }

    // Close the database connection
    mysqli_close($conn);

    ?>

    <?php if ($search) : ?>

        <div class="container table-container mt-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Income</th>
                        <th>Expenses</th>
                        <th>Balance</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($expenses as $expense) : ?>
                        <tr>
                            <td><?= htmlspecialchars($expense['title']); ?></td>
                            <td><?= htmlspecialchars($expense['category']); ?></td>
                            <td><?= htmlspecialchars($expense['date']); ?></td>
                            <td><?= htmlspecialchars($expense['income']); ?></td>
                            <td><?= htmlspecialchars($expense['expenses']); ?></td>
                            <td><?php echo $expense['income'] - $expense['expenses']; ?></td>
                            <td colspan="2">
                                <a href="_actions/del.php?id= <?= $expense['id'] ?>"><button class="btn btn-danger">Del</button></a>
                                <a href="_actions/edit.php?id= <?= $expense['id'] ?>"><button class="btn btn-success">Edit</button></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        

    <?php else : ?>

        <div class="container mt-5">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Income</th>
                            <th>Expenses</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        <?php 
                        // usort($expenses, function($a, $b) {
                        //     return $b['id'] - $a['id'];
                        // });
                        usort($expenses, function($a, $b) {
                            $date1 = new DateTime($a['date']);
                            $date2 = new DateTime($b['date']);
                            return $date2 < $date1 ? -1 : ($date2 > $date1 ? 1 : 0);
                        });
                        
                        foreach ($expenses as $expense): ?>
                            <tr>
                            <td><?php echo $expense['title']; ?></td>
                            <td><?php echo $expense['category']; ?></td>
                            <td><?php echo $expense['date']; ?></td>
                            <td><?php echo $expense['income']; ?></td>
                            <td><?php echo $expense['expenses']; ?></td>
                            <td><?php echo $expense['income'] - $expense['expenses']; ?></td>
                                <td colspan="2">
                                    <a href="_actions/del.php?id= <?= $expense['id'] ?>"><button class="btn btn-danger">Del</button></a>
                                    <a href="_actions/edit.php?id= <?= $expense['id'] ?>"><button class="btn btn-success">Edit</button></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    
    <?php endif; ?>
    
    <div class="container mt-5">
        <a id="download-pdf" class="btn btn-success text-light">Change to PDF</a>
        <a href="_actions/logout.php" class="btn btn-danger float-end text-light">logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBud7TlRbs/ic4AwGcFZOxg5DpPt8EgeUIgIwzjWfXQKWA3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

    <script>
        document.getElementById('download-pdf').addEventListener('click', function() {
            // Make AJAX request to PHP script
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'generate-pdf.php', true);
            xhr.responseType = 'arraybuffer';

            xhr.onload = function() {
            if (this.status === 200) {
                // Create link element and set href attribute to PDF file
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(new Blob([this.response], { type: 'application/pdf' }));
                link.download = 'my-table.pdf';

                // Simulate click on link element to trigger download
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
            };

            xhr.send();
        });
    </script>

</body>
</html>