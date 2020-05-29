<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="library/bootstrap-4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="library/css/css.css">
    <title>Document</title>
</head>
<style>
canvas {
    height: 400px;
    width: 700px;
    background: #92c792;
    margin: 100px;
    border:1px solid #000000;
    }  
h4{
    margin:50px;
}    

</style>
<body>
<!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mt-4">    
                           
               </div>
    </div>
</div> -->   
<div class = "container-fluid"  > 
    <?php

        include ('selectauthor.php');
        include('countKeySearch.php');

        if (isset($_POST['submit']))
        {
            if (!empty($_POST['check_list']))
            {
                // Counting number of checked checkboxes.
                $checked_count = count($_POST['check_list']);
                echo "<b>Bạn đã chọn " . $checked_count . " id sau:</b> <br/>";
                // Loop to store and display values of individual checked checkbox.
                foreach ($_POST['check_list'] as $selected)
                {
                    // echo "<p>".$selected ."</p>";         
                }
                //echo "<br/><b>Note :</b> <span>Similarily, You Can Also Perform CRUD Operations using These Selected Values.</span>";  
            }
            else
            {
                echo "<b>Please Select Atleast One Option.</b>";
            }
        }
        // Khởi tạo mảng id của các tác giả
        $arr_id = $_POST['check_list'];
        $arr_author = array();
        $arr_id2 = array();
        array_push($arr_id2,$arr_id);
    require ('connection.php');

        $query = "SELECT * FROM author where 1 = 1";

        for ($i = 0;$i < count($arr_id);$i++)
        {
            if ($i == 0)
            {
                $query .= " AND author_id = " . $arr_id[$i];
            }
            else
            {
                $query .= " OR author_id = " . $arr_id[$i];
            }
        }

        $selected = $conn->query($query);

        $num = $selected->num_rows;

        if ($num > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $selected->fetch_assoc())
            {
                $author = array(
                    $row['author_id'],
                    $row['name'],
                    $row['paper_total']
                   
                );
               // echo $row['author_id'] . "-----" . $row['name'] . "-----" . $row['paper_total'] ."-----".$row['feature_vector'] ."<br>";
                array_push($arr_author, $author);
            }
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();

    require ('connection.php');
        $query1 = "SELECT * FROM author ";
        $selected1 = $conn->query($query1);
        $num1 = $selected1->num_rows;
        if ($num1 > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $selected1->fetch_assoc())
            {
                $author1 = array(
                    $row['author_id'],
                    $row['name'],
                    $row['paper_total']
                );
                // echo $row['author_id'] . "-----" . $row['name'] . "-----" . $row['paper_total'] . "<br>";
                array_push($arr_author, $author1);

            }
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }

        $conn->close();

    $arrphpid = array(); //mảng root đợi để duyệt
        //Start with 1
        echo "<pre>";
    for ($i = 0;$i < count($arr_author) - 1;$i++)
        {
            print_r($arr_author[$i]);
            for ($j = $i + 1;$j < count($arr_author);$j++)
            {
                $arr1 = explode(',', substr(trim($arr_author[$i][2]) , 0, -1));
                $arr2 = explode(',', substr(trim($arr_author[$j][2]) , 0, -1));
                $count = 0;
                for ($k = 0;$k < count($arr1);$k++)
                {
                    // check trùng
                    if (in_array($arr1[$k], $arr2))
                    {
                        $count++;
                    }
                }
                if (($arr_author[$i][0] <> $arr_author[$j][0]) && ($count != 0))
                {
                    echo "A[" . $arr_author[$i][0] . "," . $arr_author[$j][0] . "] = " . $count . "<br>";
                    echo " Có :" . $count . " bài viết chung" . "<br>";
                    echo "--------------------------------" . "<br>";
                    array_push($arrphpid, [$arr_author[$i][0], $arr_author[$j][0], $count]);
                }
            }

            break;
        }
        //arrnode1 chứa các pt con 1
    $arrnode1 = array();
    $arr_author1 = array();
        // Start
        for ($i = 0;$i < count($arrphpid);$i++)
        {
            array_push($arrnode1, [$arrphpid[$i][1]]);
        }
        echo "---<b>Các tác giả có viết bài chung với tác giả được chọn(Mức 1)</b>---" . "<br>";
        echo '<table border="2" cellspacing="0" cellpadding="15"  >';
        for ($i = 0;$i < count($arrnode1);$i++)
        {
            echo '<tr>';
          //  echo "" . $arrnode1[$i][0] . "<br>";
            echo "<td>{$arrnode1[$i][0]}</td>";
            array_push($arr_id, $arrnode1[$i][0]);
            echo '</tr>';
        }
        echo '</table>';
        // print_r($arrnode1);
       //dữ liệu mức 2.
        $arrfinal2 = array();
        $arrNode2 = array();
    require ('connection.php');

        $query = "SELECT * FROM author where 1 = 1";

        for ($i = 0;$i < count($arrnode1);$i++)
        {
            if ($i == 0)
            {
                $query .= " AND author_id = " . $arrnode1[$i][0];
            }
            else
            {
                $query .= " OR author_id = " . $arrnode1[$i][0];
            }
        }

        $result = $conn->query($query);

        $num = $result->num_rows;

        if ($num > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $result->fetch_assoc())
            {

                // echo $row['author_id'] . "-----" . $row['name'] . "-----" . $row['paper_total'] . "<br>";
                $author = array(
                    $row['author_id'],
                    $row['name'],
                    $row['paper_total']
                );
                array_push($arr_author1, $author);

            }

        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();

        echo "        <b>Tìm kiếm tác giả có quan hệ viết bài chung với các tác giả trên.</b>   " . "<br>";

        $arrNodeList = array();

    require ('connection.php');
        $query3 = "SELECT * FROM author ";
        $selected3 = $conn->query($query3);
        $num3 = $selected3->num_rows;
        if ($num3 > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $selected3->fetch_assoc())
            {
                $author3 = array($row['author_id'],$row['name'],$row['paper_total']);
                // echo $row['author_id'] . "-----" . $row['name'] . "-----" . $row['paper_total'] . "<br>";
                array_push($arrNodeList, $author3);
            }
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();
    for ($i = 0;$i < count($arr_author1);$i++)
        {
            $arrNode2 = array();
            for ($j = $i;$j < count($arrNodeList);$j++)
            {

                $arr1 = explode(',', substr(trim($arr_author1[$i][2]) , 0, -1));
                $arr2 = explode(',', substr(trim($arrNodeList[$j][2]) , 0, -1));
                $count = 0;
                for ($k = 0;$k < count($arr1);$k++)
                {
                    // check trùng
                    if (in_array($arr1[$k], $arr2))
                    {
                        $count++;
                        //  echo "id author 1: " . $arr_author1[$i][0]. "<br>" . "id author 2: " . $arrNodeList[$j][0]. "<br>";
                        //  echo "chung tác phẩm số: " . $arr1[$k] . "<br>";
                        
                    }
                }

                if (($arr_author1[$i][0] <> $arrNodeList[$j][0]) && ($count != 0))
                {

                    echo "A[" . $arr_author1[$i][0] . "," . $arrNodeList[$j][0] . "] = " . $count . "<br>";

                    echo " Có :" . $count . " bài viết chung" . "<br>" . "<br>";

                    echo "--------------------------------" . "<br>";
                    array_push($arrNode2, $arrNodeList[$j][0]);
                }
            }
            array_push($arrfinal2, $arrNode2);
        }
    echo "                                         <b>Kết Quả Tìm kiếm tác giả có bài viết chung (mức 2)</b>               " . "<br>";
        array_push($arrfinal2, $arr_id);
        print_r($arrfinal2);
        echo '<table border="2" cellspacing="0" cellpadding="15"  >';
        for($i = 0; $i < count($arrfinal2); $i++){
            for($j=0; $j< count($arrfinal2[$i]); $j++){
        
            echo '<tr>';
            echo "<td>{$arrfinal2[$i][$j]}</td>";
            echo '</tr>';
            
        }
    }
        echo '</table>';



        $arrfinal3 = array(); // tạo mảng b
        for ($i = 0;$i < count($arrfinal2);$i++)
        {
            for ($j = 0;$j < count($arrfinal2[$i]);$j++)
            {
                // echo $arrfinal2[$i][$j].",";
                array_push($arrfinal3, $arrfinal2[$i][$j]); // push toàn bộ phần tử vào mảng b            
            }
            echo "<br>";
        }
        // print_r($arrfinal3);
        echo "<br>";
        $arrC = array(); // mảng chứa phần tử có thể cộng tác
        $arrSort = array_count_values($arrfinal3); // đếm số lần xuất hiện của các phần tử trong mảng b.
        // print_r($arrSort);
        asort($arrSort); // sắp xếp
        foreach ($arrSort as $arrfinal3[$i] => $x_value)
        {
            //echo "Key = " . $arrfinal3[$i] . ", Value = " . $x_value;
            if ($x_value <= 2)
            {
                // echo "Key = " . $arrfinal3[$i] . ", Value = " . $x_value;
                array_push($arrC, $arrfinal3[$i]);
            }
            echo "<br>";
        }
    echo "<h4>                                       THÔNG BÁO KẾT QUẢ                   </h4>"."<br>";
        echo " <b>Tổng hợp các id tác giả có khả năng cộng tác với id được chọn lúc đầu</b> " . "<br>";
       // print_r($arrC);
    require ('connection.php'); //lấy tên tác giả có thể cộng tác.
        $query = "SELECT * FROM author where 1 = 1";
        for ($i = 0;$i < count($arrC);$i++)
        {
            if ($i == 0)
            {
                $query .= " AND author_id = " . $arrC[$i];
            }
            else
            {
                $query .= " OR author_id = " . $arrC[$i];
            }
        }
        $selected = $conn->query($query);
        $num = $selected->num_rows;
        if ($num > 0)
        {
            echo '<table border="2" cellspacing="0" cellpadding="15"  >';
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $selected->fetch_assoc())
            {
                echo '<tr>';
                echo "<td>{$row['author_id']}</td>";
                echo "<td>{$row['name']}</td>";
                // $author = array($row['author_id'], $row['name']);
               // echo "id --" . $row['author_id'] . "--" . $row['name'] . "<br>";
                // array_push($arr_author, $author);
                echo '</tr>';
            }
            echo '</table>';
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();
        //code tìm độ tương tự.
    echo "--------------------Kết hợp Dữ liệu phần abstract-------------------------------" . "<br>";
        $arrabs = array();
    require ('connection.php');// bắt đầu từ đây lấy dữ liệu của bảng paper cột abstract add sang bảng author cột feature_vector
        $query1 = "SELECT * FROM paper ";
        $selected1 = $conn->query($query1);
        $num1 = $selected1->num_rows;
        if ($num1 > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $selected1->fetch_assoc())
            {
                $paper = array(
                    $row['paper_id'],
                    $row['abstract'],
                    $row['title']
                );
                // echo $row['paper_id'] ."----".$row['abstract'] . "<br>";
                array_push($arrabs, $paper);
                // $strAbs =    
            }
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();
    echo "------------------<b>Dự đoán Cộng tác </b>-----------------" . "<br>";
        echo " Dựa vào tập từ khóa sau:
        1:<b>data</b>, 2:<b>systems</b>, 3:<b>processing</b>,4:<b>relational</b>, 5:<b>attributes</b>, 6:<b>consistency</b>, 7:<b>constrained</b>, 8:<b>distributed</b>, 9:<b>analysis</b>, 10:<b>database</b>
        "."<br>";


        $keySearch = "database";
        $arrKQ = array();
        $result1 = array();
        for ($i = 0;$i < count($arrabs);$i++)
        {
            $result1 = substr_count($arrabs[$i][1], $keySearch);// tìm số lượng từ data trong abstract của mỗi id.
            //echo "id: ".$arrabs[$i][0]." với từ khóa 'data' có ".$result1." từ "."<br>";
            array_push($arrKQ, $result1);
        }
        //end
        // phần code add data keyword ở cột feature_vector bảng author
        //   CountWithKeySearch($keySearch, $arrKQ, $arrabs);
        // print_r($arrKQ);
        echo "<b>DỰA VÀO BẢNG VÀ ĐƯA RA KẾT QUẢ DỰ ĐOÁN CỘNG TÁC.</b>"."<br>";
        $arrauthorF = array();
       // print_r($arr_id2);
       array_push($arr_id2,$arrC);
      // print_r($arr_id2);
    require ('connection.php');
        $query = "SELECT * FROM author where 1 = 1";

        for ($i = 0;$i < count($arr_id2);$i++)
        {
            for($j = 0 ; $j < count($arr_id2[$i]); $j++){
            if ($i == 0)
            {
                $query .= " AND author_id = " . $arr_id2[$i][$j];
            }
            else
            {
                $query .= " OR author_id = " . $arr_id2[$i][$j];
            }
        }
        }
        $result = $conn->query($query);
        $num = $result->num_rows;
        if ($num > 0)
        {
            echo '<table border="2" cellspacing="0" cellpadding="15"  >';
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $result->fetch_assoc())
            {
                echo '<tr>';
                echo "<td>{$row['author_id']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['feature_vector']}</td>";
                // echo $row['author_id'] . "-----" . $row['name'] . "-----" . $row['feature_vector'] . "<br>";
                 echo '</tr>';
                 $author = array(
                    $row['author_id'],
                    $row['name'],
                    $row['feature_vector']
                );
                array_push($arrauthorF, $author);
            }
            echo '</table>';
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();
       print_r($arrauthorF);

    
        // for ($i = 0;$i < count($arrabs);$i++)
        // {
          
        //     $result4 = substr_count($arrabs[$i][1], "database");// tìm số lượng từ data trong abstract của mỗi id.
        //     if($result4 != 0){
        //     echo "id: ".$arrabs[$i][0]." với từ khóa 'data' có ".$result4." từ "."<br>";
        //     //array_push($arrKQ, $result1);
        //     }
        // }




