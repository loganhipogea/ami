<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\httpclient;
use yii;
use yii\web\Cookie;
use yii\web\HeaderCollection;

/**
 * Response represents HTTP request response.
 *
 * @property-read bool $isOk Whether response is OK. This property is read-only.
 * @property-read string $statusCode Status code. This property is read-only.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class Response extends Message
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        //yii::error('ingresando a la funcion',__FUNCTION__);
        $data = parent::getData();
       // yii::error('parent::getData() '.$data,__FUNCTION__);
        if ($data === null) {
            //yii::error('uY DATA E SNULO ',__FUNCTION__); 
        //yii::error('Sacando Content ',__FUNCTION__);
            $content = $this->getContent();
            //yii::error('Content ',__FUNCTION__);
            // yii::error($content,__FUNCTION__);
            if (!empty($content)) {
                 /*yii::error('content no es empty ',__FUNCTION__); 
                   yii::error('content no es empty ',__FUNCTION__); 
                   yii::error('llamando a data = this->getParser()->parse(this)',__FUNCTION__); 
                */$data = $this->getParser()->parse($this);
                /* yii::error('data',__FUNCTION__); 
                  yii::error($data,__FUNCTION__); */
                  
                $this->setData($data);
            }
        }
         /*yii::error('retirnando data',__FUNCTION__);
           yii::error($data,__FUNCTION__); */
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookies()
    {
        $cookieCollection = parent::getCookies();
        if ($cookieCollection->getCount() === 0 && $this->getHeaders()->has('set-cookie')) {
            $cookieStrings = $this->getHeaders()->get('set-cookie', [], false);
            foreach ($cookieStrings as $cookieString) {
                $cookieCollection->add($this->parseCookie($cookieString));
            }
        }
        return $cookieCollection;
    }

    /**
     * Returns status code.
     * @throws Exception on failure.
     * @return string status code.
     */
    public function getStatusCode()
    {
        $headers = $this->getHeaders();
        if ($headers->has('http-code')) {
            // take into account possible 'follow location'
            $statusCodeHeaders = $headers->get('http-code', null, false);
            return empty($statusCodeHeaders) ? null : end($statusCodeHeaders);
        }
        throw new Exception('Unable to get status code: referred header information is missing.');
    }

    /**
     * Checks if response status code is OK (status code = 20x)
     * @return bool whether response is OK.
     * @throws Exception
     */
    public function getIsOk()
    {
        return strncmp('20', $this->getStatusCode(), 2) === 0;
    }

    /**
     * Returns default format automatically detected from headers and content.
     * @return string|null format name, 'null' - if detection failed.
     */
    protected function defaultFormat()
    {
        yii::error('ingresando a la funcion default format de RESPONSE',__FUNCTION__);
        yii::error('Headers()');
        yii::error($this->getHeaders(),__FUNCTION__);
        $format = $this->detectFormatByHeaders($this->getHeaders());
        if ($format === null) {
            yii::error('Formato salio null ',__FUNCTION__); 
             yii::error('aHORA CON detectFormatByContent',__FUNCTION__);
             
            $format = $this->detectFormatByContent($this->getContent());
        }
 yii::error('EL FORMATO ES ',__FUNCTION__);
 yii::error($format,__FUNCTION__);
        return $format;
    }

    /**
     * Detects format from headers.
     * @param HeaderCollection $headers source headers.
     * @return null|string format name, 'null' - if detection failed.
     */
    protected function detectFormatByHeaders(HeaderCollection $headers)
    {
         yii::error('headers',__FUNCTION__);
        yii::error($headers,__FUNCTION__);
        $contentTypeHeaders = $headers->get('content-type', null, false);
       yii::error($contentTypeHeaders,__FUNCTION__);

        if (!empty($contentTypeHeaders)) {
            $contentType = end($contentTypeHeaders);
           yii::error('end(contentTypeHeaders)',__FUNCTION__);
            yii::error(end($contentTypeHeaders),__FUNCTION__);
            if (stripos($contentType, 'json') !== false) {
                return Client::FORMAT_JSON;
            }
            if (stripos($contentType, 'urlencoded') !== false) {
                return Client::FORMAT_URLENCODED;
            }
            if (stripos($contentType, 'xml') !== false) {
                return Client::FORMAT_XML;
            }
        }

        return null;
    }

    /**
     * Detects response format from raw content.
     * @param string $content raw response content.
     * @return null|string format name, 'null' - if detection failed.
     */
    protected function detectFormatByContent($content)
    {
        if (preg_match('/^(\\{|\\[\\{).*(\\}|\\}\\])$/is', $content)) {
            return Client::FORMAT_JSON;
        }
        if (preg_match('/^([^=&])+=[^=&]+(&[^=&]+=[^=&]+)*$/', $content)) {
            return Client::FORMAT_URLENCODED;
        }
        if (preg_match('/^<\?xml.*>$/s', $content)) {
            return Client::FORMAT_XML;
        }
        return null;
    }

    /**
     * Parses cookie value string, creating a [[Cookie]] instance.
     * @param string $cookieString cookie header string.
     * @return Cookie cookie object.
     */
    private function parseCookie($cookieString)
    {
        $params = [];
        $pairs = explode(';', $cookieString);
        foreach ($pairs as $number => $pair) {
            $pair = trim($pair);
            if (strpos($pair, '=') === false) {
                $params[$this->normalizeCookieParamName($pair)] = true;
            } else {
                list($name, $value) = explode('=', $pair, 2);
                if ($number === 0) {
                    $params['name'] = $name;
                    $params['value'] = urldecode($value);
                } else {
                    $params[$this->normalizeCookieParamName($name)] = urldecode($value);
                }
            }
        }

        $cookie = new Cookie();
        foreach ($params as $name => $value) {
            if ($cookie->canSetProperty($name)) {
                // Cookie string may contain custom unsupported params
                $cookie->$name = $value;
            }
        }
        return $cookie;
    }

    /**
     * @param string $rawName raw cookie parameter name.
     * @return string name of [[Cookie]] field.
     */
    private function normalizeCookieParamName($rawName)
    {
        static $nameMap = [
            'expires' => 'expire',
            'httponly' => 'httpOnly',
            'max-age' => 'maxAge',
        ];
        $name = strtolower($rawName);
        if (isset($nameMap[$name])) {
            $name = $nameMap[$name];
        }
        return $name;
    }

    /**
     * @return ParserInterface message parser instance.
     * @throws Exception if unable to detect parser.
     * @throws \yii\base\InvalidConfigException
     */
    private function getParser()
    {
      //yii::error('Entrnado al afuncion getParser',__FUNCTION__);
      //yii::error('format = this->getFormat()',__FUNCTION__);
        $format = $this->getFormat();
        
        //if(is_null($format))$format=Client::FORMAT_URLENCODED;
        yii::error('format s egun la funcion getPARSER DE rESPONSE',__FUNCTION__);
         yii::error($format,__FUNCTION__);
          //yii::error($format,__FUNCTION__);
         //yii::error('retornando this->client->getParser(format) ',__FUNCTION__);
        return $this->client->getParser($format);
    }
}