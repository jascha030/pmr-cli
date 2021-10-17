<?php

namespace Jascha030\PM\Project\Category;

class ResourceCategory implements ResourceCategoryInterface
{
    private string $key;

    private string $name;

    private array $options;

    private string $type;

    public function __construct(string $key, string $name, string $type, array $options = [])
    {
        $this->key     = $key;
        $this->name    = $name;
        $this->type    = $type;
        $this->options = $options;
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
