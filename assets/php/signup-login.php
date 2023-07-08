<?php

    include_once "config.php";

    
    function loginUser( string $u_username, string $u_password , string $url) : void
    {

        global $pdo;

        // var_dump($pdo);

        if ( empty($u_username) || empty($u_password) )
        {
            // echo "Empty feild";
            setSessionAttribute("error_msg", "EMPTY FEILDS");
            setSessionAttribute("error_bg", "bg-danger");
            header("Location: $url");
            exit;
        }

        $app_username = trim($u_username);
        $app_password = trim( base64_decode($u_password) );


        if(  !chechkIfUserExist($pdo, $app_username)  )
        {
            // echo "USER DOES NOT EXIST";
            setSessionAttribute("error_msg", "USER does not exist");
            setSessionAttribute("error_bg", "bg-danger");
            header("Location: $url");
            exit;
        }
        
        if ( !checkPasswordMatch( $pdo, $app_username, $app_password, true ) )
        {
            // echo "PASSWORDS DO NOT MATCH";
            setSessionAttribute("error_msg", "Passwords don't match");
            setSessionAttribute("error_bg", "bg-danger");
            header("Location: $url");
            exit;
        }


        // initiateSession();

        $user_logging_in_details = fetchUserDetails($pdo, $app_username);


        // SET NECCESSARY SESSIONS AND COOKIES AND STUFFS FOR MEETNING THE REQUIRMENENTS OF A LOGGED IN USER

        if ( setUpLogin() )
        {

            $_SESSION["loggedInUserUsername"] = $user_logging_in_details[0]['username'];
            setSessionAttribute("error_msg", "LOGIN SUCCESS. kindly wait as we redirect you.");
            setSessionAttribute("error_bg", "bg-success");


        }




    }


    function signupUser(array $userDetails, string $url) : void 
    {
        global $pdo;
        
        if ( empty($userDetails) )
        {
            // echo "EMPTY USER DETAILS";
            setSessionAttribute("error_msg", "EMPTY USER DETAILS");
            setSessionAttribute("error_bg", "bg-danger");
            header("Location: $url");
            exit;
        }



        $loginStatus = [];

        foreach ($userDetails as $key => $userDetail) 
        {
            
            // echo $userDetail . "<br>$key<br>";

            if ( empty($userDetail) )
            {



               // remove the u_ from the string

                $attributeName = str_replace("u_", " ", $key);

                // remove _ from the remaing string
                $attributeName = str_replace("_", " ", $attributeName);

                
                $message = $attributeName . " is empty";

                $return_code = "SIGNUP_EMPTY_FEILD";

                $returnMessage = array(
                    "code" => $return_code,
                    "message" => $message,
                );

                // add it to the status array

                array_push( $loginStatus, $returnMessage );





            }

        }

        $u_first_name = trim( getArrayKeyItemValue( $userDetails, 'u_first_name' ) );
        $u_last_name = trim( getArrayKeyItemValue( $userDetails, 'u_last_name' ) );
        $u_email = trim( getArrayKeyItemValue( $userDetails, 'u_email' ) );
        $u_phone_number = trim( getArrayKeyItemValue( $userDetails, 'u_phone_number' ) );
        $u_programming_stack = trim( getArrayKeyItemValue( $userDetails, 'u_programming_stack' ) );
        $u_refferer = trim( getArrayKeyItemValue( $userDetails, 'u_refferer' ) );
        $u_reason_for_joining = trim( getArrayKeyItemValue( $userDetails, 'u_reason_for_joining' ) );
        $u_username = trim( getArrayKeyItemValue( $userDetails, 'u_username' ) );
        $u_password = trim( getArrayKeyItemValue( $userDetails, 'u_password' ) );
        $u_confirm_password = trim( getArrayKeyItemValue( $userDetails, 'u_confirm_password' ) );
        $u_agree_to_t_n_c =  getArrayKeyItemValue( $userDetails, 'u_agree_to_t_n_c' ) ;



        if ( !isEmail($u_email) )
        {
         
            $message = "email is not correct";

            $return_code = "SIGNUP_INVALID_EMAIL";

            $returnMessage = array(
                "code" => $return_code,
                "message" => $message,
            );

            // add it to the status array

            array_push( $loginStatus, $returnMessage );

            
        }

        if ( ! checkPasswordMatch( $pdo, $u_password, $u_confirm_password ) )
        {
            $message = "password is not correct";

            $return_code = "SIGNUP_PASSWORD_NOT_VALID";

            $returnMessage = array(
                "code" => $return_code,
                "message" => $message,
            );

            // add it to the status array

            array_push( $loginStatus, $returnMessage );
        }

        // chechk if user exists with email
        if ( chechkIfUserExist($pdo, $u_email) != false )
        {
            header("Location: login.php");
            exit;
        }

        if ( $u_agree_to_t_n_c != true )
        {

            $message = "you need to agree to the <a href='#' target='_blank'>Terms & Conditions</a> of TSS";

            $return_code = "SIGNUP_TERMS_AND_CONDITIONS_NOT_ACCEPTED";

            $returnMessage = array(
                "code" => $return_code,
                "message" => $message,
            );

            // add it to the status array

            array_push( $loginStatus, $returnMessage );

        }

        if (
            is_null($u_first_name) ||
            is_null($u_last_name) ||
            is_null($u_email) ||
            is_null($u_phone_number) ||
            is_null($u_programming_stack) ||
            is_null($u_refferer) ||
            is_null($u_reason_for_joining) ||
            is_null($u_username) ||
            is_null($u_password) ||
            is_null($u_confirm_password) ||
            is_null($u_agree_to_t_n_c) 
        )
        {

            $message = "an error occured. please try again";

            $return_code = "SIGNUP_ERROR_OCCURED";

            $returnMessage = array(
                "code" => $return_code,
                "message" => $message,
            );

            // add it to the status array

            array_push( $loginStatus, $returnMessage );

        }

        if ( count($loginStatus) != 0 ) 
        {



            foreach ($loginStatus as $key => $loginStatu) 
            {
                
                setSessionAttribute("error_msg", $loginStatu['message']);
                setSessionAttribute("error_code", $loginStatu['code']);
                setSessionAttribute("error_bg", "bg-danger");



            }



            header("Location: $url");

            exit;
        }



        $register_user_query = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone_number`, `programming_stack`, `reference`, `reason_for_joining`, `username`, `password`, `user_id`, `agree_to_terms`) 
                VALUES (:firstname, :lastname, :email, :phonenumber, :stack, :reference, :reason, :username, :password, :userid, :tnc)";
        $stmt = $pdo->prepare($register_user_query);

        $u_ency_pass = encodeUserPassword($u_password);

        
        $u_id = generateRandomStrings(0, 'USER-');

        $stmt->bindParam(':firstname', $u_first_name);
        $stmt->bindParam(':lastname', $u_last_name);
        $stmt->bindParam(':email', $u_email);
        $stmt->bindParam(':phonenumber', $u_phone_number);
        $stmt->bindParam(':stack', $u_programming_stack);
        $stmt->bindParam(':reference', $u_refferer);
        $stmt->bindParam(':reason', $u_reason_for_joining);
        $stmt->bindParam(':username', $u_username);
        $stmt->bindParam(':password', $u_ency_pass);
        $stmt->bindParam(':userid', $u_id);
        $stmt->bindParam(':tnc', $u_agree_to_t_n_c);

        if ($stmt->execute())
        {
            setSessionAttribute("error_msg", "Signup successful. kindly wait as we redirect you to the login page.");
            setSessionAttribute("error_bg", "bg-success");
            header("Location: $url");
            exit;
        } 
        else 
        {
            setSessionAttribute("error_msg", "An error occured. try again.");
            setSessionAttribute("error_bg", "bg-danger");
            header("Location: $url");
            exit;
        }

        




    }
    


?>