<?php
/**
 * Created by PhpStorm.
 * User: lc-timorchao
 * Date: 2019/6/24
 * Time: 16:00
 */

namespace HuanLe\DBQuery\Core;


/**
 * Class DbQueryException
 * @package HuanLe\DBQuery\Core
 */
class DbQueryException extends \Exception
{
    private $responseDetails;

    /**
     * DbQueryException constructor.
     *
     * @param $responseDetails
     */
    function __construct($responseDetails)
    {
        if (is_object($responseDetails)) {
            $message = $responseDetails->getStatusCode() . ': ' . ' Content: ' . $responseDetails->getBody()->getContents();
            parent::__construct($message);
            $this->responseDetails = $responseDetails;
        } else {
            $message = $responseDetails;
            parent::__construct($message);
        }
    }

    /*
     * TODO extension DbQueryException function
     */
    public function getHTTPStatus()
    {
    }

    public function getRequestId()
    {
    }

    public function getErrorCode()
    {
    }

    public function getErrorMessage()
    {
    }

    public function getDetails()
    {
    }
}