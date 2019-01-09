<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\ImportExportCategories\Block\Adminhtml\Exportcategory\Edit\Tab;

/**
 * Exportcategory
 * @package Tutorialstab_ImportExportCategories
 */
class Exportcategory extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storemanager = $objectManager->create('Magento\Store\Model\StoreManagerInterface');

        $fieldsetexport = $form->addFieldset(
            'export_fieldset',
            [
                'legend' => __('Export Categories'),
                'class'  => 'fieldset-wide'
            ]
        );
        $_stores = [];
        $stores = $storemanager->getStores();
        foreach ($stores as $key => $store) {
            $_stores[$store->getId()] = $store->getName();
        }
        $fieldsetexport->addField(
            'store_id',
            'select',
            [
                'name'  => 'store_id',
                'label' => __('Export From Store'),
                'text' => __('Export From Store'),
                'values'  => $_stores
            ]
        );
        
        $_field = $fieldsetexport->addField(
            'export_all',
            'submit',
            [
                'name'  => 'export_all',
                'text' => __('Export All Categories'),
                'class' => 'action-default scalable save primary',
                'value'     => __('Export All Categories'),
                'style' => 'width:175px'
            ]
        );


        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Export Categories');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
