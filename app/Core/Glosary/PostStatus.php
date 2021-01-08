<?php


namespace App\Core\Glosary;


class PostStatus extends BasicEnum
{
    const PUBLIC = ['VALUE' => 1, 'NAME' => 'Public'];
    const DRAFT = ['VALUE' => 0, 'NAME' => 'Draft'];
}
