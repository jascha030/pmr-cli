<?php

namespace Jascha030\PM\Project;

use Jascha030\PM\Project\Category\ResourceCategory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface ProjectResourceInterface
{
    public function getCategory(): ResourceCategory;

    public function getName(): string;

    public function getValue(): string;

    public static function getType(): string;

    public function callResource(InputInterface $input, OutputInterface $output): int;
}
