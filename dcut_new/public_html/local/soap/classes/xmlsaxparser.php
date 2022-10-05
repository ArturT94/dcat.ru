<?php
/**
 * Класс для потокового чтения XML файлов большого размера
 *
 */
class SaxXMLReader extends XMLReader
{
    protected $callback = array();
    protected $currentDepth = 0;
    protected $prevDepth = 0;
    protected $nodesParsed = array();
    protected $nodesType = array();
    protected $nodesCounter = array();

    /**
     * Регистрация обработчика
     * @param $xpath     string     имя ноду
     * @param $callback     callable     метод для обработки ноды
     * @param $nodeType     string     тип ноды
     * @return $this object объект класса
     */
    public function registerCallback($xpath, $callback, $nodeType = XMLREADER::ELEMENT)
    {
        if (isset($this->callback[$nodeType][$xpath])) {
            throw new Exception("Такой callback уже есть '$xpath':$nodeType.");
        }
        if (!is_callable($callback)) {
            throw new Exception("Сallback не функция '$xpath':$nodeType.");
        }
        $this->callback[$nodeType][$xpath] = $callback;
        return $this;
    }
    /**
     * Отмена регистрации обработчика
     * @param $xpath     string     имя ноду
     * @param $callback     callable     метод для обработки ноды
     * @return $this object объект класса
     */
    public function unRegisterCallback($xpath, $nodeType = XMLREADER::ELEMENT)
    {
        if (!isset($this->callback[$nodeType][$xpath])) {
            throw new Exception("Не задан callback для '$xpath':$nodeType.");
        }
        unset($this->callback[$nodeType][$xpath]);
        return $this;
    }
    /**
     * Рабочий цикл
     * @return $read array
     */
    public function read()
    {
        $read = parent::read();
        if ($this->depth < $this->prevDepth) {
            if (!isset($this->nodesParsed[$this->depth])) {
                throw new Exception("Ошибка xml: потерян элемент в SaxXMLReader::\$nodesParsed");
            }
            if (!isset($this->nodesCounter[$this->depth])) {
                throw new Exception("Ошибка xml: потерян элемент в SaxXMLReader::\$nodesCounter");
            }
            if (!isset($this->nodesType[$this->depth])) {
                throw new Exception("Ошибка xml: потерян элемент в SaxXMLReader::\$nodesType");
            }
            $this->nodesParsed = array_slice($this->nodesParsed, 0, $this->depth + 1, true);
            $this->nodesCounter = array_slice($this->nodesCounter, 0, $this->depth + 1, true);
            $this->nodesType = array_slice($this->nodesType, 0, $this->depth + 1, true);
        }
        if (isset($this->nodesParsed[$this->depth]) && $this->localName == $this->nodesParsed[$this->depth] && $this->nodeType == $this->nodesType[$this->depth]) {
            $this->nodesCounter[$this->depth] = $this->nodesCounter[$this->depth] + 1;
        } else {
            $this->nodesParsed[$this->depth] = $this->localName;
            $this->nodesType[$this->depth] = $this->nodeType;
            $this->nodesCounter[$this->depth] = 1;
        }
        $this->prevDepth = $this->depth;
        return $read;
    }
    /**
     * Получить текущую ноду
     * @return $result array
     */
    public function currentXpath($nodesCounter = false)
    {
        if (count($this->nodesCounter) != count($this->nodesParsed) && count($this->nodesCounter) != count($this->nodesType)) {
            throw new Exception("Пустой файл");
        }
        $result = "";
        foreach ($this->nodesParsed as $depth => $name) {
            switch ($this->nodesType[$depth]) {
                case self::ELEMENT:
                    $result .= "/" . $name;
                    if ($nodesCounter) {
                        $result .= "[" . $this->nodesCounter[$depth] . "]";
                    }
                    break;

                case self::TEXT:
                case self::CDATA:
                    $result .= "/text()";
                    break;

                case self::COMMENT:
                    $result .= "/comment()";
                    break;

                case self::ATTRIBUTE:
                    $result .= "[@{$name}]";
                    break;
            }
        }
        return $result;
    }
    /**
     * Парсинг.
     * @return void
     */
    public function parse()
    {
        if (empty($this->callback)) {
            throw new Exception("Не задан ни один callback.");
        }
        $continue = true;
        while ($continue && $this->read()) {
            if (!isset($this->callback[$this->nodeType])) {
                continue;
            }
            if (isset($this->callback[$this->nodeType][$this->name])) {
                $continue = call_user_func($this->callback[$this->nodeType][$this->name], $this);
            } else {
                $xpath = $this->currentXpath(false);
                if (isset($this->callback[$this->nodeType][$xpath])) {
                    $continue = call_user_func($this->callback[$this->nodeType][$xpath], $this);
                } else {
                    $xpath = $this->currentXpath(true);
                    if (isset($this->callback[$this->nodeType][$xpath])) {
                        $continue = call_user_func($this->callback[$this->nodeType][$xpath], $this);
                    }
                }
            }
        }
    }

    /**
     * Сформировать документ.
     * @return xml
     */
    public function expandXpath($path, $version = "1.0", $encoding = "UTF-8", $className = null)
    {
        return $this->expandSimpleXml($version, $encoding, $className)->xpath($path);
    }

    /**
     * Сформировать документ.
     * @return xml
     */
    public function expandString($version = "1.0", $encoding = "UTF-8", $className = null)
    {
        return $this->expandSimpleXml($version, $encoding, $className)->asXML();
    }

    /**
     * Сформировать документ.
     * @return xml
     */
    public function expandSimpleXml($version = "1.0", $encoding = "UTF-8", $className = null)
    {
        $element = $this->expand();
        $document = new DomDocument($version, $encoding);
        if ($element instanceof DOMCharacterData) {
            $nodeName = array_splice($this->nodesParsed, -2, 1);
            $nodeName = (isset($nodeName[0]) && $nodeName[0] ? $nodeName[0] : "root");
            $node = $document->createElement($nodeName);
            $node->appendChild($element);
            $element = $node;
        }
        $node = $document->importNode($element, true);
        $document->appendChild($node);
        return simplexml_import_dom($node, $className);
    }

    /**
     * Сформировать документ.
     * @return xhtml
     */
    public function expandDomDocument($version = "1.0", $encoding = "UTF-8")
    {
        $element = $this->expand();
        $document = new DomDocument($version, $encoding);
        if ($element instanceof DOMCharacterData) {
            $nodeName = array_splice($this->nodesParsed, -2, 1);
            $nodeName = (isset($nodeName[0]) && $nodeName[0] ? $nodeName[0] : "root");
            $node = $document->createElement($nodeName);
            $node->appendChild($element);
            $element = $node;
        }
        $node = $document->importNode($element, true);
        $document->appendChild($node);
        return $document;
    }

}
