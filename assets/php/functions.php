<?php 

        // DB functions

        /**
         * Check if a user exists in the database.
         *
         * @param PDO    $db_conn  Database connection object.
         * @param string $username Username or email to check.
         * @return array|bool User data if found, false otherwise.
         */
        function chechkIfUserExist(PDO $db_conn, string $username): array | bool 
        {
            // Prepare the SQL query
            $check_if_user_exist_query = "SELECT username, email FROM users WHERE username = :username OR email = :username LIMIT 1";

            // Example usage:
            $stmt = queryDB($db_conn, $check_if_user_exist_query);
            bindParams($stmt, ':username', $username);
            executeQuery($stmt);

            $results = fetchDataAssoc($stmt);

            if (count($results) === 1) {
                return $results;
            }

            return false;
        }

        /**
         * Check if the provided password matches the one stored in the database for a given user.
         *
         * @param PDO    $db_conn        Database connection object.
         * @param string $user_username  Username or email of the user.
         * @param string $user_password  Password to verify.
         * @return bool True if the password matches, false otherwise.
         */
        function checkPasswordMatch(PDO $db_conn, string $user_username_or_password1, string $user_password_or_password2, bool $isFromDB = false  ): bool 
        {
            
            if ( $isFromDB )
            {


                $db_password = decodeUserPassword($db_conn, $user_username_or_password1);

                $user_password = "user-password-" . $user_password_or_password2;


                if (password_verify(  $user_password,  $db_password   ) ) 
                {
                    return true;
                }

                    return false;

            }

            if (base64_decode($user_username_or_password1) === base64_decode($user_password_or_password2) ) 
            {
                return true;
            }

            return false;
        }

        /**
         * Fetch user details from the database.
         *
         * @param PDO    $db_conn  Database connection object.
         * @param string $username Username or email of the user.
         * @return array|bool User details if found, false otherwise.
         */
        function fetchUserDetails(PDO $db_conn, string $username): array | bool 
        {
            $fetch_user_details_query = "SELECT * FROM users WHERE username = :username OR email = :username";
            $stmt = queryDB($db_conn, $fetch_user_details_query);
            bindParams($stmt, ':username', $username);
            executeQuery($stmt);
            $result = fetchDataAssoc($stmt);

            if (count($result) === 1) {
                return $result;
            }

            return false;
        }

    /**
     * Fetches basic user details from the database.
     *
     * @param PDO    $db_conn  The PDO database connection object.
     * @param string $username The username or email of the user.
     * @return array|bool User details if found, false otherwise.
     */
    function fetchBasicUserDetails(PDO $db_conn, string $username): array|bool 
    {
        $fetch_basic_user_details_query = "SELECT first_name, last_name, email, phone_number, programming_stack, reference, username, reason_for_joining FROM users WHERE username = :username OR email = :username";
        $stmt = queryDB($db_conn, $fetch_basic_user_details_query);
        bindParams($stmt, ':username', $username);
        executeQuery($stmt);
        $result = fetchDataAssoc($stmt);

        if (count($result) === 1) {
            return $result;
        }

        return false;
    }



        // User functions

        /**
         * Set a session attribute.
         *
         * @param string $attributeName  Name of the attribute.
         * @param string $attributeValue Value of the attribute.
         * @return bool True if the attribute was set successfully, false otherwise.
         */
        function setSessionAttribute(string $attributeName, string $attributeValue): bool 
        {
            $_SESSION[$attributeName] = $attributeValue;
            return true;
        }

        /**
         * Set a cookie attribute.
         *
         * @param string $attributeName  Name of the attribute.
         * @param string $attributeValue Value of the attribute.
         * @return bool True if the attribute was set successfully, false otherwise.
         */
        function setCookieAttribute(string $attributeName, string $attributeValue): bool 
        {
            $_COOKIE[$attributeName] = $attributeValue;
            return true;
        }

        /**
         * Initiate a session.
         */
        function initiateSession(): void 
        {
            session_start();
        }

        /**
         * Destroy the current session.
         */
        function destroySession(): void 
        {
            session_destroy();
        }

        /**
         * Set up login session attributes.
         *
         * @return bool True if the login setup was successful, false otherwise.
         */
        function setUpLogin(): bool 
        {
            setSessionAttribute('userSSID', generateRandomStrings(0, 'user-session-'));
            setSessionAttribute('userSSIDToken', generateRandomStrings(0, 'user-session-token'));
            setSessionAttribute('isLoggedIn', true);
            return true;
        }

        function checkIfUserIsLoggedIn() :bool 
        {

            if ( isset($_SESSION["userSSID"]) && isset($_SESSION["userSSIDToken"]) && isset( $_SESSION["isLoggedIn"] )  )
            {
                return true;
            }  

                return false;
            
        }

        /**
         * Check if the user is logged in.
         *
         * @return bool True if the user is logged in, false otherwise.
         */
        function checkIfLoggedIn(): bool 
        {
            if (isset($_SESSION['userSSID']) && isset($_SESSION['userSSIDToken']) && isset($_SESSION['isLoggedIn']) && isset($_SESSION['loggedInUserUsername'])) {
                return true;
            }
            return false;
        }


        // Utility functions

        /**
         * Generate random strings for session attributes.
         *
         * @param int    $length    Length of the generated string.
         * @param string $prefix    Prefix to add to the generated string.
         * @return string Generated random string.
         */
        function generateRandomStrings(int $amountOfChar = 40, string $prefix = '', string $suffix = ''):string
        {
            if ($amountOfChar === 0) {
                $amountOfChar = 40;
            }
    
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTWXYZ0123456789";
            
            $generatedText = '';
    
            if ( !empty($prefix) )
            {
                $generatedText = $prefix . substr(str_shuffle($chars), 0, $amountOfChar);
            }
            else if ( !empty($suffix) )
            {
                $generatedText = substr(str_shuffle($chars), 0, $amountOfChar) . $suffix;
            }
            else
            {
                $generatedText = substr(str_shuffle($chars), 0, $amountOfChar);
            }
    
            // $session_username = "session-";
            // $session_username .= substr(str_shuffle($chars), 0, $amountOfChar);
    
            return $generatedText;
        }

        function isEmail(string $email_address) : bool 
        {
            // Check if the email address is not empty
            if (!empty($email_address))
            {
                // Validate the email address using the built-in PHP filter
                if (filter_var($email_address, FILTER_VALIDATE_EMAIL))
                {
                    return true; // Email is valid
                }
                
                return false; // Email is invalid
            }
            
            return false; // Email is empty
        }
        
        function getArrayKeyItemValue(array $array, string|int $key) : string | bool | null 
        {
            return isset($array[$key]) ? $array[$key] : null; // Return the value corresponding to the provided key in the array, or null if the key doesn't exist
        }
        
        function encodeUserPassword(string $userPassword) : string | int 
        {
            // Append a prefix to the user password and then decode it using base64
            $userPassword = 'user-password-' . base64_decode($userPassword);
        
            // Hash the decoded password using the default password hashing algorithm
            $hashed_password = password_hash($userPassword, PASSWORD_DEFAULT);
        
            // Encode the hashed password using base64
            $encoded_password = base64_encode($hashed_password);
        
            return $encoded_password; // Return the encoded password
        }
        
        function decodeUserPassword(PDO $db_conn, string|int $username) : string | int 
        {
            // Prepare a SQL query to collect the password from the database based on the username or email
            $collect_password_from_db_query = "SELECT password FROM users WHERE username = :username OR email = :username LIMIT 1";
        
            // Execute the query using the provided database connection
            $stmt = queryDB($db_conn, $collect_password_from_db_query);
            bindParams($stmt, ':username', $username);
            executeQuery($stmt);
            $result = fetchDataAssoc($stmt);
        
            $password_from_db = $result[0]["password"]; // Get the password from the query result
        
            $decoded_password = base64_decode($password_from_db); // Decode the password using base64
        
            return $decoded_password; // Return the decoded password
        }
        
        function sessionExist(string $session_name) : bool 
        {
            // Check if the session with the provided name exists
            if (isset($_SESSION[$session_name]))
            {
                return true; // Session exists
            }
            
            return false; // Session does not exist
        }
        
        function unsetAnArrayItem(string $valueToUnset) : void 
        {
            if (isset($valueToUnset))
            {
                unset($valueToUnset); // Unset the provided value (Note: This may not work as expected since unset only affects the local variable, not the original array)
            }
        }
        
        function redirect(string $url) : void 
        {
            // Perform a redirection to the provided URL
            header("Location: $url");
        }
        

?>