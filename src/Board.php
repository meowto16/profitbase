<?php
namespace Meowto16\ProfitBase;

trait Board
{
    /**
     * Метод получения шахматки дома
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#tag-board
     * @param array $params
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getBoard(array $params = [])
    {
        return $this->getQueryTo('/board', $params);
    }
}