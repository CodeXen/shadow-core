<?php

namespace Shadow\View;

use Shadow\View\View;

class Raze extends View {

    public $vars = array();
    public $page;
    public $view;
    public $bDisplay = true;
    private $views_dir = '../application/Views/';

    function __construct($view = false) {
        $this->view = $view;
    }

    public function template($render = false, $data = array(), $layout = false) {
        if ($this->bDisplay === true) {
            $page = $this->views_dir . $render . '.raze.php';
            $this->vars = $data;

            if(file_exists($page)) {
                $content = file_get_contents($page);
                $content = $this->replace($content, $this->vars);
                
                $content = preg_replace('~\{LOOP:(\w+)\}~', '<?php foreach ($raze->vars[\'$1\'] as $value){ echo  $raze->replace(\'', $content);
                $content = preg_replace('~\{ENDLOOP:(\w+)\}~', '\', $value);} ?>', $content);

                $content = preg_replace('~\{IF:([^\r\n}]+)\}~', '<?php if ($1): echo \'', $content);
                $content = preg_replace('~\{ELSE\}~', '\'; else: echo \'', $content);
                $content = preg_replace('~\{ENDIF\}~', '\'; endif; ?>', $content);
                
                // Layouts
                $content = preg_replace('~\{LAYOUT:(.*)\}~', '<?php self::setLayout($1); ?>', $content);
                $content = preg_replace('~\{SECTION:(.*)\}~', '<?= self::content($1); ?>', $content);
                $content = preg_replace('~\{START:(.*)\}~', '<?php self::start($1); ?>', $content);
                $content = preg_replace('~\{END\}~', '<?php self::end(); ?>', $content);
                
                if ($render)
                    eval(' ?>' . $content . '<?php ');
                else
                    return $content;
            }
        }
        else {
            return false;
        }
    }


    public function replace($content, $vars) {
        foreach ($vars as $key => $value) {
            if (!is_array($vars[$key])) {
                $tag = '{' . $key . '}';
                $content = str_replace($tag, $value, $content);
            }
        }

        return $content;
    }

    public function assign($key, $value, $overwrite = false) {
        if ($overwrite) {
            $this->vars[$key] = $value;
        } else if (isset($this->vars[$key])) {
            echo 'this var already exists!';
        } else {
            $this->vars[$key] = $value;
        }
    }

    public function append($key, $value) {
        $this->vars[$key] .= $value;
    }

    public function addArray($array, $key, $value) {
        $this->vars[$array][][$key] = $value;
    }

    public function setPage($page) {
        $this->page = $page;
    }

}