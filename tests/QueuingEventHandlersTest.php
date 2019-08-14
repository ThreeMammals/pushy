<?php
declare (strict_types = 1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

final class QueuingEventHandlersTest extends TestCase
{
    protected $handlers;
    protected $queue;

    public function setUp()
    {
        $this->handlers = $this->getMockBuilder(\Pushy\EventHandlers::class)
            ->getMock();

        $this->queue = new \Pushy\QueuingEventHandlers($this->handlers);
    }

    public function testPostUpdated(): void
    {
        $post = (object) ['post_type' => 'post', 'post_status' => 'publish', 'post_meta' => 'foo'];
        $post_id = 1;
        $update = 3;

        $this->handlers->expects($this->once())
            ->method('postUpdated')
            ->with($this->equalTo($post_id), $this->equalTo($post), $this->equalTo($update));

        $this->queue->postUpdated($post_id, $post, $update);
        $this->queue->shutdown();
    }

    public function testPostTrashed(): void
    {
        $post_id = 1;

        $this->handlers->expects($this->once())
            ->method('postTrashed')
            ->with($this->equalTo($post_id));

        $this->queue->postTrashed($post_id);
        $this->queue->shutdown();
    }

    public function testPostRestored(): void
    {
        $post_id = 1;

        $this->handlers->expects($this->once())
            ->method('postRestored')
            ->with($this->equalTo($post_id));

        $this->queue->postRestored($post_id);
        $this->queue->shutdown();
    }

    public function testPostDeleted(): void
    {
        $post_id = 1;

        $this->handlers->expects($this->once())
            ->method('postDeleted')
            ->with($this->equalTo($post_id));

        $this->queue->postDeleted($post_id);
        $this->queue->shutdown();
    }

    public function testCategoriesUpdated(): void
    {
        $category_id = 1;

        $this->handlers->expects($this->once())
            ->method('categoriesUpdated')
            ->with($this->equalTo($category_id));

        $this->queue->categoriesUpdated($category_id);
        $this->queue->shutdown();
    }

    public function testMenuUpdated(): void
    {
        $menu_id = 1;

        $this->handlers->expects($this->once())
            ->method('menuUpdated')
            ->with($this->equalTo($menu_id));

        $this->queue->menuUpdated($menu_id);
        $this->queue->shutdown();
    }

    public function testMenuDeleted(): void
    {
        $menu_id = 1;

        $this->handlers->expects($this->once())
            ->method('menuDeleted')
            ->with($this->equalTo($menu_id));

        $this->queue->menuDeleted($menu_id);
        $this->queue->shutdown();
    }

    public function testMediaUploaded(): void
    {
        $id = 1;

        $this->handlers->expects($this->once())
            ->method('mediaUploaded')
            ->with($this->equalTo($id));

        $this->queue->mediaUploaded($id);
        $this->queue->shutdown();
    }

    public function testAttachmentUploaded(): void
    {
        $id = 1;

        $this->handlers->expects($this->once())
            ->method('attachmentUploaded')
            ->with($this->equalTo($id));

        $this->queue->attachmentUploaded($id);
        $this->queue->shutdown();
    }

    public function testAttachmentDeleted(): void
    {
        $id = 1;

        $this->handlers->expects($this->once())
            ->method('attachmentDeleted')
            ->with($this->equalTo($id));

        $this->queue->attachmentDeleted($id);
        $this->queue->shutdown();
    }

    public function testAttachmentUpdated(): void
    {
        $id = 1;

        $this->handlers->expects($this->once())
            ->method('attachmentUpdated')
            ->with($this->equalTo($id));

        $this->queue->attachmentUpdated($id);
        $this->queue->shutdown();
    }

    public function testPagePublished(): void
    {
        $id = 1;

        $this->handlers->expects($this->once())
            ->method('pagePublished')
            ->with($this->equalTo($id));

        $this->queue->pagePublished($id);
        $this->queue->shutdown();
    }

    public function testPostMetaUpdated(): void
    {
        $meta_data = (object) ['id' => 1, 'object_id' => 2, 'meta_key' => 3, 'meta_value' => 4];

        $this->handlers->expects($this->once())
            ->method('postMetaUpdated')
            ->with($this->equalTo($meta_data->id), $this->equalTo($meta_data->object_id), $this->equalTo($meta_data->meta_key), $this->equalTo($meta_data->meta_value));

        $this->queue->postMetaUpdated($meta_data->id, $meta_data->object_id, $meta_data->meta_key, $meta_data->meta_value);
        $this->queue->shutdown();
    }

    public function testTagsUpdated(): void
    {
        $tag_id = 1;

        $this->handlers->expects($this->once())
            ->method('tagsUpdated')
            ->with($this->equalTo($tag_id));

        $this->queue->tagsUpdated($tag_id);
        $this->queue->shutdown();
    }

    public function testOptionUpdated(): void
    {
        $option = (object) ['option_name' => 1, 'old_value' => 2, 'value' => 3];

        $this->handlers->expects($this->once())
            ->method('optionUpdated')
            ->with($this->equalTo($option->option_name), $this->equalTo($option->old_value), $this->equalTo($option->value));

        $this->queue->optionUpdated($option->option_name, $option->old_value, $option->value);
        $this->queue->shutdown();
    }
}
