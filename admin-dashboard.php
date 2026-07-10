<?php
session_start();
include 'config.php';


$query = "SELECT COUNT(*) AS total_accounts FROM users";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_accounts = $row['total_accounts'];


$query = "SELECT COUNT(*) AS total_users FROM users WHERE role = 'user'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_users = $row['total_users'];


$query = "SELECT COUNT(*) AS total_admins FROM users WHERE role = 'admin'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_admins = $row['total_admins'];


$query = "SELECT COUNT(*) AS deleted_users FROM archive_users";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$deleted_users = $row['deleted_users'];


$user_vs_admin_query = "SELECT 
    (SELECT COUNT(*) FROM users WHERE role = 'user') AS user_count, 
    (SELECT COUNT(*) FROM users WHERE role = 'admin') AS admin_count";
$user_vs_admin_result = mysqli_query($conn, $user_vs_admin_query);
$user_vs_admin = mysqli_fetch_assoc($user_vs_admin_result);
$user_count = $user_vs_admin['user_count'];
$admin_count = $user_vs_admin['admin_count'];


$monthly_registrations_query = "
    SELECT MONTH(date_created) AS month, COUNT(*) AS count 
    FROM users 
    WHERE YEAR(date_created) = YEAR(CURDATE()) 
    GROUP BY MONTH(date_created)";
$monthly_result = mysqli_query($conn, $monthly_registrations_query);


$monthly_registrations = array_fill(1, 12, 0);

while ($row = mysqli_fetch_assoc($monthly_result)) {
    $monthly_registrations[$row['month']] = $row['count'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- AdminLTE CSS (Local) -->
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">

    <!-- Font Awesome (Local) -->
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">

    <!-- Bootstrap (Local) -->
    <link rel="stylesheet" href="AdminLTE/plugins/bootstrap/css/bootstrap.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <!-- Sidebar Toggle Button -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <!-- Home Button -->
                <li class="nav-item">
                    <a href="admin-dashboard.php" class="nav-link"><i></i> Home</a>
                </li>
            </ul>

            <!-- Right-aligned Navbar Items -->
            <ul class="navbar-nav ml-auto">
                <!-- Expand Button -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="admin-dashboard.php" class="brand-link">
                <img src="images/gwapo.png" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin4GLTE</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="admin-dashboard.php" class="nav-link active">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="manage-user.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="archive-users.php" class="nav-link">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>Archive Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Welcome to Admin Dashboard</h1>
                </div>
            </div>

            <!-- Info Boxes with Shadows -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="info-box shadow-lg bg-light">
                                <span class="info-box-icon bg-info"><i class="fas fa-chart-bar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Accounts</span> <!-- all user/admin in user database -->
                                    <span class="info-box-number"><?php echo $total_accounts; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="info-box shadow-lg bg-light">
                                <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Users</span> <!-- total user in user database -->
                                    <span class="info-box-number"><?php echo $total_users; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="info-box shadow-lg bg-light">
                                <span class="info-box-icon bg-warning"><i class="fas fa-cogs"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Admins</span> <!-- total admin in user database -->
                                    <span class="info-box-number"><?php echo $total_admins; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="info-box shadow-lg bg-light">
                                <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Deleted Users</span> <!-- all deleted in archive table -->
                                    <span class="info-box-number"><?php echo $deleted_users; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- User & Admin Pie Chart and Bar Chart -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Pie Chart Card -->
                        <div class="col-md-6">
                            <div class="card card-info" style="height: 55vh;">
                                <div class="card-header">
                                    <h3 class="card-title">User & Admin Distribution</h3> <!-- user and admin distribution in user database -->
                                </div>
                                <div class="card-body">
                                    <canvas id="userRolePieChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart Card -->
                        <div class="col-md-6">
                            <div class="card card-warning" style="height: 55vh;">
                                <div class="card-header">
                                    <h3 class="card-title">User Registrations Per Month (2025)</h3> <!-- total user role register in each month this 2025 -->
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyUserBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </div>

    </div>
    <!-- AdminLTE Scripts -->
    <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="AdminLTE/dist/js/adminlte.min.js"></script>

    <!-- Chart.js -->
    <script src="AdminLTE/plugins/chart.js/Chart.min.js"></script>

    <script>
        $(function() {

            var ctx1 = document.getElementById('userRolePieChart').getContext('2d');
            var userRolePieChart = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: ['Users', 'Admins'],
                    datasets: [{
                        data: [<?php echo $user_count; ?>, <?php echo $admin_count; ?>],
                        backgroundColor: ['#007bff', '#28a745'],
                        hoverBackgroundColor: ['#0056b3', '#1c7430']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });


            var ctx2 = document.getElementById('monthlyUserBarChart').getContext('2d');
            var monthlyUserBarChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Registrations',
                        data: [<?php echo implode(',', $monthly_registrations); ?>],
                        backgroundColor: '#ffc107',
                        borderColor: '#ff9800',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 10,
                            suggestedMax: 50,
                            ticks: {
                                stepSize: 5,
                                callback: function(value) {
                                    return value;
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>


</body>

</html>