<?php

namespace Brendt\Stitcher\Parser;

use Brendt\Stitcher\Factory\ParserFactory;
use Brendt\Stitcher\Lib\Browser;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * The FolderParser take the path to a folder and will read all files in that folder, parsing each of the files
 * individually.
 */
class FolderParser implements Parser
{
    private $parserFactory;
    private $browser;

    public function __construct(ParserFactory $parserFactory, Browser $browser) {
        $this->parserFactory = $parserFactory;
        $this->browser = $browser;
    }

    public function parse($path) {
        $path = trim($path, '/');
        /** @var SplFileInfo[] $files */
        $files = $this->browser->src()->files()->path("data/{$path}")->name('*.*');
        $data = [];

        foreach ($files as $file) {
            $parser = $this->parserFactory->getByFileName($file->getFilename());
            $id = str_replace(".{$file->getExtension()}", '', $file->getFilename());

            $data[$id] = [
                'id'      => $id,
                'content' => $parser->parse($file->getRelativePathname()),
            ];
        }

        return $data;
    }
}
