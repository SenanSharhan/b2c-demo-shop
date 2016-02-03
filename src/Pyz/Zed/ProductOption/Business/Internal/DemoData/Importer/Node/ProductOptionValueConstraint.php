<?php

namespace Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Node;

use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Visitor\VisitableProductInterface;
use Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Visitor\ProductVisitorInterface;

class ProductOptionValueConstraint implements VisitableProductInterface
{

    /**
     * @var string
     */
    private $target;

    /**
     * @var string
     */
    private $operator;

    /**
     * @param \Pyz\Zed\ProductOption\Business\Internal\DemoData\Importer\Visitor\ProductVisitorInterface $visitor
     */
    public function accept(ProductVisitorInterface $visitor)
    {
        $visitor->visitProductOptionValueConstraint($this);
    }

    /**
     * @param string $target
     * @param string $operator
     */
    public function __construct($target, $operator)
    {
        $this->target = $target;
        $this->operator = $operator;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

}
