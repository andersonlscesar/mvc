<?php
namespace App\Http;

class Response
{
    private $httpCode = 200;
    private $headers = [];
    private $content;
    private $contentType;

    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    private function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeaders('Content-type', $contentType);
    }

    private function addHeaders($key, $value)
    {
        $this->headers[$key] = $value;
    }

    private function sendHeaders()
    {
        http_response_code($this->httpCode);
        foreach($this->headers as $key => $value) {
            header($key.': '.$value);
        }
    }

    public function sendResponse()
    {
        $this->sendHeaders();
        switch($this->contentType) {
            case 'text/html':
                print $this->content;
                exit;
        }
    }
}