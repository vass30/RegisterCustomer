<?php
/**
 * @author Korotkij Vasilij <vass.kor@gmail.com>
 */

namespace Vass\RegisterCustomer\Observer\CustomerRegistered;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Vass\RegisterCustomer\Helper\CustomerFirstNameTrim;
use Vass\RegisterCustomer\Helper\SaveCustomerToLog;
use Vass\RegisterCustomer\Helper\SendEmailToSupport;

/**
 * Class NewCustomer
 *
 * @package Vass\RegisterCustomer\Observer\CustomerRegistered
 */
class NewCustomer implements ObserverInterface
{
    /**
     * @var \Vass\RegisterCustomer\Helper\CustomerFirstNameTrim
     */
    private $customerFirstNameTrim;
    /**
     * @var \Vass\RegisterCustomer\Helper\SaveCustomerToLog
     */
    private $customerToLog;
    /**
     * @var \Vass\RegisterCustomer\Helper\SendEmailToSupport
     */
    private $sendEmailToSupport;

    /**
     * NewCustomer constructor.
     * @param \Vass\RegisterCustomer\Helper\CustomerFirstNameTrim $customerFirstNameTrim
     * @param \Vass\RegisterCustomer\Helper\SaveCustomerToLog $customerToLog
     * @param \Vass\RegisterCustomer\Helper\SendEmailToSupport $sendEmailToSupport
     */
    public function __construct(
        CustomerFirstNameTrim $customerFirstNameTrim,
        SaveCustomerToLog $customerToLog,
        SendEmailToSupport $sendEmailToSupport
    ) {
        $this->customerFirstNameTrim=$customerFirstNameTrim;
        $this->customerToLog=$customerToLog;
        $this->sendEmailToSupport=$sendEmailToSupport;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function execute(Observer $observer) :void
    {
        $newcustomer = $observer->getEvent()->getCustomer();
        $this->customerFirstNameTrim->customerFirstNameTrim($newcustomer);
        $this->customerToLog->saveCustomerToLog($newcustomer);
        $this->sendEmailToSupport->sendEmailToSupport($newcustomer);
    }
}
