<?php


namespace App\Helpers;


class UuidGenerator
{
    /**
     * Class that generates UUID Codes
     * Examples of use:
     *
     *  $orderCode = new UuidGenerator();
     *  $orderCode(6); <- Will return1 ohb00
     *
     *
     *  $orderCode = new UuidGenerator();
     *  $orderCode(6, 'foo_'); <- Will return1 foo_ohb00
     *
     */

    /**
     * @param $limit
     * @param null $prefix
     * @return string
     */

    public function __invoke($limit, $prefix = null)
    {
        return $prefix . $this->generateUniqueCode($limit);
    }

    private function generateUniqueCode($length = null){
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
    }

}
