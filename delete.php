<?php 
    require_once('includes/DB.php');
    $id = $_POST['id'] ?? null;

    if(!$id){
        header('Location: index.php');
        exit;
    }

    $statement = $ConnectingDB->prepare('DELETE FROM products WHERE id = :id');
    $statement->bindValue(':id', $id);
    $statement->execute();
    header('Location: index.php');
?>