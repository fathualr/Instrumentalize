<?php
session_start();
require 'function.php';

if(!isset($_SESSION["user_email"])){
    header("Location: account-login.php");
    exit;
}
//----------//

function delete_data($data, $successMessage, $failedMessage, $location){
    if($data > 0){
        $_SESSION['status_success'] = "$successMessage";
        header("Location: $location");
    } else {
        $_SESSION['status_failed'] = "$failedMessage";
        header("Location: $location");
    }
}

//----------//

if(isset($_GET["user_id"])){
    $user_id = $_GET["user_id"];
    delete_data(delete_user($user_id), 'Data pengguna berhasil dihapus!', 'Data pengguna gagal dihapus!', 'admin-user.php');
}

if(isset($_GET["carousel_id"])){
    $carousel_id = $_GET["carousel_id"];
    delete_data(delete_carousel($carousel_id), 'Carousel berhasil dihapus!', 'Carousel gagal dihapus!', 'admin-editor.php');
}

if(isset($_GET["category_id"])){
    $category_id = $_GET["category_id"];
    delete_data(delete_category($category_id), 'Kategori berhasil dihapus!', 'Kategori gagal dihapus!', 'admin-category.php');
}

if(isset($_GET["product_id"])){
    $product_id = $_GET["product_id"];
    delete_data(delete_product($product_id), 'Data produk berhasil dihapus!', 'Data produk gagal dihapus!', 'admin-product.php');
}

if (isset($_GET["cart_ids"])) {
    $cart_ids = explode(",", $_GET["cart_ids"]);
    
    foreach ($cart_ids as $cart_id) {
        delete_data(delete_cart($cart_id), 'Produk berhasil dihapus dari keranjang!', 'Produk gagal dihapus dari keranjang!', 'profile-cart.php');
    }
}

if(isset($_GET["order_id"])){
    $order_id = $_GET["order_id"];
    delete_data(delete_order($order_id), 'Data orderan berhasil dihapus!', 'Data orderan gagal dihapus!', 'admin-orders.php');
}

if(isset($_GET["form_id"])){
    $form_id = $_GET["form_id"];
    delete_data(delete_form($form_id), 'Pesan berhasil dihapus!', 'Pesan gagal dihapus!', 'admin-reports.php');
}
?>
