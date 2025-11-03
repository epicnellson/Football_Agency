<?php
// includes/admin_check.php
require_once 'auth_check.php';

if ($_SESSION['user_role'] != 'admin') {
    header('Location: ../dashboard.php');
    exit();
}
?>