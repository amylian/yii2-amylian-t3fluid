<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh;

/**
 * Embeds another template using Yii's templating 
 *
 * @author andreas
 */
class RenderViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('template', 'string', 'Template file name (Yii-Aliases may be used)', true);
        $this->registerArgument('view', 'string', 'ID of Instance of View', false, 'this');
        $this->registerArgument('addParameters', 'array', 'Array of additional data', false, []);
    }
    
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        if (!$arguments['view'] instanceof \yii\base\View) {
            $arguments['view'] = $renderingContext->getVariableProvider()->getByPath($arguments['view']);
        }
        $arguments['template'] = \Yii::getAlias($arguments['template']);
        $params = $renderingContext->getVariableProvider()->getAll();
        $params = \yii\helpers\ArrayHelper::merge($params, $arguments['addParameters']);
        return $arguments['view']->render($arguments['template'], $params, $arguments['view']->context);
    }
    
}
