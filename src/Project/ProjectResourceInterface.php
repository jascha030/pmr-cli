<?php

namespace Jascha030\PM\Project;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface ProjectResourceInterface
{
    public function getName(): string;

    public function getValue(): string;

    public function callResource(InputInterface $input, OutputInterface $output): int;
}
