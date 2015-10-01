<?php

namespace thebuggenie\modules\bootgenie;

use thebuggenie\core\framework;

/**
 * actions for the bootgenie module
 */
class Components extends framework\ActionComponent
{

    private function copyVars($from)
    {
        foreach(get_object_vars($from) as $name => $value) {
            $this->$name = $value;
        }
    }

    // $actionToRunName = 'component' . ucfirst($module_file['file']);
    public function componentMain_login()
    {
        $actionClass = new \thebuggenie\core\modules\main\Components();
        $actionClass->componentLogin();

        $this->copyVars($actionClass);
    }

    public function componentMain_openidbuttons()
    {
        $actionClass = new \thebuggenie\core\modules\main\Components();
        $actionClass->componentOpenidButtons();

        $this->copyVars($actionClass);
    }
}
