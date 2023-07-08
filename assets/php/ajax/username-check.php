<?php
    include_once "../config.php";

    // Check if a username exists
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        // Retrieve the JSON data from the request body and decode it
        $requestData = json_decode(file_get_contents('php://input'), true);

        if (isset($requestData['username'])) 
        {
            // Get the username from the request data
            $username = $requestData['username'];

            // Prepare a query to count the number of rows where the username matches
            $query = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':username', $username);
            $stmt->execute();

            // Fetch the result as a single column value
            $result = $stmt->fetchColumn();

            // Create a response array indicating whether the username exists
            $response = ['exists' => ($result > 0)];

            // Set the response content type as JSON
            header('Content-Type: application/json');

            // Convert the response array to JSON and send it as the response
            echo json_encode($response);
            exit();
        }
    }
?>
