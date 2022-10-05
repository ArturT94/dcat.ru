<?php
/**
 * Класс со вспомогательными методами
 *
 */
class TUtils
{
    protected static $logFileSize = '300K';//B,K,M,G
    protected static $logFileName = 'tlog';
    protected static $logFileExt = ".txt";
    protected static $logFilePath = NULL;
    protected static $logPathAndName;
    protected static $emailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
    protected static $cacheDir = '/local/custom_cache/';
    protected static $cacheSuffix = 'tcache.php';

    /**
     * Записать в лог значение
     * @param $message     (string|array|object|integer)     сообщение для логирования
     * @param $fileName     string     имя лога
     * @param $dir     string     папка
     * @return boolean да или нет
     */
    public static function log($message, $fileName = NULL, $dir = NULL)
    {

        if ($dir)
            self::$logFilePath = dirname($dir . $fileName);
        else
            self::$logFilePath = dirname($_SERVER['DOCUMENT_ROOT'] . $fileName);
        if (!is_dir(self::$logFilePath)) {
            if (!mkdir(self::$logFilePath, BX_DIR_PERMISSIONS,true)) {
                return 0;
            }
        }
        if ($fileName)
            self::$logFileName = $fileName;
        if (empty(self::fileExt())) {
            self::$logFileName .= self::$logFileExt;
        }


        self::$logPathAndName = self::$logFilePath . '/' . self::$logFileName;
        if (file_exists(self::$logPathAndName) && filesize(self::$logPathAndName) > self::fileSizeInBytes()) {
            self::rotateLogFile();
        }

        $fp = fopen(self::$logPathAndName, "a+");
        if ($fp) {
            fwrite($fp, var_export($message, 1));
            fwrite($fp, "\n");
        } else {
            return 0;
        }
        fclose($fp);
        return 1;
    }


    private function rotateLogFile()
    {
        $index = 0;
        $fileName = self::fileName();

        foreach (glob($fileName . ".*" . self::$logFileExt) as $file) {
            $index++;
        }

        $fileExt = self::fileExt();
        if (empty($fileExt))
            $fileExt = self::$logFileExt;
        $renameFileName = self::$logFilePath . '/' . $fileName . "." . $index . "." . $fileExt;
        return rename(self::$logPathAndName, $renameFileName);

    }

    private function fileName()
    {
        $path_parts = pathinfo(self::$logPathAndName);
        return $path_parts['filename'];

    }

    private function fileExt()
    {
        $path_parts = pathinfo(self::$logFileName);
        return $path_parts['extension'];
    }

    private function fileSizeInBytes()
    {
        $digits = preg_replace("/[^0-9]/", '', self::$logFileSize);
        $size = preg_replace("/[0-9]/", '', self::$logFileSize);
        switch ($size) {
            default:
            case 'B':
                return $digits;//bytes
            case 'K':
                return $digits * 1024;//KB
            case 'M':
                return $digits * 1024 * 1024;//MB
            case 'G':
                return $digits * 1024 * 1024 * 1024;//GB
        }
    }

    public static function pr($message, $title = NULL)
    {
        if ($title)
            echo '<h2>' . $title . '</h2>';
        echo '<pre>' . var_export($message, true) . '</pre>';
    }

    /**
     * Получит рандомную строку
     * @param $length     integer     длина строки
     * @param $bUseSpecSymbols     boolean     использовать спец.символы
     * @return string
     */
    public static function randomString($length = 10, $bUseSpecSymbols = false)
    {
        $strAlph = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        if ($bUseSpecSymbols) {
            $strAlph .= '!@#$%^&*()-_=+{}[]';
        }
        $alphStrLength = strlen($strAlph) - 1;
        $strResult = '';
        while (strlen($strResult) < $length) {
            $strResult .= $strAlph[rand(0, $alphStrLength)];

        }
        return $strResult;
    }
    /**
     * Получить только цифры из строки
     * @param $length     string     Входная строка
     * @return string
     */
    public static function getOnlyDigits($str)
    {
        return preg_replace('/[^0-9]/', '', $str);
    }
    /**
     * Получить только НЕ цифры из строки
     * @param $length     string     Входная строка
     * @return string
     */
    public static function getNotDigits($str)
    {
        return preg_replace('/[0-9]/', '', $str);
    }
    /**
     * Это Email?
     * @param $strEmail     string     длина строки
     * @return boolean
     */
    public static function isEmail($strEmail)
    {
        return preg_match(self::$emailPattern, $strEmail);

    }

