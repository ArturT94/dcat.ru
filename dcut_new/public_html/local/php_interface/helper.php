<?
namespace My;
class Helper
  {const BUTTON_HIDE_TIME_IN_SECONDS = 10 * 60;
   const BITRIX_REQUEST_ELEMENTS_STANDARD_LIMIT = 50;
   const PATH_OF_THE_CACHE = 'local/cache';
   const HOLD_CACHE_PERIOD = NULL;
   const BITRIX24_URL = 'https://it-valet.ru/rest/1/gs1ycntcuprb7erg';
   const CONTACTS_INFO_CACHE_KEY = 'contacts-info';
   const CALL_REQUEST_TIMES_FILE_NAME = 'call-request-times.json';
   const CONTACT_MULTIPLE_PROPERTIES = ['email', 'phone'];
   public static function getByKeyCaseInsensitive($array, $key, $defaultValue = NULL)
     {$keyInLowerCase = mb_strtolower($key);
      $resultKey = NULL;
	  $keyFound = false;
	  foreach($array as $key => $value)
	    {if(mb_strtolower($key) == $keyInLowerCase)
		   {$resultKey = $key;
            $keyFound = true;		
		   }			
	     if($keyFound)
		   {break;			   
		   }
		}
      return $keyFound ? $array[$resultKey] : $defaultValue;
	 }
   public static function getPath()
     {return '/'.implode('/', array_map(function($argument)
        {return trim($argument, '/');
        }, func_get_args()));        
     }
   public static function getBaseName()
     {return implode('.', array_map(function($argument)
        {return trim($argument, '/');
        }, func_get_args()));        
     }
   public static function fromJSON($value)
     {return json_decode($value, true);        
     }
   public static function outJSON($value)
     {header('Content-Type: application/json; charset=utf-8');
      header('Content-Length: '.strlen($value = \My\Helper::toJSON(['success' => true, 'result' => $value])));
      die($value);
     }
   public static function toJSON($value)
     {return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);        
     }
   public static function fromJSONInFile($fileName, $defaultValue = NULL)
     {return file_exists($fileName) ? static::fromJSON(file_get_contents($fileName)) : $defaultValue;
     }
   public static function toJSONInFile($fileName, $value)
     {return file_put_contents($fileName, static::toJSON($value)) !== false;
     }
   protected static function getActionTimes()
     {return static::fromJSONInFile(static::CALL_REQUEST_TIMES_FILE_NAME, array());
     }
   protected static function setActionTimes($times)
     {static::toJSONInFile(static::CALL_REQUEST_TIMES_FILE_NAME, $times);
     }
   protected static function getUserId()
     {global $USER;
      return $USER->getID();        
     }
   public static function getButtonShowTime()
     {return static::buttonIsHidden() ? (static::getActionTimes()[static::getUserId()] + static::BUTTON_HIDE_TIME_IN_SECONDS) : null;
     }
   public static function buttonIsHidden()
     {return array_key_exists($userId = static::getUserId(), $times = static::getActionTimes()) && ($times[$userId] + static::BUTTON_HIDE_TIME_IN_SECONDS >= time());
     }
   public static function hideButton()
     {$hidden = static::getActionTimes();
      $hidden[static::getUserId()] = time();
      static::setActionTimes($hidden);
     }
   protected static function getPathForCacheFile($fileName)
     {return implode('/', [$_SERVER['DOCUMENT_ROOT'], static::PATH_OF_THE_CACHE, implode('.', [$fileName, 'json'])]);
     }
   protected static function setCache($info, $value)
     {return file_put_contents(static::getPathForCacheFile($info), json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));        
     }
   protected static function getCache($info, callable $calculate)
     {if(file_exists($path = static::getPathForCacheFile($info)) && (is_null(static::HOLD_CACHE_PERIOD) || (filemtime($path) + static::HOLD_CACHE_PERIOD > time())))
        {$result = json_decode(file_get_contents($path), true);
        }
      else
        {static::setCache($info, $result = call_user_func($calculate));
        }
      return $result;
     }
   public static function requestAll($methodName, $parameters = NULL, $byKey = NULL)
     {$fromId = 0;
      $continue = true;
      if(is_null($parameters))
        {$parameters = array();           
        }
      $parameters['start'] = -1;
      $parameters['order'] = ['ID' => 'ASC'];
      $result = array();
      while($continue)
        {$parameters['filter'] = ['>ID' => $fromId];
         if(!is_null($currentResult = call_user_func_array(['static', 'request'], [$methodName, $parameters])))
           {foreach($currentResult as $currentElement)
              {if(is_null($byKey))
                 {array_push($result, $currentElement);
                 }
               elseif(array_key_exists($byKey, $currentElement))
                 {$id = $currentElement[$byKey];
                  unset($currentElement[$byKey]);
                  $result[$id] = $currentElement;
                 }                 
              }
            if($continue = (count($currentResult) >= static::BITRIX_REQUEST_ELEMENTS_STANDARD_LIMIT))
              {$fromId = $currentResult[count($currentResult) - 1]['ID'];
              }
           }
         else
           {$continue = false;              
           }
        }
      return $result;
     }
   protected static function getInMultipleCase($value)
     {return implode('', [$value, 's']);
     }
   protected static function getInitialCountsParameter()
     {static $result = NULL;
      if(is_null($result))
        {$result = array_combine(array_map(['static', 'getInMultipleCase'], static::CONTACT_MULTIPLE_PROPERTIES), array_fill(0, count(static::CONTACT_MULTIPLE_PROPERTIES), 0));
        }
      return $result;
     }
   protected static function getInitialContactsInfoData()
     {static $result = NULL;
      if(is_null($result))
        {$result = array_replace(['counts' => array()], array_combine(array_map(function($nameOfTheProperty)
           {return implode('-', ['by', static::getInMultipleCase($nameOfTheProperty)]);
           }, static::CONTACT_MULTIPLE_PROPERTIES),  array_fill(0, count(static::CONTACT_MULTIPLE_PROPERTIES), array())));
        }
      return $result;
     }
   public static function request($methodName, $parameters = NULL)
     {if(is_null($parameters))
        {$parameters = array();           
        }
      $url = implode('/', [static::BITRIX24_URL, implode('.', [$methodName, 'json'])]).((count($parameters) > 0) ? ('?'.http_build_query($parameters)) : '');
      curl_setopt_array($curl = curl_init($url), [CURLOPT_RETURNTRANSFER => true]);
      $result = json_decode($bodyOfTheResult = curl_exec($curl), true);
      curl_close($curl);
      \__Debug::log(compact(['url', 'parameters', 'bodyOfTheResult']), 'curl');
      return (is_array($result) && array_key_exists('result', $result)) ? $result['result'] : $result;
     }
   public static function processData($data)
     {foreach(static::CONTACT_MULTIPLE_PROPERTIES as $key)
        {if(array_key_exists($key, $data))
           {$data[$key] = call_user_func(['static', 'process'.ucfirst($key)], $data[$key]);              
           }
        }
      return $data;
     }
   public static function obtainContactId($data)
     {$contactsInfo = static::obtainContactsInfo();
      $bys = array();
      $ids = NULL;
      foreach(static::CONTACT_MULTIPLE_PROPERTIES as $key)
        {if(array_key_exists($key, $data) && (mb_strlen($value = call_user_func(['static', 'process'.ucfirst($key)], $data[$key])) > 0))
           {$currentIds = array_key_exists($bys[$key] = $value, $contactsInfo[$byKey = 'by-'.static::getInMultipleCase($key)]) ? $contactsInfo[$byKey][$value] : array();
            if(is_null($ids))
              {$ids = $currentIds;
              }
            else
              {$ids = array_intersect($ids, $currentIds);                 
              }
           }
        }
      $initialFields = ['NAME' => $data['name']];
      if(empty($ids))
        {$request = ['fields' => $initialFields];
         foreach($bys as $key => $value)
           {$request['fields'][mb_strtoupper($key)] = [['VALUE' => $value]];
           }
         $contactsInfo['counts'][$id = (int) static::request('crm.contact.add', $request)] = static::getInitialCountsParameter();
        }
      else
        {$email = static::processEmail($data['email']);
         $exitraIds = array_key_exists($bys['email'], $contactsInfo['by-emails']) ? $contactsInfo['by-emails'][$bys['email']] : array();
         $getParameters = function($id) use ($contactsInfo, $exitraIds)
           {return [in_array($id, $exitraIds) ? 0 : 1, $contactsInfo['counts'][$id]['phones'], $contactsInfo['counts'][$id]['emails']];
           };
         $compare = function($parameters1, $parameters2)
           {$result = NULL;
            foreach($parameters1 as $index => $value1)
              {if($value1 != ($value2 = $parameters2[$index]))
                 {$result = $value1 - $value2;                    
                 }
               if(!is_null($result))
                 {break;
                 }
              }
            return $result;
           };
         usort($ids, function($id1, $id2) use ($compare, $getParameters)
           {return $compare($getParameters($id1), $getParameters($id2));
           });
         $id = $ids[0];
        }
      $isModified = false;
      foreach($bys as $key => $value)
        {if(!array_key_exists($value, $contactsInfo[$byKey = 'by-'.$key.'s']))
           {$contactsInfo[$byKey][$value] = array();
           }
         if(!in_array($id, $contactsInfo[$byKey][$value]))
           {array_push($contactsInfo[$byKey][$value], $id);
            $contactsInfo['counts'][$id][static::getInMultipleCase($key)]++; 
            if(!$isModified)
              {$isModified = true;                 
              }
           }
        }
      if($isModified)
        {static::setCache(static::CONTACTS_INFO_CACHE_KEY, $contactsInfo);
        }
      return $id;
     }
   protected static function obtainContactsInfo()
     {return static::getCache(static::CONTACTS_INFO_CACHE_KEY, function()
        {$result = static::getInitialContactsInfoData();
         $elements = static::requestAll('crm.contact.list');
         $append = function() use (&$element, &$result)
           {$elementId = (int) $element['ID'];
            $getSingle = function() use ($elementId)
              {static $result = NULL;
               if(is_null($result))
                 {$result = static::request('crm.contact.get', ['ID' => $elementId]);                    
                 }
               return $result;
              };
            foreach(static::CONTACT_MULTIPLE_PROPERTIES as $key)
              {if($element[implode('_', array_map('mb_strtoupper', ['has', $key]))] == 'Y')
                 {$data = $getSingle();
                  $keyInUpperCase = mb_strtoupper($key);
                  foreach($data[$keyInUpperCase] as $detailInfo)
                    {if(!array_key_exists($value = call_user_func(['static', 'process'.ucfirst($key)], $detailInfo['VALUE']), $result[$type = implode('-', ['by', $typeInMultipleCase = implode('', [$key, 's'])])]))
                       {$result[$type][$value] = array();
                       }   
                     if(!in_array($elementId, $result[$type][$value]))
                       {array_push($result[$type][$value], $elementId);
                       }  
                     if(!array_key_exists($elementId, $result['counts']))
                       {$result['counts'][$elementId] = static::getInitialCountsParameter();
                       }
                     $result['counts'][$elementId][$typeInMultipleCase]++;                       
                    }
                 }                 
              }
           };
         foreach($elements as $element)
           {$append();
           }
         return $result;
        });
     }
   public static function processEmail($value)
     {return mb_strtolower(trim($value));
     }
   public static function processPhone($phone)
     {$phone = preg_replace('~[^\d+]+~i', '', trim($phone));
      if(($firstSymbol = mb_substr($phone, 0, 1)) != '+')
        {switch(mb_strlen($phone))
           {case 11:
              if(in_array((int) $firstSymbol, [7, 8]))
                {$phone = mb_substr($phone, 1);
                }
              else
                {break;
                }
             case 10:
               $phone = implode('', ['+7', $phone]);
               break;
           }
        }
      return $phone;
     }
  }