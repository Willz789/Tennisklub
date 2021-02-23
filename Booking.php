<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    require_once("./core/db_connect.php");
    ?>
    <head>
        <link rel="stylesheet" href="./Style/Booking.css">
        <!-- <link rel="stylesheet" href="./Style/Modal.css"> -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    </head>
    <body>
        <?php include("./navbar/Navbar.php"); 
        if(!isset($_SESSION['user_id'])){
            die();
        } 

        $baner = [1,2,3,4,5];
        $days = calcWeekDays();
        $times = calcTimes();
        SQLNewDay();

        ?>
        <div class="bookings-tables">
        <?php
        foreach($days as $day){
            ?>
            <div class="day-div">
                <div class="title-div"><p><?php echo($day) ?></p></div>
                <div>
                    <table>
                        <tr>
                            <td></td>
                            <td class="table-court-number">Court 1</td>
                            <td class="table-court-number">Court 2</td>
                            <td class="table-court-number">Court 3</td>
                            <td class="table-court-number">Court 4</td>
                            <td class="table-court-number">Court 5</td>
                        </tr>
                        <?php
                        foreach($times as $time){
                            ?>
                            <tr>
                                <th class="table-row-time"><?php echo $time ?></th>
                                <div class="bookings-row">
                                    <?php
                                    foreach($baner as $bane){
                                        $selectCourtsSQL = "SELECT id FROM courts WHERE `date`='$day' AND `time`='$time' AND `court_number`='$bane';";
                                        $result = mysqli_query($db, $selectCourtsSQL);
                                        if(!$result){die("NO RESULT");}
                                        $results = mysqli_num_rows($result);
                                        if($results == 0 || $results > 1){die("WRONG RESULT SIZE $results");}
                                        $row = mysqli_fetch_assoc($result);
                                        $id = $row["id"];

                                        $selectBookingsSQL = "SELECT * FROM bookings WHERE court_id='$id';";
                                        $result = mysqli_query($db, $selectBookingsSQL);
                                        if(!$result){die("NO RESULT");}
                                        $results = mysqli_num_rows($result);
                                        if($results > 1){die("WRONG RESULT SIZE $results");}

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

                                        <td class="table-field-booking">
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
    function calcWeekDays(){
        $days = [];

        $dt = new DateTime();

        $timeStampOneDay = 86400;
        for($i = 0; $i < 7; $i++){
            $stringDate = $dt->format("l jS F Y");
            array_push($days, $stringDate);
            $dt->setTimestamp($dt->getTimestamp()+$timeStampOneDay);
        }
        return $days;
    }

    function calcTimes(){
        $times = [];
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
            $selectSQL = "SELECT * FROM `courts` WHERE date='$day';";
            $result = mysqli_query($db, $selectSQL);
            if(!$result){
                die();
            }
            if(mysqli_num_rows($result) == 0){
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
        $day = calcPrevDay();
        $selectSQL = "SELECT `id` FROM `courts` WHERE `date`='$day';";
        $result = mysqli_query($db, $selectSQL);
        if(!$result){
            die("sdafds");
        }
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

    function calcPrevDay(){
        $dt = new DateTime();
        $timeStampOneDay = 86400;
        $dt->setTimestamp($dt->getTimestamp()-$timeStampOneDay);
        $day = $dt->format("l jS F Y");
        return $day;
    }
?>