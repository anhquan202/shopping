<?php
require_once __DIR__ . '/../models/eav-users/UserModel.php';
require_once __DIR__ . '/../models/eav-users/AttributeUserModel.php';
require_once __DIR__ . '/../models/eav-users/ValuesUserModel.php';
class AuthController
{
  private $userModel, $attributeUserModel, $valuesUserModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->attributeUserModel = new AttributeUserModel();
    $this->valuesUserModel = new ValuesUserModel();
  }

  public function loginPage()
  {
    ob_start();
    require_once __DIR__ . '/../views/login/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
  public function signupPage()
  {
    ob_start();
    require_once __DIR__ . '/../views/signup/index.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layout/index.php';
  }
}
