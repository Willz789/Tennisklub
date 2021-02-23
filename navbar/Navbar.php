<html>
    <head>
        <link rel="stylesheet" href="./Style/Navbar.css"> <!-- Stylesheet -->
        <script src="./navbar/Navbar.js" defer></script> <!-- Kører javascript efter dette script. -->
    </head>
        <!-- Liste med elementer i navbaren. -->
        <ul class="navbar">
            <li class="nav-item">
                <a class="navbar-link" href="./Home-Page.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="navbar-link" href="./Training.php">Training</a>
            </li>
            <li class="nav-item">
                <a class="navbar-link" href='./Booking.php'>Booking</a>
            </li>
            <li class="nav-item">
                <a class="navbar-link" href="./Forum.php">Forum</a>
            </li>
            <?php
            if(!isset($_SESSION['user_id'])){ // De næste inde i dette if-statement er kun vist, hvis man ikke er logget ind.
                ?>
                <li class="nav.item" style="float:right">
                    <a class="navbar-link" href="./CreateAccount.php">Sign up</a>
                </li>
                <li class="nav.item" style="float:right">
                    <a class="navbar-link" href="./Login.php">Login</a>
                </li>
                <?php
            } else { // De næste er kun vist, hvis man er logget ind.
                ?>
                <li class="nav-item" style="float:right">
                    <a class="navbar-link" href='account/logout.php'>Log out</a>
                </li>
                <?php
                if(($_SESSION['role']) != 0){ // Disse elementer er kun vist, hvis man enten er træner eller admin.
                    ?>
                <li class="nav-item">
                    <a class="navbar-link" href='./CreatePost.php'>Create post</a>
                </li>
                <?php
                }
                if(isset($_SESSION['role'])){
                    if($_SESSION['role'] == 2){ // Man skal kun kunne tildele roller på hjemmesiden, hvis man er admin.
                        ?>
                        <li class="nav-item">
                            <a class="navbar-link" href='./AssignRoles.php'>Assign Roles</a>
                        </li>
                        <?php
                    }
                }
            }
            ?>
        </ul>

    </body>
</html>