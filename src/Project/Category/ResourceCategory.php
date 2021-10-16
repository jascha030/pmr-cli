<?php

namespace Jascha030\PM\Project\Category;

class ResourceCategory implements ResourceCategoryInterface
{
    private string $key;

    private string $name;

    private array $options;

    private string $type;

    public function __construct(string $key, string $name, array $options, string $type)
    {
        $this->key     = $key;
        $this->name    = $name;
        $this->options = $options;
        $this->type    = $type;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
