<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Form HTML</title>
<style>

</style>    
</head>
<body>
    <h1>Danh sách bài viết</h1>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Tác Giả</th>
                <th>Tiêu Đề</th>
            </tr>
        </thead>
    <tbody>    
        <?php
      
           // require('connection.php');
            //require_once('fetch_data.php');
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "dblp_luong";
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $sql = "SELECT id,author,title FROM mydblp ORDER BY author" ;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output dữ liệu trên trang
            while($row = $result->fetch_assoc()) {
                echo "<table><tr><td><b> " . $row["id"]. ": </b></td><td><h4> " . $row["author"]. "</h4> </td><td> ---". $row["title"]."</td></tr></table>". "<br>";
                    
            }
            } else {
            echo "0 results";
            }
            $conn->close();


        ?>
    </tbody>
    </table>
</body>
</html>