<!DOCTYPE html>
<html lang="en">
    <?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("./core/db_connect.php"); // Jeg forbinder til databasen.
    ?>
    <head>
        <link rel="stylesheet" href="./Style/CourtInformation.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
        <script src="./booking/bookCourt.js" defer></script> <!-- Tilføjer javascript som kører efter dette script -->
    </head>
    <body>
        <?php include("./navbar/Navbar.php");  // Indkluderer navbar.
        // Tjekker at man er logget ind, og en bane er valgt.
        if(!isset($_SESSION['user_id'])){
            die("You aren't signed in!");
        }
        if(!isset($_POST['id'])){
            die("Couldn't pass data!");
        }

        ?>

        <!-- Tilbage-knap -->
        <form action="./Booking.php">
            <input class="back-button" type="submit" value="Back" />
        </form>

        <?php

        // Henter data fra den valgte bane
        $court_id = $_POST['id'];
        $selectSQL = "SELECT * FROM `courts` WHERE id='$court_id';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die("Couldn't query statement");
        }
        if(mysqli_num_rows($result) == 0){
            die("Couldn't find data with court_id");
        }
        $row = mysqli_fetch_assoc($result);
        $court_number = $row['court_number'];
        $date = $row['date'];
        $time = $row['time'];
        ?>
        <!-- Laver en tabel med informationer om den valgte bane. -->
        <div class="container">
            <table class="court-tabel">
                <tr class="court-tabel-row">
                    <th class="court-tabel-titel" colspan="2">Court Information</th>
                </tr>
                <tr class="court-tabel-row">
                    <th class="court-tabel-data-titel">Court number</th>
                    <th class="court-tabel-data"><?php echo $court_number ?></th>
                </tr>
                <tr class="court-tabel-row">
                    <th class="court-tabel-data-titel">Date</th>
                    <th class="court-tabel-data"><?php echo $date ?></th>
                </tr>
                <tr class="court-tabel-row">
                    <th class="court-tabel-data-titel">Time</th>
                    <th class="court-tabel-data"><?php echo $time ?></th>
                </tr>
                <tr class="court-tabel-row">
                    <th class="court-tabel-data-titel">Duration</th>
                    <th class="court-tabel-data">1 hour</th>
                </tr>
            </table>
            <?php

            // Checking if court is booked already
            $isBooked = false;
            $isBookedByMe = false;
            $selectSQL = "SELECT * FROM `bookings` WHERE court_id='$court_id';";
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die("Couldn't query statement");
            }
            if(mysqli_num_rows($result) == 1){
                $isBooked = true;
                $row = mysqli_fetch_assoc($result);
                // Tjekker om det er brugeren selv der har booket den.
                $court_user_id = $row['user_id'];
                if($court_user_id == $_SESSION['user_id']){
                    $isBookedByMe = true;
                }
            }
            ?>
                <!-- Data der sendes videre til javascript-filen når den køres efter submit-knappen trykkes på -->
                <input type="hidden" id="court-id" value="<?php echo $court_id ?>">
                <input type="hidden" id="user-id" value="<?php echo $_SESSION['user_id'] ?>">
            <?php
            
            if($isBookedByMe == true){// Knappen er rød, hvis man allerede har booket banen, og den kan afbookes.
                ?><button type="submit" id="book-court" class="book-court" style="background-color:#8B0000; border: 1px solid red;">Unbook court</button><?php
            } else if($isBooked == false){ // Book-knappen er grøn, hvis den ikke er booket.
                ?><button type="submit" id="book-court" class="book-court" style="background-color:#4CAF50; border: 1px solid green;">Book court</button><?php
            } else { // Hvis en anden har booket er der en rød tekst i stedet for.
                ?>
                <p class="already-booked" style="color:red;">Court is already booked!</p>
                <?php
            }
            ?>

            <div id="msg"></div> <!-- div til eventuel fejlbesked når man booker. (Kunne være at man ikke kan booke flere baner.) -->
        </div>

    </body>
</html>
        