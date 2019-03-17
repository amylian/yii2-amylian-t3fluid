<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\t3fluid\core;

/**
 * Description of ViewHelperRenderingContext
 *
 * @author andreas
 */
class ViewHelperRenderingContext implements \yii\base\ViewContextInterface
{
    
    /**
     * @var null|\yii\base\ViewContextInterface 
     */
    public $parentContext = null;
    
    public function getViewPath(): string
    {
        return isset($this->parentContext) ? $this->parentContext->getViewPath() : null;
    }
}
