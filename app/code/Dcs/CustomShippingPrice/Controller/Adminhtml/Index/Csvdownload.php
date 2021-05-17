<?php
namespace Dcs\CustomShippingPrice\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;

class Csvdownload extends \Magento\Backend\App\Action
{
    protected $_directoryList;
     protected $_downloader;
    protected $_coreRegistry = null;
    
	
	/**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
	 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(Action\Context $context,
		 \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
		 \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		 \Magento\Framework\Registry $registry,
		 \Magento\Framework\App\Response\Http\FileFactory $fileFactory
		)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_downloader =  $fileFactory;
		$this->_coreRegistry = $registry;
		$this->_directoryList = $directoryList;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dcs_CustomShippingPrice::csvdownload');
    }

    public function execute()
    {
       $fileName   = 'sampleshipping.csv';
       $file    = $this->_directoryList->getPath('pub').'/media/shipping/csv/sample/'.$fileName;
	   return $this->_downloader->create(
            $fileName,
            @file_get_contents($file)
        );
    }
}
