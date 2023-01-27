<?php
/*---------------Insert---------------*/
function Insert($fname,$lname,$chatId,$command,$reply)
{
    require_once('./db-config.php');

    $sql = "INSERT INTO `records`(`fname`, `lname`, `chatId`, `command`, `reply`) VALUES (:nm, :ln, :ci, :cm, :rp)";

    $query = $pdo->prepare($sql);
    $query->bindParam(':nm', $fname, PDO::PARAM_STR);
    $query->bindParam(':ln', $lname, PDO::PARAM_STR);
    $query->bindParam(':ci', $chatId, PDO::PARAM_STR);
    $query->bindParam(':cm', $command, PDO::PARAM_STR);
    $query->bindParam(':rp', $reply, PDO::PARAM_STR);

    $query->execute();
}

/*---------------Select One-----------*/
function SelectOne($id)
{
    require_once('./db-config.php');

    $sql = "SELECT * FROM `records` WHERE `id`=:id";

    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    $query->execute();
}

/*---------------Delete---------------*/
function Delete($id)
{
    require_once('./db-config.php');

    $sql = "DELETE FROM `records` WHERE `id`=:id";

    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
}
