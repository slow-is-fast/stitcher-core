<?php

namespace Brendt\Stitcher\Tests\Phpunit\Factory;

use Brendt\Stitcher\Factory\TemplateEngineFactory;
use Brendt\Stitcher\Config;
use Brendt\Stitcher\Stitcher;
use Brendt\Stitcher\Template\smarty\SmartyEngine;
use Brendt\Stitcher\Template\twig\TwigEngine;
use PHPUnit\Framework\TestCase;

class TemplateEngineFactoryTest extends TestCase
{

    public function setUp() {
        Stitcher::create('./tests/config.yml');
    }

    /**
     * @return TemplateEngineFactory
     */
    protected function createTemplateEngineFactory() {
        return Stitcher::get('factory.template');
    }

    public function test_factory_smarty() {
        $factory = $this->createTemplateEngineFactory();

        $this->assertInstanceOf(SmartyEngine::class, $factory->getByType(TemplateEngineFactory::SMARTY_ENGINE));
    }

    public function test_factory_twig() {
        $factory = $this->createTemplateEngineFactory();

        $this->assertInstanceOf(TwigEngine::class, $factory->getByType(TemplateEngineFactory::TWIG_ENGINE));
    }

    /**
     * @expectedException \Brendt\Stitcher\exception\UnknownEngineException
     */
    public function test_unknown_id_throws_exception() {
        $factory = $this->createTemplateEngineFactory();

        $factory->getByType('unknown');
    }

}
