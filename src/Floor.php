<?php
namespace Meowto16\ProfitBase;

trait Floor
{
    /**
     * Метод получения планировок этажей дома
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#tag-floor
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getFloors(array $params = [])
    {
        return $this->getQueryTo('/floor', $params);
    }
}