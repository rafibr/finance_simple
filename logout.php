<?php 
session_start();

// for logout
session_destroy();

// redirect to login
header('Location: login.php');