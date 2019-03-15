<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh\Active;

/**
 * Description of DropDownViewHelper
 *
 * @author andreas
 */
class CheckboxViewHelper extends FieldViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->overrideArgument('render', 'string', 'Render function do be used', false, 'checkbox');
        $this->overrideArgument('renderArguments', 'array', 'Use renderOptions instead', false, []);
        $this->registerArgument('renderOptions', 'array', 'Options for rendering', false, []);
    }
    
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        $arguments['renderOptions'][0] = $arguments['renderOptions'];
        return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
    }
}
