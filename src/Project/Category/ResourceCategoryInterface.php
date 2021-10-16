<?php

namespace Jascha030\PM\Project\Category;

interface ResourceCategoryInterface
{
    public function getKey(): string;

    public function getName(): string;

    public function getOptions(): array;

    public function getType(): string;
}
