<?php
session_start();
include('functions.php');

if (isLoggedIn() && isset($_POST['sell'])) {
    $userId = $_SESSION['id'];
    $cardId = $_POST['card_id'];

    $users = getUsers();
    $user = $users[$userId - 1];

    $cards = getAllCards();
    $card = $cards[$cardId - 1];

    if ($card['owner_id'] == $userId) {
        $card['owner_id'] = 1;
        $user['cards'] = array_diff($user['cards'], [$cardId]);
        $user['card_limit'] += 1;

        $users[$userId - 1] = $user;
        $cards[$cardId - 1] = $card;

        saveUsers($users);
        saveCards($cards);

        header('Location: user_details.php?success=true');
        exit();
    } else {
        header('Location: user_details.php?error=not_owner');
        exit();
    }
} else {
    header('Location: user_details.php?error=invalid_request');
    exit();
}
?>
