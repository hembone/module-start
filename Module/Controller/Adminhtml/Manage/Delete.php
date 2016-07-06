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
use Magento\TestFramework\ErrorLog\Logger;

/**
 * Delete
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class Delete extends \Magento\Backend\App\Action
{

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpine_Brand::delete');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('brand_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Alpine\Brand\Model\Brand');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The brand has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['brand_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a brand to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
