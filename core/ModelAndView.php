<?php

final class ModelAndView
{
    private string $viewName;
    private array $model;

    public function __construct(string $viewName, array $model = [])
    {
        $this->viewName = $viewName;
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getViewName(): string
    {
        return $this->viewName;
    }

    /**
     * @return array
     */
    public function getModel(): array
    {
        return $this->model;
    }
}