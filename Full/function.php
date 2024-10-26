<?php
$conn = mysqli_connect("localhost", "root", "", "instrumentalize");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $datas = [];
    while( $data = mysqli_fetch_assoc($result)){
        $datas [] = $data;
    }
    return $datas;
}



//----------------------------------------------------------------//
//------------------------------CRUD------------------------------//
//--------------------------------------------//
//--------------------USER--------------------//
function create_user($data) {
    global $conn;

    $user_name = htmlspecialchars($_POST["user_name"]);
    $user_email = htmlspecialchars($_POST["user_email"]);
    $user_birthday = htmlspecialchars($_POST["user_birthday"]);
    $user_gender = htmlspecialchars($_POST["user_gender"]);
    $user_phone = htmlspecialchars($_POST["user_phone"]);
    $user_role = htmlspecialchars($_POST["user_role"]);

    $query = "SELECT user_email FROM user WHERE user_email = '$user_email'";
    $user = mysqli_query($conn, $query);
    if(mysqli_fetch_assoc($user)){
        $_SESSION['status_failed'] = "Email sudah terdaftar, data pengguna gagal ditambahkan!";
        header("Location: admin-user.php");
        exit;
    }
    
    $user_password = htmlspecialchars($_POST["user_password"]);
    $user_password = password_hash($user_password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user VALUES ('', '$user_name', '$user_email', '$user_birthday', '$user_gender','$user_phone', '$user_password', '$user_role')";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Data pengguna berhasil ditambahkan!";
    } else {
        $_SESSION['status_failed'] = "Data pengguna gagal ditambahkan!";
    }

    header("Location: admin-user.php");
    exit;
}
if (isset($_POST["create_user"])) {
    create_user($_POST);
}

function delete_user($user_id) {
    global $conn;
    $result_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id");
    if (mysqli_num_rows($result_cart) > 0) {
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");
    }
    $result_orders = mysqli_query($conn, "SELECT * FROM orders WHERE order_user = $user_id");
    if (mysqli_num_rows($result_orders) > 0) {
        mysqli_query($conn, "DELETE FROM orders WHERE order_user = $user_id");
    }
    mysqli_query($conn, "DELETE FROM user WHERE user_id = $user_id");

    return mysqli_affected_rows($conn);
}


function edit_user($data) {
    global $conn;
    // pengambilan data dari form
    $user_id = $_POST["user_id"];
    $user_name = htmlspecialchars($_POST["user_name"]);
    $user_email = htmlspecialchars($_POST["user_email"]);
    $user_birthday = htmlspecialchars($_POST["user_birthday"]);
    $user_gender = htmlspecialchars($_POST["user_gender"]);
    $user_phone = htmlspecialchars($_POST["user_phone"]);

    $queryCheckEmail = "SELECT user_email FROM user WHERE user_id = $user_id";
    $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);
    $rowCheckEmail = mysqli_fetch_assoc($resultCheckEmail);
    $old_email = $rowCheckEmail['user_email'];

    if ($user_email !== $old_email) {
        $queryEmailExist = "SELECT user_email FROM user WHERE user_email = '$user_email'";
        $resultEmailExist = mysqli_query($conn, $queryEmailExist);
        if (mysqli_fetch_assoc($resultEmailExist)) {
            $_SESSION['status_failed'] = "Email sudah terdaftar, data pengguna gagal diubah!";
            header("Location: admin-user.php");
            exit;
        }
    }

    $user_password = htmlspecialchars($_POST["user_password"]);
    if (!empty($user_password)) {
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
    } else {
        $user_password = null;
    }

    $user_role = htmlspecialchars($_POST["user_role"]);

    if (!is_null($user_password)) {
        $query = "UPDATE user SET user_name = '$user_name', user_email = '$user_email', user_birthday = '$user_birthday', user_gender = '$user_gender', user_phone = '$user_phone', user_password = '$user_password', user_role = '$user_role' WHERE user_id = $user_id";
    } else {
        $query = "UPDATE user SET user_name = '$user_name', user_email = '$user_email', user_birthday = '$user_birthday', user_gender = '$user_gender', user_phone = '$user_phone', user_role = '$user_role' WHERE user_id = $user_id";
    }
    // query insert data
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Data pengguna berhasil diubah!";
    } else {
        $_SESSION['status_failed'] = "Data pengguna gagal diubah!";
    }

    header("Location: admin-user.php");
    exit;
}

