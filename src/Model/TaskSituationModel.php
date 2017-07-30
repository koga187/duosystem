<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 2:30 PM
 */

namespace Duosystem\Model;


class TaskSituationModel
{
    private $values = [
        0 => [
            'id' => 1,
            'name' => 'Ativo'
            ],
        1 => [
            'id' => 0,
            'name' => 'Inativo'
        ]
    ];

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }
}