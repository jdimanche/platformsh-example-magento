<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\VisualMerchandiser\Test\Block\Adminhtml\Category\AddProduct;

use Magento\Backend\Test\Block\Widget\Tab;

class NameTab extends Tab
{
    protected $dataGrid = '#catalog_category_add_product_name_tab_content';

    /**
     * @return \Magento\VisualMerchandiser\Test\Block\Adminhtml\Category\AddProduct\DataGrid
     */
    public function getDataGrid()
    {
        return $this->blockFactory->create(
            'Magento\VisualMerchandiser\Test\Block\Adminhtml\Category\AddProduct\DataGrid',
            ['element' => $this->_rootElement->find($this->dataGrid)]
        );
    }
}
