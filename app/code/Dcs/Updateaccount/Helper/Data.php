<?php

/**
 * Updateaccount data helper
 */
namespace Dcs\Updateaccount\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Path to store config where count of updateaccount posts per page is stored
     *
     * @var string
     */
    
    const XML_PATH_RECIPIENT_EMAIL = 'updateaccount/email/recipient_email';
    const XML_PATH_RECIPIENT_NAME = 'updateaccount/email/recipient_name';
    const XML_PATH_GENERAL_NAME = 'trans_email/ident_general/name';
    const XML_PATH_GENERAL_EMAIL = 'trans_email/ident_general/email';
    
    protected $mediaDirectory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Magento\Framework\HTTP\Adapter\FileTransferFactory
     */
    protected $httpFactory;
    
    /**
     * File Uploader factory
     *
     * @var \Magento\Core\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;
    
    /**
     * File Uploader factory
     *
     * @var \Magento\Framework\Io\File
     */
    protected $_ioFile;
    
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    protected $customerSession;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\File\Size $fileSize,
        \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem\Io\File $ioFile,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Image\Factory $imageFactory
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->httpFactory = $httpFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_ioFile = $ioFile;
        $this->_storeManager = $storeManager;
        $this->_customerSession = $customerSession;
        $this->_imageFactory = $imageFactory;
        parent::__construct($context);
    }
    
   
    
    public function getBaseDir()
    {
        $path = $this->filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(self::MEDIA_PATH);
        return $path;
    }
    
    /**
     * Return the Base URL for Updateaccount Item images
     *
     * @return string
     */
    public function getBaseUrl()
    { 
        return $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . '/' . self::MEDIA_PATH;
    }
    
    /**
     * Return the number of items per page
     * @return int
     */
     
    public function Recipientemail()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_RECIPIENT_EMAIL,$storeScope);
    }
    public function Recipientname()
    {		
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->scopeConfig->getValue(self::XML_PATH_RECIPIENT_NAME,$storeScope);
    }
	public function GeneralName()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
 		return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_NAME, $storeScope);
    }
	
	public function GeneralEmail()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
 		return $this->scopeConfig->getValue(self::XML_PATH_GENERAL_EMAIL, $storeScope);
    }
    public function setMessage($status,$message)
	{
		$this->_customerSession->setUpdateMessageStatus($status);
		 $this->_customerSession->setUpdateMessage($message);
	}
	public function getUpdateMessage()
	{
		 return $this->_customerSession->getUpdateMessage();
	}
	public function getUpdateMessageStatus()
	{
		 return $this->_customerSession->getUpdateMessageStatus();
	}
	public function resetSessionMessage(){
		$this->_customerSession->setUpdateMessageStatus('');
		 $this->_customerSession->setUpdateMessage('');
	}
}
