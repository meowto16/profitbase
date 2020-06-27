<?php
namespace Meowto16\ProfitBase;

trait Houses
{
    /**
     * Метод получения списка домов с возможностью фильтрации
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--house-get
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getHouses(array $params = [])
    {
        return $this->getQueryTo("/house", $params);
    }

    /**
     * Метод получения количества этажей в конкретном доме
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--house-get-count-floors-get
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getCountFloors(array $params = [])
    {
        return $this->getQueryTo("/house/get-count-floors", $params);
    }

    /**
     * Метод получения количества помещений в конкретном доме на конкретном этаже
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--house-get-count-properties-on-floor-get
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getCountPropertiesOnFloor(array $params = [])
    {
        return $this->getQueryTo("/house/get-count-floors", $params);
    }

    /**
     * Метод создание дома в существующий ЖК
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--houses-post
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function createHouse(array $params = [])
    {
        return $this->postQueryTo('/houses', $params);
    }
}