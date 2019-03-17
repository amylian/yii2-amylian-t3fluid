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
class DropDownViewHelper extends FieldViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->overrideArgument('render', 'string', 'Render function do be used', false, 'dropDownList');
        $this->overrideArgument('renderArguments', 'array', 'Do not use this attribute - Use items and renderOptions instead', false, []);
        $this->registerArgument('items', 'array', 'Items to be used in the DropDown-List', false, []);
        $this->registerArgument('renderOptions', 'array', 'Options for rendering', false, []);
    }
    
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        $arguments['renderArguments'][0] = $arguments['items'];
        $arguments['renderOptions'][1] = $arguments['renderOptions'];
        return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
    }
}
