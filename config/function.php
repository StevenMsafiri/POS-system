<?php

session_start();

include ('dbcon.php');

// Input field validation
function validate($inputData)
{
    global $conn;
    return trim(mysqli_real_escape_string($conn, $inputData));
}

// Redirects from one page to another with status
function redirect($url, $status)
{
    $_SESSION['status'] = $status;
    header('Location: ' . $url);
    exit(0);
}

// Displays status message
function alertMessage()
{
    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h6>'. $_SESSION['status'] .'</h6>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['status']);
    }
}

// Inserts data
function insert($tableName, $data)
{
    global $conn;
    $table = validate($tableName);
    
    $columns = array_keys($data);
    $values = array_map(fn($value) => "'" . mysqli_real_escape_string($conn, $value) . "'", array_values($data));

    $finalColumn = implode(',', $columns);
    $finalValues = implode(',', $values);

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    return mysqli_query($conn, $query);
}

// Updates data
function update($tableName, $id, $data)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";
    foreach ($data as $column => $value) {
        $updateDataString .= "$column = '" . mysqli_real_escape_string($conn, $value) . "', ";
    }

    $updateDataString = rtrim($updateDataString, ", "); // Remove trailing comma

    $query = "UPDATE $table SET $updateDataString WHERE id = '$id'";
    return mysqli_query($conn, $query);
}

// Gets all data
function getAll($tableName, $status = NULL)
{
    global $conn;
    $table = validate($tableName);

    $query = $status == 'status' ? "SELECT * FROM $table WHERE status = '0'" : "SELECT * FROM $table";

    return mysqli_query($conn, $query);
}

// Gets a single record
function getById($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            return [
                'status' => 200,
                'data' => mysqli_fetch_assoc($result),
                'message' => 'Record found'
            ];
        } else {
            return [
                'status' => 404,
                'message' => 'No Data Found'
            ];
        }
    } else {
        return [
            'status' => 500,
            'message' => 'Something Went Wrong'
        ];
    }
}

// Deletes a record
function delete($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id = '$id' LIMIT 1";
    $result =  mysqli_query($conn, $query);

    return $result;
}

function checkParamId($type)
{
    if(isset($_GET[$type]))
    {
        if(isset($_GET[$type])!= '')
        {
            return $_GET[$type];
        }
        else
        {
            return '<h5>No Id Found</h5>';
        }
    }
    else
    {
        return '<h5>No Id Given</h5>';
    }
}

function logoutSession()
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);

}

function jsonResponses($status, $status_type, $message)
{
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message
    ];
    echo json_encode($response);
    return $response;
}