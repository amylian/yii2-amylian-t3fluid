<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\core;

/**
 * ViewHelper wrapping outputted content 
 *
 * @author andreas
 */
class AbstractStaticCapturingViewHelper extends AbstractStaticViewHelper
{
    
    protected static function beforeDoRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderingData = array())
    {
        parent::beforeDoRenderStatic($arguments, $renderChildrenClosure, $renderingContext, $renderingData);
    }
    
    protected static function afterDoRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderingData = array())
    {
        parent::afterDoRenderStatic($arguments, $renderChildrenClosure, $renderingContext, $renderingData);
    }
    
    public static function doRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, &$renderingData = array())
    {
        return ''; // captured output is used instead of returned string
    }
    
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        $renderData = [];
        $result = '';
        ob_start();
        ob_implicit_flush(false);
        try {
            parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
        } catch (\Exception $e) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            throw $e;
        }

        return ob_get_clean();
    }
    
}
