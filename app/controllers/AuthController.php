<?php

require_once __DIR__ . '/../models/eav-users/UserModel.php';
require_once __DIR__ . '/../models/eav-users/AttributeUserModel.php';
require_once __DIR__ . '/../models/eav-users/ValuesUserModel.php';
require_once __DIR__ . '/../models/JWTModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/define.php';

class AuthController
{
  private $userModel, $attributeUserModel, $valuesUserModel, $jwtModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->attributeUserModel = new AttributeUserModel();
    $this->valuesUserModel = new ValuesUserModel();
    $this->jwtModel = new JWTModel();
  }

  public function loginPage()
  {
    ob_start();
    // set data-page for loading file js
    $data_page = 'login';

    require_once __DIR__ . '/../views/login/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
  public function signupPage()
  {
    ob_start();
    // set data-page for loading file js
    $data_page = 'signup';
    require_once __DIR__ . '/../views/signup/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $full_name = $_POST['full_name'] ?? null;
      $user_phone = $_POST['user_phone'] ?? null;
      $password = $_POST['password'] ?? null;
      $repeat_password = $_POST['repeat_password'] ?? null;

      $data = [
        'full_name' => $full_name,
        'user_phone' => $user_phone,
        'password' => $password,
        'repeat_password' => $repeat_password
      ];

      $result = $this->userModel->register($data);

      if (isset($result['status']) && $result['status'] === 200) {
        setcookie(
          'auth_token',
          $result['token'],
          time() + 36000,
          '/',
          '',
          true,
          true
        );

        header('Content-Type: application/json');
        echo json_encode([
          'success' => 201,
          'message' => 'Register successfully',
        ]);
      } else {
        header('Content-Type: application/json');
        echo json_encode([
          'success' => 409,
          'message' => 'Register failed',
          'errors' => $result,
        ]);
      }
    }
  }

  public function signin()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user_phone = $_POST['user_phone'];
      $password = $_POST['password'];

      $data = [
        'user_phone' => $user_phone,
        'password' => $password,
      ];

      $result = $this->userModel->signin($data);

      if (isset($result['status']) && $result['status'] === 200) {
        setcookie(
          'auth_token',
          $result['token'],
          time() + 36000,
          '/',
          '',
          true,
          true
        );

        header('Content-Type: application/json');
        echo json_encode([
          'status' => 201,
          'message' => 'Signin successfully',
        ]);
      } else {
        header('Content-Type: application/json');
        echo json_encode($result);
      }
    }
  }
  public function authWithGoogle()
  {
    $data = [];

    $client = new Google_Client();
    $client->setClientId(GOOGLE_APP_ID);
    $client->setClientSecret(GOOGLE_APP_SECRET);
    $client->setRedirectUri(GOOGLE_APP_CALLBACK_URL);
    $client->addScope("email");
    $client->addScope("profile");
    if (isset($_GET['code'])) {
      $code = $_GET['code'];
      $token = $client->fetchAccessTokenWithAuthCode($code);
      $client->setAccessToken($token);
      $google_oauth = new Google\Service\Oauth2($client);
      $google_account_info = $google_oauth->userinfo->get();

      $oauth_id = $google_account_info->id;
      $full_name =  $google_account_info->name;
      $user_email =  $google_account_info->email;
      $avatar = $google_account_info->picture;

      $data = [
        'oauth_id' => $oauth_id,
        'oauth_provider' => 'Google',
        'full_name' => $full_name,
        'user_email' => $user_email,
        'avatar' => $avatar
      ];
    } else {
      $authUrl = $client->createAuthUrl();
      header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
      exit();
    }
    $result = $this->userModel->authWithGoogle($data);
    if (isset($result['status']) && $result['status'] === 200 && isset($result['user_id'])) {
      setcookie(
        'auth_token',
        $result['token'],
        time() + 36000,
        '/',
        '',
        true,
        true
      );
      header('Location: /shopping');
      exit();
    } else {
      $_SESSION['tempo_user_info'] = $data;
      header('Location: ../complete-profile');
      exit();
    }
  }
  public function logout()
  {
    try {
      if (isset($_COOKIE['auth_token'])) {
        setcookie('auth_token', '', time() - 36000, '/', '', true, true);
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 201,
          'message' => 'You logged out, bye!'
        ]);
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
