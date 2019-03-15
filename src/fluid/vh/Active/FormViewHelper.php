<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh\Active;

/**
 * Description of ActiveFormViewHelper
 *
 * @author andreas
 */
class FormViewHelper extends \amylian\yii\t3fluid\fluid\vh\WidgetViewHelper
{
    
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->overrideArgument(static::ARGUMENT_WIDGET_PHP_CLASS, 'string', 'Active Form implementation class', false, \yii\widgets\ActiveForm::class);
    }
}
