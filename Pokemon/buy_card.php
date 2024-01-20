<?php
session_start();
include('functions.php');

if (isLoggedIn() && isset($_POST['buy'])) {
    $userId = $_SESSION['id'];
    $cardId = $_POST['card_id'];

    $users = getUsers();
    $cards = getAllCards();

    if (isset($users[$userId - 1]) && isset($cards[$cardId - 1])) {
        $user = $users[$userId - 1];
        $card = $cards[$cardId - 1];

        if ($user['money'] >= $card['price'] && $user['card_limit'] > 0 && $card['owner_id'] === 1) {
            $user['money'] -= $card['price'];
            $card['owner_id'] = $userId;
            $user['card_limit']--;

            $users[$userId - 1] = $user;
            $cards[$cardId - 1] = $card;

            saveUsers($users);
            saveCards($cards);

            header('Location: index.php');
            exit();
        } else {
            echo "Unable to complete the purchase. Check your funds, card limit, or card availability.";
        }
    } else {
        echo "Invalid user or card.";
    }
}

header('Location: index.php');
exit();
?>
