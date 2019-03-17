<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh;

/**
 * Encloses the text in curly braces
 *
 * @author andreas
 */
class CbViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('text', 'string', 'Text to encolose in curly braces', false, null);
    }
    
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        if (!isset($arguments['text'])) {
            $arguments['text'] = $renderChildrenClosure();
        }
        return '{'.$arguments['text'].'}';
    }

}