if (isset($_POST["edit_user"])) {
    edit_user($_POST);
}



//----------------------------------------------//
//--------------------EDITOR--------------------//
//----------------------------//
//----------CAROUSEL----------//
function create_carousel($data){
    global $conn;

    $carousel_img_name= $_FILES['carousel_img']['name'];
    $carousel_img_tmpname= $_FILES['carousel_img']['tmp_name'];
    $carousel_img_size= $_FILES['carousel_img']['size'];
    $carousel_img_error= $_FILES['carousel_img']['error'];
    $carousel_img_type= $_FILES['carousel_img']['type'];
    
    $carousel_img_ext = explode('.', $carousel_img_name);
    $carousel_img_ext_format = strtolower(end($carousel_img_ext));
    $img_ext = array('jpg', 'jpeg', 'png');

    if(in_array($carousel_img_ext_format, $img_ext)){
        if($carousel_img_error === 0){
            if($carousel_img_size < 10000000){
                $carousel_img_uniqid = uniqid('', true).".".$carousel_img_ext_format;
                $carousel_img_destination = 'images/carousel/'.$carousel_img_uniqid;
                move_uploaded_file($carousel_img_tmpname, $carousel_img_destination);
            } else {
                $_SESSION['status_failed'] = "Carousel gagal ditambahkan!, ukuran file terlalu besar!";
                header("Location: admin-editor.php");
                exit;
            }
        } else {
            $_SESSION['status_failed'] = "Carousel gagal ditambahkan!, terjadi error";
            header("Location: admin-editor.php");
            exit;
        }
    } else {
        $_SESSION['status_failed'] = "Carousel gagal ditambahkan!, format file tidak sesuai!";
        header("Location: admin-editor.php");
        exit;
    }

    $query = "INSERT INTO carousel VALUES ('', '$carousel_img_destination')";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Carousel berhasil ditambahkan!";
    } else {
        $_SESSION['status_failed'] = "Carousel gagal ditambahkan!";
    }

    header("Location: admin-editor.php");
    exit;
}
if (isset($_POST["create_carousel"])) {
    create_carousel($_POST);
}

function delete_carousel($carousel_id){
    global $conn;
    mysqli_query($conn, "DELETE FROM carousel WHERE carousel_id = $carousel_id");
    return mysqli_affected_rows($conn);
}



//------------------------------------------------//
//--------------------CATEGORY--------------------//
function create_category($data){
    global $conn;

    $category_name = htmlspecialchars($_POST["category_name"]);

    $category_img_name= $_FILES['category_img']['name'];
    $category_img_tmpname= $_FILES['category_img']['tmp_name'];
    $category_img_size= $_FILES['category_img']['size'];
    $category_img_error= $_FILES['category_img']['error'];
    $category_img_type= $_FILES['category_img']['type'];
    
    $category_img_ext = explode('.', $category_img_name);
    $category_img_ext_format = strtolower(end($category_img_ext));
    $img_ext = array('jpg', 'jpeg', 'png');

    if(in_array($category_img_ext_format, $img_ext)){
        if($category_img_error === 0){
            if($category_img_size < 10000000){
                $category_img_uniqid = uniqid('', true).".".$category_img_ext_format;
                $category_img_destination = 'images/category/'.$category_img_uniqid;
                move_uploaded_file($category_img_tmpname, $category_img_destination);
            } else {
                $_SESSION['status_failed'] = "Kategori gagal ditambahkan!, ukuran file terlalu besar!";
                header("Location: admin-category.php");
                exit;
            }
        } else {
            $_SESSION['status_failed'] = "Kategori gagal ditambahkan!, terjadi error";
            header("Location: admin-category.php");
            exit;
        }
    } else {
        $_SESSION['status_failed'] = "Kategori gagal ditambahkan!, format file tidak sesuai!";
        header("Location: admin-category.php");
        exit;
    }

    $query = "INSERT INTO category VALUES ('', '$category_name', '$category_img_destination')";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Kategori berhasil ditambahkan!";
    } else {
        $_SESSION['status_failed'] = "Kategori gagal ditambahkan!";
    }

    header("Location: admin-category.php");
    exit;
}
if (isset($_POST["create_category"])) {
    create_category($_POST);
}

