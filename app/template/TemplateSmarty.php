<?php

use Minph\View\Template;


class TemplateSmarty implements Template
{
    private $engine;

    public function __construct()
    {
        $this->engine = new Smarty();
        $this->engine->setTemplateDir(APP_DIR . '/view');
        $this->engine->setCompileDir(APP_DIR . '/storage/template/smarty/templates_c');
        $this->engine->setCacheDir(APP_DIR . '/storage/template/smarty/cache');
        $this->engine->error_reporting = 0;
        if (getenv('DEBUG') === 'true') {
            $this->engine->debugging = true;
        }
    }

    public function view($file, $model = null)
    {
        if (!empty($model)) {
            $this->engine->assign($model);
        }
        $this->engine->display($file);
    }
}
