<?php
/*
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LuckByDiceTests\Benchmark;

use Ouxsoft\PHPMarkup\Factory\ProcessorFactory;

class ProcessorFactoryBench
{
    /**
     * @var Processor
     */
    private $processor;

    public function setUp(): void
    {
        $this->processor = ProcessorFactory::getInstance();
    }

    public function tearDown(): void
    {
        unset($this->turn);
    }

    // 20000 microseconds = 0.020 seconds
    /**
     * @BeforeMethods("setUp")
     * @AfterMethods("tearDown")
     * @ParamProviders({"provideLHTML"})
     * @Assert("mode(variant.time.avg) < 20000")
     * @Assert("mode(variant.mem.peak) < 2500000")
     * @Iterations(10)
     * @Revs(5)
     * @OutputTimeUnit("seconds")
     */
    public function benchProcessor($params)
    {
        $this->processor->parseString($params['html']);
    }

    public function provideLHTML(): array
    {
        $data = [];
        $data[] = ['html' => '<html><head></head><body><div></div></body></html>'];

        return $data;
    }
}
