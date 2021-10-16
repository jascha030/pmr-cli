<?php

namespace Jascha030\PM\Project;

abstract class ProjectResourceAbstract implements ProjectResourceInterface
{
    private string $name;

    private string $value;

    public function __construct(string $name)
    {
        $this->name  = $name;
        $this->value = '';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
