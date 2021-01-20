<?php
    session_start();
    session_destroy();
    print("hi");
    header("Location: ../Home-Page.php");
?>