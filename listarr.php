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
    width: 400px;
    background: #92c792;
    margin: 100px;
    border:1px solid #000000;
    }  
h4{
    margin:50px;
}    
</style>
<body>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mt-4">   
    <?php


        include('selectauthor.php');
        
        if(isset($_POST['submit'])){
            if(!empty($_POST['check_list1'])) {
            // Counting number of checked checkboxes.
            $checked_count = count($_POST['check_list1']);
            echo "Bạn đã chọn ".$checked_count." Id sau: <br/>";
            // Loop to store and display values of individual checked checkbox.
            foreach($_POST['check_list1'] as $selected) {
            echo "<p>".$selected ."</p>";
            }
            //echo "<br/><b>Note :</b> <span>Similarily, You Can Also Perform CRUD Operations using These Selected Values.</span>";
            }
            else{
            echo "<b>Please Select Atleast One Option.</b>";
            }
            }

            
        // Khởi tạo mảng id của các tác giả
        $arr_id = $_POST['check_list1'];
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

        $selected = $conn->query($query);

        $num = $selected->num_rows;
        
        if ($num > 0)
        {
            // Vòng lặp while & fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
            while ($row = $selected->fetch_assoc())
            {
                $author = array($row['author_id'], $row['name'], $row['paper_total']);
                //echo $row['author_id'] . "-----" . $row['name'] . "-----" . $row['paper_total'] . "<br>";
                array_push($arr_author, $author);
            }
        }
        else
        {
            echo "Khong tim thay ket qua!";
        }
        $conn->close();
        $arrphp = array();
        for ($i = 0; $i < count($arr_author) - 1; $i++) {
            for ($j= $i + 1; $j < count($arr_author); $j++) {

                $arr1 =  explode(',', substr(trim($arr_author[$i][2]), 0, -1));
                $arr2 =  explode(',', substr(trim($arr_author[$j][2]), 0, -1));
                $count = 0;
                for ($k=0; $k < count($arr1); $k++) {
                    // check trùng
                    if (in_array($arr1[$k], $arr2)){
                        $count++;
                            echo "id Author : " . $arr_author[$i][0]. "<br>" . "id Author : " . $arr_author[$j][0]. "<br>";
                            echo "Viết chung bài viết số: " . $arr1[$k] . "<br>";
                        // echo " có :".$count." viết chung" ."<br>";
                    }
                
                }
                
                echo "A[" . $arr_author[$i][0] . "," . $arr_author[$j][0] ."] = " . $count . "<br>";

                array_push($arrphp,[$arr_author[$i][0],$arr_author[$j][0],$count]);
            }
            
        }  
       
    ?>  
               
      </div>
    </div>
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
            //$php_array = array('abc','def','ghi');
            $js_array = json_encode($arrphp);
            echo "var js_arr = ". $js_array . ";\n";
        ?>

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        var arrXY = [];
        //20-21
        arrXY.push([10,10,250,10]);
        //20,22
        arrXY.push([10,10,100,20]);
        //20,23
        arrXY.push([10,10,150,50]);
        //20,24
        arrXY.push([10,10, 125,110]);
        //21,22
        arrXY.push([250,10,100,20]);
        //21,23
        arrXY.push([250,10,150,50]);
        //21,24
        arrXY.push([250,10,125,110]);
        //22,23
        arrXY.push([100,20,150,50]);
        //22,24
        arrXY.push([100,20,125,110]);
        //23,24
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
        //Ve so
        ctx.beginPath();
        ctx.fillText(js_arr[0][0], arrText[0][0], arrText[0][1]);   
        ctx.fillText(js_arr[4][0], arrText[1][0], arrText[1][1]);
        ctx.fillText(js_arr[7][0], arrText[2][0], arrText[2][1]);
        ctx.fillText(js_arr[9][0], arrText[3][0], arrText[3][1]);
        ctx.fillText(js_arr[9][1], arrText[4][0], arrText[4][1])
        ctx.closePath();




</script>
</html>            
          
      

