<?php
session_start();
include('functions.php');

$showLoginForm = true;
$welcomeMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $usersData = json_decode(file_get_contents('users.json'), true);

        foreach ($usersData as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $showLoginForm = false;
                $welcomeMessage = 'Welcome <a href="user_details.php?id=' . $user['id'] . '">' . $user['username'] . '</a>!, Money: $' . $user['money'] . '.';
                break;
            }
        }
        if ($showLoginForm) {
            $errorMessage = 'Invalid username or password. Please try again.';
        }
    } elseif (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Card Trading</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to Pokémon Card Trading</h1>
    <h2>This is a platform for trading Pokémon cards.</h2>

    <?php
    if (!empty($errorMessage)) {
        echo '<p style="color: red;">' . $errorMessage . '</p>';
    }

    if ($showLoginForm) {
        echo '<form action="index.php" method="post">';
        echo '<label for="username">Username:</label>';
        echo '<input type="text" name="username" required>';
        echo '<label for="password">Password:</label>';
        echo '<input type="password" name="password" required>';
        echo '<button type="submit" name="login">Log In</button>';
        echo '</form>';
    } else {
        echo '<form action="index.php" method="post">';
        echo '<p>' . $welcomeMessage . '</p>';
        echo '<button type="submit" name="logout">Logout</button>';
        echo '</form>';
        
        echo '<div class="table-container">';
        $cards = getAllCards();
        foreach ($cards as $card) {
            echo '<div class="card">';
            echo '<img src="' . $card['image_url'] . '" alt="' . $card['name'] . '">';
            echo '<p>' . $card['name'] . '</p>';
            echo '<a href="card_details.php?id=' . $card['id'] . '">View Details</a>';

            if (isLoggedIn() && $card['owner_id'] == 1 && $_SESSION['id'] != 1) {
                echo '<form action="buy_card.php" method="post">';
                echo '<input type="hidden" name="card_id" value="' . $card['id'] . '">';
                echo '<button class="buy-button" type="submit" name="buy">Buy</button>';
                echo '</form>';
            }

            echo '</div>';
        }
        echo '</div>';

        if (isLoggedIn() && $_SESSION['id'] == 1) {
            echo '<div class="card create-card-form">';
            echo '<h2>Create a New Card</h2>';
            echo '<form action="create_card.php" method="post">';
            echo '<label for="card_name">Card Name:</label>';
            echo '<input type="text" name="card_name" required>';
            
            echo '<label for="image_url">Image URL:</label>';
            echo '<input type="text" name="image_url" required>';
        
            echo '<label for="price">Price:</label>';
            echo '<input type="number" name="price" required>';
        
            echo '<label for="hp">HP:</label>';
            echo '<input type="number" name="hp" required>';
        
            echo '<label for="element">Element:</label>';
            echo '<input type="text" name="element" required>';
        
            echo '<label for="element_color">Element Color:</label>';
            echo '<input type="text" name="element_color" required>';
        
            echo '<button type="submit" name="create_card">Create Card</button>';
            echo '</form>';
            echo '</div>';
        }
        
        echo '</div>';
    }
    ?>

</body>
</html>
