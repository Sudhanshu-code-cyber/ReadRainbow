<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
if (!isset($_GET['book_id'])) {
    redirect("index.php");
}
$book_id = $_GET["book_id"];
$query = $connect->query("select * from books where id='$book_id'");
if ($query->num_rows == 0) {
    redirect("index.php");
}
$book = $query->fetch_array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadRainbow | Details</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="flex p-10 bg-white mt-30">
        <div class="flex gap-20 items-center w-5/12 border-gray-300 border-r-2 space-x-4 p-6">
            <div class="flex flex-col space-y-2">
                <img src="<?php echo ($book['version'] != 'old') ? 'images/' . $book['img1'] : 'assets/sell_images/' . $book['img1']; ?>"
                    alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo ($book['version'] != 'old') ? 'images/' . $book['img1'] : 'assets/sell_images/' . $book['img1']; ?>')">

                <img src="<?php echo ($book['version'] != 'old') ? 'images/' . $book['img1'] : 'assets/sell_images/' . $book['img2']; ?>"
                    alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo ($book['version'] != 'old') ? 'images/' . $book['img2'] : 'assets/sell_images/' . $book['img2']; ?>')">
                <img src="<?php echo ($book['version'] != 'old') ? 'images/' . $book['img1'] : 'assets/sell_images/' . $book['img3']; ?>"
                    alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo ($book['version'] != 'old') ? 'images/' . $book['img3'] : 'assets/sell_images/' . $book['img3']; ?>')">
                <img src="<?php echo ($book['version'] != 'old') ? 'images/' . $book['img1'] : 'assets/sell_images/' . $book['img4']; ?>"
                    alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo ($book['version'] != 'old') ? 'images/' . $book['img4'] : 'assets/sell_images/' . $book['img4']; ?>')">
            </div>

            <div class="w-64 rounded-lg overflow-hidden shadow-lg">
                <img id="mainBookImage" src="images/<?= $book['img1']; ?>" alt="Book Image"
                    class="w-full h-full object-cover">
            </div>
        </div>
        <div class="w-7/12 flex flex-col gap-2 p-6">
            <div class="flex ">
                <h1 class="text-2xl font-semibold"><?= $book['book_name']; ?></h1>
                <div class="gap-4 flex ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10 px-2 py-1 text-gray-700 bg-gray-300 rounded-full">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-10 h-10 px-2 py-1 bg-gray-300 rounded-full text-gray-700">
                        <path fill-rule="evenodd"
                            d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z"
                            clip-rule="evenodd" />
                    </svg>


                </div>

            </div>

            <p class="text-orange-400 text-sm font-semibold"><?= $book['book_category']; ?></p>
            <h3 class="text-lg font-semibold">Author: <span class="text-[#3D8D7A]"><?= $book['book_author']; ?></span>
            </h3>
            <div class="flex gap-5 mb-5">
                <div
                    class="border-2 border-orange-300 hover:border-orange-500 h-22 w-42 flex flex-col rounded pt-1 px-2">
                    <p class="text-lg p-0 font-semibold">E-BOOK</p>
                    <?php if ($book['version'] != 'old'): ?>
                        <p class="text-gray-700 font-semibold">Price: <span
                                class="text-xl text-red-500">₹<?= $book['e_book_price']; ?></span></p>
                    <?php endif; ?>
                    <?=
                        $book['e_book_price'] != null ? "<span class='text-green-500 text-sm'>Available Now</span>" : "<span class='text-red-500 text-sm'>Not Available</span>";
                    ?>
                </div>
                <div
                    class="border-2 border-orange-300 hover:border-orange-500 h-22 w-42 flex flex-col rounded pt-1 px-2">
                    <p class="text-lg font-semibold"><?= $book['book_binding']; ?></p>
                    <p>40% off</p>
                    <p class="text-gray-700 font-semibold">Price: ₹<del class="text-sm"><?= $book['mrp']; ?></del> <span
                            class="text-xl text-red-500">₹<?= $book['sell_price']; ?></span></p>
                </div>
            </div>
            <hr class="text-gray-300">
            <div class="flex flex-col gap-5">
                <h1 class="text-xl text-gray-600 font-semibold">Key Highlights</h1>
                <div class="grid grid-cols-5 gap-2">
                    <div class="flex items-center border-r gap-1 border-gray-300 px-3 flex-col ">
                        <p class="text-sm text-gray-500">language</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" />
                        </svg>
                        <p><?= $book['language']; ?></p>

                    </div>
                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Total Pages</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>

                        <p><?= $book['book_pages'] ?></p>
                    </div>
                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">ISBN</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-5">
                            <path
                                d="M24 32C10.7 32 0 42.7 0 56L0 456c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24L64 56c0-13.3-10.7-24-24-24L24 32zm88 0c-8.8 0-16 7.2-16 16l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zm96 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zM448 56l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0c-13.3 0-24 10.7-24 24zm-64-8l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16s-16 7.2-16 16z" />
                        </svg>

                        <p><?= $book['isbn'] ?></p>
                    </div>

                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Publish Date</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>


                        <p><?= $book['publish_year'] ?></p>
                    </div>

                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Publish Date</p>
                        <img src="assets/images/paperback.png" class="size-7" alt="">


                        <p><?= $book['book_binding'] ?></p>
                    </div>
                </div>
                <?php
                if ($book['version'] == "new"):
                    ?>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="text-lg text-orange-600 border border-orange-500 p-3 rounded font-semibold">Add To
                            Cart</button>
                        <button class="text-lg bg-orange-600 text-white p-3 rounded font-semibold">Buy Now</button>
                    </div><?php else: ?>
                    <?php if ($book['version'] != 'new'): ?>
                        <a href="chatboard.php?chat_seller=<?= $book['seller_id']; ?>" target="_blank"
                            class="py-2 px-4 bg-blue-500 font-semibold text-center text-white rounded">
                            Chat With Seller
                        </a>

                    <?php endif; ?>
                <?php endif; ?>

            </div>



            <script>
                function changeImage(src) {
                    document.getElementById("mainBookImage").src = src;
                }
            </script>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>
<?php
if (isset($_GET['chat_seller']) && $_GET['chat_seller'] == $user['user_id']) {
    redirect("chatboard.php");
    exit(); // Always use exit() after a redirect
}

?>