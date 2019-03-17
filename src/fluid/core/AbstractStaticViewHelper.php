<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\core;

/**
 * Base implementation of ViewHelpers using static rendering
 *
 * @author andreas
 */
abstract class AbstractStaticViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var array   Array of Argument Name => Default Value. This array
     *              can be used by applications to configure custom
     *              default values.
     */
    public static $overrideArgumentDefault = [];

    /**
     * Registers or overrides an existing argument definition
     * 
     * @param type $name
     * @param type $type
     * @param type $description
     * @param bool|null $required
     * @param type $defaultValue
     */
    protected function defineArgument($name, $type, $description, $required = null, $defaultValue = null)
    {
        $argd = $this->argumentDefinitions[$name] ?? null;
        if ($argd instanceof \TYPO3Fluid\Fluid\Core\ViewHelper\ArgumentDefinition) {
            return $this->overrideArgument($name,
                            $type,
                            $description,
                            $required ?? $argd->isRequired(),
                            $defaultValue);
        } else {
            return $this->registerArgument($name,
                            $type,
                            $description,
                            $required ?? false,
                            $defaultValue);
        }
    }

    protected function registerArgument($name, $type, $description, $required = false, $defaultValue = null)
    {
        return parent::registerArgument($name,
                        $type,
                        $description,
                        $required,
                        array_key_exists($name, static::$overrideArgumentDefault) ?
                        static::$overrideArgumentDefault[$name] : $defaultValue);
    }

    protected function overrideArgument($name, $type, $description, $required = false, $defaultValue = null)
    {
        return parent::overrideArgument($name,
                        $type,
                        $description,
                        $required,
                        array_key_exists($name, static::$overrideArgumentDefault) ?
                        static::$overrideArgumentDefault[$name] : $defaultValue);
    }

    public function getViewHelperArguments()
    {
        
    }
    
    /**
     * Prepare for static rendering
     * 
     * This method is called by renderStatic() before doRenderStatic().
     * Arguments and $renderingData are passed by reference and can be
     * modified.
     * 
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @param array $renderingData
     * @return void
     */
    protected static function beforeDoRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderingData = [])
    {
        
    }
    
    /**
     * Implementation of the ViewHelper rendering
     * 
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return void
     */
    public static function doRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderingData = [])
    {
        parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
    }
    
    
    /**
     * Called by renderStatic() after doRenderStatic()
     * 
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @param array $renderingData
     */
    protected static function afterDoRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderingData = [])
    {
        
    }
    
    /**
     * Renders the viewhelper
     * 
     * The default implementation calls
     * 1. beforeDoRenderStatic()
     * 2. doRenderStatic()
     * 3. afterDoRenderStatic()
     * 
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        $renderData = [];
        static::beforeDoRenderStatic($arguments, $renderChildrenClosure, $renderingContext, $renderData);
        $result = static::doRenderStatic($arguments, $renderChildrenClosure, $renderingContext, $renderData);
        static::afterDoRenderStatic($arguments, $renderChildrenClosure, $renderingContext, $renderData);
        return $result;
    }
    
    
}
