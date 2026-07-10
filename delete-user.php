<?php
include 'config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];


    $sqlSelect = "SELECT * FROM users WHERE id = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $userId);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();


        $sqlInsert = "INSERT INTO archive_users (id, fname, lname, email, password, role, date_created, time_deleted) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param(
            "issssss",
            $user['id'],
            $user['fname'],
            $user['lname'],
            $user['email'],
            $user['password'],
            $user['role'],
            $user['date_created']
        );

        if ($stmtInsert->execute()) {

            $sqlDelete = "DELETE FROM users WHERE id = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $userId);

            if ($stmtDelete->execute()) {
                echo "<script>
                        alert('User moved to archive successfully!');
                        window.location.href = 'manage-user.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Error deleting user from users table!');
                        window.location.href = 'manage-user.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Error archiving user!');
                    window.location.href = 'manage-user.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not found!');
                window.location.href = 'manage-user.php';
              </script>";
    }


    $stmtSelect->close();
    $stmtInsert->close();
    $stmtDelete->close();
    $conn->close();
} else {
    echo "<script>
            alert('Invalid user ID!');
            window.location.href = 'manage-user.php';
          </script>";
}
