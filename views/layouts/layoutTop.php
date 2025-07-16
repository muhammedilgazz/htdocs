<?php
if (file_exists(__DIR__ . '/../../config/config.php')) {
    require_once __DIR__ . '/../../config/config.php';
}
if (file_exists(__DIR__ . '/../../bootstrap.php')) {
    require_once __DIR__ . '/../../bootstrap.php';
}
?>
<!DOCTYPE html>

<!--
 // Name: ekash
 // Description: Personal Finance Management Admin Dashboard PHP Template
 // Version: 1.0.0
 // Email : pixcelsthemes@gmail.com
 // Author: Pixcels Themes
 // URL: https://themeforest.net/user/pixcelsthemes/portfolio
 // Themeforest Profile : https://themeforest.net/user/pixcelsthemes/portfolio
-->

<html lang="tr">

<?php include './partials/head.php'?>

<body class="dashboard">

<?php include './partials/preloader.php'?>

    <div id="main-wrapper">

        <?php 
            if (!isset($header)) {
                include './partials/header.php';
            }
        ?>

        <?php 
            if (!isset($sidebar)) {
                include './partials/sidebar.php';
            }
        ?>