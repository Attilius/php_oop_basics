<?php

class ViewRenderer
{
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function render(ModelAndView $modelAndView){
        extract($modelAndView->getModel());
        $view = $modelAndView->getViewName();
        ob_clean();
        require_once $this->basePath."/templates/layout.php";
        return ob_get_clean();
    }
}