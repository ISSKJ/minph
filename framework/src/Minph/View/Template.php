<?php

namespace Minph\View;

/**
 * @interface Minph\View\Template
 */
interface Template
{
    /**
     * @method view
     * @param string `$file` template file path in `$appDirectory/view/`.
     * @param model (default = null)
     *
     * It outputs view resource.
     */
    public function view($file, $model = null);
}
