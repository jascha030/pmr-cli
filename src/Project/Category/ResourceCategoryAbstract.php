<?php

namespace Jascha030\PM\Project\Category;

use Jascha030\PM\Project\ProjectResourceInterface;

abstract class ResourceCategoryAbstract implements ResourceCategoryInterface
{
    private ProjectResourceInterface $resource;

    abstract public function getName(): string;

    abstract public function getKey(): string;

    abstract public function getOptions(): array;

    public function set(ProjectResourceInterface $resource): void
    {
        $this->resource = $resource;
    }

    public function get(): ProjectResourceInterface
    {
        return $this->resource;
    }
}
