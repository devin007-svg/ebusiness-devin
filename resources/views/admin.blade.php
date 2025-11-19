<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #6777ef;
            --sidebar-bg: #ffffff;
            --sidebar-text: #34395e;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed {
            left: calc(-1 * var(--sidebar-width));
        }
        
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #f4f6f9;
        }
        
        .sidebar-brand h4 {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }
        
        .sidebar-menu li {
            margin: 5px 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--primary-color);
            color: white;
        }
        
        .sidebar-menu i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        /* Navbar */
        .navbar-custom {
            background: white;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            padding: 15px 30px;
        }
        
        .navbar-toggler {
            border: none;
            font-size: 24px;
            color: var(--sidebar-text);
            cursor: pointer;
        }
        
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .user-dropdown-toggle:hover {
            background: #f4f6f9;
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 25px 0 rgba(0,0,0,.15);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s;
            z-index: 1001;
        }
        
        .user-dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .user-dropdown-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f4f6f9;
        }
        
        .user-dropdown-name {
            font-weight: 600;
            color: #34395e;
            margin-bottom: 3px;
        }
        
        .user-dropdown-email {
            font-size: 13px;
            color: #6c757d;
        }
        
        .user-dropdown-body {
            padding: 10px 0;
        }
        
        .user-dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #34395e;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .user-dropdown-item:hover {
            background: #f4f6f9;
            color: var(--primary-color);
        }
        
        .user-dropdown-item i {
            margin-right: 12px;
            width: 18px;
        }
        
        .user-dropdown-divider {
            height: 1px;
            background: #f4f6f9;
            margin: 10px 0;
        }
        
        /* Dashboard Content */
        .dashboard-content {
            padding: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #34395e;
            margin-bottom: 25px;
        }
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            margin-bottom: 25px;
            transition: all 0.3s;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 35px 0 rgba(0,0,0,.15);
        }
        
        .stats-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }
        
        .stats-card-icon.bg-primary { background: var(--primary-color); }
        .stats-card-icon.bg-success { background: #47c363; }
        .stats-card-icon.bg-warning { background: #ffa426; }
        .stats-card-icon.bg-danger { background: #fc544b; }
        
        .stats-card-title {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .stats-card-value {
            font-size: 28px;
            font-weight: 700;
            color: #34395e;
        }
        
        /* Chart Card */
        .chart-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            margin-bottom: 25px;
        }
        
        .chart-card-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f4f6f9;
        }
        
        .chart-card-title {
            font-size: 18px;
            font-weight: 600;
            color: #34395e;
        }
        
        /* Table */
        .table-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            overflow-x: auto;
        }
        
        .table-card-header {
            margin-bottom: 20px;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #34395e;
        }
        
        .badge-success {
            background: #47c363;
        }
        
        .badge-warning {
            background: #ffa426;
        }
        
        .badge-danger {
            background: #fc544b;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .navbar-user span {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><i class="fas fa-cube"></i> MyAdmin</h4>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="#"><i class="fas fa-box"></i> Products</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Navbar -->
        <nav class="navbar-custom">
            <div class="d-flex justify-content-between align-items-center w-100">
                <button class="navbar-toggler" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="navbar-user">
                    <div class="user-dropdown">
                        <div class="user-dropdown-toggle" id="userDropdownToggle">
                            <span class="text-muted d-none d-md-inline">Admin User</span>
                            <div class="user-avatar">A</div>
                        </div>
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-name">Admin User</div>
                                <div class="user-dropdown-email">admin@example.com</div>
                            </div>
                            <div class="user-dropdown-body">
                                <a href="#" class="user-dropdown-item">
                                    <i class="fas fa-user"></i> My Profile
                                </a>
                                <a href="#" class="user-dropdown-item">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                                <div class="user-dropdown-divider"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="user-dropdown-item"
                                        style="background:none;border:none;width:100%;text-align:left;"
                                        onclick="return confirm('Logout sekarang?')">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <h1 class="page-title">Dashboard</h1>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-card-title">Total Users</div>
                        <div class="stats-card-value">1,234</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-success">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stats-card-title">Orders</div>
                        <div class="stats-card-value">567</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-warning">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stats-card-title">Revenue</div>
                        <div class="stats-card-value">$45,890</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-danger">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stats-card-title">Products</div>
                        <div class="stats-card-value">89</div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="chart-card">
                        <div class="chart-card-header">
                            <h5 class="chart-card-title">Sales Statistics</h5>
                        </div>
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="chart-card">
                        <div class="chart-card-header">
                            <h5 class="chart-card-title">Traffic Sources</h5>
                        </div>
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h5 class="chart-card-title">Recent Orders</h5>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>Premium Package</td>
                            <td>$299</td>
                            <td><span class="badge badge-success">Completed</span></td>
                            <td>2025-11-19</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>Standard Plan</td>
                            <td>$199</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>2025-11-19</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Mike Johnson</td>
                            <td>Basic Package</td>
                            <td>$99</td>
                            <td><span class="badge badge-success">Completed</span></td>
                            <td>2025-11-18</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Sarah Wilson</td>
                            <td>Enterprise Plan</td>
                            <td>$599</td>
                            <td><span class="badge badge-danger">Cancelled</span></td>
                            <td>2025-11-18</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // User Dropdown Toggle
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        
        userDropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                userDropdownMenu.classList.remove('show');
            }
        });

        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: '#6777ef',
                    backgroundColor: 'rgba(103, 119, 239, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Traffic Chart
        const trafficCtx = document.getElementById('trafficChart').getContext('2d');
        new Chart(trafficCtx, {
            type: 'doughnut',
            data: {
                labels: ['Direct', 'Organic', 'Social', 'Referral'],
                datasets: [{
                    data: [35, 30, 20, 15],
                    backgroundColor: ['#6777ef', '#47c363', '#ffa426', '#fc544b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>