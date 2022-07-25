<?php

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ViewRenderer
{
    private $basePath;
    private CsrfTokenManagerInterface $csrfTokenManager;

    public function __construct($basePath, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->basePath = $basePath;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function render(ModelAndView $modelAndView)
    {
        extract($modelAndView->getModel());
        $view = $modelAndView->getViewName();
        $_csrf = $this->generateCsrfInput();
        ob_clean();
        require_once $this->basePath."/templates/layout.php";
        return ob_get_clean();
    }

    private function generateCsrfInput()
    {
        $csrfToken = $this->csrfTokenManager->getToken("_csrf")->getValue();
        return "<input type='hidden' name='_csrf' value='${csrfToken}'/>";
    }

}