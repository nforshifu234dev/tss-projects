<?php

/**
 * Establishes a database connection.
 *
 * @param array $config Configuration array containing connection details.
 * @return PDO|null Database connection handler or null if connection fails.
 */
function connectDB(array $config)
{
    $driver = isset($config['driver']) ? $config['driver'] : "mysql";
    $dbHost = isset($config['host']) ? $config['host'] : 'nforshifu.com';
    $username = isset($config['user']) ? $config['user'] : 'superAdmin';
    $password = isset($config['password']) ? $config['password'] : 'estherokafor123';
    $dbName = isset($config['dbName']) ? $config['dbName'] : '';

    $dsn = "mysql:host=" . $dbHost . ';port=3306;dbname=' . $dbName;

    $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
        $connectionHandler = new PDO($dsn, $username, $password, $options);
        return $connectionHandler;
    } catch (Exception $e) {
        var_dump('Couldn\'t Establish A Database Connection. Due to the following reason: ' . $e->getMessage());
        exit;
    }
}

/**
 * Prepares a database query statement.
 *
 * @param PDO   $pdo         Database connection handler.
 * @param mixed $queryString Query string to be prepared.
 * @return PDOStatement|false Prepared statement or false on failure.
 */
function queryDB($pdo, $queryString)
{
    $stmt = $pdo->prepare($queryString);
    return $stmt;
}

/**
 * Binds a value to a parameter in a prepared statement.
 *
 * @param PDOStatement $stmt  Prepared statement.
 * @param mixed        $param Parameter to bind.
 * @param mixed        $value Value to bind to the parameter.
 * @param int|null     $type  Data type of the parameter.
 * @return void
 */
function bindParams($stmt, $param, $value, $type = null)
{
    if (is_null($type)) {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
                break;
        }
    }

    $stmt->bindValue($param, $value, $type);
}

/**
 * Executes a prepared statement.
 *
 * @param PDOStatement $stmt Prepared statement to execute.
 * @return void
 */
function executeQuery($stmt)
{
    $stmt->execute();
}

/**
 * Fetches all rows from the result set of a prepared statement as an associative array.
 *
 * @param PDOStatement $stmt Prepared statement.
 * @return array Fetched data as an associative array.
 */
function fetchDataAssoc($stmt)
{
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
