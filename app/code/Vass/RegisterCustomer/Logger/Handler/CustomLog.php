<?php
/**
 * @author Korotkij Vasilij <vass.kor@gmail.com>
 */

namespace Vass\RegisterCustomer\Logger\Handler;

use Monolog\Logger;
use Magento\Framework\Logger\Handler\Base;

/**
 * Class CustomLog
 *
 * @package Vass\RegisterCustomer\Logger\Handler
 */
class CustomLog extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/customer_registered.log';
    /**
     * @var int
     */
    protected $loggerType = Logger::INFO;
}
