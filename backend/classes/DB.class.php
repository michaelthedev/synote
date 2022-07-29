<?php
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 10 Jul, 2022 10:19 AM
// +------------------------------------------------------------------------+
// | 2022 Logad Networks
// +------------------------------------------------------------------------+

// +----------------------------+
// | Database Handler
// +----------------------------+
class DB {

    ## PDO Connection ##
    private static function PDOConnection() {
        require __DIR__ . '/../inc/config.php';
        try {
            return new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8', $dbUser, $dbPass);
        } catch (PDOException $exception) {
            exit('Failed to connect to database!');
        }
        return false;
    }

    ## Run Query ##
    protected static function RunQuery($data) {
        // Create connection
        $pdoConnection = self::PDOConnection();

        $query = $pdoConnection->prepare($data['query']);
        if (!empty($data['values'])) {
            $query->execute($data['values']);
        } else {
            $query->execute();
        }

        // Confirm Query
        if (!empty($data['returnConfirmation'])) {
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return 500;
            }
        }

        // return insert ID
        if (!empty($data['returnInsertID'])) {
            if ($query->rowCount() == 1) {
                return $pdoConnection->lastInsertId();
            }
        }

        // Fetch Results
        if (!empty($data['singleRecord'])) {
            return $query->fetch(PDO::FETCH_OBJ);
        } else {
            return $query->fetchAll(PDO::FETCH_OBJ);
        }
        return false;
    }
}