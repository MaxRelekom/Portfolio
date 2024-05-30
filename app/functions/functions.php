<?php
include ("config/config.php");

function connectToDB() {
    try {
        $dbLink = new PDO("mysql:host=".SERVER_ADRESS.";dbname=".DB_NAME);
        $dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        $dbLink = $ex->getMessage();
    }

    return $dbLink;
}

function disconnectToDB(&$link) {
    $link = null;
}

function exists($mail, $password, &$msg) {
    $result = array();
    $dbConnection = null;

    try {
        $dbConnection = connectToDB();
        $result = $dbConnection->prepare("SELECT * FROM users WHERE email = :email AND password = :password");

        $result->bindValue(":email", $mail);
        $result->bindValue(":password", $password);

        if ($result->execute()) {
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (PDOException $ex) {
        $msg .= $ex->getMessage();
    }

    disconnectToDB($dbConnection);
    return $result;
}

function getArticlesBy($estPublie, &$msg) {
    $result = array();
    $dbConnection = null;

    try {
        $dbConnection = connectToDB();
        $result = $dbConnection->prepare("SELECT * FROM articles WHERE estPublie = :estPublie");

        $result->bindValue(":estPublie", $estPublie);

        if ($result->execute()) {
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $ex) {
        $msg .= $ex->getMessage();
    }

    disconnectToDB($dbConnection);
    return $result;
}

function displayArticles($articles) {
    foreach ($articles as $article) {
        $id = $article['id'];
        $validTitle = htmlentities($article['title']);

        $link = "href = \"vueArticle.php?id=$id\"";
        echo "<li><a $link> $validTitle</a></li>";
    }
}

?>