function delete_category($category_id) {
    global $conn;
    $product_check = mysqli_query($conn, "SELECT COUNT(*) as product_count FROM product WHERE category_id = $category_id");
    $product_check_total = mysqli_fetch_assoc($product_check);

    if ($product_check_total['product_count'] > 0) {
        mysqli_query($conn, "UPDATE product SET category_id = NULL WHERE category_id = $category_id");
    }
    mysqli_query($conn, "DELETE FROM category WHERE category_id = $category_id");

    return mysqli_affected_rows($conn);
}

function edit_category($data) {
    global $conn;

    $category_id = $_POST["category_id"];
    $category_name = htmlspecialchars($_POST["category_name"]);
    
    $category_img_name= $_FILES['category_img']['name'];
    $category_img_tmpname= $_FILES['category_img']['tmp_name'];
    $category_img_size= $_FILES['category_img']['size'];
    $category_img_error= $_FILES['category_img']['error'];
    $category_img_type= $_FILES['category_img']['type'];
    
    $current_category_img = $_POST["current_category_img"];

    if (!empty($category_img_name)) {
        $category_img_ext = explode('.', $category_img_name);
        $category_img_ext_format = strtolower(end($category_img_ext));
        $img_ext = array('jpg', 'jpeg', 'png');

        if (in_array($category_img_ext_format, $img_ext)) {
            if ($category_img_error === 0) {
                if ($category_img_size < 10000000) {
                    $category_img_uniqid = uniqid('', true) . "." . $category_img_ext_format;
                    $category_img_destination = 'images/category/' . $category_img_uniqid;
                    move_uploaded_file($category_img_tmpname, $category_img_destination);
                } else {
                    $_SESSION['status_failed'] = "Kategori gagal ditambahkan!, ukuran file terlalu besar!";
                    header("Location: admin-category.php");
                    exit;
                }
            } else {
                $_SESSION['status_failed'] = "Kategori gagal ditambahkan!, terjadi error";
                header("Location: admin-category.php");
                exit;
            }
        } else {
            $_SESSION['status_failed'] = "Kategori gagal ditambahkan!, format file tidak sesuai!";
            header("Location: admin-category.php");
            exit;
        }
    } else {
        $category_img_destination = $current_category_img;
    }

    $query = "UPDATE category SET category_name = '$category_name', category_img = '$category_img_destination' WHERE category_id = $category_id";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Kategori berhasil diubah!";
    } else {
        $_SESSION['status_failed'] = "Kategori gagal diubah!";
    }

    header("Location: admin-category.php");
    exit;
}
if (isset($_POST["edit_category"])) {
    edit_category($_POST);
}



//-----------------------------------------------//
//--------------------PRODUCT--------------------//
function create_product($data) {
    global $conn;
    
    $product_img_name= $_FILES['product_img']['name'];
    $product_img_tmpname= $_FILES['product_img']['tmp_name'];
    $product_img_size= $_FILES['product_img']['size'];
    $product_img_error= $_FILES['product_img']['error'];
    $product_img_type= $_FILES['product_img']['type'];
    
    $product_img_ext = explode('.', $product_img_name);
    $product_img_ext_format = strtolower(end($product_img_ext));
    $img_ext = array('jpg', 'jpeg', 'png');

    if(in_array($product_img_ext_format, $img_ext)){
        if($product_img_error === 0){
            if($product_img_size < 10000000){
                $product_img_uniqid = uniqid('', true).".".$product_img_ext_format;
                $product_img_destination = 'images/product/'.$product_img_uniqid;
                move_uploaded_file($product_img_tmpname, $product_img_destination);
            } else {
                $_SESSION['status_failed'] = "Data produk gagal ditambahkan!, ukuran file terlalu besar!";
                header("Location: admin-product.php");
                exit;
            }
        } else {
            $_SESSION['status_failed'] = "Data Produk gagal ditambahkan!, terjadi error";
            header("Location: admin-product.php");
            exit;
        }
    } else {
        $_SESSION['status_failed'] = "Data Produk gagal ditambahkan!, format file tidak sesuai!";
        header("Location: admin-product.php");
        exit;
    }
    
    $product_name = htmlspecialchars($_POST["product_name"]);
    $product_category = htmlspecialchars($_POST["product_category"]);
    $product_desc = htmlspecialchars($_POST["product_desc"]);
    $product_stock = htmlspecialchars($_POST["product_stock"]);
    $product_price = htmlspecialchars($_POST["product_price"]);

    $query = "INSERT INTO product VALUES ('', '$product_img_destination', '$product_name', '$product_category', '$product_desc', '$product_stock', '$product_price', false)";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Data produk berhasil ditambahkan!";
    } else {
        $_SESSION['status_failed'] = "Data produk gagal ditambahkan!";
    }

    header("Location: admin-product.php");
    exit;
}
if (isset($_POST["create_product"])) {
    create_product($_POST);
}

