<?php
declare (strict_types = 1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

final class EventHandlersTest extends TestCase
{
    protected $publisher;
    protected $data_access;
    protected $event_handlers;

    public function setUp()
    {
        $this->publisher = $this->getMockBuilder(\Pushy\Publisher::class)
            ->getMock();
        $this->data_access = $this->getMockBuilder(\Pushy\DataAccess::class)
            ->getMock();
        $this->event_handlers = new \Pushy\EventHandlers($this->publisher, $this->data_access);
    }

    public function testPostUpdated(): void
    {
        $post = (object) ['post_type' => 'post'];

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PostUpdated'));

        $this->event_handlers->postUpdated(1, $post, 3);
    }

    public function testPostRevision(): void
    {
        $post = (object) ['post_type' => 'revision'];

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PostRevision'));

        $this->event_handlers->postUpdated(1, $post, 3);
    }

    public function testPostTrashed(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo(1), $this->equalTo('PostTrashed'));

        $this->event_handlers->postTrashed(1);
    }

    public function testPostRestored(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo(1), $this->equalTo('PostRestored'));

        $this->event_handlers->postRestored(1);
    }

    public function testPostDeleted(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo(1), $this->equalTo('PostDeleted'));

        $this->event_handlers->postDeleted(1);
    }

    public function testCategoriesUpdated(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo('foo'), $this->equalTo('CategoriesUpdated'));

        $this->data_access->expects($this->once())
            ->method('getCategories')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getCategories')
            ->with($this->equalTo(array(
                'hide_empty' => 0,
            )));

        $this->event_handlers->categoriesUpdated(1);
    }

    public function testMenuUpdated(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo('foo'), $this->equalTo('MenuUpdated'));

        $this->data_access->expects($this->once())
            ->method('getMenu')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getMenu')
            ->with($this->equalTo(1));

        $this->event_handlers->menuUpdated(1);
    }

    public function testMenuDeleted(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo(1), $this->equalTo('MenuDeleted'));

        $this->event_handlers->menuDeleted(1);
    }

    public function testMediaUploaded(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo(1), $this->equalTo('MediaUploaded'));

        $this->event_handlers->mediaUploaded(1);
    }

    public function testAttachmentUploaded(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo(1), $this->equalTo('AttachmentUploaded'));

        $this->event_handlers->attachmentUploaded(1);
    }

    public function testAttachmentDeleted(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish', $this->equalTo('AttachmentDeleted'))
            ->with($this->equalTo(1));

        $this->event_handlers->attachmentDeleted(1);
    }

    public function testPageUpdated(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish', $this->equalTo('PageUpdated'))
            ->with($this->equalTo(1));

        $this->event_handlers->pageUpdated(1);
    }

    public function testPostMetaUpdated(): void
    {
        $meta_data = (object) ['id' => 1, 'object_id' => 2, 'meta_key' => 3, 'meta_value' => 4];

        $this->publisher->expects($this->once())
            ->method('publish', $this->equalTo('PostMetaUpdated'))
            ->with($this->equalTo($meta_data));

        $this->event_handlers->postMetaUpdated(1, 2, 3, 4);
    }
}
