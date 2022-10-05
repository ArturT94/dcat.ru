<?php
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('soap.wsdl_cache_ttl', '0');
ini_set('default_socket_timeout', 60000);
/**
 * Класс для отправки запросов через soap протокол
 *
 */
class SoapProxy
{
	private static $SoapClient = null;
	private static $soapLastError = null;
	private $uri;
	private $params;
	public $notLogOperation = false;
	public $asArray = true;
    private $rawData = null;

    /**
	 * Поулчить последнюю ошибку
	 * @return string
	 */
	public function getError()
	{
		return self::$soapLastError;
	}
	/*
	 * Получение данных в неконвертированном виде
	 * @return stdObject
	*/
	public function getRawData()
	{
        return $this->rawData;
	}
    /**
     * Поулчить последнюю ошибку
     * @return string
     */
	public function getErrorString()
	{
		return self::$soapLastError;
	}
    /**
     * Поулчить последнюю ошибку
     * @return boolean (true:false)
     */
	public function hasError()
	{
		return (empty(self::$soapLastError) || self::$soapLastError==null) ? false : true;
	}
    /**
     * Конструктор класса
	 * @param $uri     string     адрес сервиса
	 * @param $params     array     массив настроек соединения
     * @return object объект класса
     */
	public function __construct($uri, $params)
	{
		$this->params = $params;
		$this->uri = $uri;
        $this->notLogOperation = false;
	}
    /**
     * Выполнить запрос
     * @param $method     string     имя метода
     * @param $params     array     массив параметров
	 * @param $asArray     boolean   вернуть массив или объект
     * @return результат запроса
     */
    public function __soapCall($method, $params, $asArray = true)
    {
        return $this->soapCall($method, $params[0], $asArray);
    }
    /**
     * Магический метод "Выполнить запрос"
     * @param $method     string     имя метода
     * @param $params     array     массив параметров
     * @return результат запроса
     */
	public function __call($method, $params)
	{
		return $this->soapCall($method, $params[0]);
	}
    /**
     * Текст последнего запроса в всиде строки
     * @return string текст запроса
     */
	public function getRequest()
	{
		$soapClient = $this->getSoapClient();
		return htmlspecialchars($soapClient->__getLastRequest());
	}
    /**
     * екст последнего ответа в всиде строки
     * @return string текст ответа
     */
	public function getResponse()
	{
		$soapClient = $this->getSoapClient();
		return htmlspecialchars($soapClient->__getLastResponse());
	}
    /**
     * Список поддерживаемых методов сервиса
     * @return (array) результат зпроса
     */
	public function getMethodList()
	{
		$soapClient = $this->getSoapClient();
		return $soapClient->__getFunctions();
	}
    /**
     * Список поддерживаемых типов сервиса
     * @return (array) результат зпроса
     */
	public function getTypesList()
	{
   	 	$soapClient = $this->getSoapClient();
    	return $soapClient->__getTypes();
	}
    /**
     * Реализация самого запроса и его обработка
     * @param $operation     string     имя метода
     * @param $params     array     массив параметров запроса
	 * @param $asArray     boolean   вернуть массив или объект
     * @return (array|object) результат зпроса
     */
	public function soapCall($operation, $params = [], $asArray = true)
	{
		if (!is_string($operation))
            throw new \InvalidArgumentException();
        $return = null;
        $response = null;
        try {
            self::$soapLastError = null;
            $soapClient = $this->getSoapClient();
            $response = $soapClient->$operation($params);
            $this->rawData = $response;
            $arToLog = [
                'result' => 'success',
            	'operation' => $operation,
				'params' => $params,
				'response' => $this->soapResponseToArray($response),
			];
            if (isset($response->return) || isset($response->Message)) {
            	if($asArray && $this->asArray==true)
                	$return = $this->soapResponseToArray($response);
            	else
                    $return = $response;
            } else {
                self::$soapLastError = 'No response::return property!';
            }
        } catch (\Exception $e) {
            self::$soapLastError = $e->getMessage();
            $arToLog = [
                'result' => 'error',
                'error' => self::$soapLastError,
                'request' => $this->getRequest(),
                'response' => $this->getResponse(),
            ];
        }
        if($this->notLogOperation===false)
            elDiabloLog($_SERVER['DOCUMENT_ROOT'].'/soaplog/SoapProxy_'.date("Ymd").'.log', "[" . date("Y-m-d H:i:s",time()) . "] ".var_export($arToLog,1)."\r\n", FILE_APPEND);
            //TUtils::log($arToLog, '/soaplog/SoapProxy_'.date("Ymd").'.log');
        return $return;
	}
    /**
     * Реализация самого запроса и его обработка
     * @param $data     object     результат запроса
     * @return array массив ответа
     */
	private function soapResponseToArray($data)
    {
        if (is_object($data)) {
            $data = (array)$data;
        }
        if (is_array($data)) {
            foreach($data as $k=>$v) {
                $data[$k] = $this->soapResponseToArray($v);
            }
        }
        return $data;
    }
    /**
     * Реализация синглтона для единого соединения.
     * @return object объект soap клиента
     */
	private function getSoapClient()
	{
        if (is_null(self::$SoapClient)) {
            self::$SoapClient = new \SoapClient($this->uri, $this->params);
        }
        return self::$SoapClient;
    }
}
?>
