<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 18/02/2019
 * Time: 15:55
 */

namespace App\Representation;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;

class Users extends AbstractRepresentation
{
    /**
     * @Type("array<App\Entity\User>")
     */
    public $data;
}