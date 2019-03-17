<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\ViewHelpers\Html;

/**
 *
 * @author andreas
 */
trait StandardOptionsTrait
{

    abstract function getDefaultMethodName();

    protected function getOptionsArguments()
    {
        return ['name', 'id', 'class', 'style'];
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $defaultMethodName = $this->getDefaultMethodName();
        $this->overrideArgument('method', 'string', 'Name of method to call (Default: ' . $defaultMethodName . ')', false, $defaultMethodName);
        $this->registerArgument('content', 'string', 'Caption or conntent of the elment', false, null);
        $this->registerArgument('options', 'array', 'Array of options', false, []);
        foreach (static::getOptionsArguments() as $argumentName) {
            $this->registerArgument($argumentName, 'string', 'Overrides ' . $argumentName . ' in options', false, null);
        }
        $this->overrideArgument('arguments', 'array', 'Arguments to be passed to method. Do not use this. Specify parameter "content" and "options" instead', false, []);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        if (!isset($arguments['content'])) {
            $arguments['content'] = $renderChildrenClosure();
        }
        if (isset($arguments['class'])) {
            $arguments['options']['class'] = $arguments['class'];
        }
        foreach (static::getOptionsArguments() as $argumentName) {
            if (isset($arguments[$argumentName])) {
                $arguments['options'][$argumentName] = $arguments[$argumentName];
            }
        }
        $arguments['arguments'][0] = $arguments['content'];
        $arguments['arguments'][1] = $arguments['options'];
        return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
    }

}
