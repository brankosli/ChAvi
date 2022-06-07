<?php

namespace chAvio\Model;

class Setup{

    // Connection
    private $conn;

    // Table
    private $dbTable = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createDb($type='mysql')
    {
        try {

            $query = "CREATE TABLE IF NOT EXISTS " . $this->dbTable . " (
                          `userId` int(11) NOT NULL " . ($type == 'mysql' ? "AUTO_INCREMENT" : "") . ",
                          `name` varchar(256) NOT NULL,
                          `yearOfBirth` int(11),
                          `updated` date,
                          `created` date NOT NULL,
                          PRIMARY KEY (`userId`)
                        ) " . ($type == 'mysql' ? "ENGINE=InnoDB  DEFAULT CHARSET=utf8" : "") .";";

            $stmt = $this->conn->prepare($query);

            if($stmt->execute()){
                return true;
            }
            return false;

        } catch(PDOException $exception){
            echo "Problem with creating database: " . $exception->getMessage();
        }
    }

    public function insertData()
    {
        try {
            $query = "INSERT INTO " . $this->dbTable . " (`userId`, `name`, `yearOfBirth`, `updated`, `created`) VALUES 
                        (1, 'John Smith',1960,'2022-06-01','2022-05-01'),
                        (2, 'Tina Bradley',1970,'2022-06-01','2022-05-01'),
                        (3, 'Violet Carter',1980,NULL,'2022-05-01'),
                        (4, 'Sana Lane',1990,'2022-06-01','2022-05-01'),
                        (5, 'Haris Harper',2000,'2022-06-01','2022-03-01'),
                        (6, 'Branko Me',1978,NULL,'2022-04-01');";

            $stmt = $this->conn->prepare($query);

            if($stmt->execute()){
                return true;
            }
            return false;

        } catch(PDOException $exception) {
            echo "Problem with inserting data into database: " . $exception->getMessage();
        }
    }

}