function delete_product($product_id) {
    global $conn;
    mysqli_query($conn, "UPDATE product SET is_deleted = true WHERE product_id = $product_id");
    return mysqli_affected_rows($conn);
}

function edit_product($data) {
    global $conn;

    $product_id = $_POST["product_id"];

    $product_img_name= $_FILES['product_img']['name'];
    $product_img_tmpname= $_FILES['product_img']['tmp_name'];
    $product_img_size= $_FILES['product_img']['size'];
    $product_img_error= $_FILES['product_img']['error'];
    $product_img_type= $_FILES['product_img']['type'];
    
    $current_product_img = $_POST["current_product_img"];

    if (!empty($product_img_name)) {
        $product_img_ext = explode('.', $product_img_name);
        $product_img_ext_format = strtolower(end($product_img_ext));
        $img_ext = array('jpg', 'jpeg', 'png');

        if (in_array($product_img_ext_format, $img_ext)) {
            if ($product_img_error === 0) {
                if ($product_img_size < 10000000) {
                    $product_img_uniqid = uniqid('', true) . "." . $product_img_ext_format;
                    $product_img_destination = 'images/product/' . $product_img_uniqid;
                    move_uploaded_file($product_img_tmpname, $product_img_destination);
                } else {
                    $_SESSION['status_failed'] = "Data produk gagal diubah!, ukuran file terlalu besar!";
                    header("Location: admin-product.php");
                    exit;
                }
            } else {
                $_SESSION['status_failed'] = "Data Produk gagal diubah!, terjadi error";
                header("Location: admin-product.php");
                exit;
            }
        } else {
            $_SESSION['status_failed'] = "Data Produk gagal diubah!, format file tidak sesuai!";
            header("Location: admin-product.php");
            exit;
        }
    } else {
        $product_img_destination = $current_product_img;
    }

    $product_name = htmlspecialchars($_POST["product_name"]);
    $product_category = htmlspecialchars($_POST["product_category"]);
    $product_desc = htmlspecialchars($_POST["product_desc"]);
    $product_stock = htmlspecialchars($_POST["product_stock"]);
    $product_price = htmlspecialchars($_POST["product_price"]);

    $query = "UPDATE product SET product_img = '$product_img_destination', product_name = '$product_name', product_category = '$product_category', product_desc = '$product_desc', product_stock = '$product_stock', product_price = '$product_price' WHERE product_id = $product_id AND is_deleted = false";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Data produk berhasil diubah!";
    } else {
        $_SESSION['status_failed'] = "Data produk gagal diubah!";
    }

    header("Location: admin-product.php");
    exit;
}
if (isset($_POST["edit_product"])) {
    edit_product($_POST);
}



