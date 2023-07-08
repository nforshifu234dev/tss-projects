<?php 

    require_once 'assets/php/config.php';
    require_once 'assets/php/signup-login.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {

        $requestData = json_decode(file_get_contents('php://input'), true);

        $url = htmlspecialchars($_SERVER['PHP_SELF']);


        // echo "POST ACTIVATED";

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        $has_agreed_terms = isset($_POST['t-n-c']) && $_POST['t-n-c'] === 'on' ? true : false;

        if ( $has_agreed_terms != true )
        {
            setSessionAttribute("error_msg", "You need to agree to the terms and conditions");
            setSessionAttribute("error_bg", "bg-danger");
            header("Location: $url");
            exit;
        }



        $userDetails = array(
            "u_first_name" => $_POST['first-name'],
            "u_last_name" => $_POST['last-name'],
            "u_email" => $_POST['email'],
            // "u_country" => $_POST[''],
            "u_phone_number" => $_POST['country-code'] . $_POST['phone-number'],
            "u_programming_stack" => $_POST['stack'],
            "u_refferer" => $_POST['how-did-you-hear-about-us'],
            "u_reason_for_joining" => $_POST['reason'],
            "u_username" => $_POST['username'],
            "u_password" => $_POST['password'],
            "u_confirm_password" => $_POST['confirm-password'],
            "u_agree_to_t_n_c" => isset($_POST['t-n-c']) && $_POST['t-n-c'] === 'on' ? true : false ,

        );

        signupUser( $userDetails, $url );

    }

    if ( isset($_SESSION['error_bg']) && ! empty($_SESSION['error_bg']) )
    {
        header("Refresh: 5; URL=login.php");
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

    <title>Signup Page - NFORSHIFU234 - TTS Community Project</title>
</head>
<body class="darkmode">
    
    <div class="container darkmode">

        <main>

           <div class="banner-and-form">

                <div class="banner">
                    <img src="assets/img/pexels-fauxels-3182784.jpg" alt="">
                    <div class="overlay"></div>
                </div>

                <div class="form">

                    <div class="logo">
                        <img src="assets/img/logo/SINCE_2023-removebg-preview-removebg-preview.png" alt="">

                        <div class="title">
                            
                            <div>
                                <h2>Signup for an account....</h2>
                                <p>
                                    Already have an account? <a href="login.php">Login Here</a>
                                </p>
                            </div>

                            <div class="icons">

                                <a href="#" title="Login with Icloud Account" class="icon">
                                    <i class="fab fa-apple"></i>
                                </a>

                                <a href="#" title="Login with Google Account" class="icon">
                                    <i class="fab fa-google"></i>
                                </a>

                                <a href="#" title="Login with Microsoft Account" class="icon">
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

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="signup-form"  class="actual-form ui-form">

                        <div id="step1" class="step">

                            <div class="heading">
                                <h2>Personal Details</h2>
                            </div>

                            <!-- 
                                NAMES
                                EMAIL
                                PHONE NUMBER
                            -->

                            <!-- FIRST NAME & LAST NAME -->
                            <div class="input-group">

                                <div class="input">
                                    <label for="first-name"><i class="fas fa-user"></i> First Name</label>
                                    <input type="text" id="first-name" name="first-name" placeholder="John">
                                </div>

                                <div class="input">
                                    <label for="last-name"><i class="fas fa-user"></i> Last Name</label>
                                    <input type="text" id="last-name" name="last-name" placeholder="Doe">
                                </div>

                            </div>

                            <!-- EMAIL -->
                            <div class="input">
                                <label for="email"><i class="fas fa-envelope"></i> E-mail</label>
                                <input type="email" name="email" id="email" placeholder="jonnDoe@domain.com">
                            </div>

                            <!-- PHONE NUMBER -->
                            <div class="input">
                                <label for="phone-number"> <i class="fas fa-phone"></i> Phone Number</label>
                                
                                <div class="input-group phone-num">

                                    <div class="input">
                                        <select name="country-code" id="country-code" title="Select Your Country Code">
                                            <option value="">Select Your Country Code</option>
                                            <option value="">
                                                Loading Countries. Kindly Wait....
                                            </option>
                                        </select>
                                    </div>

                                    <div class="input">
                                        <input type="tel" name="phone-number" id="phone-number"  placeholder="1234567890">
                                    </div>

                                </div>

                            </div>

                            <div class="btn-group">
                                <button type="button" id="next-btn1" class="next-btn">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                            </div>

                        </div>

                        <div class="step" id="step2">

                            <div class="heading">
                                <h2>Proffesional Details </h2>
                            </div>

                            <!-- 
                                STACK
                                ROLE
                                PLACE OF WORK
                             -->

                             <!-- STACK -->
                            <div class="input">
                                <label for="stack"><i class="fas fa-cubes-stacked"></i> what is your Role?</label>
                                <label><small>Don't know your role? <a href="https://www.investopedia.com/articles/investing/101315/10-best-tech-jobs.asp/" target="_blank">Vist Here to Read About roles in Tech</a></small></label>

                                <select name="stack" id="stack" >
                                    <option value="">Select your STACK</option>
                                    <option value="nodeJs">Node JS Full Stack Web Developer</option>
                                    <option value="pyFullWeb">Python Full Stack Web Developer</option>
                                    <option value="phpFullWeb">PHP Full Stack Web Developer</option>
                                    <option value="da">Data Analysist</option>
                                    <option value="ai-e">Artificial Intelligence Enginner</option>
                                    <option value="pe">Product Engineer</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>


                             <div class="btn-group">
                                <button id="prev-btn2" class="prev-btn" type="button">Go back <i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
                                <button id="next-btn2" class="next-btn" type="button">Next <i class="fa fa-arrow-right" aria-hidden="true"></i> </button>
                             </div>

                        </div>

                        <div class="step" id="step3">

                            <div class="heading">
                                <h2>Refferer Details </h2>
                            </div>

                            <!-- 
                                How did you hear about us
                                Have you ever been in a community?
                                Reasons why you are here
                             -->

                            <!-- How did you hear from us -->
                            <div class="input">
                                <label for="how-did-you-hear-about-us"><i class="fas fa-ear-listen"></i> How did you hear about us?</label>
                                <select name="how-did-you-hear-about-us" id="how-did-you-hear-about-us">
                                    <option value="">How did you hear about us:)</option>
                                    <option value="cbu">Chibueze Munoke</option>
                                    <option value="anjii">Anjolaoluwa</option>
                                    <option value="oth">Other</option>
                                </select>
                            </div>

                            <!-- REASONS WHY YOU ARE JOING AND WHAT YOU EXPECT -->
                            <div class="input">

                                <label for="reason">Tell us why you are joing TSS  and what you expect🙂. <span><small> <span id="counter">0/250</span> words</small></span></label> 

                                <textarea name="reason" id="reason" placeholder="Tell us why you are joing TSS..."></textarea>
                                
                            </div>

                             <div class="btn-group">
                                <button id="prev-btn3" class="prev-btn" type="button">Go back <i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
                                <button id="next-btn3" class="next-btn" type="button">Next <i class="fa fa-arrow-right" aria-hidden="true"></i> </button>
                             </div>

                        </div>

                        <div class="step" id="step4">

                            <div class="heading">
                                <h2>Login Details</h2>
                            </div>

                            <!-- 
                                Username
                                Password
                                Confirm Password
                                Agree to Terms & CONditions
                             -->

                            <!-- Create Username -->
                            <div class="input">
                                <label for="username"><i class="fas fa-user-tie"></i> Create a username</label>
                                <p>
                                    Create a unique username that willl be used to identify you besides your name.
                                </p>
                                <input type="text" id="username" name="username" placeholder="Create your unique username...">
                                <div class="view-password display-none" id="username-check" >

                                    <svg fill="#000000" width="800px" height="800px" class="spin" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.409 24.405c-0.007-0-0.015-0.001-0.023-0.001-0.222 0-0.402 0.18-0.402 0.402 0 0.049 0.009 0.095 0.024 0.139l-0.001-0.003c1.342 3.747 3.537 6.053 6.005 6.053 2.12-0.214 3.89-1.526 4.749-3.352l0.015-0.036c0.035-0.058 0.056-0.129 0.056-0.204 0-0.222-0.18-0.402-0.402-0.402-0.144 0-0.271 0.076-0.342 0.19l-0.001 0.002c-0.739 1.62-2.251 2.773-4.050 2.995l-0.025 0.003c-2.050 0-4.008-2.058-5.248-5.521-0.055-0.15-0.192-0.256-0.355-0.266l-0.001-0zM27.91 22.696c0 0 0.001 0 0.001 0 0.618 0 1.12 0.501 1.12 1.12s-0.501 1.12-1.12 1.12c-0.281 0-0.539-0.104-0.735-0.275l0.001 0.001-0.008-0.015c-0.032-0.046-0.072-0.084-0.118-0.113l-0.002-0.001c-0.161-0.193-0.259-0.443-0.259-0.716 0-0.618 0.501-1.12 1.119-1.12v0zM4.090 22.696c0 0 0 0 0 0 0.618 0 1.12 0.501 1.12 1.12s-0.501 1.12-1.12 1.12c-0.618 0-1.12-0.501-1.12-1.12 0-0.206 0.056-0.399 0.153-0.565l-0.003 0.005c0.197-0.337 0.557-0.56 0.97-0.56 0 0 0 0 0 0v0zM6.668 17.676c-0.006-0-0.013-0-0.019-0-0.222 0-0.402 0.18-0.402 0.402 0 0.104 0.040 0.199 0.105 0.271l-0-0c1.718 1.84 3.691 3.412 5.87 4.666l0.122 0.065c5.517 3.185 11.379 4.105 14.447 2.298 0.311 0.226 0.701 0.361 1.122 0.361 1.063 0 1.925-0.862 1.925-1.925s-0.862-1.925-1.925-1.925c-1.063 0-1.925 0.862-1.925 1.925 0 0.35 0.093 0.677 0.256 0.96l-0.005-0.009c-2.805 1.517-8.286 0.625-13.493-2.381-2.226-1.276-4.136-2.796-5.786-4.561l-0.013-0.014c-0.069-0.076-0.168-0.126-0.277-0.131l-0.001-0zM16 15.369c-0.763 0.008-1.379 0.628-1.379 1.392 0 0.769 0.623 1.392 1.392 1.392s1.392-0.623 1.392-1.392c0-0.104-0.011-0.205-0.033-0.303l0.002 0.009c-0.142-0.633-0.7-1.098-1.365-1.098-0.003 0-0.006 0-0.009 0h0zM19.598 7.575c-0.029 0-0.057 0.004-0.084 0.010l0.003-0c-2.709 0.626-5.099 1.604-7.277 2.902l0.115-0.064c-5.711 3.297-9.488 8.116-9.197 11.711-0.594 0.335-0.988 0.961-0.988 1.68 0 1.062 0.861 1.922 1.922 1.922s1.922-0.861 1.922-1.922c0-1.062-0.861-1.922-1.922-1.922-0 0-0.001 0-0.001 0h0c-0.047 0-0.094 0.004-0.141 0.007-0.125-3.199 3.428-7.674 8.807-10.78 1.995-1.195 4.308-2.142 6.764-2.716l0.164-0.032c0.182-0.041 0.316-0.201 0.316-0.393 0-0.222-0.18-0.402-0.402-0.402-0.001 0-0.001 0-0.002 0h0zM22.97 7.21c-0.221 0.001-0.399 0.181-0.399 0.402 0 0.217 0.173 0.395 0.388 0.402l0.001 0c0.167-0.019 0.36-0.030 0.556-0.030 1.682 0 3.177 0.804 4.121 2.049l0.009 0.013c1.024 1.773 0.225 4.492-2.147 7.294-0.061 0.070-0.098 0.163-0.098 0.264 0 0.222 0.18 0.402 0.402 0.402 0.124 0 0.236-0.057 0.309-0.145l0.001-0.001c2.566-3.032 3.462-6.081 2.23-8.216-1.086-1.498-2.831-2.461-4.8-2.461-0.201 0-0.401 0.010-0.597 0.030l0.025-0.002zM9.158 7.188c-0.193-0.022-0.418-0.035-0.645-0.035-1.983 0-3.74 0.966-4.827 2.453l-0.012 0.017c-0.329 0.717-0.52 1.555-0.52 2.438 0 1.331 0.435 2.56 1.17 3.553l-0.011-0.016c0.072 0.117 0.199 0.194 0.344 0.194 0.222 0 0.402-0.18 0.402-0.402 0-0.070-0.018-0.136-0.050-0.193l0.001 0.002c-0.655-0.865-1.049-1.958-1.049-3.144 0-0.733 0.151-1.43 0.422-2.063l-0.013 0.034c1.026-1.777 3.79-2.443 7.413-1.783 0.024 0.005 0.050 0.008 0.078 0.008 0.222 0 0.402-0.18 0.402-0.402 0-0.199-0.144-0.364-0.334-0.396l-0.002-0c-0.831-0.164-1.788-0.259-2.767-0.262h-0.002zM16.014 1.808c0 0 0 0 0 0 0.618 0 1.12 0.501 1.12 1.12s-0.501 1.12-1.12 1.12c-0.618 0-1.12-0.501-1.12-1.12 0-0.206 0.056-0.399 0.153-0.565l-0.003 0.005c0.197-0.337 0.557-0.56 0.97-0.56v0zM16.014 1.004c-0 0-0.001 0-0.001 0-1.062 0-1.924 0.861-1.924 1.924s0.861 1.924 1.924 1.924c0.739 0 1.381-0.417 1.703-1.029l0.005-0.011c2.775 1.584 4.807 6.839 4.807 12.949 0 0.054 0.001 0.119 0.001 0.183 0 2.505-0.377 4.923-1.078 7.198l0.046-0.173c-0.010 0.034-0.016 0.073-0.016 0.113 0 0.222 0.18 0.402 0.402 0.402 0.177 0 0.327-0.114 0.381-0.273l0.001-0.003c0.678-2.174 1.068-4.674 1.068-7.264 0-0.065-0-0.129-0.001-0.194l0 0.010c0-6.489-2.214-12.104-5.399-13.749 0.001-0.028 0.004-0.055 0.004-0.084-0-1.062-0.861-1.923-1.924-1.923-0 0-0 0-0 0v0z"></path>
                                    </svg>

                                </div>
                            </div>

                            <!-- Create Password -->

                            <div class="input">
                                <label for="password"> <i class="fas fa-key"></i> Create your password</label>
                                <p>
                                    Create a strong password for your account. You password should contain at least <span>1 uppercasse letter</span>
                                    <span>small letters </span> and should be <span>at least 8 characters long.</span>
                                </p>
                                <div class="text-link" id="generatePassword">Generate Password</div>
                                <input type="password" name="password" id="password" placeholder="Enter your password...">
                                <div class="view-password" id="togglePassword">
                                    <i class="fas fa-eye" ></i>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="input">
                                <label for="confirm-password"> <i class="fas fa-key"></i> Confirm your password</label>
                                <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm your password...">
                            </div>

                             <div class="btn-group">
                                <button id="prev-btn4" class="prev-btn" type="button">Go back <i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
                                <button id="next-btn4" class="next-btn" type="button" > Next <i class="fa fa-arrow-right" aria-hidden="true"></i> </button>
                             </div>

                        </div>

                        <div class="step" id="step5">

                            <div class="heading">
                                Terms & Conditions
                            </div>

                            <div class="t-and-c">
                                <!-- <svg width="800px" height="800px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><defs><style>.a{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;}</style></defs><path class="a" d="M10.3635,4.51A1.9944,1.9944,0,0,0,8.4189,6.5043V41.5056A1.9945,1.9945,0,0,0,10.3635,43.5H37.5867a1.9944,1.9944,0,0,0,1.9944-1.9944V14.4719H31.6036a1.9945,1.9945,0,0,1-1.9446-1.9944V4.5Z"/><line class="a" x1="29.5693" y1="4.51" x2="39.5312" y2="14.4719"/><line class="a" x1="15.838" y1="22.928" x2="32.1121" y2="22.928"/><line class="a" x1="15.838" y1="34.994" x2="32.1121" y2="34.994"/><line class="a" x1="15.838" y1="28.961" x2="32.1121" y2="28.961"/></svg> -->
                                <video src="./assets/img/78299-document.mp4" loop autoplay></video>
                            </div>

                           <!-- Agree to TERMS & CONDITIONS -->

                           <div class="input-group terms-and-cond">

                                <div class="input">
                                    <input type="checkbox" name="t-n-c" id="t-n-c">
                                </div>

                                <div class="input">
                                    I agree to the <a href="#">Terms & Conditions</a> & <a href="#">Privacy Policy</a> &   <a href="#">Act Of Accordance</a>
                                    of Tech Skillup Society(TSS).
                                </div>

                            </div>

                            <div class="btn-group">
                                <button id="prev-btn5" class="prev-btn" type="button">Go back <i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
                                <button type="submit" id="submit" > <i class="fas fa-paper-plane"></i> submit  </button>
                            </div>

                        </div>

                    </form>

                </div>


           </div>

        <!-- <footer></footer> -->

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
    <script src="assets/js/signup-js.js"></script>

</body>
</html>
