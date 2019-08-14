<?php
declare (strict_types = 1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

final class PublishingEventHandlers extends TestCase
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
        $this->event_handlers = new \Pushy\PublishingEventHandlers($this->publisher, $this->data_access);
    }

    public function testPostUpdated(): void
    {
        $post = (object) ['post_type' => 'post', 'post_status' => 'publish', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PostUpdated'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPrivatePostUpdated(): void
    {
        $post = (object) ['post_type' => 'post', 'post_status' => 'private', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PostUpdated'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPageUpdated(): void
    {
        $post = (object) ['post_type' => 'page', 'post_status' => 'publish', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PageUpdated'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testRevision(): void
    {
        $post = (object) ['post_type' => 'revision', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('Revision'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPostAutoDraft(): void
    {
        $post = (object) ['post_type' => 'post', 'post_status' => 'auto-draft', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PostDraft'));
        
        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPostDraft(): void
    {
        $post = (object) ['post_type' => 'post', 'post_status' => 'draft', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PostDraft'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPageDraft(): void
    {
        $post = (object) ['post_type' => 'page', 'post_status' => 'draft', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PageDraft'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPageAutoDraft(): void
    {
        $post = (object) ['post_type' => 'page', 'post_status' => 'auto-draft', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PageDraft'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testNavMenuItem(): void
    {
        $post = (object) ['post_type' => 'nav_menu_item', 'post_status' => 'publish', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('MenuItemPublished'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPageFuture(): void
    {
        $post = (object) ['post_type' => 'page', 'post_status' => 'future', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('FuturePageUpdated'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPostFuture(): void
    {
        $post = (object) ['post_type' => 'post', 'post_status' => 'future', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('FuturePostUpdated'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
    }

    public function testPostTrashed(): void
    {
        $post = (object) ['post_type' => 'post', 'post_status' => 'trash', 'post_meta' => 'foo'];
        $post_id = 1;

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo($post), $this->equalTo('PostTrashed'));

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getPostMeta')
            ->with($this->equalTo($post_id));

        $this->event_handlers->postUpdated($post_id, $post, 3);
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

    public function testAttachmentUpdated(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish', $this->equalTo('AttachmentUpdated'))
            ->with($this->equalTo(1));

        $this->event_handlers->attachmentUpdated(1);
    }

    public function testPagePublished(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish', $this->equalTo('PagePublished'))
            ->with($this->equalTo(1));

        $this->event_handlers->pagePublished(1);
    }

    public function testPostMetaUpdated(): void
    {
        $meta_data = (object) ['id' => 1, 'object_id' => 2, 'meta_key' => 3, 'meta_value' => 4];

        $this->publisher->expects($this->once())
            ->method('publish', $this->equalTo('PostMetaUpdated'))
            ->with($this->equalTo($meta_data));

        $this->event_handlers->postMetaUpdated(1, 2, 3, 4);
    }

    public function testOptionUpdated(): void
    {
        $option = (object) ['option_name' => 1, 'old_value' => 2, 'value' => 3];

        $this->publisher->expects($this->once())
            ->method('publish', $this->equalTo('OptionUpdated'))
            ->with($this->equalTo($option));

        $this->event_handlers->optionUpdated(1, 2, 3);
    }

    public function testTagsUpdated(): void
    {
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with($this->equalTo('foo'), $this->equalTo('TagsUpdated'));

        $this->data_access->expects($this->once())
            ->method('getTags')
            ->willReturn('foo');

        $this->data_access->expects($this->once())
            ->method('getTags')
            ->with($this->equalTo(array(
                'hide_empty' => 0,
            )));

        $this->event_handlers->tagsUpdated(1);
    }
}
