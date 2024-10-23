<?php
    $databaseHost = 'localhost';
    $databaseName = 'todolist';
    $databaseUsername = 'root';
    $databasePassword = '';

    // Koneksi database
    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    // cek apakah koneksi ke database behasil
    if (!$mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }