<?php



namespace Dcs\Productenquiry\Block\Adminhtml;



class Productenquiry extends \Magento\Backend\Block\Widget\Grid\Container

{

    protected function _construct()

    {

        $this->_controller = 'adminhtml_productenquiry';

        $this->_blockGroup = 'Dcs_Productenquiry';

        $this->_headerText = __('Product Enquiries');

        /* $this->_addButtonLabel = __('Add New Product Enquiry'); */

        parent::_construct();

       /* if ($this->_isAllowedAction('Dcs_Productenquiry::save')) {

            $this->buttonList->update('add', 'label', __('Add New Product Enquiry'));

        } else {

            $this->buttonList->remove('add');

        } */

		$this->buttonList->remove('add');

    }

  

    protected function _isAllowedAction($resourceId)

    {

        return $this->_authorization->isAllowed($resourceId);

    }

}

