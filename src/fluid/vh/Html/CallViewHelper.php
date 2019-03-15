<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh\Html;

/**
 * Generic View Helper for \yii\helpers\Html calls. 
 *
 * @author andreas
 */
class CallViewHelper extends \amylian\yii\t3fluid\fluid\vh\CallViewHelper
{
    
    const ARGUMENT_HELPER_CLASS = 'helperClass';
    
    
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument(static::ARGUMENT_HELPER_CLASS, 'string', 'Helper-Class to use. (Default: '.\yii\helpers\Html::class.')', false, \yii\helpers\Html::class);
        $this->overrideArgument('method', 'string', 'Name of method to call', true, null);
    }
    
    /**
     * Prepares the arguments array for the call
     * @param type $arguments
     */
    protected static function getMethodCallArgumentsStatic($arguments) {
        return $arguments['arguments'];
    }
    
    protected static function getCallMethodStatic($arguments)
    {
        return (strpos($arguments['method'], '::')) ? $arguments['method'] : $arguments[static::ARGUMENT_HELPER_CLASS].'::'.$arguments['method'];
    }
    
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        if (!isset($arguments['method'])) {
            throw new ViewHelperException('the html.call View Helper requireds parameter method to be set');
        };
        $arguments['method'] = static::getCallMethodStatic($arguments);
        $arguments['arguments'] = static::getMethodCallArgumentsStatic($arguments);
        return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
    }
}
