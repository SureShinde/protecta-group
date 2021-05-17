<?php
namespace Dcs\Megamenuimg\Model\Category\Attribute\Backend;

class Image extends \Magento\Catalog\Model\Category\Attribute\Backend\Image
{   
	/*public function __construct() {
		echo "Model Rewrite Working"; die();
	}*/
	
    protected $_uploaderFactory;
    protected $_filesystem;
    protected $_fileUploaderFactory;
    protected $_logger;
    private $imageUploader;
    private $additionalData = '_additional_data_';

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_logger = $logger;
    }

    private function getImageUploader()
    {
        if ($this->imageUploader === null) {
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Catalog\CategoryImageUpload::class);
        }
        return $this->imageUploader;
    }	

	public function afterSave($object)
    {
		$image = $object->getData($this->getAttribute()->getName(), null);
		if ($image !== null) {
			try {
				$this->getImageUploader()->moveFileFromTmp($image);
			} catch (\Exception $e) {
				$this->_logger->critical($e);
			}
		}
		return $this;      
    }
}