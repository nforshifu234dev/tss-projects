<?php


    require_once 'assets/php/config.php';

    if ( !checkIfUserIsLoggedIn() )
    {
        redirect('login.php?returnUrl=' . htmlspecialchars($_SERVER['PHP_SELF']) );
        exit;
    }


    $userDetails = fetchBasicUserDetails( $pdo, $_SESSION['loggedInUserUsername'] );
    
    
    
    if (is_bool($userDetails) && $userDetails === false ) 
    {
    
        header("Location: logout.php");
        exit;
    }

    // echo "<pre>";
    // var_dump($userDetails);
    // echo "</pre>";

    $userName = $userDetails[0]['first_name'] . ' ' . $userDetails[0]['last_name'];
    $userUsername = $userDetails[0]['username'];
    $userEmail = $userDetails[0]['email'];
    $userStack = $userDetails[0]['programming_stack'];
    $userPhoneNumber = $userDetails[0]['phone_number'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="assets/img/logo/SINCE_2023-removebg-preview-removebg-preview.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TSS - NFORSHIFU234 Dev</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    
    <div class="container">

        <nav class="side-menu min-side-men">

            <div class="top-menu">

                <div class="logo">
                    <img src="assets/img/logo/SINCE_2023-removebg-preview-removebg-preview.png" alt="">
                </div>

                <div class="message">
                    Tech Skillup Society
                </div>

            </div>

            <div class="links">

                <a href="#" class="link">
                    <div class="icon">
                        <i class="fas fa-dashboard   "></i>
                    </div>
                    <div class="message">
                        dashboard
                    </div>
                </a>

                <a href="#" class="link">
                    <div class="icon">
                        <i class="fas fa-user   "></i>
                    </div>
                    <div class="message">
                        my profile
                    </div>
                </a>

                <a href="#" class="link">
                    <div class="icon">
                        <i class="fas fa-users    "></i>
                    </div>
                    <div class="message">
                        social media information
                    </div>
                    <div class="dropdown-btn">
                        <i class="fas fa-caret-down" aria-hidden="true"></i>
                    </div>
                </a>

                <a href="#" class="link">
                    <div class="icon">
                        <i class="fas fa-users    "></i>
                    </div>
                    <div class="message">
                        members
                    </div>
                    <div class="dropdown-btn">
                        <i class="fas fa-caret-down" aria-hidden="true"></i>
                    </div>
                </a>

                <a href="#" class="link">
                    <div class="icon">
                        <i class="fas fa-building   "></i>
                    </div>
                    <div class="message">
                        departments
                    </div>
                    <div class="dropdown-btn">
                        <i class="fas fa-caret-down" aria-hidden="true"></i>
                    </div>
                </a>

                <a href="#" class="link">
                    <div class="icon">
                        <i class="fas fa-cogs    "></i>
                    </div>
                    <div class="message">
                        settings
                    </div>
                    <div class="dropdown-btn">
                        <i class="fas fa-caret-down" aria-hidden="true"></i>
                    </div>
                </a>

                <a href="#" class="link">
                    <div class="icon">
                        <i class="fas fa-photo-video    "></i>
                    </div>
                    <div class="message">
                        uploaded media
                    </div>

                </a>

                <a href="logout.php" class="link bg-danger">
                    <div class="icon">
                        <i class="fas fa-door-open    "></i>
                    </div>
                    <div class="message">
                        logout
                    </div>
                </a>

            </div>

        </nav>

        <main class="main">

            <nav class="top-menu">

                <div class="sidenav-toggle">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>

                <div class="links">

                    <a href="#" class="link">

                        <div class="icon">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </div>

                        <div class="message">
                            visit home page
                        </div>

                    </a>

                    <a href="#" class="link">

                        <div class="icon">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                        </div>

                        <div class="message">
                            notification
                        </div>

                    </a>

                    <a href="#" class="link">

                        <div class="nav-profile-pic">

                            <img src="assets/img/creator/D2151F-removebg-preview.png" alt="">

                        </div>

                        <div class="message">
                            @<?php echo $userUsername ?>
                        </div>

                    </a>

                </div>

            </nav>

            <div class="contents">

                <section class="w-100 welcome-admin-banner">

                    <div class="greetings-banner">

                        <div class="greetings-message">
                            <span id="greetings">Good Morning</span>  <span><?php echo $userName ?> (@<?php echo $userUsername ?>  ) </span>
                        </div>

                        <div class="info">

                            The time is <span id="time">00:00:00</span>. You have <span class="bg-danger important">0</span> unread notifications

                        </div>

                    </div>

                    <div class="role-banner">

                        <!-- PHP Developer - Head of PHP Department - 4 Groups - Last Successful Login: 23-06-2023 -->
                        <?php echo $userStack; ?> - <?php echo $userEmail ?> - <?php echo $userPhoneNumber ?>

                    </div>

                </section>

                <section>

                    <div class="icon">
                        <i class="fas fa-building" aria-hidden="true"></i>
                    </div>

                    <div class="message">
                        6 Deparments
                    </div>

                </section>

                <a href="#" class="section">

                    <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>

                    <div class="message">
                        <span class="important">20</span> New Members
                    </div>
                </a>

                <a href="#" class="section">

                    <div class="icon">
                        <i class="fas fa-user-plus    "></i>
                    </div>

                    <div class="message">
                        Add new user
                    </div>

                </a>

                <section>

                    <div class="icon">
                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                    </div>

                    <div class="message">
                        Statistics
                        <div class="bg-danger">
                            COMING SOON
                        </div>
                    </div>

                </section>

            </div>

        </main>

        

    </div>

    <script src="assets/js/admin-js.js"></script>

</body>
</html>