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

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;


/**
 * Index
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class Index extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Construct
     * 
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alpine_Brand::manage');
        $resultPage->addBreadcrumb(__('Brands'), __('Brands'));
        $resultPage->addBreadcrumb(__('Manage Brands'), __('Manage Brands'));
        $resultPage->getConfig()->getTitle()->prepend(__('Brands'));
        return $resultPage;
    }

    /**
     * Permissions
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpine_Brand::brand');
    }


}
