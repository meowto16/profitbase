<?php
namespace Meowto16\ProfitBase;

trait Offer
{
    /**
     * Метод получения списка активных акции со списком помещений по каждой акции
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--special-offer-get
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */

    public function getSpecialOffers(array $params = [])
    {
        return $this->getQueryTo('/special-offer', $params);
    }
}