<?php
//Drop table author
    require('connection.php');
    $sql = "DROP TABLE IF EXISTS `author`";
    if ($conn->query($sql) === true){
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
//create table author
    require('connection.php');
    $sql = "CREATE TABLE IF NOT EXISTS `author` (
        `author_id` int(11) NOT NULL AUTO_INCREMENT,
        `name` text NOT NULL,
        `feature_vector` text DEFAULT NULL,
        `email` varchar(255) DEFAULT NULL,
        `paper_total` text DEFAULT NULL,
        PRIMARY KEY (`author_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    if ($conn->query($sql) === true){
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    //Drop table paper
    require('connection.php');
    $sql = "DROP TABLE IF EXISTS `paper`";
    if ($conn->query($sql) === true){
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    //create table paper
    require('connection.php');
    $sql = "CREATE TABLE IF NOT EXISTS `paper` (
        `paper_id` int(11) NOT NULL AUTO_INCREMENT,
        `title` text NOT NULL,
        `author_total` text DEFAULT NULL,
        `publisher_id` int(11) NOT NULL,
        `abstract` text NOT NULL,
        `keyword` text NOT NULL,
        PRIMARY KEY (`paper_id`),
        KEY `publisher_id` (`publisher_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if ($conn->query($sql) === true){
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    //Drop table publisher
    require('connection.php');
    $sql = "DROP TABLE IF EXISTS `publisher`";
    if ($conn->query($sql) === true){
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    //create table publisher
    require('connection.php');
    $sql = "CREATE TABLE IF NOT EXISTS `publisher` (
        `publisher_id` int(11) NOT NULL AUTO_INCREMENT,
        `title` text NOT NULL,
        `year` int(11) NOT NULL,
        `topic` text DEFAULT NULL,
        PRIMARY KEY (`publisher_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if ($conn->query($sql) === true){
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    //Khoa ngoai
    require('connection.php');
    $sql = "ALTER TABLE `paper`
    ADD CONSTRAINT `paper_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`publisher_id`) ON DELETE CASCADE ON UPDATE NO ACTION;";
    if ($conn->query($sql) === true){
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

?>