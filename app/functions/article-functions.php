<?php
include_once('functions.php');

/**
 * @param $id: L'id de l'article à récupérer
 * @param $msg: Les messages
 *
 * @return L'article sous forme d'un tableau associatif
 */

function getArticleBy($id, &$msg) {
    $result = array();
    $dbConnection = null;

    try {
        $dbConnection = connectToDB();
        $result = $dbConnection->prepare("SELECT * FROM articles WHERE id = :id");
        $result->bindValue(":id", $id);

        if ($result->execute()){
            $result = $result->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $ex) {
        $msg .= $ex->getMessage();
    }

    disconnectToDB($dbConnection);
    return $result;
}

/**
 * @param $title: Le titre de l'article
 * @param $content: Le contenu de l'article
 * @param $msg: Les messages
 *
 * @return True si l'ajout de l'article publié a été fait, false sinon
 */
function publish($title, $content, &$msg) {
    $result = array();
    $dbConnection = null;

    try {
        $dbConnection = connectToDB();
        $result = $dbConnection->prepare("INSERT INTO articles (title, content, estPublie) VALUES (:title, :content, 1)");

        $result->bindValue(":title", $title);
        $result->bindValue(":content", $content);

        if ($result->execute()) { $result = true; $msg = 'Publication réussie'; }
    } catch (PDOException $ex) {
        $msg .= $ex->getMessage();
    }

    disconnectToDB($dbConnection);
    return $result;
}

/**
 * @param $title: Le titre de l'article
 * @param $content: Le contenu de l'article
 * @param $msg: Les messages
 *
 * @return True si l'ajout de l'article sauvegardé a été fait, false sinon
 */
function save($title, $content, &$msg) {
    $result = array();
    $dbConnection = null;

    try {
        $dbConnection = connectToDB();
        $result = $dbConnection->prepare("INSERT INTO articles (title, content, estPublie) VALUES (:title, :content, 0)");

        $result->bindValue(":title", $title);
        $result->bindValue(":content", $content);

        if ($result->execute()) { $result = true; $msg = 'Sauvegarde réussie'; }
    } catch (PDOException $ex) {
        $msg .= $ex->getMessage();
    }

    disconnectToDB($dbConnection);
    return $result;
}

/**
 * @param $id: L'id de l'article
 * @param $title: Le titre de l'article
 * @param $content: Le contenu de l'article
 * @param $msg: Les messages
 *
 * @return True si la modification de l'article a été faite, un tableau vide sinon
 */
function edit($id, $title, $content, &$msg) {
    $result = array();
    $dbConnection = null;

    try {
        $dbConnection = connectToDB();
        $result = $dbConnection->prepare( "UPDATE articles SET title = :title, content = :content WHERE id = :id");

        $result->bindValue(":id", $id);
        $result->bindValue(":title", $title);
        $result->bindValue(":content", $content);

        if ($result->execute()) { $result = true; }
    } catch (PDOException $ex) {
        $msg .= $ex->getMessage();
    }

    disconnectToDB($dbConnection);
    return $result;
}

/**
 * @param $id: L'id de l'article
 * @param $msg: Les messages
 *
 * @return True si la suppression de l'article a été faite, un tableau vide sinon
 */
function delete($id, &$msg) {
    $result = array();
    $dbConnection = null;

    try {
        $dbConnection = connectToDB();
        $result = $dbConnection->prepare( "DELETE FROM articles WHERE id = :id");

        $result->bindValue(":id", $id);

        if ($result->execute()) { $result = true; }
    } catch (PDOException $ex) {
        $msg .= $ex->getMessage();
    }

    disconnectToDB($dbConnection);
    return $result;
}
