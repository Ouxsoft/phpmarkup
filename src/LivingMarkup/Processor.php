<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

/**
 * Class Processor
 * @package LivingMarkup
 */
class Processor
{

    const PROCESS_TOGGLE = 'LHTML_OFF';
    const DEBUG = true;

    private $kernel;
    private $builder;
    private $config;

    /**
     * Autoloader constructor.
     */
    public function __construct()
    {

        // instantiate Kernel
        $this->kernel = new Kernel();

        // instantiate a empty config
        $this->config = new Configuration();

        // instantiate a default builder
        $this->builder = new Builder\DynamicPageBuilder();

    }

    /**
     * Set builder
     * @param $builder
     */
    public function setBuilder($builder = null)
    {

        $this->builder = $builder;
    }

    /**
     * Set config
     * @param $filepath
     */
    public function loadConfig($filepath){

        // load config
        $this->config->loadFile($filepath);

    }

    /**
     * Get config
     * @return Configuration
     */
    public function getConfig(){
        return $this->config;
    }

    /**
     * Add a module to config
     * @param array $module
     * @return bool
     */
    public function addModule(array $module): bool
    {
        global $add_modules;

        if (!isset($add_modules)) {
            $add_modules = [];
        }
        $add_modules[] = $module;
        return true;
    }

    /**
     * Add definition for processor LHTML object
     *
     * @param string $name
     * @param string $xpath_expression
     * @param string $class_name
     */
    public function addObject(string $name,
                              string $xpath_expression,
                              string $class_name
                             ){
        $this->config->addModule([
            'name' => $name,
            'class_name' => $class_name,
            'xpath' => $xpath_expression
        ]);
    }

    /**
     * Add definition for processor LHTML object method
     *
     * @param string $method_name
     * @param string $description
     * @param string|null $execute
     */
    public function addMethod(string $method_name, string $description = '', $execute = null){
        $this->config->addMethod($method_name, $description, $execute);
    }


    /**
     * Process output buffer
     */
    public function parseBuffer(){
        if (defined(self::PROCESS_TOGGLE )) {
            return;
        }

        // process buffer once completed
        ob_start([$this, 'parseBufferCallback']);
    }


    /**
     * Callback to run kernel
     * @param string $markup
     * @return string
     */
    private function parseBufferCallback(string $markup) : string
    {

        // return buffer if it's not HTML
        if ($markup==strip_tags($markup)) {
            return $markup;
        }

        // add buffer to config
        $this->config->add('markup', $markup);

        return $this->parse();
    }

    /**
     * Process a file
     *
     * @param $filepath
     * @return string
     */
    public function parseFile($filepath) : string {

        $markup = file_get_contents($filepath);

        // return buffer if it's not HTML
        if ($markup==strip_tags($markup)) {
            return $markup;
        }

        $this->config->setMarkup($markup);

        return $this->parse();

    }

    /**
     * Process string
     *
     * @param string $markup
     * @return string
     */
    public function parseString(string $markup) : string {

        // return buffer if it's not HTML
        if ($markup==strip_tags($markup)) {
            return $markup;
        }

        $this->config->setMarkup($markup);

        return $this->parse();

    }


    private function parse(){

        // add runtime modules to config
        if (isset($add_modules)) {
            $this->config->addModules($add_modules);
        }

        // echo Kernel build of Builder
        return $this->kernel->build($this->builder, $this->config);


    }
}