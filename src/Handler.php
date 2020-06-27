<?php

namespace Meowto16\ProfitBase;

class Handler extends Base
{
    use Board, Houses, Plan, Projects, Properties, Floor, Facade, Offer;
    public $API_TOKEN;

    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->auth();
    }

    protected final function auth()
    {
        $this->API_TOKEN = parent::getToken();
    }
}