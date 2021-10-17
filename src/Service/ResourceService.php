<?php

namespace Jascha030\PM\Service;

use Jascha030\PM\Project\Category\ResourceCategory;
use Jascha030\PM\Project\ProjectResourceAbstract;

class ResourceService
{
    private const DATA_MAPPING = [
        1 => 'key',
        2 => 'category',
        3 => 'name',
        4 => 'value',
        5 => 'type',
    ];

    private array $definitions;

    private array $types;

    public function __construct(array $types =  [])
    {
        $this->types =  $types;
        $this->definitions = [];
    }

    public function getClassFromType(string $type): ?string
    {
        return $this->types[$type];
    }

    /**
     * @return \Jascha030\PM\Project\Category\ResourceCategoryInterface[]
     */
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

            $this->definitions[$key] = new ResourceCategory($key, $definition['name'], $definition['type'], $options);
        }
    }

    public function parseConfig(string $path): array
    {
        $contents = TomlService::parseToString($path);
        $pattern = '/\[pm.([a-z]*)]\n[ \t]*category = "(.*)"\n[ \t]*name = "(.*)"\n[ \t]*value = "(.*)"\n[ \t]*type = "(.*)"/';
        $dataLength = preg_match_all($pattern, $contents, $matches);

        if ($dataLength === null || $dataLength === false || $dataLength === 0) {
            throw new \RuntimeException("Could not parse toml data to valid Resource objects.");
        }

        $resources  = [];

        for ($index = 0; $index < $dataLength; $index++) {
            $type = $matches[$this->getDataIndex('type')][$index];

            $category = new ResourceCategory(
                $matches[$this->getDataIndex('key')][$index],
                $matches[$this->getDataIndex('category')][$index],
                $type
            );

            $class = $this->getClassFromType($type);

            if (! is_subclass_of($class, ProjectResourceAbstract::class)) {
                throw new \InvalidArgumentException("Invalid type: \"{$type}\".");
            }

            $resources[$category->getKey()] = new $class(
                $category,
                $matches[$this->getDataIndex('name')][$index],
                $matches[$this->getDataIndex('value')][$index],
            );
        }

        return $resources;
    }

    private function getDataIndex(string $name): int
    {
        if (!isset(array_flip(self::DATA_MAPPING)[$name])) {
            throw new \InvalidArgumentException("Invalid key name: \"{$name}\".");
        }

        return array_flip(self::DATA_MAPPING)[$name];
    }
}
