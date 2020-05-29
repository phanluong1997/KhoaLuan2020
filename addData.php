<?php


    $xml_patch = "fileXML.xml";

    $text = preg_replace("/&(?!#?[a-z0-9]+;)/", '&amp;', file_get_contents($xml_patch));
    $text = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
    $text = str_replace(' & ' ,' &amp; ', html_entity_decode((htmlspecialchars_decode($text))));

    $xml = simplexml_load_string($text);

// echo "<pre>";
// var_dump($xml);

    require('init.php');
    
    echo '<p style="color:red">Lay du lieu cua publisher</p>';
    foreach ($xml as $key => $value) {
        if (isset($value->year)){
            // echo "<pre>";
            // echo $value->year;

            //Kiểm tra các publisher đã có $key và $value->year
            // TH1: có rồi: lấy publisher_id = id tại $key và $value->year
            // TH2: chưa có: chèn vào bảng publisher và lấy publisher_id = id vừa chèn vào

            require('connection.php');
            $sql = "SELECT publisher_id FROM publisher WHERE title ='". $key . "' AND year = " . $value->year;
            $result = $conn->query($sql);
            
            $checkExistsPublisherId = 0;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $checkExistsPublisherId = $row["publisher_id"];
                }
            }
            $conn->close();

            $publisher_id = 0;
            // TH1
            if($checkExistsPublisherId != 0){
                // echo $checkExistsPublisherId . "exists publiser <br>";
                $publisher_id = $checkExistsPublisherId;
            } else {
                //TH2: insert data for publisher table 
                require('connection.php');
                $sql = "INSERT INTO publisher (title, year) VALUES ('" . $key . "', " . $value->year . ")";
                if ($conn->query($sql) === true){
                    // echo "created <br>";
                }
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $conn->close();

                //Get publisher_id
                require('connection.php');
                $sql = "SELECT Max(publisher_id) AS MaxColumn FROM `publisher`";
                $result = $conn->query($sql);

                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $publisher_id = $row["MaxColumn"];
                    }
                } else {
                    echo "0 results";
                }
                
                $conn->close();
            }

            //insert data for paper table 
            if (isset($value->title)){
                require('connection.php');
                $value->title = str_replace("'", "\'", $value->title);
                $sql = "INSERT INTO paper (title, publisher_id) VALUES  ('" . $value->title . "', " . $publisher_id . ")";
                if ($conn->query($sql) === true){
                    //  echo "created <br>";
                }
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $conn->close();

                $paper_id = 0;
                // Get paper_id => insert paper_id to papaer_total in table author
                require('connection.php');
                $sql = "SELECT Max(paper_id) AS MaxColumn FROM `paper`";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $paper_id = $row["MaxColumn"];
                    }
                } else {
                    echo "0 results";
                }
                
                $conn->close();
            
                //Get paper_id
                echo $paper_id."<br>";

                //Duyet tat ca cac author co paper = $paper_id
                if (isset($value->author)){
                    echo " ---- count author: ". count($value->author) ."<br>";
                    for($i = 0; $i < count($value->author); $i++){
                        // echo $value->author[$i]. "<br>";
                        //Kiem tra ton tai name author trong bang author
                        $author_id = 0;
                        require('connection.php');
                        $sql = "SELECT author_id FROM `author` WHERE name = '".$value->author[$i] ."'";
                        $result = $conn->query($sql);
                        if($result){
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $author_id = $row["author_id"];
                                }
                            } else {
                                //echo "0 results";
                            }
                        }

                        if($author_id == 0){
                            // Chen du lieu bang author
                            require('connection.php');
                            $value->author[$i] = str_replace("'", "\'", $value->author[$i]);
                            $sql = "INSERT INTO `author`(`name`, `paper_total`) VALUES ('" . $value->author[$i] . "', '" . $paper_id . ",')";
                            if ($conn->query($sql) === true){
                                echo "created author truong hop chua co -----";
                            }
                            else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                            $conn->close();

                            // Lay author_id
                            $author_id  = 0;
                            require('connection.php');
                            $sql = "SELECT Max(author_id) AS MaxColumn FROM `author`";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $author_id = $row["MaxColumn"];
                                }
                            } else {
                                echo "0 results";
                            }
                            
                            $conn->close();

                            require('connection.php');
                            // Cap nhat author_total trong bang paper
                            $sql = "UPDATE paper SET author_total = CONCAT( IF(author_total IS NULL,'', author_total), '". $author_id . ",') WHERE paper_id=" . $paper_id;

                            if ($conn->query($sql) === TRUE) {
                                echo "Record paper updated set author_total truong hop chua co author $author_id<br>";
                               
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $conn->close();                                                             

                        } else{
                            // Lay author_id
                             echo "da co author_id: $author_id ----tai paper_id:  $paper_id<br>";
                            require('connection.php');
                            // Cap nhat bang author tai author_id: paper_total = $paper_id
                            $sql = "UPDATE author SET paper_total = CONCAT(IF(paper_total IS NULL,'', paper_total), '". $paper_id . ",') WHERE author_id=" . $author_id;

                            if ($conn->query($sql) === TRUE) {
                                echo "Record updated author truong hop da co author successfully $author_id<br>";
                            
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $conn->close();
                            // Cap nhat author_total trong bang paper
                            require('connection.php');
                            $sql = "UPDATE paper SET author_total = CONCAT(IF(author_total IS NULL,'', author_total), '". $author_id . ",') WHERE paper_id=" . $paper_id;

                            if ($conn->query($sql) === TRUE) {
                                echo "Record paper updated set author_total truong hop da co author $author_id<br>";
                               
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $conn->close();       
                        }
                    }
                }

            }
        }
    }


    
?>
