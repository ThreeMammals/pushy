<?php
declare (strict_types = 1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

class WPDataAccessTest extends \WP_Mock\Tools\TestCase
{

    protected $data_access;

    public function setUp()
    {
        $this->$data_access = new \Pushy\WPDataAccess();
        \WP_Mock::setUp();
    }

    public function tearDown()
    {
        \WP_Mock::tearDown();
    }

    public function testGetCategories()
    {
        \WP_Mock::userFunction('get_categories', array(
            'times' => 1,
            'return' => [1, 2, 3],
        ));

        $result = $this->$data_access->getCategories();

        $this->assertEquals([1, 2, 3], $result);
    }

    public function testGetMenu()
    {
        \WP_Mock::userFunction('wp_get_nav_menu_items', array(
            'args' => 42,
            'times' => 1,
            'return' => [1, 2, 3],
        ));

        $result = $this->$data_access->getMenu(42);

        $this->assertEquals([1, 2, 3], $result);
    }

    public function testGetTags()
    {
        \WP_Mock::userFunction('get_tags', array(
            'times' => 1,
            'return' => [1, 2, 3],
        ));

        $result = $this->$data_access->getTags();

        $this->assertEquals([1, 2, 3], $result);
    }

    public function testGetPostMeta()
    {
        \WP_Mock::userFunction('get_post_meta', array(
            'args' => 42,
            'times' => 1,
            'return' => [1, 2, 3],
        ));

        $result = $this->$data_access->getPostMeta(42);

        $this->assertEquals([1, 2, 3], $result);
    }
}
