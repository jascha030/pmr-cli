<?php

namespace Jascha030\PM\Project;

interface ResourceCategoryInterface
{
    public function getName(): string;

    public function getOptions(): array;

    public function set(ProjectResourceInterface $resource): void;

    public function get(): ProjectResourceInterface;
}
