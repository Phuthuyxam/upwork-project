<?php


namespace App\Core\Glosary;


class ResponeCode extends BasicEnum
{
    const SUCCESS = ['CODE' => 200, 'STATUS' => 'success'];
    const CREATE = ['CODE' => 201, 'STATUS' => 'created'];
    const NOCONTENT = ['CODE' => 204, 'STATUS' => 'no content'];
    const BADREQUEST = ['CODE' => 400, 'STATUS' => 'bad request'];
    const UNAUTHORIZED = ['CODE' => 401, 'STATUS' => 'unauthorized'];
    const FORBIDDEN = ['CODE' => 403, 'STATUS' => 'Forbidden'];
    const NOTFOUND = ['CODE' => 404, 'STATUS' => 'Not Found'];
    const METHODNOTALLOWED = ['CODE' => 405, 'STATUS' => 'Method Not Allowed'];
    const NOTACCEPTABLE = ['CODE' => 405, 'STATUS' => 'Not Acceptable'];
    const UNSUPPORTEDMEDIATYPE = ['CODE' => 415, 'STATUS' => 'Unsupported Media Type'];
    const UNPROCESSABLEENTITY = ['CODE' => 422, 'STATUS' => 'Unprocessable Entity'];
    const SERVERERROR = ['CODE' => 500, 'STATUS' => 'Internal Server Error'];
}
