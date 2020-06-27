<?php
namespace Meowto16\ProfitBase;

trait Projects
{
    /**
     * Метод получения списка ЖК
     * @package Meowto16\ProfitBase
     * @link https://developer.profitbase.ru/#operation--projects-get
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function getProjects()
    {
        return $this->getQueryTo('/projects');
    }

    /**
     * Метод создания ЖК
     * @package Meowto16\ProfitBase
     * @param array $params
     * @link https://developer.profitbase.ru/#operation--projects-post
     * @return array|bool Ответ от ProfitBase (массив или false)
     */
    public function createProject(array $params = [])
    {
        return $this->postQueryTo('/projects', $params);
    }
}