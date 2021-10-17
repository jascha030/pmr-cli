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

class InitCommand extends Command
{
    private const INTRO = "    ____  __  _______     ________    ____
   / __ \/  |/  / __ \   / ____/ /   /  _/
  / /_/ / /|_/ / /_/ /  / /   / /    / /  
 / ____/ /  / / _, _/  / /___/ /____/ /   
/_/   /_/  /_/_/ |_|   \____/_____/___/";

    private ResourceService $resourceService;

    public function __construct(ResourceService $resourceService, string $name = null)
    {
        $this->resourceService = $resourceService;

        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(self::INTRO . PHP_EOL);

        $this->resourceService->fetchDefinitions();
        $definitions     = $this->resourceService->getDefinitions();
        $questionService = $this->getHelper('question');

        $answers = [];

        foreach ($definitions as $definition) {
            $confirmation = "Do you want to add a: {$definition->getName()}? ";

            if (!$questionService->ask($input, $output, new ConfirmationQuestion($confirmation, false))) {
                continue;
            }

            $lowercaseCategory = strtolower($definition->getName());
            $class             = $this->resourceService->getClassFromType($definition->getType());

            $option = $questionService->ask($input, $output, new ChoiceQuestion(
                "Which {$lowercaseCategory} do you use? ",
                $definition->getOptions()
            ));

            $value = $questionService->ask($input, $output,
                new Question("Enter the {$definition->getType()}: ")
            );

            $answers[$definition->getKey()] = new $class($definition, $option, $value);
        }

        $tomlString = '';

        foreach ($answers as $resource) {
            $tomlString .= TomlService::parseResource($resource) . PHP_EOL;
        }

       return 0;
    }

    final protected function configure(): void
    {
        $this->setName('init')->setDescription('Init project and define it\'s resources for quick access.');
    }
}
