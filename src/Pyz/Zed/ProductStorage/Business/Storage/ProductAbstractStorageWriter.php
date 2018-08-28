<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductStorage\Business\Storage;

use Generated\Shared\Transfer\ProductAbstractStorageTransfer;
use Spryker\Zed\ProductStorage\Business\Storage\ProductAbstractStorageWriter as SprykerProductAbstractStorageWriter;

class ProductAbstractStorageWriter extends SprykerProductAbstractStorageWriter
{
     const COL_FK_PRODUCT_SET = 'fk_product_set';
    /**
     * @param array $productAbstractLocalizedEntity
     * @param \Generated\Shared\Transfer\ProductAbstractStorageTransfer $productAbstractStorageTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractStorageTransfer
     */
    protected function mapToProductAbstractStorageTransfer(
        array $productAbstractLocalizedEntity,
        ProductAbstractStorageTransfer $productAbstractStorageTransfer
    ) {
        $productAbstractStorageTransfer = parent::mapToProductAbstractStorageTransfer($productAbstractLocalizedEntity, $productAbstractStorageTransfer);

        $productAbstractStorageTransfer->setProductSetIds([]);

        if (isset($productAbstractLocalizedEntity['SpyProductAbstract']['SpyProductAbstractSets'])) {
            $productSetIds = [];
            foreach ($productAbstractLocalizedEntity['SpyProductAbstract']['SpyProductAbstractSets'] as $productAbstractSet) {
                if (isset($productAbstractSet[static::COL_FK_PRODUCT_SET])) {
                    $productSetIds[] = $productAbstractSet[static::COL_FK_PRODUCT_SET];
                }
            }

            $productAbstractStorageTransfer->setProductSetIds($productSetIds);
        }

        return $productAbstractStorageTransfer;
    }
}
