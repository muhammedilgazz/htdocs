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

<?php include ROOT_PATH . '/views/partials/head.php'?>

<body class="dashboard">

<?php include ROOT_PATH . '/views/partials/preloader.php'?>

    <div id="main-wrapper">
        <div class="d-flex">
            <?php
                if (!isset($sidebar) || $sidebar === true) {
                    include ROOT_PATH . '/views/partials/sidebar.php';
                }
            ?>
            
            <div class="flex-grow-1" style="margin-left:280px;">
                <?php
                    if (!isset($header) || $header === true) {
                        include ROOT_PATH . '/views/partials/header.php';
                    }
                ?>
                
                <div class="page-content">