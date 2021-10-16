<?php

namespace Jascha030\PM\Project\Category;

use Jascha030\PM\Project\ProjectResourceInterface;

class ResourceCategory extends ResourceCategoryAbstract
{
    private ProjectResourceInterface $resource;

    private string $name;

    private string $key;

    private array $options;

    public function __construct(string $name, string $key, array $options)
    {
        $this->name    = $name;
        $this->key     = $key;
        $this->options = $options;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
