<?php
/**
 * 2016 Smart Soft.
 *
 * @author    Marcin Kubiak
 * @copyright Smart Soft
 * @license   Commercial License
 *  International Registered Trademark & Property of Smart Soft
 */

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__) . '/../../amazingzoom.php';

class AmazingZoomTest extends TestCase
{
    const AmazingZoom = 'amazingzoom';
    public $amazingzoom;

    public function setup()
    {
        $this->amazingzoom = $this->getMockBuilder(self::AmazingZoom)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
