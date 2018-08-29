<?php

namespace Shadow\Console;

class Genarators
{
  public static $instance;
  public function __construct() {
    self::$instance = $this;
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function generateController($controllerName)
  {
    if (file_exists(getcwd(). '/application/Http/Controllers/'.$controllerName.'.php')) {    
      return [
      'status' => false,
      'message' => ucfirst($controllerName).' Controller Build Not Successful, Controller Already Exist'
      ];
    }
    $templatefile = getcwd(). '/vendor/codexen/shadow-core/src/Console/templates/ControllerTemplate.php';
    if(file_exists($templatefile)){
      if( strpos(file_get_contents($templatefile),'controllername') !== false) {
        $controllerFolders = explode('/', $controllerName);
        $controllerFileName = end($controllerFolders);
        array_pop($controllerFolders);
        $foldersString = implode('/', $controllerFolders);

        $namespace = trim('App\Controllers\\' . str_replace('/', '\\', $foldersString), '\\');

        $template = file_get_contents($templatefile);
        $template = str_replace('controllername', $controllerFileName, $template);
        $template = str_replace('controller_namespace', $namespace, $template);

        //Create new folders
        if (!is_dir(getcwd().'/application/Http/Controllers/'. $foldersString)) {
          mkdir(getcwd().'/application/Http/Controllers/'. $foldersString, 0777, true);
        }

        $controllerfile = getcwd(). '/application/Http/Controllers/'.$controllerName.'.php';

        $newfile = fopen($controllerfile, 'w');
        file_put_contents($controllerfile,$template);

        return [
          'status' => true,
          'message' => ucfirst($controllerName).' Controller Generated Successfully'
        ];
      } else {
        return [
          'status' => false,
          'message' => 'Controller Template File Not Found'
        ];
      }
    }
  }

  public function generateModel($modelname)
  {
    if (file_exists(getcwd(). '/application/Models/'.$modelname.'Model.php')) {
      return [
      'status' => false,
      'message' => ucfirst($modelname).' Model Build Not Successful, Model Already Exist'
      ];
    }
    $templatefile = getcwd(). '/vendor/codexen/shadow-core/src/Console/templates/ModelTemplate.php';
    if(file_exists($templatefile)){
      if( strpos(file_get_contents($templatefile),'modelname') !== false) {
        $modelFolders = explode('/', $modelname);
        $modelFileName = end($modelFolders);
        array_pop($modelFolders);
        $foldersString = implode('/', $modelFolders);
        $namespace = trim('App\Models\\' . str_replace('/', '\\', $foldersString), '\\');

        $template = file_get_contents($templatefile);
        $template = str_replace('modelname', $modelFileName, $template);
        $template = str_replace('model_namespace', $namespace, $template);

        //Create new folders
        if (!is_dir(getcwd().'/application/Models/'. $foldersString)) {
          mkdir(getcwd().'/application/Models/'. $foldersString, 0777, true);
        }

        $modelfile = getcwd(). '/application/Models/'.$modelname.'.php';
        $newfile = fopen($modelfile, 'w');
        file_put_contents($modelfile,$template);
        return [
          'status' => true,
          'message' => ucfirst($modelname).' Model Generated Successfully'
        ];
      } else {
        return [
        'status' => false,
        'message' => 'Model Template File Not Found'
        ];
      }
    }
  }
}