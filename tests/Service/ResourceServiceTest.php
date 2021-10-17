<?php

namespace Jascha030\PM\Test\Service;

use Jascha030\PM\Project\Category\ResourceCategoryInterface;
use Jascha030\PM\Project\ProjectResourceInterface;
use Jascha030\PM\Project\UrlResource;
use Jascha030\PM\Service\ResourceService;
use PHPUnit\Framework\TestCase;

class ResourceServiceTest extends TestCase
{
    public function test__construct(): ResourceService
    {
        $types = [
            UrlResource::getType() => UrlResource::class
        ];

        $service = new ResourceService($types);
        self::assertInstanceOf(ResourceService::class, $service);

        return $service;
    }

    /**
     * @depends test__construct
     */
    public function testParseConfig(ResourceService $service): void
    {
        $path = dirname(__FILE__, 2) . '/Fixtures/pm.toml';
        $parsedData = $service->parseConfig($path);

        self::assertIsArray($parsedData);
        self::assertNotEmpty($parsedData);
        self::assertCount(2, $parsedData);

        foreach($parsedData as $resource) {
            self::assertInstanceOf(ProjectResourceInterface::class, $resource);
        }
    }

    /**
     * @depends test__construct
     */
    public function testFetchDefinitions(ResourceService $service): array
    {
        self::assertIsArray($service->getDefinitions());
        self::assertEmpty($service->getDefinitions());

        $service->fetchDefinitions();
        $definitions = $service->getDefinitions();

        self::assertIsArray($definitions);
        self::assertNotEmpty($definitions);

        return $definitions;
    }

    /**
     * @depends testFetchDefinitions
     */
    public function testGetDefinitions(array $definitions): void
    {
        foreach ($definitions as $definition) {
            self::assertInstanceOf(ResourceCategoryInterface::class, $definition);
        }
    }
}
