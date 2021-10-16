<?php

namespace Jascha030\PM\Project\Category;

use Jascha030\PM\Project\ProjectResourceInterface;

class TaskTrackingResourceCategory extends ResourceCategoryAbstract
{
    public const PROVIDERS = [
        'Asana',
        'ClickUp',
        'Jira',
        'Monday',
        'Trello',
        'Other'
    ];

    private ProjectResourceInterface $resource;

    public function getName(): string
    {
        return 'Task Manager';
    }

    public function getOptions(): array
    {
        return self::PROVIDERS;
    }

    public function getKey(): string
    {
        return 'tasks';
    }
}
