<?php

class Contacts
{
    private $db         = "jstest";
    private $localhost  = "localhost";
    private $username   = "root";
    private $password   = "";

    function __construct()
    {
        switch ($_SERVER["REQUEST_METHOD"])
        {
            case "GET":
                $id = $this->getId();
                ($id > 0) ? $this->getCompany($id) : $this->getAllCompanies();
                break;
            case "POST":
                $data = $this->getJSONData();
                $this->createCompany($data);
                break;
            case "PUT":
                $data = $this->getJSONData();
                $this->updateCompany($data);
                break;
            case "DELETE":
                $id = $this->getId();
                $this->deleteCompany($id);
                break;
            default:
                $this->getAllCompanies();
                break;
        }
    }
    
    /*
     * mysql function for CRUD operations
     */
    private function getAllCompanies()
    {
        mysql_connect($this->localhost, $this->username, $this->password);
        mysql_select_db($this->db);

        $SQL = "SELECT id, name, email FROM contacts";
        $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

        $resultArray = array();
        while($item = mysql_fetch_assoc($result))
        {
            array_push($resultArray, $item);
        }
        echo json_encode($resultArray);
        return ;
    }

    private function getCompany($id)
    {
        mysql_connect($this->localhost, $this->username, $this->password);
        mysql_select_db($this->db);

        $SQL = "SELECT id, name, email FROM contacts WHERE id = " + $id;
        $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

        $resultArray = array();
        while($item = mysql_fetch_assoc($result))
        {
            array_push($resultArray, $item);
        }
        echo json_encode($resultArray);
        return ;
    }

    private function updateCompany($data)
    {
        mysql_connect($this->localhost, $this->username, $this->password);
        mysql_select_db($this->db);

        $SQL = "UPDATE contacts SET name = '" . $data['name'] . "', email ='" . $data['email'] . "' WHERE id ='" .  $data['id'] ."'";
        $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

        return ;
    }

    private function createCompany($data)
    {
        mysql_connect($this->localhost, $this->username, $this->password);
        mysql_select_db($this->db);

        $SQL = "INSERT INTO contacts (id, name, email) VALUES ('" . $data['id'] . "','" . $data['name'] . "','" . $data['email'] . "')";
        $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

        return ;
    }

    private function deleteCompany($id)
    {
        mysql_connect($this->localhost, $this->username, $this->password);
        mysql_select_db($this->db);

        $SQL = "DELETE FROM contacts WHERE id ='" .  $id ."'";
        $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

        return ;
    }

    /*
     * Retrieve Data functions
     */
    private function getJSONData()
    {
        $json = file_get_contents('php://input');
        $_data = (string)$json;
        $data = json_decode($_data);
        return get_object_vars($data);

    }

    private function getId()
    {
        $url = explode("/", $_SERVER["REQUEST_URI"]);
        return $url[3];
    }
}

$contact = new Contacts();
?>
