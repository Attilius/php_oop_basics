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

    /**
     * @param $target
     * @return Redirect
     */
    public static function to($target): Redirect
    {
        return new self($target);
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
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