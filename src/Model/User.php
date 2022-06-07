<?php

namespace chAvio\Model;

use chAvio\Exceptions\DbException;
use \PDO;
use \PDOException;

class User
{
    /**
     * @var \chAvio\Interfaces\DatabaseInterface
     */
    private $db;

    /**
     * @var string Name of DB table
     */
    private $dbTable = "users";

    /**
     * @var int
     */
    public $userId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $yearOfBirth;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $updated;

    /**
     * User constructor.
     * @param \chAvio\Interfaces\DatabaseInterface|null $db
     */
    public function __construct($db=null)
    {
        $this->db = $db;
    }

    public function setId($userId)
    {
        $this->userId = !empty($userId) ? htmlspecialchars(strip_tags($userId)) : null;
        return $this;
    }

    public function setName($name)
    {
        $this->name = !empty($name) ? htmlspecialchars(strip_tags($name)) : null;
        return $this;
    }

    public function setYearOfBirth($yearOfBirth)
    {
        $this->yearOfBirth = !empty($yearOfBirth) ? htmlspecialchars(strip_tags($yearOfBirth)) : null;
        return $this;
    }

    public function setCreated()
    {
        $this->created = date('Y-m-d');;
        return $this;
    }

    public function setUpdated()
    {
        $this->updated = date('Y-m-d');;
        return $this;
    }

    // CREATE
    public function createUser()
    {
        try
        {
            $query = "INSERT INTO
                        ". $this->dbTable ."
                    SET
                        name = :name, 
                        yearOfBirth = :yearOfBirth, 
                        created = :created";

            $stmt = $this->db->prepare($query);

            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":yearOfBirth", $this->yearOfBirth);
            $stmt->bindParam(":created", $this->created);

            if($stmt->execute()){
                return $this->db->lastInsertId();
            }
            return false;

        } catch(PDOException $exception){
            throw new DbException("Problem with creating user", 0, $exception);
        } catch (Error $e) {
            echo "Error caught: " . $e->getMessage();
        }
    }

    // READ single
    public function getSingleUser()
    {
        try {

            $query = "SELECT
                        *
                      FROM
                        ". $this->dbTable ."
                    WHERE 
                       userId = ?";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $this->userId);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $exception){
            throw new DbException("Problem with getting user data", 0, $exception);
        }
    }

    // UPDATE
    public function updateUser()
    {
        try {
            $query = "UPDATE
                        ". $this->dbTable ."
                    SET
                        name = :name, 
                        yearOfBirth = :yearOfBirth, 
                        updated = :updated
                    WHERE 
                        userId = :userId";

            $stmt = $this->db->prepare($query);

            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":yearOfBirth", $this->yearOfBirth);
            $stmt->bindParam(":updated", $this->updated);
            $stmt->bindParam(":userId", $this->userId);

            if($stmt->execute()){
                return true;
            }
            return false;
        } catch(PDOException $exception){
            throw new DbException("Problem with updating user data", 0, $exception);
        }

    }

    // DELETE
    function deleteUser()
    {
        try{
            $query = "DELETE FROM 
                    " . $this->dbTable . " 
                    WHERE userId = ?";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(1, $this->userId);

            if($stmt->execute()){
                return true;
            }
            return false;
        } catch(PDOException $exception){
            throw new DbException("Problem with deleting user data", 0, $exception);
        }
    }
}