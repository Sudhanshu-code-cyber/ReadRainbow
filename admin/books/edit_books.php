<?php include_once '../../config/connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Rainbow (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


</head>

<body>

    <?php include_once "../includes/admin_navbar.php"; ?>



    <div class="full-screen">
        <?php include_once "../includes/admin_sidebar.php"; ?>

        <div class="main-content">
            <div class="content flex-grow-1 p-4">
                <h2>VIEW FULL BOOK DETAILs...</h2>

                <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                <?php
                if (isset($_GET['full_view_books'])) {
                    $id = $_GET['full_view_books'];
                    // Fetch the current category details
                    $call_books_id = mysqli_query($connect, "SELECT * FROM books WHERE id='$id'");
                    $books_row = mysqli_fetch_array($call_books_id);

                    
                }
                ?>
                <div class="container mt-5">
                    <div class="row">
                        <!-- Book Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bookName" class="form-label">Book Name</label>
                                <input type="text" class="form-control" id="bookName" name="book_name" value="<?= $books_row['book_name'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" id="author" name="book_author" value="<?= $books_row['book_author'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Binding -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="binding" class="form-label">Binding</label>
                                <input type="text" class="form-control" id="binding" name="book_binding" value="<?= $books_row['book_binding'] ?>" readonly>
                            </div>
                        </div>

                        <!-- MRP -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mrp" class="form-label">MRP</label>
                                <input type="text" class="form-control" id="mrp" name="mrp" value="<?= $books_row['mrp'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Selling Price -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sellingPrice" class="form-label">Selling Price</label>
                                <input type="text" class="form-control" id="sellingPrice" name="sell_price" value="<?= $books_row['sell_price'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Pages -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pages" class="form-label">Pages</label>
                                <input type="text" class="form-control" id="pages" name="book_pages" value="<?= $books_row['book_pages'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Category -->


                        <!-- Language -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" class="form-control" id="rating" name="language" min="1" max="5"
                                    step="0.1" value="<?= $books_row['language'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="text" class="form-control" id="rating" name="book_rating" min="1" max="5"
                                    step="0.1" value="<?= $books_row['book_rating'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" id="rating" name="book_category" min="1" max="5"
                                    step="0.1" value="<?= $books_row['book_category'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Language -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Sub-Category</label>
                                <input type="text" class="form-control" id="rating" name="book_sub_category" min="1" max="5"
                                    step="0.1" value="<?= $books_row['book_sub_category'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- ISBN -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="<?= $books_row['isbn'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Publish Year -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="publishYear" class="form-label">Publish Year</label>
                                <input type="text" class="form-control" id="publishYear" name="publish_year" value="<?= $books_row['publish_year'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Quality -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quality" class="form-label">Quality</label>
                                <input type="text" class="form-control" id="rating" name="quality" min="1" max="5"
                                    step="0.1" value="<?= $books_row['quality'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="book_description" rows="4"
                                value="" readonly><?= $books_row['book_description'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- E-book Availability -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ebookAvailable" class="form-label">E-book Available</label>
                                <input type="text" class="form-control" id="rating" name="e_book_avl" min="1" max="5"
                                    step="0.1" value="<?= $books_row['e_book_avl'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">E-book Price</label>
                                <input type="text" class="form-control" id="rating" name="e_book_price" min="1" max="5"
                                    step="0.1" value="<?= $books_row['e_book_price'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <!-- Image Upload Section -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Thumbnail Image</label>
                            
                            <img id="preview1" src="../../images/<?= $books_row['img1'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Image 1</label>
                            
                            <img id="preview1" src="../../images/<?= $books_row['img1'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Image 2</label>
                            
                            <img id="preview1" src="../../images/<?= $books_row['img1'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Image 3</label>
                            
                            <img id="preview1" src="../../images/<?= $books_row['img1'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        
                    </div>
                    <hr>

                    <div class="row mt-3">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-success">update detail</button>
                            <!-- <a  class="btn btn-primary" name="edit"><i class="bi bi-pencil-square me-2"></i>Edit Book Detail</a> -->
                        </div>
                    </div>

                </div>
                <!-- </form> -->
                <?php
                // if (isset($_POST['insert_book'])) {
                //     $book_name = $_POST['book_name'];
                //     $book_author = $_POST['book_author'];
                //     $book_binding = $_POST['book_binding'];
                //     $mrp = $_POST['mrp'];
                //     $sell_price = $_POST['sell_price'];
                //     $book_pages = $_POST['book_pages'];
                //     $book_category = $_POST['book_category'];
                //     $book_sub_category = $_POST['book_sub_category'];
                //     $language = $_POST['language'];
                //     $isbn = $_POST['isbn'];
                //     $publish_year = $_POST['publish_year'];
                //     $quality = $_POST['quality'];
                //     $book_description = $_POST['book_description'];
                //     $e_book_avl = $_POST['e_book_avl'];
                //     $book_rating = $_POST['book_rating'];
                
                //     // image 1 working
                //     $image1 = $_FILES['img1']['name'];
                //     $tmp_image1 = $_FILES['img1']['tmp_name'];
                //     move_uploaded_file($tmp_image1, "../../images/$image1");
                
                //     // image 2 working
                //     $image2 = $_FILES['img2']['name'];
                //     $tmp_image2 = $_FILES['img2']['tmp_name'];
                //     move_uploaded_file($tmp_image2, "../../images/$image2");
                
                //     // image 3 working
                //     $image3 = $_FILES['img3']['name'];
                //     $tmp_image3 = $_FILES['img3']['tmp_name'];
                //     move_uploaded_file($tmp_image3, "../../images/$image3");
                
                //     // image 4 working
                //     $image4 = $_FILES['img4']['name'];
                //     $tmp_image4 = $_FILES['img4']['tmp_name'];
                //     move_uploaded_file($tmp_image4, "../../images/$image4");
                
                //     $insert_books = mysqli_query($connect, "INSERT INTO books (book_name,book_author,book_binding,mrp,sell_price,book_pages,book_category,book_sub_category,language,isbn,publish_year,quality,book_description,e_book_avl,book_rating,img1,img2,img3,img4) VALUE ('$book_name','$book_author','$book_binding','$mrp','$sell_price','$book_pages','$book_category','$book_sub_category','$language','$isbn','$publish_year','$quality','$book_description','$e_book_avl','$book_rating','$image1','$image2','$image3','$image4')");
                
                // }
                

                ?>
            </div>
        </div>

        <script>
            // Function to preview image before uploading
            // function previewImage(imageNumber) {
            //     var file = document.getElementById('image' + imageNumber).files[0];
            //     var reader = new FileReader();
            //     reader.onloadend = function () {
            //         document.getElementById('preview' + imageNumber).src = reader.result;
            //         document.getElementById('preview' + imageNumber).style.display = 'block';
            //     };
            //     if (file) {
            //         reader.readAsDataURL(file);
            //     }
            // }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    </div>












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        // Sidebar toggler for mobile
        document.getElementById('sidebar-toggler').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>

</body>

</html>