<?php include_once "config/connect.php"; 
if (isset($_SESSION['user'])) {
    $user = getUser();
}
?>


<?php
if (isset($_GET['add_book'])) {
    $item_id = $_GET['add_book'];
    $email = $_SESSION['user'];
    $itemInCart = mysqli_query($connect, "SELECT * FROM cart where item_id='$item_id'");
    $noItemInCart = mysqli_num_rows($itemInCart);
    if ($noItemInCart) {
        $updateQty = mysqli_query($connect, "UPDATE cart SET qty = qty + 1 where item_id='$item_id'");
    } else {
        $insert_cart = mysqli_query($connect, "INSERT INTO cart (email,item_id) VALUE ('$email','$item_id')");
    }

    echo "<script>window.location.href='cart.php';</script>";

}


if (isset($_GET['minus_book'])) {
    $item_id = $_GET['minus_book'];
    $email = $_SESSION['user'];
    $itemInCart = mysqli_query($connect, "SELECT * FROM cart where item_id='$item_id'");
    $itemData = mysqli_fetch_assoc($itemInCart);
    if ($itemData) {
        if ($itemData['qty'] > 1) {
            $updateQty = mysqli_query($connect, "UPDATE cart SET qty = qty - 1 WHERE item_id='$item_id'");
        } else {
            $deleteItem = mysqli_query($connect, "DELETE FROM cart WHERE item_id='$item_id'");
        }
    } else {
        echo "Item not found in cart!";
    }

    echo "<script>window.location.href='cart.php';</script>";

}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="mt-12">
        <?php include_once "includes/header.php"; ?>
    </nav>

    <div class="container mx-auto p-6 md:p-10">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Product List -->
            <div class="w-full md:w-2/3 bg-white p-6 shadow-lg rounded-lg h-[500px] overflow-y-auto">
                <h2 class="text-xl font-bold mb-4">Your Cart</h2>
                <div class="space-y-6">
                    <?php
                    $email = $_SESSION['user'];
                    $callCartItem = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id where cart.email='$email'");
                    while ($cartItem = mysqli_fetch_array($callCartItem)) { ?>
                        <div class="flex items-center gap-4 border-b pb-4">
                            <a href="view2.php?book_id=<?= $cartItem['item_id'] ?>">
                                <img src="images/<?= $cartItem['img1'] ?>" class="w-24 h-24 rounded-lg shadow-md" alt="Product">
                            </a>
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg"> <?= $cartItem['book_name'] ?> </h3>
                                <p class="text-sm text-gray-500">Author: <?= $cartItem['book_author'] ?></p>
                                <p class="text-green-500 font-semibold text-lg">₹<?= $cartItem['sell_price'] ?>
                                    <span class="text-gray-500 line-through text-sm">₹<?= $cartItem['mrp'] ?></span></p>
                            </div>
                            <div class="flex items-center gap-2 border rounded-lg p-1 shadow-md">
                                <a href="?minus_book=<?= $cartItem['id'] ?>" class="px-3 py-2 bg-gray-300 hover:bg-gray-400 rounded-full">-</a>
                                <span class="text-lg font-bold"> <?= $cartItem['qty'] ?> </span>
                                <a href="?add_book=<?= $cartItem['id'] ?>" class="px-3 py-2 bg-gray-300 hover:bg-gray-400 rounded-full">+</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Price Details -->
            <?php 
            $totleMrp = 0;
            $totleSellPrice = 0;
            $callCartItem = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id where cart.email='$email'");
            while($price = mysqli_fetch_array($callCartItem)){
                $totleMrp += $price['qty'] * $price['mrp'];
                $totleSellPrice += $price['qty'] * $price['sell_price'];
            }
            ?>
            <div class="w-full md:w-1/3 bg-white p-6 shadow-lg rounded-lg h-fit">
                <h2 class="text-xl font-bold mb-4">Price Details</h2>
                <div class="space-y-3 text-gray-700">
                    <p class="flex justify-between"><span>Price</span> <span>₹<?= $totleMrp ?></span></p>
                    <p class="flex justify-between text-green-500"><span>Discount</span> <span>- ₹<?= $totleMrp - $totleSellPrice ?></span></p>
                    <p class="flex justify-between"><span>Delivery</span> <span class="text-green-500">Free</span></p>
                    <hr>
                    <p class="flex justify-between text-lg font-semibold"><span>Total</span> <span>₹<?= $totleSellPrice ?></span></p>
                </div>
                <button class="w-full bg-orange-500 text-white py-3 mt-4 rounded-lg shadow-md hover:bg-orange-600 transition">PLACE ORDER</button>
            </div>
        </div>
    </div>
</body>
</html>
