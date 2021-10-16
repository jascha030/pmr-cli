<?php

namespace Jascha030\PM\Console\Command;

use Symfony\Component\Console\Command\Command;

class InitCommand extends Command
{
    private const INTRO = '    ____  __  _______     ________    ____
   / __ \/  |/  / __ \   / ____/ /   /  _/
  / /_/ / /|_/ / /_/ /  / /   / /    / /  
 / ____/ /  / / _, _/  / /___/ /____/ /   
/_/   /_/  /_/_/ |_|   \____/_____/___/';

    final protected function configure(): void
    {
        $this
            ->setName('init')
            ->setDescription('Init project and define it\'s resources for quick access.');
    }

    public function execute()
    {

    }
}
