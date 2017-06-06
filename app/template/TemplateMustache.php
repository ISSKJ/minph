<?php

use Minph\View\Template;


class TemplateMustache implements Template
{
    private $engine;

    public function __construct()
    {
        $this->engine = new Mustache_Engine(array(
            //'template_class_prefix' => '__MyTemplates_',
            'cache' => APP_DIR .'/storage/template',
            //'cache_file_mode' => 0666, // Please, configure your umask instead of doing this :)
            'cache_lambda_templates' => true,
            'loader' => new Mustache_Loader_FilesystemLoader(APP_DIR .'/view'),
            //'partials_loader' => new Mustache_Loader_FilesystemLoader(APP_DIR .'/view/partials'),
            'helpers' => array('i18n' => function($text) {
                // do something translatey here...
            }),
            'escape' => function($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
            },
            'charset' => 'ISO-8859-1',
            'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
            'strict_callables' => true,
            'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
        ));
    }

    public function view($file, $model)
    {
        echo $this->engine->render($file, $model);
    }
}
