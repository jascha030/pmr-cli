<?php

namespace Jascha030\PM\Project;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class UrlResource extends ProjectResourceAbstract
{
    public const MAC   = 0;
    public const LINUX = 1;

    public const SUPPORTED_OS_UNAMES = [
        self::MAC   => 'Darwin',
        self::LINUX => 'Linux',
    ];

    private const OS_OPEN_COMMANDS = [
        self::MAC   => 'open',
        self::LINUX => 'xdg-open',
    ];

    public function callResource(InputInterface $input, OutputInterface $output): int
    {
        if (empty($this->getValue())) {
            $output->writeln("Invalid url supplied for: {$this->getName()}.");

            return Command::FAILURE;
        }

        if (! $this->supportsOS()) {
            $output->writeln('This command currently does not seem to support your system.');

            return Command::FAILURE;
        }

        $openCommand = $this->getOpenCommand();

        return Process::fromShellCommandline("{$openCommand} {$this->getValue()}")->run();
    }

    final public function getOpenCommand(): string
    {
        return self::OS_OPEN_COMMANDS[array_flip(self::SUPPORTED_OS_UNAMES)[PHP_OS]];
    }

    private function supportsOS(): bool
    {
        return isset(array_flip(self::SUPPORTED_OS_UNAMES)[PHP_OS]);
    }
}
