<?php
/**
 * Формирование JSON по формату требуемому
 *
 */
class MakeStructJV8
{
    private $struct = [];
    /**
     * Конструктор класса
     * @return object объект класса
     */
    public function __construct()
    {
        $this->struct = [
            '#type' => 'jv8:Structure',
            '#value' => []
        ];
    }
    /**
     * Добавить параметр
     * @param $name     string     Имя переменной
     * @param $value     string     Значение переменной
     * @param $type     string     Тип переменной
     * @return void
     */
    public function addParam($name, $value, $type = 'string')
    {
        $tmp = [
            'name' => [
                '#type' => 'jxs:string',
                '#value' => $name,
            ],
            'Value' => [
                '#type' => 'jxs:'.$type,
                '#value' => $value,
            ],
        ];
        $this->struct['#value'][] = $tmp;
    }
    /**
     * Результат формирования
     * @return string результирующий json
     */
    public function getToService()
    {
        return json_encode($this->struct);
    }
}
