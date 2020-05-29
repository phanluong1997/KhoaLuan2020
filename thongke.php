<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
<style>
   
</style>
</head>
<body>
    <?php
        // Khởi tạo mảng id của các tác giả
        $arr_id = array(1,2,3);
        $arr_author = array();
        
        
        require('connection.php');

        $query = "SELECT * FROM author where 1 = 1";

        for ($i=0; $i < count($arr_id); $i++) {
            if($i == 0){
                $query .= " AND author_id = " . $arr_id[$i];
            } else {
                $query .= " OR author_id = " . $arr_id[$i];
            }
        }

        $result = $conn->query($query);

        $num = $result->num_rows;
      
        if ($num > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $result->fetch_assoc())
            {
                echo $row['author_id'] . "-----" . $row['name'] . "-----" . $row['paper_total'] . "<br>";
                $author = array($row['author_id'], $row['name'], $row['paper_total']);
              // array_push($arr_author, $author); 
               
            }
            
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();
       

        
        // for ($i = 0; $i < count($arr_author) - 1; $i++) {
        //     for ($j= $i + 1; $j < count($arr_author); $j++) {

        //         $arr1 =  explode(',', substr(trim($arr_author[$i][2]), 0, -1));
        //         $arr2 =  explode(',', substr(trim($arr_author[$j][2]), 0, -1));
        //         $count = 0;
        //         for ($k=0; $k < count($arr1); $k++) {
        //             // check trùng
        //             if (in_array($arr1[$k], $arr2)){
        //                 $count++;
        //                 // echo "id author 1: " . $arr_author[$i][0]. "<br>" . "id author 2: " . $arr_author[$j][0]. "<br>";
        //                 // echo "chung tác phẩm số: " . $arr1[$k] . "<br>";
                        
        //             }
        //         }
        //         echo "A[" . $arr_author[$i][0] . "," . $arr_author[$j][0] ."] = " . $count . "<br>";
        //        //array_push($arrphp,[$arr_author[$i][0],$arr_author[$j][0],$count]);
        //     }
        // }

            

    ?>

</body>

</html>