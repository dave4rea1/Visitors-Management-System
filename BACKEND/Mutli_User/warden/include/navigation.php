<div class="container">
        <div class="navigation">
            <ul>
                <!--MY LOGO-->
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="logo-laravel"></ion-icon></span>
                        <span class="title">Regiflow</span>
                    </a>
                </li>

                <!--Dashboard-->
                <li <?php if ($current_page === "dashboard") echo 'class="active"'; ?>>
                    <a href="dashboard.php">
                        <span class="icon"><ion-icon name="bar-chart-outline"></ion-icon></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <!--Manage-->
                <li <?php if ($current_page === "manage") echo 'class="active"'; ?>>
                    <a href="manage.php">
                        <span class="icon"><ion-icon name="create-outline"></ion-icon></span>
                        <span class="title">Manage</span>
                    </a>
                </li>

                <!--SERVICES-->
                <li <?php if ($current_page === "service") echo 'class="active"'; ?>>
                    <a href="service.php">
                        <span class="icon"><ion-icon name="build-outline"></ion-icon></span>
                        <span class="title">Service</span> 
                    </a>
                </li>

                <!--Report-->
                <li <?php if ($current_page === "report") echo 'class="active"'; ?>>
                    <a href="report.php">
                        <span class="icon"><ion-icon name="file-tray-full-outline"></ion-icon></span>
                        <span class="title">Report</span>
                    </a>
                </li>

                
                <!--LOGOUT-->
                <li>
                    <a href="logout.php">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">Logout</span>
                    </a>
                </li>
                
            </ul>
        </div>
    
    
            <!--MAIN CONTENT-->
            <div class="main">
            <div class="topbar">
                <!--Menu Toggle Button-->
                <div class="toggle" onclick="toggleMenu();">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <!--Search bar-->
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <!--User Role-->
                <div>
                    <h3>Warden</h3>
                </div>

                <!--User profile-->
                <div class="user">
                    <img src="images/profile.png" alt="" class="user-pic" onclick="toggleMenu()">
                    <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <div class="user-info">
                            <img src="images/profile.png">
                            <h3>Warden</h3>
                        </div>

                        <hr>
                            <a href="#" class="sub-menu-link">
                                <img src="images/profile.png" alt="">
                                <p>My Profile</p>
                                <span>></span>
                            </a>

                            <a href="#" class="sub-menu-link">
                                <img src="images/settings.png" alt="">
                                <p>Settings</p>
                                <span>></span>
                            </a>

                            <a href="#" class="sub-menu-link">
                                <img src="images/update.png" alt="">
                                <p>Update</p>
                                <span>></span>
                            </a>

                            <a href="logout.php" class="sub-menu-link">
                                <img src="images/logout.png" alt="">
                                <p>Logout</p>
                                <span>></span>
                            </a>
                        
                    </div>
                </div>
                </div>
                </nav>
                
            </div>
            <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu(){
                subMenu.classList.toggle("open-menu");
            }
            </script>


            