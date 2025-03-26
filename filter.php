<?php
include_once "config/connect.php";
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null;
// Wishlist Toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist1'])) {
    if ($userId) {
        $bookId = $_POST['wishlist_id1'];
        $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        if ($check->num_rows > 0) {
            $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        } else {
            $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
        }
        redirect("filter.php");
        exit();
    } else {
        redirect("login.php");
        exit();
    }
}
// Base query
$sql = "SELECT books.*, books.id AS book_id, category.cat_title 
        FROM books 
        JOIN category ON books.book_category = category.cat_title 
        WHERE 1";

// Filter: Category
if (!empty($_GET['filter'])) {
    $cat_title = mysqli_real_escape_string($connect, $_GET['filter']);
    $sql .= " AND book_category = '$cat_title'";
}



// Filter: Search
if (!empty($_GET['search_book'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search_book']);
    if (strlen($search) < 1) {
        message("Please enter a search term.");
        redirect("filter.php");
    }

    $sql .= " AND (
        LOWER(book_name) LIKE LOWER('%$search%') OR 
        LOWER(book_author) LIKE LOWER('%$search%') OR 
        LOWER(book_category) LIKE LOWER('%$search%') OR 
        LOWER(isbn) LIKE LOWER('%$search%')
    )";
}





$booksQuery = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Used Books</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#FBFFE4] text-gray-800 font-sans bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="flex flex-col mt-38  gap-6 p-4">
        <?php
        if (isset($_GET['hide'])) {
        } else {
        ?>
            <div class="flex justify-center items-center">
                <h2 class="text-2xl font-serif py-2 px-6 rounded-md bg-[#3D8D7A] font-bold text-white">
                    <?= htmlspecialchars($filter); ?>
                </h2>
            </div>
        <?php
        }
        ?>



        <div class="flex-1">
            <?php if ($booksQuery->num_rows > 0): ?>
                <main class="grid grid-cols-5 gap-4">
                    <?php while ($book = $booksQuery->fetch_assoc()):
                        $bookId = $book['book_id'];
                        $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                        $isWishlisted = ($checkWishlist->num_rows > 0);

                        //discount work

                        $mrp = floatval($book['mrp']);
                        $sell_price = floatval($book['sell_price']);

                        if ($mrp > 0 && is_numeric($sell_price)) {
                            $percentage = ($mrp - $sell_price) / $mrp * 100;
                        } else {
                            echo "Error: Invalid price values.";
                        }

                    ?>
                        <div class="bg-white p-4 rounded-lg shadow-lg h-[60vh] border border-gray-200 w-full relative">
                            <div class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md"><?= round($percentage); ?>% OFF</div>

                            <!-- Wishlist Button -->
                            <form method="POST" action="" class="absolute top-3 right-3" onclick="event.stopPropagation();">
                                <input type="hidden" name="wishlist_id1" value="<?= $bookId; ?>">
                                <button type="submit" name="toggle_wishlist1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-6 hover:scale-110 transition">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="view.php?book_id=<?= $bookId; ?>" class="block h-full">
                                <div class="flex justify-center hover:scale-105 transition">
                                    <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover" class="w-40 h-56 object-cover shadow-md rounded-md">
                                </div>

                                <div class="mt-4 text-center">
                                    <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
                                    <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?>
                                        <span class="text-sm text-orange-400 ml-2"><?= $book['book_category']; ?></span>
                                    </p>

                                    <div class="flex justify-center items-center space-x-2 mt-1">
                                        <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                        <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                                    </div>
                                </div>

                                <div class="mt-4 border-t pt-3 flex justify-between items-center">
                                    <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>
                                    <div class="flex">
                                        <?php
                                        $rating = rand(2, 5);
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo '<span class="' . ($i <= $rating ? 'text-orange-500' : 'text-gray-400') . ' text-lg">★</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </main>
            <?php else: ?>



                <div class="flex justify-center items-center h-[60vh]">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-red-500 mb-4">😕 Oops! No books found for the selected filters.</h2>

                    </div>
                </div>
            <?php endif; ?>
            <?php
            // Assuming you already have a DB connection in $connect and user ID in $userId
            if (isset($_GET['old_books']) && $_GET['old_books'] === 'old_book') {
                // $booksQuery = $connect->query("SELECT * FROM books WHERE version = 'old'");
            }
            ?>

            <?php
            while ($book = $booksQuery->fetch_assoc()):
                // Check if the book is already in the wishlist
                $bookId = $book['id'];
                $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                $isWishlisted = ($checkWishlist->num_rows > 0);

                //discount work

                $mrp = floatval($book['mrp']);
                $sell_price = floatval($book['sell_price']);

                if ($mrp > 0 && is_numeric($sell_price)) {
                    $percentage = ($mrp - $sell_price) / $mrp * 100;
                } else {
                    echo "Error: Invalid price values.";
                }
            ?>
                <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                    <!-- Discount Badge (60% Off) -->
                    <div
                        class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                        <?= round($percentage); ?>% OFF
                    </div>

                    <!-- Wishlist Heart Icon (Prevents Click from Going to Next Page) -->
                    <form method="POST"
                        action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>"
                        class="absolute top-3 right-3" onclick="event.stopPropagation();">
                        <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                        <button type="submit" name="toggle_wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                class="size-6 hover:scale-110 transition">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </form>

                    <!-- Book Click Redirect -->
                    <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                        <div class="flex justify-center hover:scale-105 transition">
                            <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                class="w-40 h-56 object-cover shadow-md rounded-md">
                        </div>

                        <!-- Book Info -->
                        <div class="mt-4 text-center">
                            <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
                            <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?>
                                <span class="text-sm text-orange-400 ml-2"><?= $book['book_category']; ?></span>
                            </p>

                            <!-- Price -->
                            <div class="flex justify-center items-center space-x-2 mt-1">
                                <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                            </div>
                        </div>
                    </a>
                    <!-- Footer (Add to Cart + Rating) -->
                    <a href="cart.php?add_book=<?= $book['id']; ?>">
                        <div class="mt-4 border-t pt-3 flex justify-between items-center">
                            <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>

                            <!-- Dynamic Rating -->
                            <div class="flex">
                                <?php
                                $rating = $book['book_rating']; // Random Rating for demo
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<span class="text-orange-500 text-lg">★</span>';
                                    } else {
                                        echo '<span class="text-gray-400 text-lg">★</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                </div>

            <?php endwhile; ?>



        </div>

    </div>

    <?php include_once "includes/footer2.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>