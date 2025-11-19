<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard - {{ config('app.name', 'Laravel') }}</title>
    
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
            background: none;
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
            background: none;
            border: none;
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
            min-width: 220px;
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
            width: 100%;
            text-align: left;
            background: none;
            border: none;
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
            margin-bottom: 10px;
        }
        
        .welcome-text {
            color: #6c757d;
            margin-bottom: 25px;
        }
        
        /* Profile Card */
        .profile-card {
            background: linear-gradient(135deg, #6777ef 0%, #5a68d8 100%);
            border-radius: 12px;
            padding: 30px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 4px 25px 0 rgba(103, 119, 239, 0.3);
        }
        
        .profile-card-content {
            display: flex;
            align-items: center;
            gap: 25px;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }
        
        .profile-info h3 {
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        
        .profile-info p {
            margin: 0;
            opacity: 0.9;
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
        
        /* Activity Card */
        .activity-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            margin-bottom: 25px;
        }
        
        .activity-card-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f4f6f9;
        }
        
        .activity-card-title {
            font-size: 18px;
            font-weight: 600;
            color: #34395e;
            margin: 0;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f4f6f9;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        
        .activity-content h6 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: 600;
            color: #34395e;
        }
        
        .activity-content p {
            margin: 0;
            font-size: 13px;
            color: #6c757d;
        }
        
        .activity-time {
            font-size: 12px;
            color: #95aac9;
            margin-top: 5px;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .quick-action-btn {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: #34395e;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
            transition: all 0.3s;
        }
        
        .quick-action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 35px 0 rgba(0,0,0,.15);
            color: var(--primary-color);
        }
        
        .quick-action-btn i {
            font-size: 32px;
            margin-bottom: 10px;
            display: block;
        }
        
        .quick-action-btn span {
            font-size: 14px;
            font-weight: 500;
        }
        
        /* Table */
        .table-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 25px 0 rgba(0,0,0,.1);
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
            background: #d4edda;
            color: #155724;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .badge-primary {
            background: #e7eaf6;
            color: var(--primary-color);
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
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
            
            .profile-card-content {
                flex-direction: column;
                text-align: center;
            }
            
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4><i class="fas fa-cube"></i> {{ config('app.name', 'MyApp') }}</h4>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
            <li><a href="#"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
            <li><a href="#"><i class="fas fa-heart"></i> Wishlist</a></li>
            <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
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
                        <button class="user-dropdown-toggle" id="userDropdownToggle">
                            <span class="text-muted d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        </button>
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                                <div class="user-dropdown-email">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="user-dropdown-body">
                                <a href="#" class="user-dropdown-item">
                                    <i class="fas fa-user"></i> My Profile
                                </a>
                                <a href="#" class="user-dropdown-item">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                                <div class="user-dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="user-dropdown-item">
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
            <p class="welcome-text">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your account today.</p>

            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-card-content">
                    <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="profile-info">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p><i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}</p>
                        <p><i class="fas fa-calendar me-2"></i>Member since {{ Auth::user()->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-shopping-cart" style="color: #6777ef;"></i>
                    <span>New Order</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-box" style="color: #47c363;"></i>
                    <span>Track Order</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-history" style="color: #ffa426;"></i>
                    <span>Order History</span>
                </a>
                <a href="#" class="quick-action-btn">
                    <i class="fas fa-headset" style="color: #fc544b;"></i>
                    <span>Support</span>
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stats-card-title">Total Orders</div>
                        <div class="stats-card-value">24</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-card-title">Completed</div>
                        <div class="stats-card-value">18</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-card-title">Pending</div>
                        <div class="stats-card-value">4</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-card-icon bg-danger">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stats-card-title">Wishlist</div>
                        <div class="stats-card-value">12</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Activity -->
                <div class="col-lg-6">
                    <div class="activity-card">
                        <div class="activity-card-header">
                            <h5 class="activity-card-title">Recent Activity</h5>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #47c363;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Order Delivered</h6>
                                <p>Your order #12345 has been delivered successfully</p>
                                <div class="activity-time">2 hours ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #6777ef;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="activity-content">
                                <h6>New Order Placed</h6>
                                <p>Order #12346 has been placed and is being processed</p>
                                <div class="activity-time">5 hours ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #ffa426;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Review Submitted</h6>
                                <p>Thank you for reviewing your recent purchase</p>
                                <div class="activity-time">1 day ago</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-lg-6">
                    <div class="table-card">
                        <div class="table-card-header">
                            <h5 class="activity-card-title">Recent Orders</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#12346</td>
                                        <td>Nov 18, 2025</td>
                                        <td><span class="badge-primary">Processing</span></td>
                                        <td>$125.00</td>
                                    </tr>
                                    <tr>
                                        <td>#12345</td>
                                        <td>Nov 17, 2025</td>
                                        <td><span class="badge-success">Delivered</span></td>
                                        <td>$89.50</td>
                                    </tr>
                                    <tr>
                                        <td>#12344</td>
                                        <td>Nov 15, 2025</td>
                                        <td><span class="badge-warning">Pending</span></td>
                                        <td>$56.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('show');
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

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>