<?php
class Controller
{
  public static function view($view, $data = [])
  {
    $viewPath = __DIR__ . '/../views/' . $view . '.php';
    if (file_exists($viewPath)) {
      extract($data);
      require_once $viewPath;
    } else {
      die('View not exist');
    }
  }
  public static function model($model)
  {
    $modelPath = __DIR__ . '/../views/' . $model . '.php';
    if (file_exists($modelPath)) {
      require_once $modelPath;
      return new $model;
    }
    return null;
  }
}
