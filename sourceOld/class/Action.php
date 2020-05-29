<?php
class Action
{
    public function insertData($obj){
        // require_once("../connection.php");
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
        
        $sql = "INSERT INTO MyDBLP (author, title, year, journal) VALUES (". $obj->author . ", ". $obj->title . ",". $obj->year . " , ". $obj->journal. ")";
        //$sql = "INSERT INTO MyDBLP (author, title, year, journal) VALUES ('123', 'abc', 2000, 'journaljournal')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
    }
    
    
}
?>