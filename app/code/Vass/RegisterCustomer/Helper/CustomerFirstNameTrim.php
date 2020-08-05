<?php
/**
 * @author Korotkij Vasilij <vass.kor@gmail.com>
 */

namespace Vass\RegisterCustomer\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Class CustomerFirstNameTrim
 *
 * @package Vass\RegisterCustomer\Helper
 */
class CustomerFirstNameTrim
{
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $_customerRepositoryInterface;

    /**
     * CustomerFirstNameTrim constructor.
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     */
    public function __construct(CustomerRepositoryInterface $customerRepositoryInterface)
    {
        $this -> _customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * @param $newcustomer
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function customerFirstNameTrim($newcustomer): void
    {
        $customerFirstName = $newcustomer->getFirstName();
        $string = str_replace(' ', '', $customerFirstName);
        $newcustomer->setFirstName($string);
        $this -> _customerRepositoryInterface ->save($newcustomer);
    }
}
