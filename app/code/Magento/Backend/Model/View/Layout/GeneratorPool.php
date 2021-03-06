<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Backend\Model\View\Layout;

use Magento\Framework\View\Layout\ScheduledStructure;
use Magento\Framework\View\Layout\Data\Structure;
use Magento\Framework\App\ObjectManager;

/**
 * Pool of generators for structural elements
 */
class GeneratorPool extends \Magento\Framework\View\Layout\GeneratorPool
{
    /**
     * @var Filter\Acl
     */
    protected $aclFilter;

    /**
     * @var FilterInterface
     */
    private $filter;

    /**
     * @param ScheduledStructure\Helper $helper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\ScopeResolverInterface $scopeResolver
     * @param \Psr\Log\LoggerInterface $logger
     * @param Filter\Acl $aclFilter
     * @param array $generators
     */
    public function __construct(
        ScheduledStructure\Helper $helper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\ScopeResolverInterface $scopeResolver,
        \Psr\Log\LoggerInterface $logger,
        Filter\Acl $aclFilter,
        array $generators = null
    ) {
        $this->aclFilter = $aclFilter;
        parent::__construct(
            $helper,
            $scopeConfig,
            $scopeResolver,
            $logger,
            $generators
        );
    }

    /**
     * @return FilterInterface
     */
    private function getFilter()
    {
        if (!$this->filter) {
            $this->filter = ObjectManager::getInstance()->get(FilterInterface::class);
        }
        return $this->filter;
    }

    /**
     * Build structure that is based on scheduled structure
     *
     * @param ScheduledStructure $scheduledStructure
     * @param Structure $structure
     * @return $this
     */
    protected function buildStructure(ScheduledStructure $scheduledStructure, Structure $structure)
    {
        parent::buildStructure($scheduledStructure, $structure);
        $this->getFilter()->filterElement($scheduledStructure, $structure);
        return $this;
    }
}
