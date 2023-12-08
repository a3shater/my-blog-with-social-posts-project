<?php
require_once('app/app.php');
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

define('ROOT_PATH', '/social_app');
$pageName = $_SERVER['REQUEST_URI'];
$pageName = str_replace(ROOT_PATH, "", $pageName);

if ($pageName == "/") {
    $pageName = "home";
} elseif ($pageName == "/login") {
    if (is_login()) {
        header("Location:" . ROOT_PATH . "/home");
    } else {
        if ($_POST) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if (log_in($username, $password)) {
                $_SESSION['login_message'] = "";
                header("Location:" . ROOT_PATH . "/home");
            } else {
                $_SESSION['login_message'] = "اسم المستخدم او كلمة السر غير صحيحة";
            }
        } else {
            $_SESSION['login_message'] = "";
        }
    }
} elseif ($pageName == '/logout') {
    log_out();
    header("Location:" . ROOT_PATH . "/home");
} elseif ($pageName == '/admin') {
    if (!is_login()) {
        header("Location:" . ROOT_PATH . "/login");
    }
} elseif (str_starts_with($pageName, "/post")) {
    if (isset($_GET['sort_as'])) {
        $_SESSION['sort_as'] = $_GET['sort_as'] ?? "";
        header("Location:" . ROOT_PATH . "/post");
    }
    $_SESSION['search'] = $_POST['search'] ?? "";
} elseif (str_starts_with($pageName, '/delete_post')) {
    if (isset($_GET['id'])) {
        update_post($_GET['id']);
        header("location:" . ROOT_PATH . "/admin");
    }
} elseif (str_starts_with($pageName, '/recovery_post')) {
    if (isset($_GET['id'])) {
        recovery_post($_GET['id']);
        header("location:" . ROOT_PATH . "/admin");
    }
} elseif ($pageName == "/create_post") {

    $filePath = "assets/images/default.jpg";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && isset($_POST['content'])) {
        $filePath = create_post($_POST['content'], $_FILES['image']);
    } elseif (isset($_POST['content'])) {
        create_post($_POST['content'], "", true);
    }

    if (isset($_POST)) {

        $client = new Client();

        if (isset($_POST['instagram'])) {
            if ($_POST['instagram'] == 'on') {

                $baseUrl = 'https://graph.facebook.com/v18.0/{Your-Id}/media';
                $accessToken = '{Your-Token}';

                $headers = [
                    'Authorization' => 'Bearer ' . $accessToken,
                ];


                try {
                    $response = $client->request('POST', $baseUrl, [
                        'headers' => $headers,
                        'query' =>  [
                            'caption' => $_POST['content'] ?? "",
                            'image_url' => "{Your-Image}"
                        ],
                    ]);
                    $baseUrl = 'https://graph.facebook.com/v18.0/{Your-Id}/media_publish';
                    $queryParams = [
                        'creation_id' => json_decode($response->getBody(), true)['id'],
                    ];
                    $response2 = $client->request('POST', $baseUrl, [
                        'headers' => $headers,
                        'query' => $queryParams,
                    ]);
                } catch (Exception $e) {
                    echo 'Error: ' . $e;
                }
            }
        }


        if (isset($_POST['facebook'])) {
            if (($_POST['facebook'] == 'on')) {
                $url = 'https://graph.facebook.com/v18.0/{Your-Id}/photos';

                $accessToken = '{Your-Token}';
                $headers = [
                    'Authorization' => 'Bearer ' . $accessToken,
                ];

                try {
                    $response = $client->request('POST', $url, [
                        'headers' => $headers,
                        'multipart' => [
                            [
                                'name' => 'message',
                                'contents' => $_POST['content'] ?? "",
                            ],
                            [
                                'name' => 'published',
                                'contents' => 'true',
                            ],
                            [
                                'name' => 'source',
                                'contents' => "{Your-Image}",
                            ],
                        ],
                    ]);

                    // Process the response
                    echo $response->getBody();
                } catch (Exception $e) {
                    // Handle any exceptions
                    echo 'Error: ' . $e->getMessage();
                }
            }
        }
    }

    header("location:" . ROOT_PATH . "/admin");
}

$filePath = 'pages/' . $pageName . '.php';
if (file_exists($filePath)) {
    require_once('layout/header.php');
    require_once($filePath);
    require_once('layout/footer.php');
}
