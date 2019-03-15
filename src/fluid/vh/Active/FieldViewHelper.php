<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh\Active;

/**
 * Description of FieldViewHelper
 *
 * @author andreas
 */
class FieldViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('form', 'mixed', 'Related ActiveForm', false, null);
        $this->registerArgument('model', 'mixed', 'Object ID of the used model', true, null);
        $this->registerArgument('attribute', 'string', 'Attribute in model', true, null);
        $this->registerArgument('options', 'array', 'Array of additional options', false, []);
        $this->registerArgument('render', 'string', 'Render function to call', false, null);
        $this->registerArgument('renderArguments', 'array', 'parameters passed to the render function', false, []);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        if (!is_object($arguments['model'])) {
            $arguments['model'] = $renderingContext->getVariableProvider()->getByPath($arguments['model']);
        }
        if (!is_object($arguments['form'])) {
            $arguments['form'] = $renderingContext->getVariableProvider()->getByPath($arguments['form']);
        }
        if (!$arguments['form'] instanceof \yii\widgets\ActiveForm) {
            throw new \TYPO3Fluid\Fluid\Core\ViewHelper\Exception('Instance of active form expected in form attribute');
        } else {
            $f = $arguments['form']->field($arguments['model'], $arguments['attribute'], $arguments['options']);
            if ($arguments['render']) {
                return (string) call_user_func_array([$f, $arguments['render']], $arguments['renderOptions']);
            } else {
                return (string) $f;
            }
        }
    }

}
