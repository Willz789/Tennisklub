<?php
    /*
    Session gemmer variable mellem scripts (I vores tilfælde er det login-credentials).
    */
    session_start(); 
    session_destroy(); // Jeg ødelægger al' data i sessionen.
    header("Location: ../Home-Page.php"); // Jeg går til hjem-siden.
?>




