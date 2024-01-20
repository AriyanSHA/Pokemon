<?php
session_start();
include('functions.php');

if (isset($_GET['id'])) {
    $cardId = $_GET['id'];
    $cards = getAllCards();

    if (isset($cards[$cardId - 1])) {
        $card = $cards[$cardId - 1];
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Details - Pokémon Card Trading</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: <?php echo $card['element_color']; ?>;
            color: black;
            margin: 0;
            padding: 20px;
        }
        .card-details {
            padding: 20px;
            border: 2px solid black;
            max-width: 400px;
            margin: 0 auto;
        }
        a {
            color: black;
        }
    </style>
</head>
<body>

    <div class="card-details">
        <h1><?php echo $card['name']; ?></h1>
        <img src="<?php echo $card['image_url']; ?>" alt="<?php echo $card['name']; ?>">
        <p>HP: <?php echo $card['name']; ?></p>
        <p>HP: <?php echo $card['hp']; ?></p>
        <p>Element: <?php echo $card['element']; ?></p>
        <p>Description: <?php echo "This card is from Pokemon World, we trade cards in this website!"; ?></p>
    </div>

    <p><a href="index.php">Back to Main Page</a></p>
</body>
</html>
