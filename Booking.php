<!DOCTYPE html>
<html lang="en">
    <?php
    session_start(); // Jeg starter sessionen, som skal indeholde login-data, efter jeg logger ind.
    require_once("./core/db_connect.php"); // Jeg forbinder til databasen.
    ?>
    <head>
        <link rel="stylesheet" href="./Style/Booking.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script> <!-- Tilføjer javascript-library "jqeury" -->
    </head>
    <body>
        <?php include("./navbar/Navbar.php");  // indkludere navbar
        if(!isset($_SESSION['user_id'])){ // Tjekker at man er logget ind.
            die();
        } 

        $baner = [1,2,3,4,5]; // Liste med banerne.
        $days = calcWeekDays(); // Beregner datoer for i dag og de næste 6 dage.
        $times = calcTimes(); // Liste med tider som banerne kan bookes. (Hver time)
        SQLNewDay(); // Funktion der fjerner tidligere dage fra databasen og tilføjer nye, når døgnet skifter.

        ?>
        <div class="bookings-tables"> <!-- Div med alle tabeller på siden -->
        <?php
        foreach($days as $day){ // For hver dag på ugen tilføjes der en ny tabel.
            ?>
            <div class="day-div"> <!-- Div som indeholder tabel for en dag -->
                <div class="title-div"><p><?php echo($day) ?></p></div>
                <div>
                    <table> 
                        <tr> <!-- Titler på kolonnerne. -->
                            <td></td>
                            <td class="table-court-number">Court 1</td>
                            <td class="table-court-number">Court 2</td>
                            <td class="table-court-number">Court 3</td>
                            <td class="table-court-number">Court 4</td>
                            <td class="table-court-number">Court 5</td>
                        </tr>
                        <?php
                        foreach($times as $time){ // For hver time på dagen er der en ny bane der kan bookes
                            ?>
                            <tr>
                                <th class="table-row-time"><?php echo $time ?></th>
                                <div class="bookings-row">
                                    <?php
                                    foreach($baner as $bane){ // Banernes felter i tabellen bliver oprettet.

                                        // Jeg giver hver bane et id.
                                        $selectCourtsSQL = "SELECT id FROM courts WHERE `date`='$day' AND `time`='$time' AND `court_number`='$bane';";
                                        $result = mysqli_query($db, $selectCourtsSQL);
                                        if(!$result){die("NO RESULT");}
                                        $results = mysqli_num_rows($result);
                                        if($results == 0 || $results > 1){die("WRONG RESULT SIZE $results");}
                                        $row = mysqli_fetch_assoc($result);
                                        $id = $row["id"];

                                        // Jeg ser om banen er booket.
                                        $selectBookingsSQL = "SELECT * FROM bookings WHERE court_id='$id';";
                                        $result = mysqli_query($db, $selectBookingsSQL);
                                        if(!$result){die("NO RESULT");}
                                        $results = mysqli_num_rows($result);
                                        if($results > 1){die("WRONG RESULT SIZE $results");}

                                        // Jeg ser om det er brugeren selv der har booket
                                        $isBooked = false;
                                        $isMyCourt = false;
                                        if($results == 1){
                                            $isBooked = true;
                                        }
                                        if($isBooked == true){
                                            $row = mysqli_fetch_assoc($result);
                                            if($row["user_id"] == $_SESSION['user_id']){
                                                $isMyCourt = true;
                                            }
                                        }

                                        ?>

                                        <td class="table-field-booking"> <!-- Banen bliver oprettet, og farves efter, hvorvidt den er booket -->
                                            <form class="table-field-form" action="./CourtInformation.php" method="POST">
                                                <input type="hidden" name="id" id="court" value="<?php echo $id; ?>">
                                                <?php
                                                if($isBooked == true && $isMyCourt == false){
                                                    echo("<input type=\"submit\" class=\"booking-button-red\" id=\"submit\" value=\"Booked\">");
                                                } else if ($isBooked == false && $isMyCourt == false){
                                                    echo("<input type=\"submit\" class=\"booking-button-green\" id=\"submit\" value=\"Book now!\">");
                                                } else if($isBooked == true && $isMyCourt == true){
                                                    echo("<input type=\"submit\" class=\"booking-button-blue\" id=\"submit\" value=\"Your Court\">");
                                                }
                                                ?>
                                            </form>
                                        </td>
                                                
                                    <?php } ?>
                                </div>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
    </body>
</html>

<?php
    // Funktion der beregnet ugens datoer.
    function calcWeekDays(){
        $days = [];

        $dt = new DateTime(); // Indbygget klasse med library

        $timeStampOneDay = 86400; // Sekunder på et døgn.
        // For hver dag på ugen tilføjes der en dato til listen "days".
        for($i = 0; $i < 7; $i++){
            $stringDate = $dt->format("l jS F Y"); // Formaterer datoen "$dt" til "dag, dagstal, månednavn, årstal".
            array_push($days, $stringDate); // Tilføjer dato til listen.
            $dt->setTimestamp($dt->getTimestamp()+$timeStampOneDay); // Går en dag frem til næste loop.
        }
        return $days; // returnerer listen.
    }

    function calcTimes(){
        $times = [];
        // For hver time på døgnet tilføjes en string med tiden i formatet "time:minut".
        for($i = 0;$i < 24;$i++){
            $time = strval($i);
            
            if(strlen($i) == 1){
                $time = "0$time";
                
            }
            $time = "$time:00";
            array_push($times, $time);
        }
        return $times;
    }

    function SQLNewDay(){
        global $days, $baner, $times, $db;

        foreach($days as $day){
            // Hvis der er en dato på ugen som ikke har en tabel, så oprettes tabellen i databasen.
            $selectSQL = "SELECT * FROM `courts` WHERE date='$day';";
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die();
            }
            if(mysqli_num_rows($result) == 0){
                // Hvis dagen ikke findes, så oprettes den.
                print("Added new day");
                foreach($baner as $bane){
                    foreach($times as $time){
                        $insertSQL = "INSERT INTO `courts` (`court_number`, `date`, `time`)
                        VALUES (
                            '$bane',
                            '$day',
                            '$time'
                        );";
                        $result = mysqli_query($db, $insertSQL);
                        if(!$result){
                            die();
                        }
                    }
                }
            }
        }

        // Delete previous days
        $day = calcPrevDay(); // Beregner dato for tidligere dag.
        $selectSQL = "SELECT `id` FROM `courts` WHERE `date`='$day';"; // Vælgerr baner som ligger på den tigligere dag.
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die();
        }
        // For hver tigligere bane bliver den fjernet både fra bookninger og baner.
        while($row = mysqli_fetch_assoc($result)){
            extract($row);
            $court_id = $row["id"];
            $deleteSQL = "DELETE FROM `bookings` WHERE court_id='$court_id';";
            $resultDelete = mysqli_query($db,$deleteSQL);
            if(!$resultDelete){
                die();
            }
            $deleteSQL = "DELETE FROM `courts` WHERE id='$court_id';";
            $resultDelete = mysqli_query($db, $deleteSQL);
            if(!$resultDelete){
                die();
            }
        }


    }

    // Funktion der beregner tidligere dags dato.
    function calcPrevDay(){
        $dt = new DateTime();
        $timeStampOneDay = 86400;
        $dt->setTimestamp($dt->getTimestamp()-$timeStampOneDay);
        $day = $dt->format("l jS F Y");
        return $day;
    }
?>