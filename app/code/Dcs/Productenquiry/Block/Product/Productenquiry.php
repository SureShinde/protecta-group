<?php 
namespace Dcs\Productenquiry\Block\Product;

class Productenquiry extends \Magento\Framework\View\Element\Template
{
	protected $_checkoutSession;
	
	private $redirectFactory;
	
	private $moduleManager;

	protected $customerSession;
	
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
		\Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->objectManager = $objectManager;
		$this->_checkoutSession = $checkoutSession;
		$this->redirectFactory = $redirectFactory;
		$this->_moduleManager = $moduleManager;
		$this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }
	public function isModuleEnabled(){
		return $this->_moduleManager->isEnabled('Dcs_Productenquiry');
	}
	public function isExistEnquiryQuote(){
		if($this->_checkoutSession->getEnquiryQuote())
		{
			return 1;
		}
	}
	public function getFullname()
	{
		return trim($this->customerSession->getCustomer()->getName());
	}
	public function getEmailaddress()
	{
		return trim($this->customerSession->getCustomer()->getEmail());
	}
	
	public function getNscompanyname()
	{
		return trim($this->customerSession->getCustomer()->getNsCompanyName());
	}
		
	public function getEnquiryQuoteProducts(){
		if($this->_checkoutSession->getEnquiryQuote())
		{
			return $this->_checkoutSession->getEnquiryQuote();
		}
		else
		{
			return $this->redirectFactory->create()->setPath('*/*/');
		}
	}
}
