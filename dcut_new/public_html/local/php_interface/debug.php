<?
if(!class_exists('__Debug')):
class __Debug
  {const SHOW_ERRORS = true;
   const CLEAR_OLD_FILES = false;
   const OPERATIONS_COUNT_TO_SHOW = 10000000000;
   protected static $is_debugger = NULL;
   protected static $is_new = NULL;
   protected static $is_test = NULL;
   protected static $inited = NULL;
   protected static $values = array();
   protected static $fixes = array();
   protected static $_isOn = true;
   public static function getForEcho($value)
     {return '';
      return $value;        
     }
   protected static function isAborted()
     {static $lastResult = NULL;
      $currentTime = microtime(true);
      if(is_null($lastResult) || ($currentTime - $lastResult['time'] >= 1))
        {if(!ignore_user_abort())
           {ignore_user_abort(true);
           }
         $level = ob_get_level();
         while($level-- > 0)
           {ob_get_contents();
            ob_end_clean();
           };
         echo 's';
         flush();
         $lastResult = ['time' => $currentTime, 'value' => connection_aborted()];
        }
      return $lastResult['value'];
     }
   public static function fixTime($key = NULL)
     {return;
      static $fixes = array(), $lastKey = NULL, $fixesCount = 0;
      if(static::isAborted())
        {static::log(['Aborted', debug_backtrace()], 'aborted');
         die();
        }
      if(!is_null($lastKey))
        {if(!array_key_exists($lastKey, static::$fixes))
           {static::$fixes[$lastKey] = ['value' => 0, 'count' => 0];
           }
         static::$fixes[$lastKey]['value'] += microtime(true) - $fixes[$lastKey];
         static::$fixes[$lastKey]['count']++;
         if($fixesCount++ >= 1000)
           {foreach(static::$fixes as &$currentFix)
              {$currentFix[implode('-', ['time', 'on', static::OPERATIONS_COUNT_TO_SHOW, 'operations'])] = \Site\Format::toTime((int) ceil(static::OPERATIONS_COUNT_TO_SHOW * ($currentFix['value'] / $currentFix['count'])));
              }
            unset($currentFix);
            //\Site\File::toJSON(static::$fixes, \Site\File::getPath('fixes.json'));
            $fixesCount = 0;
           }
        }
      if(is_null($key))
        {$key = 'after'.$lastKey;
        }
      $fixes[$key] = microtime(true);           
      $lastKey = $key;
     }
   public static function assert($value, $report = NULL)
     {if(!$value)
        {static::out(\Site\Arrays::filterNotNulls(['Assert not matches', $report]));
        }
      return $value ? true : false;
     }
   public static function assertEquality($value1, $value2, $report = NULL)
     {if($result = static::assert($value1 == $value2, $report))
        {static::out(\Site\Arrays::filterNotNulls(['Assertion of equality is successful', $value1, $value2, $report]), false);           
        }      
     }
   public static function showErrors($value = NULL)
     {if(func_num_args() == 0)
        {$value = true;
        }
      if(!is_null($value))
        {if(is_bool($value))
           {$value = $value ? E_ALL : 0;              
           }
         error_reporting($value);
         ini_set('display_errors', $value > 0);
        }
      return ((boolean) (int) ini_get('display_errors')) ? error_reporting() : false;
     }
   public static function value()
     {$key = func_get_arg(0);
      if(func_num_args() > 1)
        {$value = static::$values[$key] = func_get_arg(1);
        }
      else
        {$value = array_key_exists($key, static::$values) ? static::$values[$key] : NULL;
        }
      return $value;
     }
   public static function is()
     {$arguments = func_get_args();
      $process = function($value)
        {return (boolean) ((int) $value);
        };
      if(count($arguments) > 1)
        {$arguments[1] = $process($arguments[1]);
        }
      return $process(call_user_func_array(['static', 'value'], $arguments));
     }
   public static function inc($key)
     {if(!array_key_exists($key, static::$values))
        {static::$values[$key] = 0;
        }
      return static::$values[$key]++;
     }
   public static function turnOn()
     {static::$_isOn = true;        
     }
   public static function turnOff()
     {static::$_isOn = false;        
     }
   public static function isOn()
     {static::init();
      return !empty(static::$is_debugger) && static::$_isOn;
     }
   public static function isTest()
     {return in_array($_SERVER['HTTP_HOST'], ['devilscup.ru']);
      static::init();
      return !static::isNew() && !empty(static::$is_test);
     }
   public static function isNew()
     {static::init();
      return !empty(static::$is_new);
     }
   public static function init()
     {if(is_null(static::$inited))
        {static::$inited = false;
         if(isset($_GET['is_debugger']))
           {setcookie('is_debugger', (static::$is_debugger = ((boolean) ((int) $_GET['is_debugger']))) ? 1 : 0, (time() + 3600 * 12 * 365), '/');
           }
         elseif(is_null(static::$is_debugger))
           {static::$is_debugger = array_key_exists('is_debugger', $_COOKIE) ? ((boolean) ((int) $_COOKIE['is_debugger'])) : false;
           }
         /*if(static::$is_debugger && static::SHOW_ERRORS)
           {error_reporting(E_ALL);
            ini_set('display_errors', true);
           }
         */
         if(isset($_GET['is_new']) || array_key_exists('REMOTE_USER', $_SERVER) && in_array($_SERVER['REMOTE_USER'], ['new-tester']))
           {setcookie('is_new', static::$is_new = (in_array($_SERVER['REMOTE_USER'], ['new-tester']) || (static::$is_new = ((boolean) ((int) $_GET['is_new'])))) ? 1 : 0, (time() + 3600), '/');
           }
         elseif(is_null(static::$is_new))
           {static::$is_new = array_key_exists('is_new', $_COOKIE) ? ((boolean) ((int) $_COOKIE['is_new'])) : false;
           }
         if(isset($_GET['is_test']) || isset($_SERVER) && is_array($_SERVER) && array_key_exists('HTTP_HOST', $_SERVER) && in_array($_SERVER['HTTP_HOST'], ['devilscup.ru']))
           {setcookie('is_test', static::$is_test = (in_array($_SERVER['HTTP_HOST'], ['devilscup.ru']) || (static::$is_test = ((boolean) ((int) $_GET['is_test'])))) ? 1 : 0, (time() + 60 * 60 * 24 * 365 * 1000), '/');
           }
         elseif(is_null(static::$is_test))
           {static::$is_test = array_key_exists('is_test', $_COOKIE) ? ((boolean) ((int) $_COOKIE['is_test'])) : false;
           }
         static::$inited = true;
        }
     }
   public static function getInfo($item, $type = NULL)
     {if(is_string($item) || (is_array($item) && count($item) == 2))
        {$reflectionObject = NULL;
         if(class_exists($item))
           {$reflectionObject = new ReflectionClass($item);
           }
         elseif(is_callable($item))
           {$reflectionObject = is_array($item) ? new ReflectionMethod($item[0], $item[1]) : new ReflectionFunction($item);
           }           
        }
      else
        {if(is_null($type))
           {$type = is_callable($item) ? 'function' : 'class';
           }
         $className = 'Reflection'.ucfirst($type);
         $reflectionObject = new $className($item);
        }
      return isset($reflectionObject) ? $reflectionObject->getFileName() : 'Unknown'.(isset($type) ? " type" : '');
     }
   public static function out($data = NULL, $die = true)
     {if(static::isOn())
        {echo '<pre>';
         var_dump($data);
         /*
         is_string($data) ? print $data : var_dump($data);
         */
         if($die)
           {debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            die('</pre>');
           }
         else
           {//debug_print_backtrace();              
           }
         echo '</pre>';
        }
     }
   public static function outInfo($data, $type = NULL, $die = true)
     {if(is_bool($type))
        {$die = $type;
         $type = NULL;           
        }
      return static::out(static::getInfo($data, $type), $die);
     }
   public static function logInfo($data, $type = NULL)
     {if(is_bool($type))
        {$dir = $type;
         $type = NULL;           
        }
      return static::log(static::getInfo($data), $type);
     }
   public static function log($givenText, $type = NULL, $redo = NULL)
     {static $paths = array();
      if(is_bool($type))
        {$redo = $type;
         $type = NULL;           
        }
      if(is_null($type))
        {$type = 'log';
        }
      if(is_nulL($redo))
        {$redo = false;           
        }
      $filePath = $_SERVER['DOCUMENT_ROOT'].'/local/logs/'.$type.'.txt';
      //$filePath = \Site\File::getPath(implode('.', [$type, 'txt']));
      if(static::CLEAR_OLD_FILES)
        {static $paths = array();
         if(!in_array($filePath, $paths))
           {//\Site\File::unlinkIfExists($filePath);
            array_push($paths, $filePath);
           }
        }
      if($redo)
        {static $processingTypes = NULL;
         if(is_null($processingTypes))
           {$processingTypes = array();              
           }
         if(!in_array($type, $processingTypes))
           {if(file_exists($filePath))
              {unlink($filePath);
              }
            array_push($processingTypes, $type);
           }
        }
      $text = ((file_exists($filePath) ? filesize($filePath) : 0) > 0) ? "\r\n" : '';
      if(is_array($givenText))
        {$givenText = var_export($givenText, true);           
        }
      $text .= implode(': ', [implode(', ', [date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']]), $givenText]);
      fwrite($fileHandle = fopen($filePath, 'a'), $text);
      fclose($fileHandle);
     }
  }
__Debug::init();
if(!function_exists('o'))
  {function o()
     {return call_user_func_array(['__Debug', 'out'], func_get_args());
     }
  }
endif;
if(!function_exists('dd'))
  {function dd()
     {return call_user_func_array(['\\__Debug', 'out'], func_get_args());
     };
  }