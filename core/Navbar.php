<html>
    <head>
        <link rel="stylesheet" href="./Style/Navbar.css">
        <script src="./core/Navbar.js" defer></script>
    </head>
    <body>
        <ul class="navbar">
            <li class="nav-item">
                <a class="navbar-link" href="./Home-Page.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="navbar-link" href="./Forum.php">Forum</a>
            </li>
            <?php
            if(!isset($_SESSION['user_id'])){
                ?>
                <li class="nav.item" style="float:right">
                    <a class="navbar-link" href="./CreateAccount.php">Sign up</a>
                </li>
                <li class="nav.item" style="float:right">
                    <a class="navbar-link" href="./Login.php">Login</a>
                </li>
                <?php
            } else {
                ?>
                <li class="nav-item" style="float:right">
                    <a class="navbar-link" href='account/logout.php'>Log out</a>
                </li>
                <li class="nav-item">
                    <a class="navbar-link" href='./Booking.php'>Booking</a>
                </li>
                
                <?php
            }
            ?>
        </ul>

    </body>
</html>