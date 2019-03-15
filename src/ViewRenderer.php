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

namespace amylian\yii\t3fluid;

use Yii;
use yii\base\View;
use yii\base\ViewRenderer as BaseViewRenderer;

class ViewRenderer extends BaseViewRenderer
{

    /**
     * @var \TYPO3Fluid\Fluid\View\TemplateView Used View
     */
    public $templateView = null;

    /**
     * @var bool    Specifies wether the caching system of Yii or the 
     *              Fluid's own cache implementation is used.
     *              {@see $cache} for details.
     */
    public $useYiiCache = false;

    /**
     * @var string|\yii\caching\CacheInterface|array|null Used caching
     * 
     * if `false` or `null` caching is disabled. 
     * 
     * if {@see $useYiiCache} is `false` this property specifies the
     * directory used for storage. Yii-Aliases are allowed, e.g. 
     * `@runtime/t3fluid/cache`.
     * 
     * If {@see $useYiiCache} is `true` this property specifies either
     * 
     * - an application component ID (e.g. `cache`)
     * - a component configuration array
     * - a [[\yii\caching\Cache]] object
     */
    public $cache = '@runtime/t3fluid/cache';

    /**
     * @var \TYPO3Fluid\Fluid\Core\Cache\FluidCacheInterface
     */
    protected $fluidCacheInstance = null;

    public function init()
    {
        parent::init();
        $this->initFluidTemplateView();
    }

    /**
     * Registers the viewhelper namespace
     * 
     * This function registers a viewhelper namespace to typo3fluid by calling
     * {@see \TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver::addNamespace()}
     * 
     * @param type $identifier
     * @param type $phpNamespace
     */
    public function addViewHelperNamespace($identifier, $phpNamespace)
    {
        $this->templateView->getRenderingContext()->getViewHelperResolver()->addNamespace($identifier, $phpNamespace);
    }

    /**
     * Creates and configures the cache object for fluid
     */
    protected function initFluidCache()
    {
        if (!$this->fluidCacheInstance) {
            if ($this->useYiiCache) {
                $this->fluidCacheInstance = new fluid\YiiProxyCache(\yii\di\Instance::ensure($this->cache));
            } else 
            {
                $d = \Yii::getAlias($this->cache); // resolve aliased names
                \yii\helpers\FileHelper::createDirectory($d);
                $this->fluidCacheInstance = new \TYPO3Fluid\Fluid\Core\Cache\SimpleFileCache($d);
            }
        }
        $this->templateView->setCache($this->fluidCacheInstance);
    }
    
    protected function initFluidTemplateView()
    {
        $this->templateView = new \TYPO3Fluid\Fluid\View\TemplateView();
        $this->initFluidCache();
        $this->addViewHelperNamespace('yf', '\\amylian\\yii\\t3fluid\\fluid\\vh');
    }

    protected function getExtStrippedFile($file)
    {
        $e = pathinfo($file);
        return $e['dirname'] . '/' . $e['filename'];
    }

    protected function configureTemplatePaths($view, $file)
    {
        $this->templateView->getTemplatePaths()->setTemplatePathAndFilename($file);
    }

    /**
     * Renders a view file.
     *
     * This method is invoked by [[View]] whenever it tries to render a view.
     * Child classes must implement this method to render the given view file.
     *
     * @param View $view the view object used for rendering the file.
     * @param string $file the view file.
     * @param array $params the parameters to be passed to the view file.
     *
     * @return string the rendering result
     */
    public function render($view, $file, $params)
    {
        // Make the view accessible by "this"
        $this->templateView->assign('this', $view);
        $this->templateView->assign('app', \Yii::$app);        
        // Compose and register array of useful template paths
        $this->configureTemplatePaths($view, $file);
        // Assign user passed parmeters
        $this->templateView->assignMultiple($params);
        // Find the template
        $this->templateView->getTemplatePaths()->setTemplateRootPaths([]);
        // Render template
        return $this->templateView->render();
    }

}
