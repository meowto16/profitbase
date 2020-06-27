<?php
namespace Meowto16\ProfitBase;

trait Properties
{

    /**
     * Метод получения списка помещений с возможностью фильтрации
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--property-get
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getProperties(array $params = [])
    {
        return $this->getQueryTo('/property', $params);
    }

    /**
     * Метод получения списка типов помещений и их дополнительных полей
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--property-types-get
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getPropertyTypes()
    {
        return $this->getQueryTo('/property-types');
    }

    /**
     * Метод получения списка помещений привязанных к конкретной сделке
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--get-property-deals-get
     * @param int $dealId
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getPropertiesFromDeal(int $dealId)
    {
        return $this->getQueryTo("/property/deal/$dealId");
    }

    /**
     * Метод получения истории изменения статусов по конкретному помещению
     * @package Meowto16\ProfitBase
     * @param int $propertyId
     * @link https://developer.profitbase.ru/#operation--property-deal--dealId--get
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getPropertyHistory(int $propertyId)
    {
        return $this->getQueryTo("/property/history/$propertyId");
    }
}