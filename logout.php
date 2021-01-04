<?php
session_start();///active
session_unset();///desactive
session_destroy();////Detruit

header('location: index.php');
?>