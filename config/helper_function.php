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

function deleteById($conn, $table, $id,$path='products')
{
    $table = mysqli_real_escape_string($conn, $table);
    $id = (int) $id;
    $currentProduct = getById($conn, $path, $id);
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
        $hashed_password = md5($password);
        
        if ($hashed_password === $user['password']) {
        // if (1) {
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

function getSubcategoriesByCategoryId($conn, $categoryId)
{
    $subcategories = [];
    $sql = "SELECT id FROM sub_category WHERE parent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row['id'];
    }

    return $subcategories;
}

function getProductsByCategory($conn, $categoryId)
{
    // Get subcategories for the given category ID
    $subcategoryIds = getSubcategoriesByCategoryId($conn, $categoryId);

    // Get products for the subcategories
    $products = [];

    if (empty($subcategoryIds)) {
        return $products;
    }

    $placeholders = implode(',', array_fill(0, count($subcategoryIds), '?'));
    $types = str_repeat('i', count($subcategoryIds)); // Assuming all IDs are integers

    $sql = "SELECT * FROM product WHERE sub_categoryId IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$subcategoryIds);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}


function addToCart($conn, $productID, $quantity = 1)
{
    $product = getById($conn, 'product', $productID);
    // Initialize the cart if it's not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product['id']])) {
        // Update the quantity and total price
        $_SESSION['cart'][$product['id']]['quantity'] += $quantity;
        $_SESSION['cart'][$product['id']]['total_price'] += $product['price'] * $quantity;
    } else {
        // Add new product to the cart
        $_SESSION['cart'][$product['id']] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'unit_price' => $product['price'],
            'quantity' => $quantity,
            'total_price' => $product['price'] * $quantity
        ];
    }
}

function showCart()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [
            'products' => [],
            'total_price' => 0
        ];
    }

    $cart = $_SESSION['cart'];
    $totalPrice = array_sum(array_column($cart, 'total_price'));

    return [
        'products' => $cart,
        'total_price' => $totalPrice
    ];
}

function getCartProductCount()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return '';
    }

    return array_sum(array_column($_SESSION['cart'], 'quantity'));
}
function clearCart()
{
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
}


function updateCartItemQuantity($productId, $quantity)
{
    if (isset($_SESSION['cart'][$productId])) {
        // Update quantity
        $_SESSION['cart'][$productId]['quantity'] = $quantity;

        // Update total price for the item
        $_SESSION['cart'][$productId]['total_price'] = $_SESSION['cart'][$productId]['unit_price'] * $quantity;

        // Calculate total cart price
        $totalCartPrice = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalCartPrice += $item['total_price'];
        }

        // Update total cart price
        $_SESSION['cart']['total_price'] = $totalCartPrice;

        // Return updated cart data
        return $_SESSION['cart'];
    }

    // Return empty array if product not found (though in typical usage, you might handle this differently)
    return false;
}

function createOrder($conn, $name, $email, $phone, $address, $payment_method, $ref_no = 'cash_on_delivery')
{

    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        return false;
    }

    $orderDetails = [];
    $totalPrice = 0;

    foreach ($cart as $productId => $item) {
        $orderDetails[] = [
            'product_id' => $productId,
            'name' => $item['name'],
            'unit_price' => $item['unit_price'],
            'quantity' => $item['quantity'],
            'total_price' => $item['unit_price'] * $item['quantity']
        ];
        $totalPrice += $item['unit_price'] * $item['quantity'];
    }


    $data = [
        'userId' =>  0,
        'status' =>  'Pending',
        'total' => $totalPrice,
        'order_details' => json_encode($orderDetails),
        // 'ref_no' => uniqid('order_'),
        'ref_no' => $ref_no,
        'payment_method' => $payment_method,
        'user_details' => json_encode([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ]),
        'date' => date('Y-m-d H:i:s'),
    ];

    // $stmt = $conn->prepare("INSERT INTO orders (total, userId, order_details, ref_no, payment_method, user_details,date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // $stmt->bind_param("disssss", $totalPrice, $userId, $orderDetailsJson, $refNo, $payment_method, $userDetailsJson, $date);
    $newData = createData($conn, 'orders', $data);
    if ($newData) {
        // Clear the cart after successful order
        unset($_SESSION['cart']);
        return true;
    } else {
        return false;
    }
}

function showDate($date)
{
    $date = new DateTime($date);
    $formattedDate = $date->format('H:i, d F Y'); // Change the format as needed

    return $formattedDate;
}
