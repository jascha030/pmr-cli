<?php

namespace Jascha030\PM\Project;


use Jascha030\PM\Project\Category\ResourceCategory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ProjectResourceAbstract implements ProjectResourceInterface
{
    private ResourceCategory $category;

    private string $name;

    private string $value;

    public function __construct(ResourceCategory $category, string $name, string $value)
    {
        $this->category = $category;
        $this->name     = $name;
        $this->value    = $value;
    }

    public function getCategory(): ResourceCategory
    {
        return $this->category;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    abstract public static function getType(): string;

    abstract public function callResource(InputInterface $input, OutputInterface $output): int;
}
