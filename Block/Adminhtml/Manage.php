<?php
/**
 * Alpine Brand Extension
 *
 * @category Alpine
 * @package Alpine_Brand
 * @copyright Copyright (c) 2016 Alpine Consulting, Inc (www.alpineinc.com)
 * @author Alpine Consulting (magento@alpineinc.com)
 */

namespace Alpine\Brand\Block\Adminhtml;

/**
 * Manage
 *
 * @category Alpine
 * @package Alpine_Brand
 */
class Manage extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Construct
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_manage';
        $this->_blockGroup = 'Alpine_Brand';
        $this->_headerText = __('Manage Brands');

        parent::_construct();

        if ($this->_isAllowedAction('Alpine_Brand::save')) {
            $this->buttonList->update('add', 'label', __('Add New Brand'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    /**
     * Permissions
     * 
     * @param $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
