<?php
session_start();
include 'config.php';

if (isset($_POST['add_user'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "INSERT INTO users (fname, lname, email, password, role) VALUES ('$fname','$lname', '$email', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "New account added successfully!";
    } else {
        $_SESSION['error'] = "Error adding account: " . mysqli_error($conn);
    }

    header("Location: manage-user.php");
    exit();
}
