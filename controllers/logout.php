<?php
session_start();
unset($_SESSION["USER_ID"]);
unset($_SESSION["name"]);
header("Location: ../index.html");
?>