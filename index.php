<?php 
    require_once('includes/DB.php');

    $search = $_GET['search'] ?? null;

    if($search){
        $statement = $ConnectingDB->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
        $statement->bindValue(':title', "%$search%");
    } else {
        $statement = $ConnectingDB->prepare('SELECT * FROM products ORDER BY create_date DESC');
    }
    
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>CRUD</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Products CRUD</h1>

        <p>
            <a href="create.php" class="btn btn-success">Create Product</a>
        </p>

        <form>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search for products" name="search"
                    value="<?php echo $search; ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Create Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($products as $i => $product){
                ?>
                <tr>
                    <th scope="row"><?php echo $i + 1 ?></th>
                    <td><img src="<?php echo $product['image'] ?>" width="100px"></td>
                    <td><?php echo $product['title'] ?></td>
                    <td><?php echo $product['price'] ?></td>
                    <td><?php echo $product['create_date'] ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary">Edit</a>
                        <form style="display: inline-block;" method="POST" action="delete.php">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>