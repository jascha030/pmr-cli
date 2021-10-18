<?php

namespace Jascha030\PM\Console\Command;

use Jascha030\PM\Service\ResourceService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class OpenCommand extends Command
{
    private ResourceService $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;

        parent::__construct('open');
    }

    protected function configure(): void
    {
        $this->setName('open')->setDescription('Navigate to one (or all) of your PM resources.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (! file_exists(getcwd() . '/.pm.toml')) {
            $output->writeln('Could not find a .pm.toml config file in this directory.');

            return Command::FAILURE;
        }

        $resources        = $this->resourceService->parseConfig(getcwd() . '/.pm.toml');
        $helper           = $this->getHelper('question');
        $resources['All'] = null;

        $selection = $helper->ask($input,
            $output,
            new ChoiceQuestion("Which resource are you looking for?", array_keys($resources)));

        if ($selection === 'All') {
            foreach ($resources as $key => $resource) {
                if ($key !== 'All') {
                    $resource->callResource($input, $output);
                }
            }

            return Command::SUCCESS;
        }

        $resources[$selection]->callResource($input, $output);

        return Command::SUCCESS;
    }
}
