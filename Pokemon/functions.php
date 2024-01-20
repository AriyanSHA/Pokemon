<?php
function isLoggedIn() {
    return isset($_SESSION['id']);
}

function getAllCards() {
    $cardsData = json_decode(file_get_contents('cards.json'), true);
    return $cardsData;
}

function getUsers() {
    $usersData = json_decode(file_get_contents('users.json'), true);
    return $usersData;
}

function saveUsers($usersData) {
    file_put_contents('users.json', json_encode($usersData, JSON_PRETTY_PRINT));
}

function saveCards($cardsData) {
    file_put_contents('cards.json', json_encode($cardsData, JSON_PRETTY_PRINT));
}
function sellCard($userId, $cardId) {
    $users = getUsers();
    $cards = getAllCards();

    if (isset($users[$userId - 1]) && isset($cards[$cardId - 1])) {
        $user = $users[$userId - 1];
        $card = $cards[$cardId - 1];

        if (in_array($card['id'], $user['cards'])) {
            $sellPrice = $card['price'] * 0.9;
            $user['cards'] = array_diff($user['cards'], [$card['id']]);
            $adminDeck = getUsers();
            $adminDeck[] = $card;
            $user['money'] += $sellPrice;
            $users[$userId - 1] = $user;

            saveUsers($users);
            saveUsers($adminDeck);

            return true; 
        }
    }
    return false;
}

function getUserOwnedCards($userId) {
    $cards = getAllCards();
    $userOwnedCards = [];

    foreach ($cards as $card) {
        if ($card['owner_id'] == $userId) {
            $userOwnedCards[] = $card;
        }
    }

    return $userOwnedCards;
}

?>