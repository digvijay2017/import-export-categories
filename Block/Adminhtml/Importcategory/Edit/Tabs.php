<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\ImportExportCategories\Block\Adminhtml\Importcategory\Edit;

/**
 * Tabs
 * @package Tutorialstab_ImportExportCategories
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('import_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Import Categories'));
    }
}
