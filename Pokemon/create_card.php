<?php
session_start();
include('functions.php');

if (!isLoggedIn() || $_SESSION['id'] !== 1) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_card'])) {
    $cardName = trim($_POST['card_name']);
    $imageUrl = trim($_POST['image_url']);
    $price = floatval($_POST['price']);
    $hp = intval($_POST['hp']);
    $element = trim($_POST['element']);
    $elementColor = trim($_POST['element_color']);

    if (empty($cardName) || empty($imageUrl) || $price <= 0 || $hp <= 0 || empty($element) || empty($elementColor)) {
        $_SESSION['error'] = "All fields are required and must have valid values.";
        header('Location: create_card_form.php'); 
        exit();
    }

    $existingCards = getAllCards();
    $lastCard = end($existingCards);
    $lastCardId = $lastCard ? $lastCard['id'] : 0;

    $newCardId = $lastCardId + 1;

    $newCard = [
        'id' => $newCardId,
        'name' => $cardName,
        'image_url' => $imageUrl,
        'price' => $price,
        'hp' => $hp,
        'element' => $element,
        'element_color' => $elementColor,
        'owner_id' => 1, 
    ];

    $existingCards[] = $newCard;

    saveCards($existingCards);

    $_SESSION['success'] = "Card created successfully.";
    header('Location: index.php'); 
    exit();
}

header('Location: index.php'); 
exit();

?>