//--------------------------------------------//
//--------------------CART--------------------//
function add_to_cart($data){
    global $conn;

    $id_pengguna = $_SESSION['user_id'];

    $product_id = $_POST["product_id"];
    $product_img = $_POST["product_img"];
    $product_quantity = $_POST["product_quantity"];

    $product_price_total = $_POST["product_price_total"];
    number_format($product_price_total,0,',','.');
    $product_price_total = $product_price_total * $product_quantity;

    $cart_item = mysqli_query($conn, "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $id_pengguna");

    if(mysqli_num_rows($cart_item) > 0){
        $_SESSION['status_failed'] = "Produk gagal ditambahkan!, produk sudah ada di keranjang";
        header("Location: search-result.php");
        exit;
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, product_img, product_quantity, product_price_total) 
        VALUES ('$id_pengguna', '$product_id', '$product_img', '$product_quantity', '$product_price_total') ");
        $_SESSION['status_success'] = "Produk berhasil ditambahkan ke keranjang!";
        header("Location: search-result.php");
        exit;
    }
}

function delete_cart($cart_id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id = $cart_id");
    return mysqli_affected_rows($conn);
}



//---------------------------------------------//
//--------------------ORDER--------------------//
function create_order() {
    global $conn;

    $id_pengguna = $_SESSION['user_id'];
    $cart = query("SELECT *, P.product_name AS pdtname FROM cart C JOIN product P ON C.product_id = P.product_id WHERE C.user_id = '$id_pengguna'");

    if (isset($_POST["create_order"])) {
        $is_stock_available = true;

        foreach ($cart as $crt) {
            $product_id = $crt['product_id'];
            $product_quantity = $crt['product_quantity'];
            $product_price_total = $crt['product_price_total'];

            $query_check_stock = "SELECT product_stock FROM product WHERE product_id = '$product_id'";
            $result_stock = mysqli_query($conn, $query_check_stock);
            $row_stock = mysqli_fetch_assoc($result_stock);
            $current_stock = $row_stock['product_stock'];

            if ($current_stock >= $product_quantity) {
                continue;
            } else {
                $is_stock_available = false;

                $user_id = $_SESSION['user_id'];
                $query_delete_from_cart = "DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
                mysqli_query($conn, $query_delete_from_cart);
            }
        }

        if ($is_stock_available) {
            $order_user = $_POST['order_user'];
            $order_address = $_POST['order_address'];
            $order_phone = $_POST['order_phone'];
            $order_total = $_POST['order_total'];
            $order_payment = $_POST['payment'];
            $order_datetime = date('Y-m-d H:i:s');

            $query = "INSERT INTO orders VALUES ('', '$order_user', '$order_address', '$order_phone', '$order_total', '$order_payment', 'Antrian', '', '$order_datetime')";
            mysqli_query($conn, $query);
            $order_id = mysqli_insert_id($conn);

            foreach ($cart as $crt) {
                $product_id = $crt['product_id'];
                $product_quantity = $crt['product_quantity'];
                $product_price_total = $crt['product_price_total'];
                
                $query_order_item = "INSERT INTO order_item VALUES ('', '$order_id', '$product_id', '$product_quantity', '$product_price_total')";
                mysqli_query($conn, $query_order_item);

                $query_check_stock = "SELECT product_stock FROM product WHERE product_id = '$product_id'";
                $result_stock = mysqli_query($conn, $query_check_stock);
                $row_stock = mysqli_fetch_assoc($result_stock);
                $current_stock = $row_stock['product_stock'];
                
                $new_stock = $current_stock - $product_quantity;
                $query_update_stock = "UPDATE product SET product_stock = '$new_stock' WHERE product_id = '$product_id'";
                mysqli_query($conn, $query_update_stock);

                $user_id = $_SESSION['user_id'];
                $query_delete_from_cart = "DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
                mysqli_query($conn, $query_delete_from_cart);
            }
            $_SESSION['status_success'] = "Pesanan berhasil dibuat! Silahkan lihat pesanan anda";
            header("Location: profile-status.php");
            exit;
        } else {
            $_SESSION['status_failed'] = "Pesanan gagal dibuat! Terdapat produk yang sudah tidak tersedia";
            header("Location: profile-cart.php");
            exit();
        }
    }
}

function delete_order($order_id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM order_item WHERE order_id = $order_id");
    mysqli_query($conn, "DELETE FROM orders WHERE order_id = $order_id");
    return mysqli_affected_rows($conn);
}