    /**
     * Это мобильный телефон из России?
     * @param $strEmail     string     длина строки
     * @return boolean
     */
    public static function isRusMobilePhone($strPhone)
    {
        $strPhone = self::getOnlyDigits($strPhone);
        if (strlen($strPhone) == 10 && $strPhone[0] == '9')
            return true;
        if (strlen($strPhone) == 11 && $strPhone[1] == '9' && ($strPhone[0] == '7' || $strPhone[0] == '8'))
            return true;
        return false;

    }

    /**
     * Склонение слов в зависимости от количества
     * @param $str     string     строка, основа
     * @param $count     integer     цифра
     * @param $arSuffixes     array     окончания
     * @return string
     */
    public static function getWordForm($str, $count, $arSuffixes)
    {
        $count = abs($count);
        $keys = array(2, 0, 1, 1, 1, 2);
        $mod = $count % 100;
        $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod % 10, 5)];
        return $str . $arSuffixes[$suffix_key];
    }

    /**
     * Округлить
     * @param $sum     integer     число
     * @param $to     integer     до какого размера
     * @return boolean
     */
    public static function round_to($sum, $to)
    {
        if ($to <= 0) {
            return $sum;
        }
        return ceil($sum / $to) * $to;
    }

    /**
     * Очистить строку от всех html сущностей
     * @param $str     string     строка для очистки
     * @return string
     */
    public static function clearHtml($str)
    {
        return strip_tags(htmlspecialchars_decode($str));
    }

    /**
     * ФОрматировать цену
     * @param $strPrice     (integer|float)     число для вывода
     * @param $decimals     integer     скольк символов после запятой
     * @param $delimiter     string     разделитель
     * @return string
     */
    public static function price_format($strPrice, $decimals = 0, $delimiter = false)
    {
        if (!$delimiter)
            $delimiter = '.';
        return number_format($strPrice, $decimals, $delimiter, ' ');
    }

    /**
     * Читает файл csv и возвращает его как массив значений
     * @param $file
     * @param string $delimiter
     * @param bool $bFirstLineIsHeader
     * @return array
     * @throws Exception
     */
    public static function readCSV($file, $delimiter = ';', $bFirstLineIsHeader = false)
    {
        $filePoint = fopen($file, 'r');
        if (!$filePoint) {
            throw new Exception("Could not open a file " . $file);
        }
        $arResult = [];
        while ($arData = fgetcsv($filePoint, 0, $delimiter)) {
            $arResult[] = $arData;
        }
        if ($bFirstLineIsHeader && isset($arResult[0]))
            unset($arResult[0]);

        return $arResult;
    }
    /**
     * Читает файл csv и возвращает его как массив значений
     * @param $file
     * @param string $delimiter
     * @param bool $bFirstLineIsHeader
     * @return array
     * @throws Exception
     */
    public static function writeCSV($file, $data, $delimiter = ';')
    {
        if (empty($data)) {
            return false;
        }
        if (is_string($data)) {
            $data = explode($delimiter, $data);
        }
        $filePoint = fopen($file, 'a+');
        if (!$filePoint) {
            throw new Exception("Could not create a file " . $file);
        }
        return fputcsv($filePoint, $data, $delimiter);
    }

    /**
     *  Возвращает название месяца как массив, где 0 элемент - в именительном падеже, 1 элемента - в родительном падеже
     * @param $monthNumber
     * @return mixed
     */
    public static function getMonthName($monthNumber)
    {
        if ($monthNumber < 1)
            $monthNumber = 1;
        if ($monthNumber > 12)
            $monthNumber = 12;
        $monthAr = array(
            1 => array('Январь', 'Января', 'Янв.'),
            2 => array('Февраль', 'Февраля', 'Фев.'),
            3 => array('Март', 'Марта', 'Мар.'),
            4 => array('Апрель', 'Апреля', 'Апр.'),
            5 => array('Май', 'Мая', 'Май'),
            6 => array('Июнь', 'Июня', 'Июн.'),
            7 => array('Июль', 'Июля', 'Июл.'),
            8 => array('Август', 'Августа', 'Авг.'),
            9 => array('Сентябрь', 'Сентября', 'Сен.'),
            10 => array('Октябрь', 'Октября', 'Окт.'),
            11 => array('Ноябрь', 'Ноября', 'Ноя.'),
            12 => array('Декабрь', 'Декабря', 'Дек.')
        );
        return $monthAr[$monthNumber];
    }

    /**
     * Сортирует двумерный массив $arr по вложенным массивам по ключу $field и направление $sortBy
     * @param $arr
     * @param $field
     * @param string $sortBy
     */
    public static function custom_array_sort_by(&$arr, $field, $sortBy = 'asc')
    {
        usort($arr, function ($a, $b) use ($field, $sortBy) {
            if ($a[$field] == $b[$field])
                return 0;
            if (strtolower($sortBy) == 'asc')
                return ($a[$field] < $b[$field]) ? -1 : 1;//asc
            else
                return ($a[$field] < $b[$field]) ? 1 : -1;//desc
        });

    }

    /**
     * Функция возвращает разницу в днях между двух дат
     * @param $date1
     * @param null $date2
     * @param bool $ignoreInvert
     * @return int|mixed
     */
    public static function diff_date_in_days($date1, $date2 = NULL, $ignoreInvert = true)
    {
        $date1 = new DateTime($date1);
        if (!$date2)
            $date2 = new DateTime();
        else
            $date2 = new DateTime($date2);
        $diff = $date2->diff($date1);
        if ($diff->invert && !$ignoreInvert)
            return ((-1) * $diff->days);
        return $diff->days;
    }

    /**
     * Простая функция записи кэша в файл (на текущую дату)
     * @param $key
     * @param $data
     * @param $ttl
     * @return bool|int
     */
    public static function createCache($key, $data, $ttl = 3600)
    {

        $cacheKey = $key . "_" . self::$cacheSuffix;
        $cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$cacheDir;
        if (!is_dir($cacheDir))
            @mkdir($cacheDir, BX_DIR_PERMISSIONS,true);
        $arResult = [
            'DATA' => serialize($data),
        ];

        $ttl = IntVal($ttl);
        if ($ttl > 0)
            $arResult['DATE_EXPIRED'] = time() + $ttl;
        else
            $arResult['DATE_EXPIRED'] = 'unlimited';
        $sdata = serialize($arResult);
        $sdata = str_replace("'", "\'", $sdata);
        return file_put_contents($cacheDir . $cacheKey, '<?php return \'' . $sdata . '\';?>');
    }

    /**
     * Проверяем, существует ли кэш (на текущую дату)
     * @param $key
     * @return bool
     */
    public static function existCache($key)
    {
        $cacheKey = $key . "_" . self::$cacheSuffix;
        $cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$cacheDir;
        if (file_exists($cacheDir . $cacheKey)) {
            $data = include($cacheDir . $cacheKey);
            $data = unserialize($data);
            if (isset($data['DATE_EXPIRED']) && ($data['DATE_EXPIRED'] == 'unlimited' || time() <= $data['DATE_EXPIRED']))
                return true;
            self::clearCache($key);
        }
        return false;
    }

    /**
     * Читает данные из кэша и возращает их
     * @param $key
     * @return bool|mixed
     */
    public static function readCache($key)
    {
        $cacheKey = $key . "_" . self::$cacheSuffix;
        $cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$cacheDir;
        if (self::existCache($key)) {
            $data = include($cacheDir . $cacheKey);
            $data = unserialize($data);
            $data['DATA'] = unserialize($data['DATA']);
            return $data['DATA'];
        }
        return false;
    }

    /**
     * Удаляет кэш
     * @param $key
     * @return bool|mixed
     */
    public static function clearCache($key)
    {
        if ($key === 'all') {
            $cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$cacheDir;
            foreach (glob($cacheDir . "*_" . self::$cacheSuffix) as $file) {
                unlink($file);
            }

        } else {
            $cacheKey = $key . "_" . self::$cacheSuffix;
            $cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$cacheDir;
            return unlink($cacheDir . $cacheKey);
        }
    }

    /**
     * Удаляет кэш по маске
     * Например, если передать mask как abc то очистятся все файлы кэши, содержащие abc
     * @param $mask
     */
    public static function deleteCacheByMask($mask)
    {
        $cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$cacheDir;
        $pattern = $cacheDir . "*" . $mask . "*" . self::$cacheSuffix;
        foreach (glob($pattern) as $file) {
            unlink($file);
        }
    }

    /**
     * Возвращает дату создания файла
     * @param $cacheKey
     * @param string $format
     * @return bool|false|string
     */
    public static function getCacheCreatedDate($cacheKey, $format = 'd-m-Y H:i')
    {
        $cacheKey = $cacheKey . "_" . self::$cacheSuffix;
        $cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$cacheDir;
        $file = $cacheDir . $cacheKey;
        if (file_exists($file))
            return date($format, filectime($file));
        return false;
    }

    /**
     * Добавляет к текущему URI набор из arParams = array(key=>value)
     * @param array $arParams
     * @return string
     */
    public static function add_GETParamToCurrentURI($arParams)

    {

        if (!empty($_SERVER['REDIRECT_URL']))
            $strResult = $_SERVER['REDIRECT_URL'];
        else
            $strResult = $_SERVER['SCRIPT_NAME'];

        $arParams = array_merge($_GET, $arParams);
        $bFirst = true;
        foreach ($arParams as $key => $value) {
            $delimiter = "&";
            if ($bFirst)
                $delimiter = "?";
            $bFirst = false;
            $strResult .= $delimiter . $key . "=" . $value;
        }
        return $strResult;
    }

    /**
     * Функция добавляет GET параметры $arParams в $url
     * @param $url string
     * @param $arParams array GET параметры
     * @return string
     */
    public static function add_GETParamsToURL($url, $arParams)
    {
        if (!empty($url) && !empty($arParams)) {
            $firstKey = array_keys($arParams)[0];
            $firstValue = array_values($arParams)[0];
            array_shift($arParams);
            if (stripos($url, '?') !== FALSE) {
                $firstDelimiter = "&";
            } else
                $firstDelimiter = '?';
            $url .= $firstDelimiter . $firstKey . '=' . $firstValue;
            foreach ($arParams as $key => $value) {
                $url .= '&' . $key . '=' . $value;
            }
        }
        return $url;
    }

    /**
     * Очищает URL от GET-параметров
     * @param $url string
     * @return string
     */
    public static function clearURL($url)
    {
        return strtok($url, '?');
    }

    /**
     * Простой GET запрос на основе curl
     * @param $url
     * @param array $arData
     * @return mixed
     */
    public static function curl_get($url, $arData = array(), $arHeaders = array())
    {
        $response = false;
        if (!empty($url)) {
            $ch = curl_init();
            if (!empty($arData))
                $url = self::add_GETParamsToURL($url, $arData);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if (!empty($arHeaders))
                curl_setopt($ch, CURLOPT_HTTPHEADER, $arHeaders);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        return $response;

    }

    /**
     * Простой POST на основе CURL
     * @param $url
     * @param $arPostData
     * @param array $arHeaders
     * @return mixed
     */
    public static function curl_post($url, $arPostData, $arHeaders = [])
    {
        $response = false;

        $ch = curl_init();
        $url = self::clearURL($url);
        if (!empty($url)) {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arPostData));  //Post Fields
            if (!empty($arHeaders))
                curl_setopt($ch, CURLOPT_HTTPHEADER, $arHeaders);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        return $response;

    }

    /**
     * Информация по YouTube - видео по урлу
     * @param $url
     * @return mixed
     */
    public static function getYoutubeInfo($url)
    {

        $youtube = "http://www.youtube.com/oembed?url=" . $url . "&format=json";

        $curl = curl_init($youtube);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return json_decode($return, true);

    }

    /**
     * Очищает текст от тегов и дубликатов "пробелов"
     * @param $text
     * @return mixed|string
     */
    public static function onlyText($text)
    {
        $text = trim(strip_tags($text));
        $text = preg_replace("/[\s]{2,}/um", '', $text);
        return $text;
    }
    public static function _e($data)
    {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (!call_user_func(__METHOD__, $value)) return false;
            }
            return true;
        } elseif (is_object($data)) {
            $data = (array)$data;
            return call_user_func(__METHOD__, $data);
        }
        return empty($data);
    }


}

?>