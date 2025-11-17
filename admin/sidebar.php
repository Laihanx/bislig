<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bislig Tourism Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1d4ed8;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --secondary-color: #e0f2fe;
            --accent-color: #fbbf24;
            --text-color: #333333;
            --light-text: #ffffff;
            --muted-text: #777777;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --sidebar-width: 270px;
            --sidebar-collapsed: 80px;
            --header-height: 70px;
            --border-radius: 10px;
            --card-radius: 12px;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            --sidebar-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            --card-shadow: 0 6px 15px rgba(29, 78, 216, 0.08);
            --transition: all 0.3s ease;
            --menu-item-height: 50px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Menu item styling */
        .menu-item {
            margin: 3px 0;
            height: var(--menu-item-height);
            position: relative;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 20px;
            color: var(--light-text);
            text-decoration: none;
            transition: var(--transition);
            border-left: 4px solid transparent;
            box-sizing: border-box;
        }

        .menu-item a i {
            margin-right: 15px;
            font-size: 1.1em;
            min-width: 20px;
            text-align: center;
            transition: var(--transition);
        }

        .menu-item.active a {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--accent-color);
            font-weight: 500;
        }

        .menu-item a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent-color);
        }

        .menu-text {
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            transition: var(--transition);
        }

        /* Sidebar styling */
        .sidebar {
            background: linear-gradient(165deg, var(--primary-color), var(--primary-dark));
            color: var(--light-text);
            transition: transform var(--transition), width var(--transition);
            width: var(--sidebar-width);
            position: fixed;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 100;
            box-shadow: var(--sidebar-shadow);
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px 0;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
            text-align: center;
        }

        .sidebar-logo {
            display: flex;
            margin-left: 23px;
            align-items: center;
            padding: 0 15px;
            margin-bottom: 10px;
            transition: var(--transition);
            width: 100%;
            box-sizing: border-box;
        }

        .sidebar-logo img {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            margin: 0 0 10px 0;
            object-fit: cover;
            border: 3px solid var(--accent-color);
            box-shadow: 0 0 8px rgba(251, 191, 36, 0.5);
            transition: var(--transition);
            display: block;
            cursor: pointer;
        }

        .sidebar-logo img:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
        }

        .sidebar.collapsed .sidebar-logo img {
            margin: 0 auto;
            width: 45px;
            height: 45px;
            border-width: 2px;
        }

        .sidebar-logo h2 {
            font-size: 1.4rem;
            text-align: left;
            padding-left: 10px;
            margin: 0;
            font-weight: 700;
            color: var(--accent-color);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            transition: opacity var(--transition);
        }

        .sidebar.collapsed .sidebar-logo h2 {
            opacity: 0;
            height: 0;
            overflow: hidden;
            pointer-events: none;
            margin-top: 0;
            margin-bottom: 0;
        }

        .user-role {
            color: var(--accent-color);
            text-transform: uppercase;
            font-weight: 600;
            padding: 5px 15px;
            margin-top: -30px;
            margin-left: 18px;
            border-radius: 4px;
            font-size: 0.85rem;
            text-align: center;
            transition: opacity var(--transition);
            width: 100%;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar.collapsed .user-role {
            opacity: 0;
            height: 0;
            overflow: hidden;
            pointer-events: none;
            margin-top: 0;
            margin-bottom: 0;
        }

        .menu-list {
            list-style: none;
            padding: 10px 0;
            margin: 0;
            flex-grow: 1;
        }

        /* Mobile hamburger button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--light-text);
            z-index: 101;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: var(--transition);
        }

        .mobile-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        .mobile-toggle i {
            font-size: 20px;
        }

        /* Desktop sidebar toggle button */
        .sidebar-toggle {
            position: fixed;
            left: calc(var(--sidebar-width) - 20px);
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--light-text);
            z-index: 101;
            transition: left var(--transition);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar.collapsed + .sidebar-toggle {
            left: calc(var(--sidebar-collapsed) - 20px);
        }

        .sidebar-toggle:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        .sidebar-toggle i {
            font-size: 18px;
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .sidebar.collapsed + .sidebar-toggle i {
            transform: rotate(180deg);
        }

        /* Collapsed state adjustments */
        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed .menu-item a {
            justify-content: center;
            padding: 0;
            position: relative;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.3em;
        }

        /* Tooltip for collapsed sidebar */
        .sidebar.collapsed .menu-item a::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            margin-left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.18s ease, visibility 0.18s ease, transform 0.18s ease;
            box-shadow: var(--shadow);
        }

        .sidebar.collapsed .menu-item a::before {
            content: '';
            position: absolute;
            left: calc(100% + 6px);
            top: 50%;
            transform: translateY(-50%);
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-right: 6px solid rgba(0, 0, 0, 0.85);
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.18s ease, visibility 0.18s ease;
        }

        .sidebar.collapsed .menu-item a:hover::after,
        .sidebar.collapsed .menu-item a:focus::after,
        .sidebar.collapsed .menu-item a:hover::before,
        .sidebar.collapsed .menu-item a:focus::before {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) translateX(5px);
        }

        .main-content {
            transition: margin-left var(--transition);
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
            background-color: var(--bg-color);
            box-sizing: border-box;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
        }

        /* Logout Item */
        .logout-item {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 5px;
        }

        .logout-item a {
            color: #ff6b6b;
        }

        .logout-item a:hover {
            background-color: rgba(255, 107, 107, 0.2);
            border-left-color: #ff6b6b;
            color: #ffffff;
        }

        .sidebar.collapsed .logout-item a i {
            color: #ff6b6b;
        }

        .menu-item.active a i {
            color: var(--accent-color);
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 40px;
            border-radius: var(--card-radius);
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
        }

        .welcome-section h1 {
            margin: 0 0 10px 0;
            font-size: 2.2rem;
            font-weight: 700;
        }

        .welcome-section p {
            margin: 0;
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .stat-card h3 {
            margin: 0 0 5px 0;
            font-size: 2rem;
            color: var(--text-color);
        }

        .stat-card p {
            margin: 0;
            color: var(--muted-text);
            font-size: 0.95rem;
        }

        /* Logout Modal Styling */
        #logoutModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        #logoutModal > div {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            width: 90%;
            max-width: 450px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modal-appear 0.3s ease-out forwards;
        }

        @keyframes modal-appear {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #logoutModal .fas {
            font-size: 60px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        #logoutModal h2 {
            margin: 15px 0 10px;
            font-size: 1.8rem;
            color: var(--text-color);
        }

        #logoutModal p {
            color: #555;
            margin-bottom: 30px;
            font-size: 1rem;
            line-height: 1.5;
        }

        #logoutModal button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 8px;
            font-size: 1rem;
        }

        #logoutModal button[onclick*="confirmLogout"] {
            background-color: #ff6b6b;
            color: white;
        }

        #logoutModal button[onclick*="confirmLogout"]:hover {
            background-color: #e05050;
            transform: translateY(-2px);
        }

        #logoutModal button[onclick*="hideLogoutPrompt"] {
            background-color: #cccccc;
            color: #333;
        }

        #logoutModal button[onclick*="hideLogoutPrompt"]:hover {
            background-color: #b3b3b3;
            transform: translateY(-2px);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: none;
            }

            .mobile-toggle {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
                box-shadow: none;
            }

            .sidebar.mobile-active {
                transform: translateX(0);
                box-shadow: var(--sidebar-shadow);
            }

            .sidebar.mobile-active .menu-text,
            .sidebar.mobile-active .sidebar-logo h2,
            .sidebar.mobile-active .user-role {
                display: block;
                opacity: 1;
                height: auto;
            }

            .sidebar.mobile-active .sidebar-logo img {
                margin: 0 0 10px 0;
                width: 60px;
                height: 60px;
            }

            .sidebar.mobile-active .menu-item a {
                justify-content: flex-start;
                padding: 0 20px;
            }

            .sidebar.mobile-active .menu-item i {
                margin-right: 15px;
            }

            .main-content {
                margin-left: 0;
                padding: 70px 15px 15px 15px;
            }

            .welcome-section h1 {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            #logoutModal > div {
                width: 95%;
                padding: 25px 20px;
            }

            #logoutModal button {
                display: block;
                width: 100%;
                margin: 5px 0;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 85%;
                max-width: 300px;
            }

            .mobile-toggle {
                width: 40px;
                height: 40px;
                top: 12px;
                left: 12px;
            }

            .main-content {
                padding: 65px 12px 12px 12px;
            }

            .welcome-section {
                padding: 25px 20px;
            }

            .welcome-section h1 {
                font-size: 1.5rem;
            }
        }

        @media print {
            .sidebar,
            .sidebar-toggle,
            .mobile-toggle,
            .sidebar-overlay,
            #logoutModal {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 20px !important;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Mobile Hamburger Toggle -->
<div class="mobile-toggle" id="mobileToggle">
    <i class="fas fa-bars"></i>
</div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="../assets/logo.jpg" alt="Bislig Tourism Logo" id="logoImage">
            <h2>Bislig Tourism</h2>
        </div>
        <div class="user-role">
            <span>Administrator</span>
        </div>
    </div>

    <ul class="menu-list">
        <li class="menu-item active">
            <a href="dashboard.php" data-title="Dashboard">
                <i class="fas fa-chart-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="manage_destinations.php" data-title="Manage Destinations">
                <i class="fas fa-map-marker-alt"></i>
                <span class="menu-text">Destinations</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="manage_restaurants.php" data-title="Manage Restaurants">
                <i class="fas fa-utensils"></i>
                <span class="menu-text">Restaurants</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="manage_accommodations.php" data-title="Manage Accommodations">
                <i class="fas fa-hotel"></i>
                <span class="menu-text">Accommodations</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="manage_attractions.php" data-title="Manage Attractions">
                <i class="fas fa-star"></i>
                <span class="menu-text">Attractions</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="manage_festivals.php" data-title="Manage Festivals">
                <i class="fas fa-calendar-alt"></i>
                <span class="menu-text">Festivals</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="manage_transportation.php" data-title="Manage Transportation">
                <i class="fas fa-bus"></i>
                <span class="menu-text">Transportation</span>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="manage_emergency.php" data-title="Emergency Contacts">
                <i class="fas fa-phone-alt"></i>
                <span class="menu-text">Emergency Contacts</span>
            </a>
        </li>
        
        
        <li class="menu-item logout-item">
            <a href="#" onclick="showLogoutPrompt(); return false;" data-title="Logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="menu-text">Logout</span>
            </a>
        </li>
    </ul>
</aside>

<!-- Desktop toggle button -->
<div class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-chevron-left" id="toggleIcon"></i>
</div>


<!-- Logout Confirmation Modal -->
<div id="logoutModal">
    <div>
        <i class="fas fa-sign-out-alt"></i>
        <h2>Confirm Logout</h2>
        <p>Are you sure you want to log out from the Bislig Tourism Admin Panel?</p>
        <button onclick="confirmLogout()">Yes, Logout</button>
        <button onclick="hideLogoutPrompt()">Cancel</button>
    </div>
</div>

<script>
    function showLogoutPrompt() {
        document.getElementById('logoutModal').style.display = 'flex';
    }

    function hideLogoutPrompt() {
        document.getElementById('logoutModal').style.display = 'none';
    }

    function confirmLogout() {
        window.location.href = 'logout.php';
        hideLogoutPrompt();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const desktopToggle = document.getElementById('sidebarToggle');
        const mobileToggle = document.getElementById('mobileToggle');
        const overlay = document.getElementById('sidebarOverlay');
        const mainContent = document.querySelector('.main-content');
        const logoImage = document.getElementById('logoImage');
        
        function isMobile() {
            return window.innerWidth <= 768;
        }

        // Desktop sidebar toggle
        if (desktopToggle) {
            const sidebarState = localStorage.getItem('sidebarState');
            
            if (!isMobile()) {
                if (sidebarState === 'collapsed') {
                    sidebar.classList.add('collapsed');
                    if (mainContent) {
                        mainContent.style.marginLeft = 'var(--sidebar-collapsed)';
                    }
                }
            }

            desktopToggle.addEventListener('click', function() {
                if (isMobile()) return;
                
                sidebar.classList.toggle('collapsed');

                if (sidebar.classList.contains('collapsed')) {
                    localStorage.setItem('sidebarState', 'collapsed');
                    if (mainContent) {
                        mainContent.style.marginLeft = 'var(--sidebar-collapsed)';
                    }
                } else {
                    localStorage.setItem('sidebarState', 'expanded');
                    if (mainContent) {
                        mainContent.style.marginLeft = 'var(--sidebar-width)';
                    }
                }
                updateLinkTitles();
            });
        }

        // Mobile sidebar toggle
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-active');
                overlay.classList.toggle('active');
                
                const icon = mobileToggle.querySelector('i');
                if (sidebar.classList.contains('mobile-active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        }

        // Close sidebar when clicking overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
                const icon = mobileToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            });
        }

        // Close mobile sidebar when clicking a menu item
        const menuLinks = document.querySelectorAll('.menu-item a:not(.logout-item a)');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (isMobile() && sidebar.classList.contains('mobile-active')) {
                    sidebar.classList.remove('mobile-active');
                    overlay.classList.remove('active');
                    const icon = mobileToggle.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });

        // Logo interaction
        if (logoImage) {
            logoImage.addEventListener('click', function() {
                logoImage.style.animation = 'none';
                setTimeout(() => {
                    logoImage.style.transform = 'scale(1.2) rotate(10deg)';
                    setTimeout(() => {
                        logoImage.style.transform = '';
                    }, 300);
                }, 10);
            });
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (!isMobile()) {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
                const savedState = localStorage.getItem('sidebarState');
                if (savedState === 'collapsed') {
                    sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.style.marginLeft = 'var(--sidebar-collapsed)';
                } else {
                    sidebar.classList.remove('collapsed');
                    if (mainContent) mainContent.style.marginLeft = 'var(--sidebar-width)';
                }
                const icon = mobileToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            } else {
                sidebar.classList.remove('collapsed');
                if (mainContent) mainContent.style.marginLeft = '0';
            }
            updateLinkTitles();
        });

        // Update link titles for tooltips
        function updateLinkTitles() {
            const links = document.querySelectorAll('.menu-item a[data-title]');
            const collapsed = sidebar.classList.contains('collapsed') && !isMobile();
            links.forEach(link => {
                const txt = link.getAttribute('data-title');
                if (!txt) return;
                if (collapsed) {
                    link.setAttribute('title', txt);
                    link.setAttribute('aria-label', txt);
                } else {
                    link.removeAttribute('title');
                    link.removeAttribute('aria-label');
                }
            });
        }

        updateLinkTitles();

        // Close modal on outside click
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('logoutModal');
            if (event.target === modal) {
                hideLogoutPrompt();
            }
        });

        // Handle escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideLogoutPrompt();
                if (sidebar.classList.contains('mobile-active')) {
                    sidebar.classList.remove('mobile-active');
                    overlay.classList.remove('active');
                    const icon = mobileToggle.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });

        // Set active menu item based on current page
        const currentPage = window.location.pathname.split('/').pop();
        const menuItems = document.querySelectorAll('.menu-item');
        // Remove all active classes first
        menuItems.forEach(item => item.classList.remove('active'));
        // Add active only to the correct one
        menuItems.forEach(item => {
            const link = item.querySelector('a');
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'dashboard.php')) {
                item.classList.add('active');
            }
        });
    });
</script>

</body>
</html>