<?php

namespace Jascha030\PM\Service;

use Jascha030\PM\Project\ProjectResourceInterface;
use Symfony\Component\Filesystem\Filesystem;

class TomlService
{
    public static function addToGitignore(): void
    {
        $path = getcwd() . '/.gitignore';
        $fs = new Filesystem();

        // Todo: Check if dir even has .git/ beforehand
        if (! file_exists($path)) {
            return;
        }

        $file = new \SplFileInfo($path);
        $contents = file_get_contents($file->getRealPath());

        // Todo: give user option to create new .gitignore
        if (! $contents) {
            return;
        }

        // Todo: Check if toml already ignored
        $contents .= PHP_EOL . '.pm.toml' . PHP_EOL . PHP_EOL;
        $fs->dumpFile($file->getRealPath(), $contents);
    }


    public static function parseToString(string $path): string
    {
        if (! file_exists($path)) {
            throw new \InvalidArgumentException("Path: \"{$path}\" does not exist.");
        }

        $file      = new \SplFileInfo($path);
        $extension = $file->getFileInfo()->getExtension();

        if ($extension !== 'toml') {
            throw new \InvalidArgumentException("Invalid file: \"{$path}\", file should be a .toml file.");
        }

        return file_get_contents($file->getRealPath());
    }

    public static function parseResource(ProjectResourceInterface $resourceCategory): string
    {
        $template = '[pm.%s]' .
                    PHP_EOL .
                    "\tcategory = \"%s\"" .
                    PHP_EOL .
                    "\tname = \"%s\"" .
                    PHP_EOL .
                    "\tvalue = \"%s\"" .
                    PHP_EOL .
                    "\ttype = \"%s\"" .
                    PHP_EOL;

        return sprintf(
            $template,
            $resourceCategory->getCategory()->getKey(),
            $resourceCategory->getCategory()->getName(),
            $resourceCategory->getName(),
            $resourceCategory->getValue(),
            $resourceCategory::getType()
        );
    }
}
