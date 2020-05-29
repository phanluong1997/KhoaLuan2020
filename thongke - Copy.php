<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
<style>
    /* #board{
        display:block;
        background: white;
        
        margin : 10px auto;
        width : 800px;
        height: 500px;
    } */
    #canvas {
        height: 400px;
        width: 400px;
        background: #92c792;
        }
</style>
</head>
<body>

    <?php

        // Khởi tạo mảng id của các tác giả
        $arr_id = array( 20, 21, 22, 23, 24);
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
       // $arrphp  = array();

        for ($i = 0; $i < count($arr_author) - 1; $i++) {
            for ($j= $i + 1; $j < count($arr_author); $j++) {

                $arr1 =  explode(',', substr(trim($arr_author[$i][2]), 0, -1));
                $arr2 =  explode(',', substr(trim($arr_author[$j][2]), 0, -1));
                $count = 0;
                for ($k=0; $k < count($arr1); $k++) {
                    // check trùng
                    if (in_array($arr1[$k], $arr2)){
                        $count++;
                        // echo "id author 1: " . $arr_author[$i][0]. "<br>" . "id author 2: " . $arr_author[$j][0]. "<br>";
                        // echo "chung tác phẩm số: " . $arr1[$k] . "<br>";
                        
                    }
                }
                echo "A[" . $arr_author[$i][0] . "," . $arr_author[$j][0] ."] = " . $count . "<br>";
               // array_push($arrphp,[$arr_author[$i][0],$arr_author[$j][0],$count]);
            }
        }

            

    ?>
<canvas id="canvas" ></canvas> 
    <!-- <canvas id="board" ></canvas>   -->
</body>
<script type="text/javascript" >
        // <?php
        //     //$php_array = array('abc','def','ghi');
        //     $js_array = json_encode($arrphp);
        //     echo "var js_arr = ". $js_array . ";\n";
        // ?>

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

            var js_arr = [];
            js_arr.push([20,21,5]);
            js_arr.push([20,22,2]);
            js_arr.push([20,23,0]);
            js_arr.push([20,24,0]);
            js_arr.push([21,22,1]);
            js_arr.push([21,23,0]);
            js_arr.push([21,24,0]);
            js_arr.push([22,23,0]);
            js_arr.push([22,24,0]);
            js_arr.push([23,24,9]);

            for(var i = 0; i < js_arr.length; i++){
                console.log(js_arr[i][1]);
            }

            ctx.beginPath(); 
            //for(var i = 0; i<js_arr.length; i++){
                // ctx.fillText("20", 8, 7);
                // ctx.fillText("21", 255, 7);
                // ctx.fillText("22", 100, 15);
                // ctx.fillText("23", 150,45);
                // ctx.fillText("24", 130,120);

           
            if(js_arr[0][2]!==0){ 
            //20-21     
            ctx.moveTo(10, 10); 
            ctx.fillText("20", 8, 7);   
            ctx.lineTo(250, 10);
            ctx.fillText("21", 255, 7);
            //ctx.stroke();
            }
            else{
                ctx.fillText("21", 255, 7);
            }
            if(js_arr[1][2]!==0){
            //20-22
            ctx.moveTo(10,10);
            ctx.lineTo(100,20);
            ctx.fillText("22", 100, 15);
            }
            else {
                ctx.fillText("22", 100, 15);
            }
            if(js_arr[2][2]!==0){
            // 20-23
            ctx.moveTo(10,10);
            ctx.lineTo(150,50);
            ctx.fillText("23", 150,45);

            }else{
                ctx.fillText("23", 150,45);
            }
            if(js_arr[3][2]!==0){
                //20-24
            ctx.moveTo(10,10);
            ctx.lineTo(125,110);
            ctx.fillText("24", 130,120);
            }
            else{
                ctx.fillText("24", 130,120)
            }
            if(js_arr[4][2]!==0){
            //21-22     
            ctx.moveTo(250, 10);  
            ctx.lineTo(100,20);
            }
            else{}
            if(js_arr[5][2]!==0){
            //21-23
            ctx.moveTo(250,10);
            ctx.lineTo(150,50);
            }
            else{}

            if(js_arr[6][2]!==0){
            //21-24
            ctx.moveTo(250,10);
            ctx.lineTo(125,110);
            }
            else{}
            if(js_arr[7][2]!==0){
            //22-23
            ctx.moveTo(100,20);
            ctx.lineTo(150,50);
            }
            else{}
            if(js_arr[8][2]!==0){
            //22-24
            ctx.moveTo(100,20);
            ctx.lineTo(125,110);
            }
            else{}
            if(js_arr[9][2]!==0){
            //23-24
            ctx.moveTo(150,50);
            ctx.lineTo(125,110);
            }
            else{}



            ctx.stroke();



</script>
</html>