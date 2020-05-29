<?php
    function CountWithKeySearch($keySearch, $arrKQ, $arrabs){
        $authorkey = array();
        //lay du lieu bang author
        require ('connection.php');// bắt đầu từ đây lấy dữ liệu của bảng paper cột abstract add sang bảng author cột feature_vector
        $query1 = "SELECT * FROM author ORDER by author_id ASC ";
        $selected1 = $conn->query($query1);
        $num1 = $selected1->num_rows;
        if ($num1 > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $selected1->fetch_assoc())
            {
                $author = array(
                    $row['author_id'],
                    $row['paper_total'],
                    $row['feature_vector']
                );
                array_push($authorkey, $author);
            }
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();

        for ($i = 0; $i < count($authorkey); $i++)
        {
            // Create count keywork
            $countKey = 0;
           // Get list key paper
            $listIdPaper = explode(",", $authorkey[$i][1]);
           
            for ($j = 0; $j < count($listIdPaper); $j++)
            {
                for ($k = 0;$k < count($arrKQ); $k++)
                {
                    if($listIdPaper[$j] == $arrabs[$k][0] && $arrKQ[$k] != 0){
                        $countKey += $arrKQ[$k];
                    }
                }
            }
            //$a = 0;
            if($countKey > 0 ){
               if( count($authorkey) > 0){
                 $valUpdate = $authorkey[$i][2].",".$keySearch.":".$countKey;
               }
               else{
                   $valUpdate = $keySearch.":".$countKey;
               }
                
                require ('connection.php');
                $sqlUpd = 'UPDATE author SET feature_vector = "'.$valUpdate.'" WHERE author_id = '.$authorkey[$i][0];//'.$valUpdate.'

                if ($conn->query($sqlUpd) === TRUE) {
                    echo "Thành công ".$sqlUpd."<br>";
                } 
                else {
                    echo "Thất bại ".$sqlUpd."<br>";
                }
                $countKey = 0;
                $conn->close();  
            }
        }


     }

?>