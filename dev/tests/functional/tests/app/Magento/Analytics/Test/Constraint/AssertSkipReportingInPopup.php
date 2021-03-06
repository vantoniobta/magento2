<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Analytics\Test\Constraint;

use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Verify that admin user chose to skip Advanced Reporting on Analytics pop-up.
 */
class AssertSkipReportingInPopup extends AbstractConstraint
{
    /**
     * Verify that admin user chose to skip Advanced Reporting on Analytics pop-up.
     *
     * @param Dashboard $dashboard
     * @return void
     */
    public function processAssert(Dashboard $dashboard)
    {
        $dashboard->open();
        $dashboard->getSubscriptionBlock()->disableCheckbox();
        $dashboard->getSubscriptionBlock()->skipAdvancedReporting();
        \PHPUnit_Framework_Assert::assertFalse(
            $dashboard->getSubscriptionBlock()->isVisible(),
            'Advanced Reporting was not skipped'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Advanced Reporting was skipped';
    }
}
