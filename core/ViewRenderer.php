<?php

use Laminas\I18n\Translator\Translator;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ViewRenderer
{
    private string $basePath;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private Translator $translator;

    public function __construct(string $basePath, CsrfTokenManagerInterface $csrfTokenManager, Translator $translator)
    {
        $this->basePath = $basePath;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->translator = $translator;
    }

    /**
     * @param ModelAndView $modelAndView
     * @param string $locale
     * @return false|string
     */
    public function render(ModelAndView $modelAndView, string $locale): false|string
    {
        extract($modelAndView->getModel());
        $view = $modelAndView->getViewName();
        $trans = function ($key) use($locale) {
            return $this->translator->translate($key, "messages", $locale);
        };
        $_csrf = $this->generateCsrfInput();
        ob_clean();
        require_once $this->basePath."/templates/layout.php";
        return ob_get_clean();
    }

    /**
     * @return string
     */
    private function generateCsrfInput(): string
    {
        $csrfToken = $this->csrfTokenManager->getToken("_csrf")->getValue();
        return "<input type='hidden' name='_csrf' value='${csrfToken}'/>";
    }
}