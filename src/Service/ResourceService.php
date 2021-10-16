<?php

namespace Jascha030\PM\Service;

use Jascha030\PM\Project\Category\ResourceCategory;

class ResourceService
{
    private array $definitions;

    public function __construct()
    {
        $this->definitions = [];

        $this->fetchDefinitions();
    }

    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    public function fetchDefinitions(): void
    {
        $definitionsPath = dirname(__FILE__, 3) . '/config/definitions.php';

        if (! file_exists($definitionsPath)) {
            throw new \InvalidArgumentException('Definitions config is corrupted.');
        }

        $definitions = include $definitionsPath;

        foreach ($definitions as $key => $definition) {
            if (!is_array($definition)) {
                throw new \InvalidArgumentException('Definitions config is corrupted.');
            }

            $options = $definition['options'];

            if (! in_array('Other', $options, true)) {
                $options[] = 'Other';
            }

            $this->definitions[$key] = new ResourceCategory($definition['name'], $key, $options);
        }
    }
}
