<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="booksite.css">
</head>
<body>
    <div id="container">
        <header>
            <h1>Your Favorite Books</h1>
        </header>
        <nav id="main-navi">
            <ul>
                <li><a href="booksite.php">Home</a></li>
                <li><a href="booksite.php?genre=adventure">Adventure</a></li>
                <li><a href="booksite.php?genre=classic">Classic Literature</a></li>
                <li><a href="booksite.php?genre=coming-of-age">Coming-of-age</a></li>
                <li><a href="booksite.php?genre=fantasy">Fantasy</a></li>
                <li><a href="booksite.php?genre=historical">Historical Fiction</a></li>
                <li><a href="booksite.php?genre=horror">Horror</a></li>
                <li><a href="booksite.php?genre=mystery">Mystery</a></li>
                <li><a href="booksite.php?genre=romance">Romance</a></li>
                <li><a href="booksite.php?genre=scifi">Science Fiction</a></li>
            </ul>
        </nav>
        <main>
        <?php
        
// bringing data in from JSON 
$booksData = file_get_contents("books.json");
$books = json_decode($booksData, true);

// to check if the genre has been selected
if (isset($_GET['genre'])) {
    $selectedGenre = strtolower($_GET['genre']);
} else {
    $selectedGenre = '';
}

// filter the books 
$filteredBooks = [];
if ($selectedGenre) {
    foreach ($books as $book) {
        if (strtolower($book['genre']) == $selectedGenre) {
            $filteredBooks[] = $book;
        }
    }
} else {
    $filteredBooks = $books;
}


// display the books
foreach ($filteredBooks as $book) {
    $isFavorite = false;
    if (isset($_COOKIE['favorite_books'])) {
        $favoriteIds = explode(",", $_COOKIE['favorite_books']);
        if (in_array($book['id'], $favoriteIds)) {
            $isFavorite = true;
        }
    }

    if ($isFavorite) {
        $favoriteClass = "fa-star";
    } else {
        $favoriteClass = "fa-star-o";
    }
    ?>
    <section class="book">
        <a class="bookmark fa <?php print $favoriteClass ?>" href="setfavorite.php?id=<?php print $book['id'] ?>"></a>
        <h3><?php print $book['title'] ?></h3>
        <p class="publishing-info">
            <span class="author"><?php print $book['author'] ?></span>,
            <span class="year"><?php print $book['publishing_year'] ?></span>
        </p>
        <p class="description"><?php print $book['description'] ?></p>
    </section>
<?php }

// no books found 
if (empty($filteredBooks)) {
    ?>
    <p>No books found for the selected genre.</p>
<?php } ?>
         </main>
    </div>    
</body>
</html>
