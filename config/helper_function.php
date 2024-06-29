<?php


// get all data

function getAll($conn, $table, $order = 'DESC', $orderBy = 'id')
{
    // Sanitize input
    $table = mysqli_real_escape_string($conn, $table);
    $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';
    $orderBy = mysqli_real_escape_string($conn, $orderBy);

    $sql = "SELECT * FROM `$table` ORDER BY `$orderBy` $order";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        // Fetch all rows into an array
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}


//------use------
/*
    $tableData = getAll('your_table', 'ASC'); //
    foreach ($tableData as $row) {
         echo "id: " . $row["id"] . " - Name: " . $row["name"] . "<br>"; // Adjust according to your table structure
    }
*/

// get single
function getById($conn, $table, $id)
{
    // Sanitize input
    $table = mysqli_real_escape_string($conn, $table);
    $id = (int) $id;

    $sql = "SELECT * FROM `$table` WHERE `id` = $id LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the row as an associative array
        return $result->fetch_assoc();
    } else {
        return null; // No record found
    }
}


/*
$row = getById($conn, 'your_table', $id); // Replace 'your_table' with your actual table name

if ($row) {
    // Print the data
    echo "id: " . $row["id"] . " - Name: " . $row["name"] . "<br>"; // Adjust according to your table structure
} else {
    echo "Record not found.";
}
?>

*/

function deleteById($conn, $table, $id)
{
    // Sanitize input
    $table = mysqli_real_escape_string($conn, $table);
    $id = (int) $id;

    $sql = "DELETE FROM `$table` WHERE `id` = $id";
    return $conn->query($sql) === TRUE;
}

function deleteAll($conn, $table)
{
    // Sanitize input
    $table = mysqli_real_escape_string($conn, $table);

    $sql = "DELETE FROM `$table`";
    return $conn->query($sql) === TRUE;
}


function createData($conn, $table, $data)
{

    $table = mysqli_real_escape_string($conn, $table);

    $escaped_values = array_map(function ($value) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $value) . "'";
    }, array_values($data));

    $columns = implode(', ', array_keys($data));
    $values = implode(', ', $escaped_values);

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $last_data = getById($conn, $table, $last_id);
        return $last_data;
    } else {
        return false;
    }
}

function updateById($conn, $table, $id, $data)
{
    $table = mysqli_real_escape_string($conn, $table);
    $id = intval($id);

    $set_clause = [];
    foreach ($data as $key => $value) {
        $key = mysqli_real_escape_string($conn, $key);
        $value = mysqli_real_escape_string($conn, $value);
        $set_clause[] = "`$key` = '$value'";
    }
    $set_clause = implode(', ', $set_clause);

    $sql = "UPDATE $table SET $set_clause WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $updated_data = getById($conn, $table, $id);
        return $updated_data;
    } else {
        return false;
    }
}
function newRegister($conn, $data)
{
    $table = mysqli_real_escape_string($conn, 'user');

    $sql_check_empty = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($sql_check_empty);

    if ($result && $result->fetch_assoc()['count'] == 0) {
        $data['role'] = 'admin';
    } else {
        $data['role'] = 'customer';
    }

    $escaped_values = array_map(function ($value) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $value) . "'";
    }, array_values($data));

    $columns = implode(', ', array_keys($data));
    $values = implode(', ', $escaped_values);

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;

        $last_data = getById($conn, $table, $last_id);

        return $last_data;
    } else {
        return false;
    }
}


session_start();


function login($conn, $email, $password)
{
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $table = 'user';
    $sql = "SELECT * FROM `$table` WHERE `email` = '$email' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        var_dump($user['password']);
        $hashed_password = md5($password);
        if ($hashed_password === $user['password']) {
            unset($user['password']);
            $_SESSION['user'] = $user;
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function logout()
{
    $_SESSION = [];

    if (session_id() != "" || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    session_destroy();
}


function isLoggedIn()
{
    return isset($_SESSION['user']);
}


function isAdmin()
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}


function isCustomer()
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'customer';
}

function getSettings($conn, $key)
{
    $key = mysqli_real_escape_string($conn, $key);

    $sql = "SELECT `value` FROM settings WHERE `key` = '$key' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['value'];
    } else {
        return null;
    }
}

function getCurrentUser()
{
    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    } else {
        return null;
    }
}
