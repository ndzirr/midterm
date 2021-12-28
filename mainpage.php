<?php
$results_per_page = 4;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

include_once("../dbconnect.php");

if (isset($_GET['op'])) {
    $op = $_GET['op'];
    if ($op == 'delete') {
        $id = $_GET['id'];
        $sqldelete = "DELETE FROM tbl_user WHERE idno = '$id'";
        $stmt = $conn->prepare($sqldelete);
        if ($stmt->execute()) {
            echo "<script> alert('Delete Success')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        } else {
            echo "<script> alert('Delete Failed')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        }
    }
}

if (isset($_GET['button'])) {
    $op = $_GET['button'];
    $option = $_GET['option'];
    $search = $_GET['search'];
    if ($op == 'search') {
        if ($option == "idno") {
            $sqltenant = "SELECT * FROM tbl_user WHERE idno LIKE '%$search%'";
        }
        if ($option == "title") {
            $sqltenant = "SELECT * FROM tbl_user WHERE title LIKE '%$search%'";
        }
    }
} else {
    $sqltenant = "SELECT * FROM tbl_user ORDER BY regdate DESC";
}

$stmt = $conn->prepare($sqltenant);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltenant = $sqltenant . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltenant);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

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
        <a href="newtenant.php" class="w3-bar-item w3-button w3-
         left">New Tenant</a>
    </div>

    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h4>Tenant Search</h4>
        <form action="mainpage.php">
            <div class="w3-row">
                <div class="w3-half w3-container">
                    <p><input class="w3-input w3-block w3-round w3-border" type="search" id="idsearch" name="search" placeholder="Enter search term" /></p>
                </div>
                <div class="w3-half w3-container">
                    <p><select class="w3-input w3-block w3-round w3-border" name="option" id="srcid">
                            <option value="name">By IDNo</option>
                            <option value="ic">By Phone</option>
                            <option value="today">State</option>
                        </select>
                    <p>
                </div>
            </div>
            <div class="w3-container">
                <p><button class="w3-button w3-purple w3-round w3-right" type="submit" name="button" value="search">search</button></p>
            </div>

        </form>
    </div>

    <div class="w3-grid-template">
        <?php
        foreach ($rows as $tenant) {
            $idno = $tenant['idno'];
            $phone = $tenant['phone'];
            $title = $tenant['title'];
            $descrip = $tenant['descrip'];
            $price = $tenant['price'];
            $depo = $tenant['depo'];
            $area = $tenant['area'];
            $state = $tenant['state'];
            $datecreate = $tenant['regdate'];
            $latitude = $tenant['latitude'];
            $longitude = $tenant['longitude'];
            echo "<div class='w3-center w3-padding'>";
            echo "<div class='w3-card-4 w3-dark-grey'>";
            echo "<header class='w3-container w3-purple'";
            echo "<h5>$idno</h5>";
            echo "</header>";
            echo "<div class='w3-padding'><img class='w3-image' src=../res/images/$idno.png" .
                " onerror=this.onerror=null;this.src='../res/images/profile.png'"
                . " '></div>";
            echo "<div class='w3-container w3-left-align'><hr>";
            echo "<p>
            <i class='fa fa-phone' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$phone<br>

            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$title<br>

            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$descrip<br>

            <i class='fa fa-money' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$price<br>

            <i class='fa fa-money' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$depo<br>

            <i class='fa fa-map' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$state<br>
            
            <i class='fa fa-map' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$area<br>

            <i class='fa fa-calendar' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$datecreate<br>

            <i class='fa fa-globe' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$latitude<br>

            <i class='fa fa-globe' style='font-size:16px'>
            </i>&nbsp&nbsp&nbsp&nbsp$longitude<br>";

             echo "<table class='w3-table'><tr>
             <td class='w3-center'><a href=tenantdetails.php?id=$idno>
             <i class='fa fa-user-o' style='font-size:32px' onClick=
             'return moreDialog()' style='text-decoration:none'></i></a></td>
             <td class='w3-center'><a href=tenantupdate.php?id=$idno>
             <i class='fa fa-edit' style='font-size:32px' onClick=
             'return updateDialog()' style='text-decoration:none'></i></a></td>
             <td class='w3-center'><a href='mainpage.php?op=delete&id=$idno'>
             <i class='fa fa-trash-o' style='font-size:32px' onClick=
             'return deleteDialog($idno)' style='text-decoration:none'></i></a></td>
             </tr></table>";


            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + $results_per_page;
    } else {
        $num = $pageno * $results_per_page - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "mainpage.php?pageno=' . $page . '" style=
        "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>

    <footer class="w3-footer w3-center w3-bue-grey">
        <p>Rent</p>
    </footer>

</body>

</html>