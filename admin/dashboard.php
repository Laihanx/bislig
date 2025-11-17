<?php
// dashboard.php - Admin dashboard with sidebar and CRUD links
session_start();
if (!isset($_SESSION['admin_user'])) {
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../assets/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #263238;
        }
        
        .main-content { 
            margin-left: 270px; 
            padding: 40px 32px; 
            min-height: 100vh;
        }
        
        /* Dashboard Header */
        .dashboard-header { 
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            border-radius: 20px;
            padding: 40px 32px;
            margin-bottom: 32px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .dashboard-header h1 { 
            font-size: 2.5rem; 
            font-weight: 700; 
            margin-bottom: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }
        
        .dashboard-header span { 
            color: #64748b; 
            font-size: 1.1rem; 
            font-weight: 500;
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .dashboard-header span::before {
            content: '📍';
            font-size: 1.2rem;
        }
        
        /* Section Styling */
        section header {
            margin-bottom: 24px;
        }
        
        section header h2 {
              font-size: 1.75rem;
              font-weight: 700;
              color: #263238;
              margin-bottom: 8px;
              text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        section header p {
              color: #607d8b;
              font-size: 1rem;
              font-weight: 400;
        }
        
        /* Card Grid */
        .card-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 24px;
            margin-top: 24px;
        }
        
        /* Card Link Styling */
        .card-link { 
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-decoration: none;
            color: #263238;
            padding: 32px 28px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        /* Top accent bar */
        .card-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        
        /* Different gradient for each card */
        .card-link:nth-child(1)::before { background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); }
        .card-link:nth-child(2)::before { background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%); }
        .card-link:nth-child(3)::before { background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); }
        .card-link:nth-child(4)::before { background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); }
        .card-link:nth-child(5)::before { background: linear-gradient(90deg, #fa709a 0%, #fee140 100%); }
        .card-link:nth-child(6)::before { background: linear-gradient(90deg, #30cfd0 0%, #330867 100%); }
        .card-link:nth-child(7)::before { background: linear-gradient(90deg, #ff6b6b 0%, #ee5a6f 100%); }
        
        .card-link:hover::before {
            transform: scaleX(1);
        }
        
        .card-link:hover { 
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 16px 48px rgba(102, 126, 234, 0.2);
        }
        
        /* Card Icon */
        .card-link .card-icon { 
            width: 72px;
            height: 72px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: white;
            transition: transform 0.3s ease;
        }
        
        /* Unique gradient backgrounds for icons */
        .card-link:nth-child(1) .card-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-link:nth-child(2) .card-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .card-link:nth-child(3) .card-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .card-link:nth-child(4) .card-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .card-link:nth-child(5) .card-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .card-link:nth-child(6) .card-icon { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
        .card-link:nth-child(7) .card-icon { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); }
        
        .card-link:hover .card-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        /* Card Title */
        .card-link h3 { 
            font-size: 1.375rem; 
            font-weight: 600; 
            margin-bottom: 8px;
            color: #1e293b;
        }
        
        /* Card Description */
        .card-link p { 
            font-size: 0.975rem; 
            color: #64748b; 
            line-height: 1.6;
        }
        
        /* Responsive Design */
        @media (max-width: 900px) { 
            .main-content { 
                margin-left: 0; 
                padding: 24px 16px; 
            }
            
            .dashboard-header {
                padding: 28px 20px;
            }
            
            .dashboard-header h1 {
                font-size: 2rem;
            }
            
            .card-grid { 
                grid-template-columns: 1fr; 
            }
            
            section header h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 600px) {
            .dashboard-header h1 {
                font-size: 1.75rem;
            }
            
            .card-link {
                padding: 24px 20px;
            }
            
            .card-link .card-icon {
                width: 64px;
                height: 64px;
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
        <div class="dashboard-header">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_user']) ?>!</h1>
            <span>Bislig City Tourism Admin Dashboard</span>
        </div>
        <section>
            <header>
                <h2>Manage Content</h2>
                <p>Select a section below to add, edit, or delete site content.</p>
            </header>
            <div class="card-grid">
                <a href="manage_destinations.php" class="card-link">
                    <span class="card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <h3>Destinations</h3>
                    <p>Manage tourist destinations</p>
                </a>
                <a href="manage_restaurants.php" class="card-link">
                    <span class="card-icon"><i class="fas fa-utensils"></i></span>
                    <h3>Restaurants</h3>
                    <p>Manage dining options</p>
                </a>
                <a href="manage_accommodations.php" class="card-link">
                    <span class="card-icon"><i class="fas fa-hotel"></i></span>
                    <h3>Accommodations</h3>
                    <p>Manage lodging options</p>
                </a>
                <a href="manage_attractions.php" class="card-link">
                    <span class="card-icon"><i class="fas fa-star"></i></span>
                    <h3>Attractions</h3>
                    <p>Manage tourist attractions</p>
                </a>
                <a href="manage_festivals.php" class="card-link">
                    <span class="card-icon"><i class="fas fa-calendar-alt"></i></span>
                    <h3>Festivals</h3>
                    <p>Manage festival calendar</p>
                </a>
                <a href="manage_transportation.php" class="card-link">
                    <span class="card-icon"><i class="fas fa-bus"></i></span>
                    <h3>Transportation</h3>
                    <p>Manage transport options</p>
                </a>
                <a href="manage_emergency.php" class="card-link">
                    <span class="card-icon"><i class="fas fa-phone-alt"></i></span>
                    <h3>Emergency Contacts</h3> 
                    <p>Manage emergency contacts</p>
                </a>
            </div>
        </section>
    </main>
</body>
</html>