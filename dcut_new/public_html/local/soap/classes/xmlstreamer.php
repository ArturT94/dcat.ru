<?php
/**
 * Класс для потокового чтения XML файлов большого размера
 *
 */
abstract class XmlStreamer
{
    private $closeWhenFinished = false;
    private $handle;
    private $totalBytes;
    private $readBytes = 0;
    private $nodeIndex = 0;
    private $chunk = "";
    private $chunkSize;
    private $readFromChunkPos;
    private $rootNode;
    private $customRootNode;
    /**
     * Конструктор класса
     * @param $mixed             Путь к XML или дескриптор файла
     * @param $chunkSize         Байт за цикл (по умолчанию 16 KiB)
     * @param $customRootNode    Начальная нода (необязательно)
     * @param $totalBytes        Размер файла - ОБЯЗАТЕЛЬНО если передаем дескриптор а не путь
     * @param $customChildNode   Нода, которую искать (необязательно)
     */
    public function __construct($mixed, $chunkSize = 16384, $customRootNode = null, $totalBytes = null, $customChildNode = null) {
        if (is_string($mixed)) {
            $this->handle = fopen($mixed, "r");
            $this->closeWhenFinished = true;
            if (isset($totalBytes)) {
                $this->totalBytes = $totalBytes;
            } else {
                $this->totalBytes = filesize($mixed);
            }
        } else if (is_resource($mixed)){
            $this->handle = $mixed;
            if (!isset($totalBytes)) {
                throw new \Exception("totalBytes parameter required when supplying a file handle.");
            }
            $this->totalBytes = $totalBytes;
        }
        $this->chunkSize = $chunkSize;
        $this->customRootNode = $customRootNode;
        $this->customChildNode = $customChildNode;
        $this->init();
    }

    public function init()
    {
    }

    public function chunkCompleted()
    {
    }
    /**
     * Вызывается для каждой найденой дочерней ноды
     * @param $xmlString     XML строка
     * @param $elementName   Имя ноды
     * @param $nodeIndex     Номер ноды (отсчет с ноля!)
     * @return               true или false false - остановит работу по файлу.
     */
    abstract public function processNode($xmlString, $elementName, $nodeIndex);

    public function getReadBytes()
    {
        return $this->readBytes;
    }

    public function getTotalBytes()
    {
        return $this->totalBytes;
    }
    /**
     * Парсинг.
     * @return void
     */
    public function parse()
    {
        $counter = 0;
        $continue = true;
        while ($continue) {
            $continue = $this->readNextChunk();
            $counter++;
            if (!isset($this->rootNode)) {
                if (isset($this->customRootNode)) {
                    $customRootNodePos = strpos($this->chunk, "<{$this->customRootNode}");
                    if ($customRootNodePos !== false) {
                        $closer = strpos(substr($this->chunk, $customRootNodePos), ">");
                        $readFromChunkPos = $customRootNodePos + $closer + 1;
                        if (isset($this->customChildNode)) {
                            $customChildNodePos = strpos(substr($this->chunk, $readFromChunkPos), "<{$this->customChildNode}");
                            if ($customChildNodePos !== false) {
                                $readFromChunkPos = $readFromChunkPos + $customChildNodePos;
                            } else {
                                continue;
                            }
                        }
                        $this->rootNode = $this->customRootNode;
                        $this->readFromChunkPos = $readFromChunkPos;
                    } else {
                        $this->readFromChunkPos = 0;
                        $this->chunk = "";
                        continue;
                    }
                } else {
                    preg_match('/<([^>\?]+)>/', $this->chunk, $matches);
                    if (isset($matches[1])) {
                        $this->rootNode = $matches[1];
                        $this->readFromChunkPos = strpos($this->chunk, $matches[0]) + strlen($matches[0]);
                    } else {
                        $this->readFromChunkPos = 0;
                        $this->chunk = "";
                        continue;
                    }
                }
            }
            while (true) {
                $fromChunkPos = substr($this->chunk, $this->readFromChunkPos);
                preg_match('/<([^>]+)>/', $fromChunkPos, $matches);
                if (isset($matches[1])) {
                    $element = $matches[1];
                    $spacePos = strpos($element, " ");
                    $crPos =    strpos($element, "\r");
                    $lfPos =    strpos($element, "\n");
                    $tabPos =   strpos($element, "\t");
                    $aPositionsIn = array($spacePos, $crPos, $lfPos, $tabPos);
                    $aPositions = array();
                    foreach($aPositionsIn as $iPos){
                        if($iPos !== false){
                            $aPositions[] = $iPos;
                        }
                    }
                    $minPos = $aPositions===array() ? false : min($aPositions);
                    if($minPos !== false && $minPos != 0){
                        $sElementName = substr($element, 0, $minPos);
                        $endTag = "</".$sElementName.">";
                    } else {
                        $sElementName = $element;
                        $endTag = "</$sElementName>";
                    }
                    $endTagPos = false;
                    $lastCharPos = strlen($element)-1;
                    if(substr($element, $lastCharPos) == "/"){
                        $endTag = "/>";
                        $endTagPos = $lastCharPos;
                        $iPos = strpos($fromChunkPos, "<");
                        if($iPos !== false){
                            $endTagPos += $iPos +1;
                        }
                    }
                    if($endTagPos === false){
                        $endTagPos = strpos($fromChunkPos, $endTag);
                    }
                    if ($endTagPos !== false) {
                        $endTagEndPos = $endTagPos + strlen($endTag);
                        $elementWithChildren = trim(substr($fromChunkPos, 0, $endTagEndPos));
                        $continueParsing = $this->processNode($elementWithChildren, $sElementName, $this->nodeIndex++);
                        $this->chunk = substr($this->chunk, strpos($this->chunk, $endTag) + strlen($endTag));
                        $this->readFromChunkPos = 0;
                        if (isset($continueParsing) && $continueParsing === false) {
                            $this->chunkCompleted();
                            break(2);
                        }
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
            $this->chunkCompleted();
        }
        if ($this->closeWhenFinished) {
            fclose($this->handle);
        }
        return isset($this->rootNode);
    }
    /**
     * Прочитать следующий чанк.
     * @return boolean
     */
    private function readNextChunk()
    {
        $this->chunk .= fread($this->handle, $this->chunkSize);
        $this->readBytes += $this->chunkSize;
        if ($this->readBytes >= $this->totalBytes) {
            $this->readBytes = $this->totalBytes;
            return false;
        }
        return true;
    }
}