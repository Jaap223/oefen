<?php 
session_start();
require_once 'head/head.php';
require_once 'data/db.php';
require_once 'data/db.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>head</title>
</head>

<body>

    <?php echo 'Welcome, ' . $_SESSION['naam'] . '!'; ?>
    <?php
    if (isset($_SESSION['inloggen']) && $_SESSION['inloggen']) {
        echo '<a href="Login.php">Logout</a>';
    }
    ?>
    <div class="welkom">
        <h1>Welkom !</h1>

        <p>Over ons:
            .</p>

    </div>


</body>
<main>
    <section>
        <article class="info">

        </article>
    </section>

</main>