<?php

$image[] = '';
$imagepath = '';
$date = '';
$result = '';
$data[] = '';
$imagename = '';
$type = ['jpg', 'jpeg', 'png'];
include_once("function.php");
include_once("pdo_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $date = date('Y-m-d H-i-s');
    if (!is_dir('xyz')) {
        mkdir('xyz');
    }
    for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
        $imagename = $_FILES['image']['name'][$i];
        $tmpname = $_FILES['image']['tmp_name'][$i];
        $imageValidation = explode('.', $imagename);
        $lastIndex = count($imageValidation);
        $lastEle = $imageValidation[$lastIndex - 1];
        if (in_array($lastEle, $type)) {
            $imagename = implode('.', $imageValidation);
            $imagepath = '';

            if ($imagename && $tmpname) {
                $imagepath = "xyz/" . randomstring(5) .  $imagename;
                move_uploaded_file($tmpname, $imagepath);



                $statement = $pdo->prepare("INSERT INTO gallery (image , created_at) VALUES (:image, :date)");
                $statement->bindValue(':image', $imagepath);
                $statement->bindValue(':date', $date);
                $statement->execute();
            }
        } else { ?>
            <div id="error" class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i>Please Upload jpg/png/jpeg File</h4>
            </div>

<?php }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" integrity="undefined" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .myImg {
            width: 500px;
            padding: 65px;
            border-radius: 5px;
            cursor: pointer;
            transition: 1s;
        }

        .myImg:hover {
            transform: scale(1.1);
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        .caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content,
        .caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
    </style>
    <title>MyGalleyApp</title>
</head>

<body>
    <nav class="navbar navbar-light bg-dark">
        <div class="container-fluid">
            <a style="color: white;" class="navbar-brand">My Gallery</a>
            </form>
        </div>
    </nav>
    <br>
    <center>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class=" form-group" align center>
                <h3><b><label>Upload Image</label></b></h3>
                <br>
                <input type="file" name="image[]" multiple>
            </div>
            <button type="submit" class="btn btn-success" name="submit">Submit</button>
            <?php

            $statement = $pdo->prepare('SELECT * FROM gallery');
            $statement->execute();
            $products = $statement->fetchAll();

            ?>

            <br><br><br>

            <div class="gallery">
                <?php if (isset($products)) {
                    foreach ($products as $row) {
                        $i = $row['id'] ?>

                        <img class="myImg" id="myImg_<?php echo $i; ?>" src="<?php echo $row['image'] ?>" onclick="clicked(<?php echo $i; ?>)">
                        <div id="myModal_<?php echo $i; ?>" class="modal">
                            <span class="close" id="close_<?php echo $i; ?>" onclick="closePic(<?php echo $i; ?>)"> &times; </span>
                            <img class="modal-content" id="img01_<?php echo $i; ?>">
                        </div>
            </div>
    <?php }
                } ?>
    </div>
        </form>
    </center>
</body>
<script>
    // Get the modal


    function clicked(id) {
        var modal = document.getElementById("myModal_" + id);
        var modalImg = document.getElementById("img01_" + id);
        var imgsrc = document.getElementById("myImg_" + id).getAttribute('src');

        modal.style.display = "block";
        modalImg.src = imgsrc;
    }

    function closePic(id) {
        var modal = document.getElementById("myModal_" + id);
        modal.style.display = "none";
    }
</script>


</html>