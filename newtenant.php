<?php
if (isset($_POST["submit"])) {
    include_once("../dbconnect.php");
    $idno = $_POST["idno"];
    $phone = $_POST["phone"];
    $title = $_POST["title"];
    $descrip = $_POST["descrip"];
    $price = $_POST["price"];
    $depo = $_POST["depo"];
    $area = $_POST["area"];
    $state = $_POST["state"];
    $regdate = $_POST["regdate"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $sqlregister = "INSERT INTO `tbl_user`(`idno`, `phone`, `title`, `descrip`, `price`, `depo`, `area`, `state`, `regdate`, `latitude`, `longitude`) VALUES ('$idno', '$phone', '$title', '$descrip', '$price', '$depo', '$area', '$state', '$regdate', '$latitude', '$longitude')";
    try {
        $conn->exec($sqlregister);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            uploadImage($idno);
        }
        echo "<script>alert('Registration successful')</script>";
        echo "<script>window.location.replace('mainpage.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Registration failed')</script>";
        echo "<script>window.location.replace('newtenant.php')</script>";
    }
}

function uploadImage($id)
{
    $target_dir = "../res/images/";
    $target_file = $target_dir . $id . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <script src="../javascript/script.js"></script>
    <title>Rent A Room</title>
</head>

<body>
    <div class="w3-header w3-container w3-purple w3-padding-32 w3-center">
        <h1 style="font-size:calc(8px + 4vw);">Want To Rent A Room ?</h1>
        <p style="font-size:calc(8px + 1vw);;">Let Us Help</p>
    </div>

    <div class="w3-bar w3-blue-gray">
        <a href="#contact" class="w3-bar-item w3-button w3-right">Logout</a>
        <a href="mainpage.php" class="w3-bar-item w3-button w3-left">Home</a>
    </div>

    <div class="w3-container w3-padding-64 form-container">
        <div class="w3-card">
            <div class="w3-container w3-purple">
                <p>Tenant Registration
                <p>
            </div>
            <form class="w3-container w3-padding" name="registerForm" action="newtenant.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()" >
                <div class="w3-container w3-border w3-center w3-padding">
                    <img class="w3-image w3-round w3-margin" src="../res/images/profile.png" style="width:100%; max-width:600px"><br>
                    <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
                </div>

                <p>
                    <label>Id</label>
                    <input class="w3-input w3-border w3-round" name="name" id="idname" type="text" required>
                </p>
                <p>
                    <label>Phone</label>
                    <input class="w3-input w3-border w3-round" name="phone" id="idphone" type="text" required>
                </p><p>
                    <label>Title</label>
                    <input class="w3-input w3-border w3-round" name="title" id="idtitle" type="text" required>
                </p><p>
                    <label>Description</label>
                    <input class="w3-input w3-border w3-round" name="descrip" id="iddescrip" type="text" required>
                </p><p>
                    <label>Price</label>
                    <input class="w3-input w3-border w3-round" name="price" id="idprice" type="text" required>
                </p><p>
                    <label>Deposit</label>
                    <input class="w3-input w3-border w3-round" name="depo" id="iddepo" type="text" required>
                </p><p>
                    <label>State</label>
                    <input class="w3-input w3-border w3-round" name="state" id="idstate" type="text" required>
                </p><p>
                    <label>Area</label>
                    <input class="w3-input w3-border w3-round" name="area" id="idarea" type="text" required>
                </p><p>
                    <label>Date Created</label>
                    <input class="w3-input w3-border w3-round" name="regdate" id="iddate" type="date" required>
                </p><p>
                    <label>Latitude</label>
                    <input class="w3-input w3-border w3-round" name="latitude" id="idlatitude" type="text" required>
                </p><p>
                    <label>Longitude</label>
                    <input class="w3-input w3-border w3-round" name="longitude" id="idlongitude" type="text" required>
                </p>

                <div class="row">
                    <input class="w3-input w3-border w3-block w3-purple w3-round" type="submit" name="submit" value="Submit">
                </div>

            </form>


        </div>
    </div>

    <footer class="w3-footer w3-center w3-blue-grey">
        <p>Rent</p>
    </footer>

</body>

</html>