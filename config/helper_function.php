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
    $table = mysqli_real_escape_string($conn, $table);
    $id = (int) $id;
    $currentProduct = getById($conn, 'product', $id);
    $currentImagePath = $currentProduct['image'];
    if (file_exists($currentImagePath)) {
        unlink($currentImagePath);
    }
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
            return $user;
        } else {
            return [];
        }
    } else {
        return [];
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

function saveImage($folderName, $file)
{
    $folderName = '../uploads/' . $folderName;
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            if (!is_dir($folderName)) {
                mkdir($folderName, 0755, true);
            }

            // The path to where the file will be moved
            $dest_path = $folderName . DIRECTORY_SEPARATOR . $newFileName;

            // Move the file to the specified folder
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Return the file path
                return $dest_path;
            } else {
                // Handle error during file upload
                return false;
            }
        } else {
            // Handle invalid file type
            return false;
        }
    } else {
        // Handle error in file upload
        return false;
    }
}

function productsByCategory($conn, $catId)
{
    $catId = mysqli_real_escape_string($conn, $catId);

    $sql = "SELECT * FROM product WHERE sub_categoryId = $catId";
    $result = $conn->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}
function productsBySearch($conn, $searchTerm)
{
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

    $sql = "SELECT * FROM product WHERE name LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    return $products;
}

function showText($text, $max_length = 30)
{
    if (strlen($text) > $max_length) {
        $shortenedText = substr($text, 0, $max_length) . '...';
    } else {
        $shortenedText = $text;
    }

    return $shortenedText;
}


// Function to get subcategories by category
function getSubcategoriesByCategory($conn)
{
    $sql = "SELECT id, name, parent_id 
    FROM sub_category";
    $result = $conn->query($sql);

    $subcategories = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $parentId = $row['parent_id'];
            if (!isset($subcategories[$parentId])) {
                $subcategories[$parentId] = [];
            }
            $subcategories[$parentId][] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
    }

    return $subcategories;
}
