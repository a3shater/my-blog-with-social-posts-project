<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

require_once('core/database.php');

$db_server = "localhost";
$db_user = "root";
$db_user_pass = "";
$db_name = "social_app";
$connection = db_connect($db_server, $db_user, $db_user_pass, $db_name);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Function to authenticate user
function log_in($username, $password)
{
    global $connection;
    $checkUsername = array(
        "column" => "username",
        "operator" => "=",
        "value" => $username
    );
    $checkPassword = array(
        "column" => "password",
        "operator" => "=",
        "value" => $password
    );
    $where = array();
    $where[] = $checkPassword;
    $where[] = $checkUsername;
    $users = db_select($connection, "users", "*", $where);
    // Check if user exists and password matches
    if ($users) {
        $_SESSION['isSignedIn'] = true;
        return true;
    }
    return false; // Authentication failed
}

// Function to check if user is logged in
function is_login()
{
    return isset($_SESSION['isSignedIn']);
}

// Function to log out user
function log_out()
{
    session_unset();
    session_destroy();
}


function render_admin_post()
{
    global $connection;
    $posts = db_select($connection, "posts", "*", "", "DESC");
    $result = '';
    foreach ($posts as $keys => $values) {
        $dlt_action = "/social_app/delete_post";
        $recovery = $values['check_exit'] ? "<a href='/social_app/recovery_post/?id=" . $values['id'] . "'>
        <button style='background-color:var(--c3)' type='button' class='btn btn-primary' >استعادة
        </button>
        </a>" : "";
        $disabled = $values['check_exit'] ? "disabled" : "";
        $opacity = $values['check_exit'] ? "0.7" : "1";
        $file = $values['file_path'];
        $content = $values['content'];
        $ago = Carbon::now("Asia/Riyadh")->diffForHumans($values['created_at']);
        $result .= " 
        <!-- Modal-2 -->
        <div class='modal fade' id='staticBackdrop-" . $values['id'] . "' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='staticBackdropLabel'>حذف المنشور</h1>
                        <button type='button' class='btn-close m-0' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        هل تريد حذف المنشور؟
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>ألغاء</button>
                        <button  class='btn btn-danger' type='submit' form='delete_form" . $values['id'] . "'>حذف</button>
                    </div>
                </div>
            </div>
        </div>   
        <div class='card mb-3' >
            <div class='row g-0' >
                <div class='col-md-4' style='opacity:$opacity;'>
                    <img src='$file' class='img-fluid rounded-end h-100' alt='...'>
                </div>
                <div class='col-md-8'>
                    
                    <div class='card-body h-100'>
                    <div class='d-flex h-100 flex-column justify-content-between'>
                    <p class='card-text' style='opacity:$opacity;'>$content
                    </p>
                   
                    <div>
                    <div class='d-flex justify-content-between'>
                    <p class='card-text' dir='ltr'><small class='text-body-secondary'>$ago</small></p>
                    <div class='text-start'>
                        <form action='$dlt_action' id='delete_form" . $values['id'] . "'>
                        <input type='text' value='" . $values['id'] . "' name='id' style='display:none;'>
                        <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#staticBackdrop-" . $values['id'] . "' $disabled>حذف
</button>
$recovery
                        </form>
                    </div> </div></div></div>
                    </div>
                </div>
            </div>
        </div>";
    }
    return $result;
}
function render_recent_post()
{
    global $connection;
    $posts = db_select($connection, "posts", "*", "", "DESC");
    $counter = 3;
    $i = 0;
    $result = '';
    foreach ($posts as $keys => $values) {
        if (!$values['check_exit']) {
            if ($i < $counter) {
                $file = $values['file_path'];
                $content = $values['content'];
                $ago = Carbon::now("Asia/Riyadh")->diffForHumans($values['created_at']);
                $result .= " <div class='col-lg-4 my-3'>
                <div class='card h-100'>
                    <img src='$file' class='card-img-top h-100' alt='...'>
                    <div class='card-body d-flex flex-column justify-content-between'>
                        <p class='card-text'>$content</p>
                        <p class='card-text' dir='ltr'><small>$ago</small></p>
                    </div>
                </div>
            </div>";
            } else {
                break;
            }
            $i++;
        }
    }
    return $result;
}
function render_main_post($sort_as)
{
    global $connection;
    // DESC, ASC
    if ($sort_as == "") {
        $sort_as = "DESC";
    }
    $posts = db_select($connection, "posts", "*", "", $sort_as);
    $result = "";

    foreach ($posts as $keys => $values) {
        if (!$values['check_exit']) {
            $file = $values['file_path'];
            $content = $values['content'];
            $ago = Carbon::now("Asia/Riyadh")->diffForHumans($values['created_at']);
            $result .= "<div class='card mb-3' style='max-width: 700px;'>
                            <div class='row g-0'>
                                <div class='col-md-4' >
                                    <img src='$file' class='img-fluid rounded-end h-100' alt='...' >
                    </div>
                    <div class=' col-md-8'>
                                    <div class='card-body d-flex flex-column h-100 justify-content-between'>
                                        <p class='card-text'>$content</p>
                                        <p class='card-text' dir='ltr'><small class='text-body-secondary'>$ago</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>";
        }
    }
    return $result;
    // print_r($posts);
}
function render_search_post($search_value)
{
    global $connection;
    $posts = db_select($connection, "posts");
    $result = "";
    foreach ($posts as $keys => $values) {

        if (!$values['check_exit']) {
            if (str_contains($values['content'], $search_value)) {
                $file = $values['file_path'];
                $content = str_replace($search_value, "<mark>" . $search_value . "</mark>", $values['content']);
                $ago = Carbon::now("Asia/Riyadh")->diffForHumans($values['created_at']);
                $result .= "<div class='card mb-3' style='max-width: 700px;'>
                                <div class='row g-0'>
                                    <div class='col-md-4'>
                                        <img src='$file' class='img-fluid rounded-end h-100' alt='...'>
                        </div>
                        <div class=' col-md-8'>
                                        <div class='card-body d-flex flex-column h-100 justify-content-between'>
                                            <p class='card-text'>$content</p>
                                            <p class='card-text' dir='ltr'><small class='text-body-secondary'>$ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>";
            }
        }
    }
    return $result;
}
function create_post($content, $file, $fileExits = false)
{
    global $connection;
    $filePath = '';
    if (!$fileExits) {
        $filename = $file['name'];
        $destination = 'assets/images/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $filePath = $destination;
        }

        $data = array(
            "content" => $content,
            "file_path" => $filePath
        );
    } else {
        $data = array(
            "content" => $content
        );
    }
    $user = db_insert($connection, "posts", $data);
    return $filePath;
}

function update_post($id)
{
    global $connection;
    $checkUsername = array(
        "column" => "id",
        "operator" => "=",
        "value" => $id
    );
    $data = array(
        "check_exit" => true
    );
    $where = array();
    $where[] = $checkUsername;
    $user = db_update($connection, "posts", $data, $where);
}
function recovery_post($id)
{
    global $connection;
    $checkUsername = array(
        "column" => "id",
        "operator" => "=",
        "value" => $id
    );
    $data = array(
        "check_exit" => false
    );
    $where = array();
    $where[] = $checkUsername;
    $user = db_update($connection, "posts", $data, $where);
}
