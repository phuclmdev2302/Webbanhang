<?php
require_once("config.php");

// insert, update, delete, select
function execute($sql) {
    // mở kết nối
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // thiết lập bộ ký tự
    mysqli_set_charset($conn, 'utf8');

    // truy vấn
    mysqli_query($conn, $sql);
    
    // đóng kết nối
    mysqli_close($conn);
}

// SQL: select -> lấy dữ liệu đầu ra
function executeResult($sql, $isSingle = false) {
    $data = [];

    // mở kết nối
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // thiết lập bộ ký tự
    mysqli_set_charset($conn, 'utf8');

    // truy vấn
    $result = mysqli_query($conn, $sql);
    
    if( $isSingle ){
        $data = mysqli_fetch_array($result, 1);
    }else{
        // lấy các hàng từ tập kết quả
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }
    }
    
    
    // đóng kết nối
    mysqli_close($conn);

    return $data;
}
?>