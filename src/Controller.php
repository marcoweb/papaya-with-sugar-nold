<?php
namespace PapayaWithSugar;

class Controller {
    private $requestInfo;


    public function __construct(array $requestInfo) {
        $this->requestInfo = $requestInfo;
    }
    
    public function getRequestInfo() {
        return $this->requestInfo;
    }

    public function view(array $params = [], string $viewName = null) {
        foreach($params as $k => $v) {
            $$k = $v;
        }
        $_template = 'default';
        $viewFile = '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->requestInfo['controller'] . DIRECTORY_SEPARATOR;
        $viewFile .= (is_null($viewName)) ? $this->requestInfo['action'] : $viewName;
        $viewFile .= '.phtml';

        $_viewContent = '';
        ob_start();
        include($viewFile);
        $_viewContent = ob_get_clean() . "\n";
        $teplateFile = '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . '_templates' . DIRECTORY_SEPARATOR . $_template . '.phtml';
        ob_start();
        include($teplateFile);
        $result = ob_get_clean();
        
        return $result;
    }
}