<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: admin-dashboard.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT id, fname, lname, email, role, date_created FROM users WHERE id = ? AND time_deleted IS NULL LIMIT 1');
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

$user = $result->fetch_assoc();
$fullName = trim($user['fname'] . ' ' . $user['lname']);
$firstName = $user['fname'];
$memberSince = !empty($user['date_created']) ? date('F d, Y', strtotime($user['date_created'])) : 'Not available';
$today = date('F d, Y');
$currentTime = date('h:i A');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="AdminLTE/plugins/bootstrap/css/bootstrap.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="user-dashboard.php" class="nav-link">Home</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link text-muted"><?php echo htmlspecialchars($fullName); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="user-dashboard.php" class="brand-link">
                <i class="brand-image img-circle elevation-3 fas fa-th-large bg-primary text-white text-center" style="width: 33px; height: 33px; line-height: 33px; opacity: .9"></i>
                <span class="brand-text font-weight-light">Admin4GLTE</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="images/gwapo.png" class="img-circle elevation-2" alt="User profile">
                    </div>
                    <div class="info">
                        <a href="user-dashboard.php" class="d-block"><?php echo htmlspecialchars($fullName); ?></a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="user-dashboard.php" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
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

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Welcome, <?php echo htmlspecialchars($firstName); ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="user-dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Account Status</span>
                                    <span class="info-box-number">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-success"><i class="fas fa-id-badge"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Account Role</span>
                                    <span class="info-box-number"><?php echo ucfirst(htmlspecialchars($user['role'])); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-warning"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Member Since</span>
                                    <span class="info-box-number"><?php echo htmlspecialchars($memberSince); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="images/gwapo.png" alt="User profile picture">
                                    </div>
                                    <h3 class="profile-username text-center"><?php echo htmlspecialchars($fullName); ?></h3>
                                    <p class="text-muted text-center"><?php echo ucfirst(htmlspecialchars($user['role'])); ?> Account</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Email</b>
                                            <span class="float-right text-muted"><?php echo htmlspecialchars($user['email']); ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <b>User ID</b>
                                            <span class="float-right text-muted">#<?php echo (int) $user['id']; ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Joined</b>
                                            <span class="float-right text-muted"><?php echo htmlspecialchars($memberSince); ?></span>
                                        </li>
                                    </ul>

                                    <a href="logout.php" class="btn btn-danger btn-block">
                                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Account Overview</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="callout callout-info">
                                                <h5>Today</h5>
                                                <p class="mb-0"><?php echo htmlspecialchars($today); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="callout callout-success">
                                                <h5>Current Time</h5>
                                                <p class="mb-0"><?php echo htmlspecialchars($currentTime); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline timeline-inverse mt-3">
                                        <div class="time-label">
                                            <span class="bg-primary">Dashboard</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-user bg-info"></i>
                                            <div class="timeline-item">
                                                <h3 class="timeline-header">Your account is ready</h3>
                                                <div class="timeline-body">
                                                    You are signed in as <?php echo htmlspecialchars($fullName); ?>. Use this dashboard to review your account details and session information.
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-shield-alt bg-success"></i>
                                            <div class="timeline-item">
                                                <h3 class="timeline-header">Secure session active</h3>
                                                <div class="timeline-body">
                                                    Remember to log out when you finish using the system, especially on shared computers.
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="AdminLTE/dist/js/adminlte.min.js"></script>
</body>

</html>