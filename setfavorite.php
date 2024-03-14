<?php
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
} else {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
}

if (isset($_COOKIE['favorite_books'])) {
    $favoriteIds = explode(",", $_COOKIE['favorite_books']);
} else {
    $favoriteIds = [];
}

if (in_array($bookId, $favoriteIds)) {
    $favoriteIds = array_diff($favoriteIds, [$bookId]);
} else {
    $favoriteIds[] = $bookId;
}

$favoriteString = implode(",", $favoriteIds);
setcookie("favorite_books", $favoriteString, time() + 86400 * 30);

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;
?>