function update_order($data){
    global $conn;

    $order_id = $_POST['order_id'];
    $order_status = htmlspecialchars($_POST['order_status']);

    $query = "UPDATE orders SET order_status = '$order_status' WHERE order_id = $order_id";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Status pesanan berhasil diubah!";
    } else {
        $_SESSION['status_failed'] = "Status pesanan gagal diubah!";
    }

    header("Location: admin-orders.php");
    exit;
}
if (isset($_POST["update_order"])) {
    update_order($_POST);
}



//-----------------------------------------------//
//--------------------REPORTS--------------------//
function send_message($data){
    global $conn;

    $form_name = htmlspecialchars($_POST['form_name']);
    $form_email = htmlspecialchars($_POST['form_email']);
    $form_phone = htmlspecialchars($_POST['form_phone']);
    $form_title = htmlspecialchars($_POST['form_title']);
    $form_desc = htmlspecialchars($_POST['form_desc']);
    $form_datetime = date('Y-m-d H:i:s');

    $query = "INSERT INTO form VALUES ('', '$form_name', '$form_email', '$form_phone', '$form_title', '$form_desc', '$form_datetime')";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Pesan berhasil dikirim!";
    } else {
        $_SESSION['status_failed'] = "Pesan gagal dikirim!";
    }

    header("Location: index.php#contact-path");
    exit;
}
if (isset($_POST["send_message"])) {
    send_message($_POST);
}

function delete_form($form_id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM form WHERE form_id = $form_id");
    return mysqli_affected_rows($conn);
}



//------------------------------------------------------------------//
//------------------------------SEARCH------------------------------//
function search_result($search_keyword, $category_id = null){
    $query = "SELECT *, C.category_name as catname FROM product P JOIN category C ON P.product_category = C.category_id WHERE P.product_name LIKE '%$search_keyword%' AND P.is_deleted = false";

    if ($category_id !== null) {
        $query .= " AND P.product_category = $category_id";
    }
    $query .= " ORDER BY P.product_id DESC";

    return query($query);
}




//---------------------------------------------------//
//--------------------LIVE SEARCH--------------------//



//-------------------------------------------------------------------//
//------------------------------ACCOUNT------------------------------//
//------------------------------------------------//
//--------------------REGISTER--------------------//
function register_user($data){
    global $conn;

    $user_name = htmlspecialchars($_POST["user_name"]);
    $user_email = htmlspecialchars(strtolower(stripslashes($_POST["user_email"])));

    $query = "SELECT user_email FROM user WHERE user_email = '$user_email'";
    $user = mysqli_query($conn, $query);
    if(mysqli_fetch_assoc($user)){
        $_SESSION['status_failed'] = "Email sudah terdaftar, gagal mendaftarkan akun!";
        header("Location: account-register.php");
        exit;
    }

    $user_birthday = htmlspecialchars($_POST["user_birthday"]);
    $user_gender = htmlspecialchars($_POST["user_gender"]);
    $user_phone = htmlspecialchars($_POST["user_phone"]);

    $user_password = htmlspecialchars($_POST["user_password"]);
    $user_password2 = htmlspecialchars($_POST["user_password2"]);
    if ($user_password !== $user_password2) {
        $_SESSION['status_failed'] = "Password tidak cocok!";
        header("Location: account-register.php");
        exit;
    }
    $user_password = password_hash($user_password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO user VALUES ('', '$user_name', '$user_email', '$user_birthday', '$user_gender','$user_phone', '$user_password', 'Buyer')";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['status_success'] = "Berhasil mendaftarkan akun!";
    } else {
        $_SESSION['status_failed'] = "Gagal mendaftarkan akun!";
    }

    header("Location: account-register.php");
    exit;
}
if (isset($_POST["register_user"])) {
    register_user($_POST);
}


