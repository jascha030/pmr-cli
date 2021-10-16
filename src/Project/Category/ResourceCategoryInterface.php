<?php

namespace Jascha030\PM\Project\Category;

use Jascha030\PM\Project\ProjectResourceInterface;

interface ResourceCategoryInterface
{
    public function getName(): string;

    public function getKey(): string;

    public function getOptions(): array;

    public function set(ProjectResourceInterface $resource): void;

    public function get(): ProjectResourceInterface;
}
