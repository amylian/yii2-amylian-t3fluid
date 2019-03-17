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

namespace amylian\yii\t3fluid\fluid\ViewHelpers;

/**
 * Description of WidgetViewHelper
 *
 * @author andreas
 */
class WidgetViewHelper extends \amylian\yii\t3fluid\fluid\core\AbstractStaticCapturingViewHelper
{
    const ARGUMENT_WIDGET_PHP_CLASS = 'widgetClass';
    const ARGUMENT_AS = 'as';
    
    public static $defaultAsArgument = '___currentWidget';

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
        $this->registerArgument(static::ARGUMENT_AS, 'string', 'Name of variable to be used for the widget instance', false, static::$defaultAsArgument);
        $this->registerArgument('config', 'array', 'Configuration array passed as Widget::begin($config)', false, []);
        $this->registerArgument('block', 'mixed', 'Specifies wether this is widget block(true) or not. NULL for auto detection', false, null);
    }
    
    public static function doRenderStatic(array &$arguments, \Closure $renderChildrenClosure, \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext, &$renderingData = array())
    {
        $renderingData['currentWidget'] = $arguments[static::ARGUMENT_WIDGET_PHP_CLASS]::begin($arguments['config']);
        $renderingContext->getVariableProvider()->add($arguments[static::ARGUMENT_AS], $renderingData['currentWidget']);
        echo $renderChildrenClosure();
        $renderingData['currentWidget']->end();
        return ''; // ATTENTION: Captured output is used instead of the return value of doRenderStatic
    }
    
}
