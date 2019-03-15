<?php

/*
 * BSD 3-Clause License
 * 
 * Copyright (c) 2019, Andreas Prucha - Abexto - Helicon Software Development / Amylian Project
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 * * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 * 
 * * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 * 
 * * Neither the name of the copyright holder nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace amylian\yii\t3fluid\fluid\vh;

/**
 * Description of WidgetViewHelper
 *
 * @author andreas
 */
class WidgetViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    const ARGUMENT_WIDGET_PHP_CLASS = 'widgetClass';

    /**
     * @var int 
     */
    protected static $widgetVariableCounter = 1;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument(static::ARGUMENT_WIDGET_PHP_CLASS, 'string', 'Class of widget', true);
        $this->registerArgument('as', 'string', 'Name of variable to be used for the widget instance', false, null);
        $this->registerArgument('arguments', 'array', 'Arguments to be passed to the widget class', false, null);
        $this->registerArgument('block', 'mixed', 'Specifies wether this is widget block(true) or not. NULL for auto detection', false, null);
    }

    protected static function renderStaticInit(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderData)
    {
        if (!isset($arguments['as'])) {
            $arguments['as'] = '___tmpWidget' . static::$widgetVariableCounter++;
        }
    }

    protected static function renderStaticContentBegin(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderData)
    {
        // Create andr reigster widget object
        $renderData['tmpWidget'] = $arguments[static::ARGUMENT_WIDGET_PHP_CLASS]::begin($arguments['arguments']);
        $renderingContext->getVariableProvider()->add($arguments['as'], $renderData['tmpWidget']);
    }

    protected static function renderStaticChildrenContent(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderData)
    {
        echo $renderChildrenClosure();
    }

    protected static function renderStaticContentEnd(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderData)
    {
        $renderData['tmpWidget']->end();
    }

    protected static function renderStaticFinalize(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, array &$renderData)
    {
        if (isset($arguments['as'])) {
            $renderingContext->getVariableProvider()->remove($arguments['as']);
        }
    }

    /**
     * Renders the widget
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
    {
        $renderData = [];
        $result = '';
        ob_start();
        ob_implicit_flush(false);
        try {
            static::renderStaticInit($arguments, $renderChildrenClosure, $renderingContext, $renderData);
            static::renderStaticContentBegin($arguments, $renderChildrenClosure, $renderingContext, $renderData);
            static::renderStaticChildrenContent($arguments, $renderChildrenClosure, $renderingContext, $renderData);
            static::renderStaticContentEnd($arguments, $renderChildrenClosure, $renderingContext, $renderData);
            static::renderStaticFinalize($arguments, $renderChildrenClosure, $renderingContext, $renderData);
            unset($renderData['tmpWidget']);
        } catch (\Exception $e) {
            // close the output buffer opened above if it has not been closed already
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            throw $e;
        }

        $result = ob_get_clean();
        return $result;
    }

}
