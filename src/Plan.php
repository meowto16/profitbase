<?php
namespace Meowto16\ProfitBase;

trait Plan
{
    /**
     * Метод получения планировок помещений с возможностью фильтрации
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#tag-presets
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */

    public function getPlan(array $params = [])
    {
        return $this->getQueryTo('/plan', $params);
    }
}