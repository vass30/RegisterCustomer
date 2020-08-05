<?php
/**
 * @author Korotkij Vasilij <vass.kor@gmail.com>
 */

namespace Vass\RegisterCustomer\Helper;

use Psr\Log\LoggerInterface;

/**
 * Class SaveCustomerToLog
 *
 * @package Vass\RegisterCustomer\Helper
 */
class SaveCustomerToLog
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * SaveCustomerToLog constructor.
     * @param $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this -> logger = $logger;
    }

    /**
     * @param $newcustomer
     */
    public function saveCustomerToLog($newcustomer): void
    {
        $customerFirstName = $newcustomer->getFirstName();
        $customerLastName = $newcustomer->getLastName();
        $data = $newcustomer->getCreatedAt();
        $email = $newcustomer->getEmail();

        $this->logger->info('Customer has been registered.', [
            'First name' => $customerFirstName,
            'Last name' => $customerLastName,
            'Date of registration' => $data,
            'Email' => $email,]);
    }
}
