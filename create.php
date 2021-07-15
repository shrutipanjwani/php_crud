<?php 
    require_once('includes/DB.php');
    $errors = [];
    $title = '';
    $price = '';
    $description = '';
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $date = date('Y-m-d H:i:s');
    
        if(!$title){
            $errors[] = 'Product Title is required';
        }

        if(!$price){
            $errors[] = 'Product Price is required';
        }

        if(!is_dir('images')){
            mkdir('images');
        }

        if(empty($errors)){
            $image = $_FILES['image'] ?? null;
            $imagePath = '';
            if($image && $image['tmp_name']){

                $imagePath = 'images/'.randomString(8).'/'.$image['name'];

                mkdir(dirname($imagePath));

                move_uploaded_file($image['tmp_name'], $imagePath);
            }

            $statement = $ConnectingDB->prepare("INSERT INTO products(title, image, description, price, create_date) VALUES (:title, :image, :description, :price, :date)");
            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', $date);
            $statement->execute();
            header('Location: index.php');
        }
    }

    function randomString($n){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for($i = 0; $i < $n; $i++){
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }
        return $str;
    }

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
        <h1 class="text-center">Create new product</h1>
        <?php if (!empty($errors)){ ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error){?>
            <div><?php echo $error; ?></div>
            <?php  } ?>
        </div>
        <?php } ?>

        <form action="create.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Product Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Product Description</label>
                <textarea class="form-control" name="description">
                    <?php echo $description; ?>
                </textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Product Price</label>
                <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $price; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>