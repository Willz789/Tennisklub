<?php
    session_start(); // Sessions der gemmer variable mellem scripts (Ens login-credentials, så siden husker hvem der er logget ind).
    session_destroy(); // Jeg ødelægger al' data i sessionen.
    header("Location: ../Home-Page.php"); // Jeg går til hjem-siden.
?>