?>  
</div>
<h4>Đồ thị liên kết thể hiện mối quan hệ giữa các tác giả. </h4>
<canvas id="canvas" ></canvas> 
<footer>
        <div class="contact">
            <h2>-2020-</h2>
        </div>     
</footer>   
</body>
  <script type="text/javascript" >
        <?php
        //$php_array = array('abc','def','ghi');s
        $js_array = json_encode($arr_id);
        echo "var js_arr = " . $js_array . ";\n";
        ?> 



                const canvas = document.getElementById('canvas');
                const ctx = canvas.getContext('2d');
                // mảng các đỉnh
                var arrXY = [];
            
                arrXY.push([10,10,250,10]);
            
                arrXY.push([10,10,100,20]);
                
                arrXY.push([10,10,150,50]);
                
                arrXY.push([10,10, 125,110]);
            
                arrXY.push([250,10,100,20]);
            
                arrXY.push([250,10,150,50]);
            
                arrXY.push([250,10,125,110]);
            
                arrXY.push([100,20,150,50]);
            
                arrXY.push([100,20,125,110]);
            
                arrXY.push([150,50,125,110]);

                for(var i = 0; i < js_arr.length; i++){
                    if(js_arr[i][2] != 0){
                        ctx.beginPath();
                        ctx.moveTo(arrXY[i][0], arrXY[i][1]); 
                        ctx.lineTo(arrXY[i][2], arrXY[i][3]);
                        ctx.stroke();
                        ctx.closePath();
                    }
                }

                var arrText = [];
                arrText.push([8, 7]);   
                arrText.push([255, 7]);
                arrText.push([110, 25]);
                arrText.push([150, 45]);
                arrText.push([130, 120]);
                // arrText.push([170, 65]);
                // arrText.push([150, 140]);

                //Ve text đỉnh
                ctx.beginPath();
                ctx.fillText(js_arr[0], arrText[0][0], arrText[0][1]);   
                ctx.fillText(js_arr[1], arrText[1][0], arrText[1][1]);
                ctx.fillText(js_arr[2], arrText[2][0], arrText[2][1]);
                ctx.fillText(js_arr[3], arrText[3][0], arrText[3][1]);
                ctx.fillText(js_arr[4], arrText[4][0], arrText[4][1])
                // ctx.fillText(js_arr[5], arrText[5][0], arrText[5][1]);
                // ctx.fillText(js_arr[6], arrTexT[6][0], arrText[6][1])

                ctx.closePath();




</script>
</html>
