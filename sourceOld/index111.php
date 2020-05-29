<?php
require_once ('class\Article.php');
require_once ('class\Action.php');
//require_once ('class\fetch_data.php');

//require('connection.php');

$xml_patch = "fileXML.xml";

$text = preg_replace("/&(?!#?[a-z0-9]+;)/", '&amp;', file_get_contents($xml_patch));

$text = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
$text = str_replace(' & ', ' &amp; ', html_entity_decode((htmlspecialchars_decode($text))));

$xml = simplexml_load_string($text);

// echo "<pre>";
// var_dump($xml);
// Lay du lieu cua article
echo '<p style="color:red">article</p>';
if (isset($xml->article))
{
    foreach ($xml->article as $article)
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dblp_luong";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($inproceedings->journal))
        {
            $article->title = str_replace("'", "\'", $article->title);

            $sql = "INSERT INTO MyDBLP (isarticle, author, title, year, journal) VALUES (true,'" . $article->author . "', '" . $article->title . "'," . $article->year . ", '" . $article->journal . "')";
        }
        else
        {
            $sql = "INSERT INTO MyDBLP (isarticle, author, title, year) VALUES (true,'" . $article->author . "', '" . $article->title . "'," . $article->year . ")";
        }

        if ($conn->query($sql) === true)
        {
            echo "created article<br>";
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
else
{
    echo "khong";
}

echo '<p style="color:red">inproceedings</p>';

// Lay du lieu cua inproceedings
if (isset($xml->inproceedings))
{
    foreach ($xml->inproceedings as $inproceedings)
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dblp_luong";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        $inproceedings->title = str_replace("'", "\'", $inproceedings->title);

        if (isset($inproceedings->journal))
        {
            $sql = "INSERT INTO MyDBLP (isarticle, author, title, year, journal) VALUES (false,'" . $inproceedings->author . "', '" . $inproceedings->title . "'," . $inproceedings->year . ", '" . $inproceedings->journal . "')";
        }
        else
        {
            $sql = "INSERT INTO MyDBLP (isarticle, author, title, year) VALUES (false,'" . $inproceedings->author . "', '" . $inproceedings->title . "'," . $inproceedings->year . ")";
        }

        if ($conn->query($sql) === true)
        {
            echo "created inproceedings<br>";
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
else
{
    echo "khong";
}

?>
