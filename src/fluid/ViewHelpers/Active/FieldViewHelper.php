<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\ViewHelpers\Active;

/**
 * Description of FieldViewHelper
 *
 * @author andreas
 */
class FieldViewHelper extends \amylian\yii\t3fluid\fluid\core\AbstractStaticViewHelper
{
    const ARGUMENT_ACTIVE_FORM = 'activeForm';

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument(\amylian\yii\t3fluid\fluid\ViewHelpers\WidgetViewHelper::ARGUMENT_WIDGET_PHP_CLASS, 'Class of FieldWidget to be used. If not specified the standard field object of the active form is used ', false, null);
        $this->registerArgument(static::ARGUMENT_ACTIVE_FORM, 'mixed', 'Variable ID of ActiveForm as specifed in as argument of <yf:active.form> (Default: ' . FormViewHelper::$defaultAsArgument . ')', false, FormViewHelper::$defaultAsArgument);
        $this->registerArgument('model', 'mixed', 'Object ID of the used model', true, null);
        $this->registerArgument('config', 'array', 'Configuration array of the field component', false, []);
        $this->registerArgument('attribute', 'string', 'Attribute in model', true, null);
        $this->registerArgument('options', 'array', 'Array of addtional options used for rendering', false, []);
        $this->registerArgument('render', 'string', 'Render function to call', false, null);
        $this->registerArgument('renderArguments', 'array', 'parameters passed to the render function', false, []);
    }
    
    
    protected static function beforeDoRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderingData = array()): void
    {
        parent::beforeDoRenderStatic($arguments, $renderChildrenClosure, $renderingContext, $renderingData);
        if (!is_object($arguments['model'])) {
            $arguments['model'] = $renderingContext->getVariableProvider()->getByPath($arguments['model']);
        }
        if (!$arguments[static::ARGUMENT_ACTIVE_FORM] instanceof \yii\widgets\ActiveForm) {
            $arguments[static::ARGUMENT_ACTIVE_FORM] = $renderingContext->getVariableProvider()->get($arguments[static::ARGUMENT_ACTIVE_FORM]);
        }
    }
    

    public static function doRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderingData = [])
    {
        if (!$arguments[static::ARGUMENT_ACTIVE_FORM] instanceof \yii\widgets\ActiveForm) {
            throw new \TYPO3Fluid\Fluid\Core\ViewHelper\Exception('Instance of active form expected in form attribute');
        } else {
            if (isset($arguments[\amylian\yii\t3fluid\fluid\ViewHelpers\WidgetViewHelper::ARGUMENT_WIDGET_PHP_CLASS])) {
                $arguments['config']['class'] = $arguments[\amylian\yii\t3fluid\fluid\ViewHelpers\WidgetViewHelper::ARGUMENT_WIDGET_PHP_CLASS];
            }
            $f = $arguments[static::ARGUMENT_ACTIVE_FORM]->field($arguments['model'], $arguments['attribute'], $arguments['options']);
            if ($arguments['render']) {
               return (string) call_user_func_array([$f, $arguments['render']], $arguments['renderOptions']);
            } else {
               return (string) $f;
            }
        }
    }

}
