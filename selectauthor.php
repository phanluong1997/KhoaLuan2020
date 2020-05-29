<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="library/bootstrap-4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="library/css/css.css">
    <title>Danh sách hiển thị List tác giả</title>
</head>
<body>
   <div class="menu">
            <nav class="navbar  navbar-inverse  ">                  
                <a href="#" class="navbar-brand"><img src="library/image/dblp.png" style="width:150px; height:150px;" >  </a>    
                 <header>
                    <h2><strong>HỆ KHUYẾN NGHỊ HỢP TÁC NGHIÊN CỨU</strong></h2>
                    <h6><i>DỰA TRÊN DỮ LIỆU THU THẬP TỪ DBLP</i></h6>
                </header>
            </nav>
    </div>
    
        <h1><strong>CHƯƠNG TRÌNH THỬ NGHIỆM</strong></h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mt-4">
               
    
                <?php
                    // Nếu người dùng submit form thì thực hiện
                    if (isset($_REQUEST['ok']))
                    {
                        // Gán hàm addslashes để chống sql injection
                        $search = addslashes($_GET['search']);

                        // Nếu $search rỗng thì báo lỗi, tức là người dùng chưa nhập liệu mà đã nhấn submit.
                        if (empty($search))
                        {
                            echo "CHƯA NHẬP ";
                        }
                        else
                        {

                            // Dùng câu lênh like trong sql và sứ dụng toán tử % của php để tìm kiếm dữ liệu chính xác hơn.
                            $query = "SELECT * FROM author where name like '%$search%'";

                            // // Kết nối sql
                            // mysql_connect("localhost", "root", "", "dblpkhoaluan");
                            $connect = mysqli_connect('localhost', 'root', '', 'dblpkhoaluan');
                            //Kiểm tra kết nối
                            if (!$connect)
                            {
                                die('kết nối không thành công ' . mysqli_connect_error());
                            }
                            // Thực thi câu truy vấn
                            // $sql = mysql_query($query);
                            $result = $connect->query($query);

                            // Đếm số đong trả về trong sql.
                            $num = $result->num_rows;

                            // Nếu có kết quả thì hiển thị, ngược lại thì thông báo không tìm thấy kết quả
                            if ($num > 0 && $search != "")
                            {
                                // Dùng $num để đếm số dòng trả về.
                                echo " --Tìm Được $num Kết quả trả vê với từ khóa --  <b><i>$search</i></b> -- là:" . "<br>";

                                //echo '<td><button type =submit> Chọn </button></td>'; 
                                // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
                                echo '<form method = "post" action = "DEMO.php"  >';    
                                echo '<table border="2" cellspacing="0" cellpadding="15"  >';
                                echo  '<input type="submit" value="Chọn" name="submit" >';
                                while ($row = $result->fetch_assoc())
                                {
                                    echo '<tr>';
                                    echo "<td>{$row['author_id']}</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo '<td><input type="checkbox" value ="'.$row['author_id'].'" name="check_list[]"></input</td>';
                                    
                                    echo '</tr>';
                                   
                                }
                                echo '</table>';

                            //but2
 
                             }
                                   
                                     
                            else
                            {
                                echo "Khong tim thay ket qua!";
                            }
                        }
                    }

                ?>
                     
                     </div>
        </div>
    </div>
               
</body>
</html>