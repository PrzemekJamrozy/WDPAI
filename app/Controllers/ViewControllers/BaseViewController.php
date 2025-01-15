<?php

namespace Controllers\ViewControllers;

abstract class BaseViewController
{
    const BASE_VIEW_DIR = __DIR__ . "/../../../views";

    protected function render(string $template, array $variables = [])
    {
        $templatePath = self::BASE_VIEW_DIR . "/" . $template . ".php";
        if(file_exists($templatePath)){
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
            print $output;
        }
        else{
            die("Couldn't find template $templatePath");
        }
    }

}