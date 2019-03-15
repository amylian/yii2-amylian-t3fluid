<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\fluid\vh\Html;

/**
 * @author andreas
 */
trait Standard2ParameterTrait
{
    use StandardOptionsTrait;
    
    protected static function getMethodCallArgumentsStatic($arguments) {
        return [
            $arguments['content'],
            $arguments['options']
        ];
    }

}
