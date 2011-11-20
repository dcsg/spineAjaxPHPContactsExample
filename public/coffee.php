<?php

/*
 * mysql function for CRUD operations
 */
function getAllCompanies()
{
    mysql_connect('localhost', 'root', '');
    mysql_select_db('jstest');

    $SQL = "SELECT id, name, email FROM contacts";
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    $resultArray = array();
    while($item = mysql_fetch_assoc($result))
    {
        array_push($resultArray, $item);
    }
    echo json_encode($resultArray);
}

function getCompany($id)
{
    mysql_connect('localhost', 'root', '');
    mysql_select_db('jstest');

    $SQL = "SELECT id, name, email FROM contacts WHERE id = " + $id;
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    $resultArray = array();
    while($item = mysql_fetch_assoc($result))
    {
        array_push($resultArray, $item);
    }
    echo json_encode($resultArray);
}

function updateCompany($data)
{
    mysql_connect('localhost', 'root', '');
    mysql_select_db('jstest');

    $SQL = "UPDATE contacts SET name = '" . $data['name'] . "', email ='" . $data['email'] . "' WHERE id ='" .  $data['id'] ."'";
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    return ;
}

function createCompany($data)
{
    mysql_connect('localhost', 'root', '');
    mysql_select_db('jstest');

    $SQL = "INSERT INTO contacts (id) VALUES ('" . $data['id'] . "')";
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    return ;
}

function deleteCompany($id)
{
    mysql_connect('localhost', 'root', '');
    mysql_select_db('jstest');

    $SQL = "DELETE FROM contacts WHERE id ='" .  $id ."'";
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());

    return ;
}

/*
 * Retrieve Data functions
 */
function getJSONData()
{
    $json = file_get_contents('php://input');
    $_data = (string)$json;
    $data = json_decode($_data);
    return get_object_vars($data);

}

function getId()
{
    $url = explode("/", $_SERVER["REQUEST_URI"]);
    return $url[3];
}

switch ($_SERVER["REQUEST_METHOD"])
{
    case "GET":
        $id = getId();
        ($id > 0) ? getCompany($id) : getAllCompanies();
        break;
    case "POST":
        $data = getJSONData();
        createCompany($data);
        break;
    case "PUT":
        $data = getJSONData();
        updateCompany($data);
        break;
    case "DELETE":
        $id = getId();
        deleteCompany($id);
        break;
    default:
        getAllCompanies();
        break;
}

?>
