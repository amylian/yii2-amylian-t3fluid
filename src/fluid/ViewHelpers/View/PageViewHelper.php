<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\ViewHelpers\View;

/**
 * Description of BeginPageViewHelper
 *
 * @author andreas
 */
class PageViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    
    /**
     * @var boolean
     */
    protected $escapeOutput = false;
    
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('view', 'string', 'Variable ID of Yii View object', false, 'this');
    }
    
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        if (!$arguments['view'] instanceof \yii\base\View) {
            $arguments['view'] = $renderingContext->getVariableProvider()->getByPath($arguments['view']);
        }
        return $arguments['view']->beginPage().$renderChildrenClosure().$arguments['view']->endPage();
    }
}
