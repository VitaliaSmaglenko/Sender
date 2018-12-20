<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 19.12.18
 * Time: 16:22
 */

class Render
{
    public $context;
    public $params = [];

    public function rendering($view, $params)
    {
        $viewFile = $this->findViewFile($view, $params);

        //return $this->renderFile($viewFile, $params);
    }

    protected function findViewFile($view, $params, $context = null)
    {

        $path = 'view/'.$view.'.php';
        $this->renderPhpFile($path, $params);
        return $path;
    }


    public function renderFile($viewFile, $params = [], $context = null)
    {

        $viewFile = $requestedFile = Yii::getAlias($viewFile);


        if ($this->theme !== null) {
            $viewFile = $this->theme->applyTo($viewFile);
        }
        if (is_file($viewFile)) {
            $viewFile = FileHelper::localize($viewFile);
        } else {
            throw new ViewNotFoundException("The view file does not exist: $viewFile");
        }
        $oldContext = $this->context;
        if ($context !== null) {
            $this->context = $context;
        }
        $output = '';
        $this->_viewFiles[] = [
            'resolved' => $viewFile,
            'requested' => $requestedFile
        ];
        if ($this->beforeRender($viewFile, $params)) {
            Yii::debug("Rendering view file: $viewFile", __METHOD__);
            $ext = pathinfo($viewFile, PATHINFO_EXTENSION);
            if (isset($this->renderers[$ext])) {
                if (is_array($this->renderers[$ext]) || is_string($this->renderers[$ext])) {
                    $this->renderers[$ext] = Yii::createObject($this->renderers[$ext]);
                }
                /* @var $renderer ViewRenderer */
                $renderer = $this->renderers[$ext];
                $output = $renderer->render($this, $viewFile, $params);
            } else {
                $output = $this->renderPhpFile($viewFile, $params);
            }
            $this->afterRender($viewFile, $params, $output);
        }
        array_pop($this->_viewFiles);
        $this->context = $oldContext;
        return $output;
    }

    public function renderPhpFile($path, $_params_ = [])
    {
       // $_obInitialLevel_ = ob_get_level();
       // echo $path;
        print_r($_params_);
        ob_start();
        extract($_params_, EXTR_OVERWRITE);


        try {
            require $path;

            return ob_get_clean();
        } catch (Exception $e) {
            throw new Exception('NOOOOO');

        }


      //  require $path;

      //  return ob_get_clean();

        /*
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        extract($_params_, EXTR_OVERWRITE);

        try {
            require $_file_;
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
        */
    }
}