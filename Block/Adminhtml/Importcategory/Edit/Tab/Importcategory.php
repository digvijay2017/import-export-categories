<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\ImportExportCategories\Block\Adminhtml\Importcategory\Edit\Tab;

/**
 * Importcategory
 * @package Tutorialstab_ImportExportCategories
 */
class Importcategory extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
        $url = $this->getViewFileUrl('Tutorialstab_ImportExportCategories/tutorialstab_importexportcategories.zip');

        $fieldsetimport = $form->addFieldset(
            'import_fieldset',
            [
                'legend' => __('Import Categories'),
                'class'  => 'fieldset-wide'
            ]
        );
        $fieldsetimport->addField(
            'file',
            'file',
            [
                'name'  => 'file',
                'label' => __('Upload File'),
                'title' => __('Upload File'),
                'required' => true,
            ]
        );


        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Sample Files'),
                'class'  => 'fieldset-wide'
            ]
        );
        $fieldset->addField(
            'export_sample',
            'button',
            [
                'name'  => 'export_sample',
                'label' => __('Sample Files'),
                'text' => __('Sample Files'),
                'value'     => __('Sample Files'),
                'onclick'   => "javascript:window.location = '$url' ",
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
        return __('Import Categories');
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
