<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh\Html;

/**
 * Generic View Helper calling \yii\helpers\Html::button
 *
 * @author andreas
 */
class ButtonViewHelper extends \amylian\yii\t3fluid\fluid\vh\Html\CallViewHelper
{
    use Standard2ParameterTrait;
    
    public function getDefaultMethodName()
    {
        return 'button';
    }

}
