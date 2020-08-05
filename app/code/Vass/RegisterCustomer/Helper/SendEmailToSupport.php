<?php
/**
 * @author Korotkij Vasilij <vass.kor@gmail.com>
 */

namespace Vass\RegisterCustomer\Helper;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class SendEmailToSupport
 *
 * @package Vass\RegisterCustomer\Helper
 */
class SendEmailToSupport
{
    /**
     * string
     */
    const XML_PATH_EMAIL_SUPPORT = 'trans_email/ident_support/email';
    /**
     * string
     */
    const XML_PATH_EMAIL_GENERAL = 'trans_email/ident_general/email';
    /**
     * string
     */
    const XML_PATH_NAME_GENERAL = 'trans_email/ident_general/name';

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $_transportBuilder;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    private $inlineTranslation;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Framework\Escaper
     */
    private $_escaper;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * SendEmailToSupport constructor.
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Escaper $escaper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        Escaper $escaper,
        LoggerInterface $logger
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->_escaper = $escaper;
        $this -> logger = $logger;
    }

    /**
     * @param $newcustomer
     */
    public function sendEmailToSupport($newcustomer)
    {
        $this->inlineTranslation->suspend();
        try {
            $error = false;

            $sender = [
                'name' => $this->_escaper->escapeHtml($this->scopeConfig->getValue(self::XML_PATH_NAME_GENERAL)),
                'email' => $this->_escaper->escapeHtml($this->scopeConfig->getValue(self::XML_PATH_EMAIL_GENERAL)),
            ];
            $postObject = new DataObject();
            $postObject->setData($sender);
            $storeScope = ScopeInterface::SCOPE_STORE;
            $transport =
                $this->_transportBuilder
                    ->setTemplateIdentifier('email_to_support')
                    ->setTemplateOptions(
                        ['area' => Area::AREA_FRONTEND,
                         'store' => Store::DEFAULT_STORE_ID,]
                    )
                    ->setTemplateVars(
                        ['data' => $postObject,
                        'customerfirstname' => $newcustomer->getFirstName(),
                        'customerlastname' => $newcustomer->getLastName(),
                         'customeremail' => $newcustomer->getEmail(),]
                    )
                    ->setFrom($sender)
                    ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SUPPORT, $storeScope))
                    ->getTransport();
            $transport->sendMessage();

            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
