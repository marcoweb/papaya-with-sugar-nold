<?php
namespace PapayaWithSugar;

class Application {
    private $requestStringArray;
    private $requestInfo = [];
    
    private function parseRequest() {
        $this->requestInfo['requestString'] = $_SERVER['REQUEST_URI'];
        $this->requestInfo['requestStringArray'] = ($this->requestInfo['requestString'] != '/') ?
            explode('/', trim($this->requestInfo['requestString'], '/')) : [];
        $this->requestInfo['action'] = (count($this->requestInfo['requestStringArray']) > 1) ?
            end($this->requestInfo['requestStringArray']) : 'index';
        $this->requestInfo['controller'] = (count($this->requestInfo['requestStringArray']) > 0) ?
            (end($this->requestInfo['requestStringArray']) == $this->requestInfo['action']) ?
                implode(DIRECTORY_SEPARATOR, array_slice($this->requestInfo['requestStringArray'],0, count($this->requestInfo['requestStringArray']) -1)) :
                implode(DIRECTORY_SEPARATOR, $this->requestInfo['requestStringArray'])
            : 'Home';
    }

    public function request() {
        $this->parseRequest();
        $controllerClass = __NAMESPACE__ . '\Controllers\\' . $this->requestInfo['controller'] . 'Controller';
        $controllerObject = new $controllerClass($this->requestInfo);
        echo call_user_func_array([$controllerObject, $this->requestInfo['action']], []);
    }
}