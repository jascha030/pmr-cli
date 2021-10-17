<?php

namespace Jascha030\PM\Test\Service;

use Jascha030\PM\Project\Category\ResourceCategory;
use Jascha030\PM\Project\UrlResource;
use Jascha030\PM\Service\TomlService;
use PHPUnit\Framework\TestCase;

class TomlServiceTest extends TestCase
{

    public function testParseResource()
    {
        $expected = '[pm.task]
	category = "Task Manager"
	name = "ClickUp"
	value = "http://app.clickup.com/123/v/123"
	type = "url"' . PHP_EOL;

        $resourceCategory = new ResourceCategory('task', 'Task Manager', 'url');
        $resource = new UrlResource($resourceCategory, 'ClickUp', 'http://app.clickup.com/123/v/123');

        $parsed = TomlService::parseResource($resource);
        self::assertEquals($expected, $parsed);
    }

    public function testParse(): void
    {
        $filePath = dirname(__FILE__, 2) . '/Fixtures/pm.toml';
        $string = TomlService::parseToString($filePath);

        self::assertIsString($string);
    }
}
