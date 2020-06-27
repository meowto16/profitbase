<?php
namespace Meowto16\ProfitBase;

trait Facade
{
    /**
     * Метод получения списка фасадов дома
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#tag-facade
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getFacade(array $params = [])
    {
        return $this->getQueryTo('/facade', $params);
    }
}