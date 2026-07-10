    <?php
    include 'config.php';

    $sql = "SELECT id, fname, lname, email, role, time_deleted FROM archive_users WHERE time_deleted IS NOT NULL";
    $result = $conn->query($sql);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Archived Users</title>

        <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="AdminLTE/plugins/bootstrap/css/bootstrap.min.css">

        <!-- DataTables -->
        <link rel="stylesheet" href="AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                                <a href="admin-dashboard.php" class="nav-link">
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
                                <a href="archive-users.php" class="nav-link active">
                                    <i class="nav-icon fas fa-archive"></i>
                                    <p>Archived Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="logout.php" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                        </ul>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <h1 class="m-0">Archived Users</h1>
                    </div>
                </div>

                <!-- Archived Users Table -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Deleted User List</h3>
                            </div>
                            <div class="card-body">
                                <table id="archivedUsersTable" class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Time Deleted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['fname']); ?></td>
                                                <td><?php echo htmlspecialchars($row['lname']); ?></td>
                                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                                <td><?php echo date('m/d/y h:i:s A', strtotime($row['time_deleted'])) ?></td>
                                                <td>
                                                    <a href="recover-user.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">
                                                        <i class="fas fa-undo"></i> Recover
                                                    </a>
                                                    <a href="delete-user-permanently.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user permanently?');">
                                                        <i class="fas fa-trash"></i> Delete Permanently
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

        </div>

        <!-- Scripts -->
        <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
        <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="AdminLTE/dist/js/adminlte.min.js"></script>

        <!-- DataTables Scripts -->
        <script src="AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#archivedUsersTable").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "ordering": false
                });
            });
        </script>

    </body>

    </html>