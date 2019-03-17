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
 * The use case is similar to <f:render/>, but uses Yii's rendering 
 * functionality instead. This means all registered renderers can be 
 * used (i.E. template snippets in php)
 *
 * @author andreas
 */
class IncludeViewHelper extends \amylian\yii\t3fluid\fluid\core\AbstractStaticViewHelper
{
    
    /**
     * @var boolean
     */
    protected $escapeOutput = false;
    
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->defineArgument('template', 'string', 'Template file name (Yii-Aliases may be used)', true);
        $this->defineArgument('view', 'string', 'ID of Instance of View', false, 'this');
        $this->defineArgument('addParameters', 'array', 'Array of additional data', false, []);
    }

    public static function renderStatic($arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        if (!$arguments['view'] instanceof \yii\base\View) {
            $arguments['view'] = $renderingContext->getVariableProvider()->getByPath($arguments['view']);
        }
        $params = $renderingContext->getVariableProvider()->getAll();
        unset($params['this']);
        $params = \yii\helpers\ArrayHelper::merge($params, $arguments['addParameters']);
        $vhContext = new \amylian\yii\t3fluid\core\ViewHelperRenderingContext();
        $vhContext->parentContext = $arguments['view']->context;
        return $arguments['view']->render($arguments['template'], $params, $vhContext);
    }

}
