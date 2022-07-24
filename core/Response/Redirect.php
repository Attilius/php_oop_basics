<?php

namespace Response;

class Redirect
{
    private string $target;
    private array $flashMessages = [];

    public function __construct(string $target)
    {
        $this->target = $target;
    }

    public static function to($target)
    {
        return new self($target);
    }

    public function with($name, $value)
    {
        $this->flashMessages[$name] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return array
     */
    public function getFlashMessages(): array
    {
        return $this->flashMessages;
    }
}