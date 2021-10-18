<?php

namespace Jascha030\PM\Console\Command;

use Jascha030\PM\Service\ResourceService;
use Jascha030\PM\Service\TomlService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class InitCommand extends Command
{
    private const INTRO = "    ____  __  _______     ________    ____
   / __ \/  |/  / __ \   / ____/ /   /  _/
  / /_/ / /|_/ / /_/ /  / /   / /    / /  
 / ____/ /  / / _, _/  / /___/ /____/ /   
/_/   /_/  /_/_/ |_|   \____/_____/___/";

    private ResourceService $resourceService;

    private Filesystem $filesystem;

    public function __construct(ResourceService $resourceService, string $name = null)
    {
        $this->resourceService = $resourceService;

        $this->filesystem = new Filesystem();

        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(self::INTRO . PHP_EOL . PHP_EOL);

        $this->resourceService->fetchDefinitions();
        $definitions     = $this->resourceService->getDefinitions();
        $questionService = $this->getHelper('question');

        $answers = [];

        foreach ($definitions as $definition) {
            $lower = strtolower($definition->getName());
            $confirmation = "Do you want to add a <info>{$lower}</info> resource? (return to skip)\n<comment>[yes|y|ok]</comment>: ";

            if (!$questionService->ask($input, $output, new ConfirmationQuestion($confirmation, false, '/^(yes|ok|y)/i'))) {
                continue;
            }

            $lowercaseCategory = strtolower($definition->getName());
            $class             = $this->resourceService->getClassFromType($definition->getType());

            $option = $questionService->ask($input, $output, new ChoiceQuestion(
                "Which {$lowercaseCategory} do you use? ",
                $definition->getOptions(),
                'Other'
            ));

            $value = $questionService->ask($input, $output,
                new Question("Enter the {$definition->getType()}: ")
            );

            if (!$value) {
                continue;
            }

            $answers[$definition->getKey()] = new $class($definition, $option, $value);
        }

        $tomlString = '';

        foreach ($answers as $resource) {
            $tomlString .= TomlService::parseResource($resource) . PHP_EOL;
        }

        $file = getcwd() . '/.pm.toml';
        $this->filesystem->touch($file);

        try {
            $this->filesystem->dumpFile($file, $tomlString);
        } catch(IOException $e) {
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }

        $output->writeln("Resource file was created successfully!");

        return Command::SUCCESS;
    }

    final protected function configure(): void
    {
        $this->setName('init')->setDescription('Init project and define it\'s resources for quick access.');
    }
}
