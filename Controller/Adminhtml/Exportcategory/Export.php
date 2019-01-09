<?php

/**
 * @author  digvijay <digvijayemails@gmail.com>
 */

namespace Tutorialstab\ImportExportCategories\Controller\Adminhtml\Exportcategory;

/**
 * Export
 * @package Tutorialstab_ImportExportCategories
 */
class Export extends \Magento\Backend\App\Action
{
    /**
     * Redirect result factory
     *
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * constructor
     *
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $prodcollection
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $prodcollection,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Backend\App\Action\Context $context
    ) {

        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_storeManager = $storeManagerInterface;
        $this->_categoryFactory = $categoryFactory;
        $this->_productcollection = $prodcollection;
        $this->resultRawFactory = $resultRawFactory;
        $this->fileFactory  = $fileFactory;
        parent::__construct($context);
    }

    /**
     * Export Category and download csv files
     *
     * @return null
     */
    public function execute()
    {
        $store_id = $this->getRequest()->getPost('store_id');
        $singlestoremode = $this->_storeManager->isSingleStoreMode();
        $_stores = [];
        if (!$singlestoremode) {
            $stores = $this->_storeManager->getStores();
            foreach ($stores as $key => $store) {
                $_stores[$store->getId()] = $store->getCode();
            }
        }
        $fileName = 'categories.csv';
        $content = 'category_id,parent_id';
        $content .= ',store';
        $content .= ',name,path,image,is_active,is_anchor,include_in_menu,meta_title,meta_keywords,meta_description,display_mode,custom_use_parent_settings,custom_apply_to_products,custom_design,custom_design_from,custom_design_to,default_sort_by,page_layout,description,products'."\n";
        $collection = $this->_categoryFactory->create()->getCollection()->addAttributeToSort('entity_id', 'asc');

        foreach ($collection as $key => $cat) {
            $categoryitem = $this->_categoryFactory->create();
            if ($cat->getId()>=2) {
                $categoryitem->setStoreId($store_id);
                $categoryitem->load($cat->getId());
                if ($categoryitem->getId()) {
                    
                    $skuvals = '';
                    $productidsData = $this->_productcollection->addCategoryFilter($categoryitem);
                    $productids = $productidsData->getAllIds();
                    $skuData = array();
                    if($productidsData->getSize()>0){
                        foreach ($productidsData as $pdt) {
                            if(in_array($pdt->getId(),$productids)){
                             $skuData[] = $pdt->getSku();
                            }
                        }
                        $skuvals = implode('|', $skuData);
                    }


                    $content .= ''.$categoryitem->getId().','.$categoryitem->getParentId().',';
                    $content .= $_stores[$categoryitem->getStoreId()].',';                



                    $catName = "\"".str_replace("\",\"",",",$categoryitem->getName())."\"";
                    $catMetaTitle = "\"".str_replace("\",\"",",",$categoryitem->getMetaTitle())."\"";
                    $catMetaKeywords = "\"".str_replace("\",\"",",",$categoryitem->getMetaKeywords())."\"";
                    $catMetaDescription = "\"".str_replace("\",\"",",",$categoryitem->getMetaDescription())."\""; 
                    $catDescription =   "\"".str_replace("\",\"",",",$categoryitem->getDescription())."\"";          
                   

                    $content .= $catName.','.$categoryitem->getPath().','.$categoryitem->getImage().','.$categoryitem->getIsActive().','.$categoryitem->getIsAnchor().','.$categoryitem->getIncludeInMenu().','.$catMetaTitle.','.$catMetaKeywords.','.$catMetaDescription.','.$categoryitem->getDisplayMode().','.$categoryitem->getCustomUseParentSettings().','.$categoryitem->getCustomApplyToProducts().','.$categoryitem->getCustomDesign().','.$categoryitem->getCustomDesignFrom().','.$categoryitem->getCustomDesignTo().','.$categoryitem->getDefaultSortBy().','.$categoryitem->getPageLayout().','.$catDescription.','.$skuvals.''."\n";
                }
            }
        }
        $this->_prepareDownloadResponse($fileName, $content);
    }


    /**
     * Prepare and Download csv files
     *
     * @return Object
     */
    public function _prepareDownloadResponse($name, $content)
    {
        $fileName = $name;
        $this->fileFactory->create(
            $fileName,
            $content,
            'var',
            'text/csv',
            strlen($content)
        );
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw;
    }
}
