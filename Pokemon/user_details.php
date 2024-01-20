<?php
session_start();
include('functions.php');

if (isLoggedIn()) {
    $userId = $_SESSION['id'];
    $users = getUsers();
    $user = $users[$userId - 1];

    echo '<h2>User Details</h2>';
    echo '<p>Username: ' . $user['username'] . '</p>';
    echo '<p>Money: $' . $user['money'] . '</p>';
    echo '<p>Card Limit: ' . $user['card_limit'] . '</p>';

    $userOwnedCards = getUserOwnedCards($userId);
    if (!empty($userOwnedCards)) {
        echo '<h3>Owned Cards:</h3>';
        echo '<ul class="user-cards">';
        foreach ($userOwnedCards as $card) {
            echo '<li class="card-details">';
            echo '<h4>' . $card['name'] . '</h4>';
            echo '<p>Card ID: ' . $card['id'] . '</p>';
            echo '<p>Element: ' . $card['element'] . '</p>';
            echo '<img src="' . $card['image_url'] . '" alt="' . $card['name'] . '">';

            echo '<form action="sell_card.php" method="post">';
            echo '<input type="hidden" name="card_id" value="' . $card['id'] . '">';
            echo '<button class="sell-button" type="submit" name="sell">Sell</button>';
            echo '</form>';

            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>You do not own any cards.</p>';
    }
    echo '<form action="index.php" method="post">';
    echo '<button class="return-button" type="submit" name="return">Return to Menu</button>';
    echo '</form>';
}
?>
