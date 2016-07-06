<?php
/**
 * Alpine Brand Extension
 *
 * @category Alpine
 * @package Alpine_Brand
 * @copyright Copyright (c) 2016 Alpine Consulting, Inc (www.alpineinc.com)
 * @author Alpine Consulting (magento@alpineinc.com)
 */

namespace Alpine\Brand\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Save
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var File
     */
    private $file;

    private $fileId = 'image';

    private $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

    private $filePath = 'alpine/brand/images';

    /**
     * Construct
     *
     * @param Context $context
     * @param UploaderFactory|Uploader $uploaderFactory
     * @param Filesystem $filesystem
     */
    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        File $file
    ) {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->file = $file;
    }

    /**
     * Permissions
     * 
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpine_Brand::save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Alpine\Brand\Model\Brand $model */
            $model = $this->_objectManager->create('Alpine\Brand\Model\Brand');

            $id = $this->getRequest()->getParam('brand_id');
            if ($id) {
                $model->load($id);
            }
            
            $res = $this->imageManager($data);
            if ($res['processed']) {
                $data[$this->fileId] = $res['result'];
            }
            
            $model->setData($data);

            $this->_eventManager->dispatch(
                'blog_post_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Brand.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['brand_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the brand.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['brand_id' => $this->getRequest()->getParam('brand_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Image manager
     *
     * If a new image exists, upload it and return the image name.
     * If the delete flag exists, remove image file.
     *
     * @param $data
     * @return bool|string
     */
    public function imageManager($data)
    {
        if (isset($_FILES['image']) && isset($_FILES['image']['name']) && strlen($_FILES['image']['name'])) {
            $destinationPath = $this->getDirPath($this->filePath);
            $newFilename = $this->getNewFilename($_FILES['image']['name']);
            $uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
                ->setAllowCreateFolders(true)
                ->setAllowRenameFiles(true)
                ->setAllowedExtensions($this->allowedExtensions);
            try {
                $uploader->save($destinationPath, $newFilename);
                return ['processed'=>true, 'result'=>$this->filePath.'/'.$newFilename];
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while uploading the image.'));
            }
        }

        if (isset($data['image'])) {
            if (isset($data['image']['delete'])) {
                $basePath = $this->getDirPath('/');
                if ($this->file->isExists($basePath.$data['image']['value'])) {
                    try {
                        $this->file->deleteFile($basePath.$data['image']['value']);
                        return ['processed'=>true, 'result'=>''];
                    } catch (\Magento\Framework\Exception\LocalizedException $e) {
                        $this->messageManager->addError($e->getMessage());
                    } catch (\RuntimeException $e) {
                        $this->messageManager->addError($e->getMessage());
                    } catch (\Exception $e) {
                        $this->messageManager->addException($e, __('Something went wrong while deleting the image.'));
                    }
                }
            } else {
                return ['processed'=>true, 'result'=>$data['image']['value']];
            }
        }

        return ['processed'=>false];
    }

    /**
     * Get directory path
     * 
     * @param $path
     * @return string
     */
    public function getDirPath($path)
    {
        return $this->filesystem
            ->getDirectoryWrite(DirectoryList::MEDIA)
            ->getAbsolutePath($path);
    }

    /**
     * Generate a random filename
     * 
     * @param $name
     * @return string
     */
    public function getNewFilename($name)
    {
        $parts = explode('.', $name);
        return md5($parts[0].time()).'.'.$parts[1];
    }

}
