<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\ImportExportCategories\Block\Adminhtml\Exportcategory;

/**
 * Edit
 * @package Tutorialstab_ImportExportCategories
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * constructor
     *
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
    
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Test edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'export_id';
        $this->_blockGroup = 'Tutorialstab_ImportExportCategories';
        $this->_controller = 'adminhtml_exportcategory';
        parent::_construct();
        $this->buttonList->remove('save');
        $this->buttonList->remove('back');
        $this->buttonList->remove('reset');
        $this->buttonList->remove('delete');
    }
    /**
     * Retrieve text for header element depending on loaded Test
     *
     * @return string
     */
    public function getHeaderText()
    {
        return __('Export Categories');
    }
}