//---------------------------------------------//
//--------------------LOGIN--------------------//
function login_user($data){
    global $conn;

    $user_email = $_POST["user_email"];
    $user_password = $_POST["user_password"];

    $query = "SELECT * FROM user WHERE user_email = '$user_email'";
    $user = mysqli_query($conn, $query);

    if(mysqli_num_rows($user) === 1){
        $user_data = mysqli_fetch_assoc($user);
        if(password_verify($user_password, $user_data["user_password"])){
            $_SESSION["user_id"] = $user_data["user_id"];
            $_SESSION["user_name"] = $user_data["user_name"];
            $_SESSION["user_email"] = $user_data["user_email"];
            $_SESSION["user_birthday"] = $user_data["user_birthday"];
            $_SESSION["user_gender"] = $user_data["user_gender"];
            $_SESSION["user_phone"] = $user_data["user_phone"];
            $_SESSION["user_role"] = $user_data["user_role"];

            if($user_data["user_role"] === "Seller"){
                header("Location: admin-dashboard.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }
        } else {
            $_SESSION['status_failed'] = "Password tidak sesuai! Silahkan coba lagi.";
        }
    } else {
        $_SESSION['status_failed'] = "Username tidak ditemukan! Silahkan coba lagi.";
    }
    header("Location: account-login.php");
    exit;
}
if(isset($_POST["login_user"])){
    login_user($_POST);
}



//-------------------------------------------------------------------//
//------------------------------PROFILE------------------------------//
function edit_profile($data){
    global $conn;
    // pengambilan data dari form
    $user_id = $_POST["user_id"];
    $user_name = htmlspecialchars($_POST["user_name"]);
    $user_email = htmlspecialchars($_POST["user_email"]);
    $user_birthday = htmlspecialchars($_POST["user_birthday"]);
    $user_gender = htmlspecialchars($_POST["user_gender"]);
    $user_phone = htmlspecialchars($_POST["user_phone"]);

    // query insert data
    $query = "UPDATE user SET user_name = '$user_name', user_email = '$user_email', user_birthday = '$user_birthday', user_gender = '$user_gender', user_phone = '$user_phone' WHERE user_id = $user_id";
    mysqli_query($conn, $query);

    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user_birthday'] = $user_birthday;
    $_SESSION['user_gender'] = $user_gender;
    $_SESSION['user_phone'] = $user_phone;

    return mysqli_affected_rows($conn);
}
if(isset($_POST["edit_profile"])){
    if(edit_profile($_POST)> 0){
        echo "
            <script>
                alert('data berhasil diubah!');
            </script>
        ";
        header("Location: profile-information.php");
    } else {
        echo "
            <script>
                alert('data gagal diubah!');
            </script>
        ";
        header("Location: profile-information.php");
    }
}

function send_order_proof($data) {
    global $conn;

    $order_id = $_POST["order_id"];

    $order_proof_img_name = $_FILES['order_proof_img']['name'];
    $order_proof_img_tmpname = $_FILES['order_proof_img']['tmp_name'];
    $order_proof_img_size = $_FILES['order_proof_img']['size'];
    $order_proof_img_error = $_FILES['order_proof_img']['error'];
    $order_proof_img_type = $_FILES['order_proof_img']['type'];

    $order_proof_img_ext = explode('.', $order_proof_img_name);
    $order_proof_img_ext_format = strtolower(end($order_proof_img_ext));
    $img_ext = array('jpg', 'jpeg', 'png');

    if (in_array($order_proof_img_ext_format, $img_ext)) {
        if ($order_proof_img_error === 0) {
            if ($order_proof_img_size < 10000000) {
                $order_proof_img_uniqid = uniqid('', true) . "." . $order_proof_img_ext_format;
                $order_proof_img_destination = 'images/order_proof/' . $order_proof_img_uniqid;
                move_uploaded_file($order_proof_img_tmpname, $order_proof_img_destination);

                $query = "UPDATE orders SET order_proof = '$order_proof_img_destination' WHERE order_id = $order_id";
                mysqli_query($conn, $query);

                header("Location: profile-status.php");
            } else {
                echo "<script>alert('File terlalu besar');</script>";
                return false;
            }
        } else {
            echo "<script>alert('File terlalu besar');</script>";
            return false;
        }
    } else {
        echo "<script>alert('File tidak diterima');</script>";
        return false;
    }
}
if (isset($_POST["send_order_proof"])) {
    if (send_order_proof($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
            </script>
        ";
        header("Location: profile-status.php");
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
            </script>
        ";
        header("Location: profile-status.php");
    }
}



?>