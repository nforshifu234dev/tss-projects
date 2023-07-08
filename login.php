<?php 

require_once 'assets/php/config.php';
require_once 'assets/php/signup-login.php';

    if ( checkIfUserIsLoggedIn() )
    {
        redirect('dashboard.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $url = htmlspecialchars($_SERVER['PHP_SELF']);


        // echo "POST ACTIVATED";

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        $username = trim( $_POST['username'] );
        $password = $_POST['password'];

        loginUser($username, $password, $url);

    }

    if ( isset($_SESSION['error_bg']) && $_SESSION['error_bg'] === "bg-success"  )
    {
        // Delay for 5 seconds
        // sleep(5);

        if ( isset($_SESSION['redirectUrl'])  && ! empty($_SESSION['redirectUrl']) )
        {
            header("Refresh: 5; URL=" . $_SESSION['redirectUrl']);
        }
        elseif ( isset($_GET['redirectUrl']) && ! empty($_GET['redirectUrl']) )
        {

            header("Refresh: 5; URL=" . $_GET['redirectUrl'] );

        }
        else
        {

            header("Refresh: 5; URL= dashboard.php");
        }


        // Redirect to a new page
    }

    if ( isset( $_GET['returnUrl'] ) && ! empty($_GET['returnUrl'] ) )
    {
        $_SESSION['redirectUrl'] = $_GET['returnUrl'];
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="assets/img/logo/SINCE_2023-removebg-preview-removebg-preview.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Login Page - NFORSHIFU234 - TTS Community Project</title>

    <style>

        main  .banner-and-form .form .actual-form
        {
            height: calc(100% - 100px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        main  .banner-and-form .form .logo .title
        {   
            /* text-align: center; */
            width: 100%;
            align-items: center;
            /* border: red solid 2px; */
        }

    </style>

</head>
<body>
    
    <div class="container">

        <main>

           <div class="banner-and-form">

                <div class="banner">
                    <img src="assets/img/logo/SINCE_2023-removebg-preview-removebg-preview.png" alt="">
                    <!-- <div class="overlay"></div> -->
                </div>

                <div class="form">

                    <div class="logo">
                        <!-- <img src="assets/img/logo/SINCE_2023-removebg-preview-removebg-preview.png" alt=""> -->

                        <div class="title">
                            
                            <div>
                                <h2>Login into your account....</h2>
                                <p>
                                    Don't have an account? <a href="signup.php">Signup Here</a>
                                </p>
                            </div>

                            <div class="icons">

                                <a href="#" class="icon">
                                    <i class="fab fa-apple"></i>
                                </a>

                                <a href="#" class="icon">
                                    <i class="fab fa-google"></i>
                                </a>

                                <a href="#" class="icon">
                                    <i class="fab fa-microsoft"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                    <?php 

                        if (  sessionExist('error_msg') && sessionExist('error_bg') ):

                    ?>
                        <div class="error-container <?php if ( $_SESSION['error_bg'] === "bg-success"  ){ echo "bg-success"; } ?> " id="error-message-container">

                            <div class="message">
                                <?php echo $_SESSION['error_msg']; ?>
                            </div>

                            <div class="icon close-btn">
                                <i class="fas fa-times-circle"></i>
                            </div>

                        </div>

                    <?php endif; unset($_SESSION['error_msg']); unset($_SESSION['error_bg']); ?>


                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="loginForm"  class="actual-form ui-form">


                        <!-- EMAIL -->
                        <div class="input">
                            <label for="username"><i class="fas fa-user"></i> Username or E-mail</label>
                            <input type="text" name="username" id="username" placeholder="Username or Email..." <?php if( isset($_POST['username']) && !empty($_POST['username']) ): ?> value="<?php echo $_POST['username']; endif;?>" >
                        </div>

                        <!-- Create Password -->

                        <div class="input">
                            <label for="password"> <i class="fas fa-key"></i>  Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter your password...">
                            <div class="view-password" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn">Login into your Account</button>

                    </form>

                </div>

           </div>


        </main>


        <footer>

            <div class="footer-links"> 
                <a href="#"  class="footer-link">
                    Home
                </a>
                <a href="#" class="footer-link">
                    About
                </a>
                <a href="#" class="footer-link">
                    Blog
                </a>
                <a href="https://www.linktr.ee/nforshifu234dev/" target="_blank" class="footer-link footer-creator-logo">
                    <img src="assets/img/creator/D2151F-removebg-preview.png" alt="">
                </a>
                <a href="#" class="footer-link">
                    API
                </a>
                <a href="#" class="footer-link">
                    Contact
                </a>
                <a href="#" class="footer-link">
                    Terms & Conditions
                </a>

            </div>

            <div class="copyright-message">
                Copyright &copy; 2023 - Tech Skillup Society (TSS)
            </div>

        </footer>

        

    </div>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/validation.js"></script>
    <script src="assets/js/login-js.js"></script>

</body>
</html>