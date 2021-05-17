<?php


namespace Dcs\CustomShippingPrice\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	const PDF_MEDIA_PATH    = 'shipping/csv';

    const MAX_FILE_SIZE = 1048576123;

    protected $mediaDirectory;

    protected $filesystem;

    protected $httpFactory;

    protected $_fileUploaderFactory;

    protected $_ioFile;

    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,

        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\File\Size $fileSize,
        \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroup,
        \Magento\Framework\Filesystem\Io\File $ioFile,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Image\Factory $imageFactory
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        $this->filesystem = $filesystem;
        $this->_customerGroup = $customerGroup;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->httpFactory = $httpFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_ioFile = $ioFile;
        $this->_storeManager = $storeManager;
        $this->_imageFactory = $imageFactory;
        parent::__construct($context);
    }

	public function uploadCSV($scope)
    {
        $adapter = $this->httpFactory->create();

        if ($adapter->isUploaded($scope)) {
            if (!$adapter->isValid($scope)) {
                throw new \Exception(__('Uploaded CSV is not valid.'));
            }

            $uploader = $this->_fileUploaderFactory->create(['fileId' => $scope]);
            $uploader->setAllowedExtensions(['csv']);
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);
            $uploader->setAllowCreateFolders(false);

            if ($uploader->save($this->getPdfBaseDir())) {
                return $uploader->getUploadedFileName();
            }
        }
        return false;
    }

    public function getBaseDir()
    {
        $path = $this->filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(self::MEDIA_PATH);
        return $path;
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . '/' . self::MEDIA_PATH;
    }

	public function getPdfBaseDir()
    {
        $path = $this->filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(self::PDF_MEDIA_PATH);
        return $path;
    }

    public function getPdfBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . '/' . self::PDF_MEDIA_PATH;
    }

	public function getMediaUrl()
    {
		return $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );
	}

}
