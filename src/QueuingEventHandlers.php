<?php
declare (strict_types = 1);

namespace Pushy;

final class QueuingEventHandlers
{
    protected $queued;
    protected $handlers;

    public function __construct(EventHandlers $handlers)
    {
        $this->handlers = $handlers;
        $this->queued = [];
    }

    public function shutdown()
    {
        // have a shit case statement here..
        foreach ($this->queued as $event) {
            switch ($event->type) {
                case 'PostUpdated':
                    $this->handlers->postUpdated($event->post_id, $event->post, $event->update);
                    break;
                case 'PostTrashed':
                    $this->handlers->postTrashed($event->post_id);
                    break;
                case 'PostRestored':
                    $this->handlers->postRestored($event->post_id);
                    break;
                case 'PostDeleted':
                    $this->handlers->postDeleted($event->post_id);
                    break;
                case 'CategoriesUpdated':
                    $this->handlers->categoriesUpdated($event->category_id);
                    break;
                case 'MenuUpdated':
                    $this->handlers->menuUpdated($event->menu_id);
                    break;
                case 'MenuDeleted':
                    $this->handlers->menuDeleted($event->menu_id);
                    break;
                case 'MediaUploaded':
                    $this->handlers->mediaUploaded($event->id);
                    break;
                case 'AttachmentUploaded':
                    $this->handlers->attachmentUploaded($event->id);
                    break;
                case 'AttachmentDeleted':
                    $this->handlers->attachmentDeleted($event->id);
                    break;
                case 'AttachmentUpdated':
                    $this->handlers->attachmentUpdated($event->id);
                    break;
                case 'PagePublished':
                    $this->handlers->pagePublished($event->id);
                    break;
                case 'PostMetaUpdated':
                    $this->handlers->postMetaUpdated($event->id, $event->object_id, $event->meta_key, $event->meta_value);
                    break;
                case 'TagsUpdated':
                    $this->handlers->tagsUpdated($event->tag_id);
                    break;
                case 'OptionUpdated':
                    $this->handlers->optionUpdated($event->option_name, $event->old_value, $event->value);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    public function postUpdated($post_id, $post, $update)
    {
        $event = (object) ['type' => 'PostUpdated', 'post_id' => $post_id, 'post' => $post, 'update' => $update];
        array_push($this->queued, $event);
    }

    public function postTrashed($post_id)
    {
        $event = (object) ['type' => 'PostTrashed', 'post_id' => $post_id];
        array_push($this->queued, $event);
    }

    public function postRestored($post_id)
    {
        $event = (object) ['type' => 'PostRestored', 'post_id' => $post_id];
        array_push($this->queued, $event);
    }

    public function postDeleted($post_id)
    {
        $event = (object) ['type' => 'PostDeleted', 'post_id' => $post_id];
        array_push($this->queued, $event);
    }

    public function categoriesUpdated($category_id)
    {
        $event = (object) ['type' => 'CategoriesUpdated', 'category_id' => $category_id];
        array_push($this->queued, $event);
    }

    public function menuUpdated($menu_id)
    {
        $event = (object) ['type' => 'MenuUpdated', 'menu_id' => $menu_id];
        array_push($this->queued, $event);
    }

    public function menuDeleted($menu_id)
    {
        $event = (object) ['type' => 'MenuDeleted', 'menu_id' => $menu_id];
        array_push($this->queued, $event);
    }

    public function mediaUploaded($id)
    {
        $event = (object) ['type' => 'MediaUploaded', 'id' => $id];
        array_push($this->queued, $event);
    }

    public function attachmentUploaded($id)
    {
        $event = (object) ['type' => 'AttachmentUploaded', 'id' => $id];
        array_push($this->queued, $event);
    }

    public function attachmentDeleted($id)
    {
        $event = (object) ['type' => 'AttachmentDeleted', 'id' => $id];
        array_push($this->queued, $event);
    }

    public function attachmentUpdated($id)
    {
        $event = (object) ['type' => 'AttachmentUpdated', 'id' => $id];
        array_push($this->queued, $event);
    }

    public function pagePublished($id)
    {
        $event = (object) ['type' => 'PagePublished', 'id' => $id];
        array_push($this->queued, $event);
    }

    public function postMetaUpdated($id, $object_id, $meta_key, $meta_value)
    {
        $event = (object) ['type' => 'PostMetaUpdated', 'id' => $id, 'object_id' => $object_id, 'meta_key' => $meta_key, 'meta_value' => $meta_value];
        array_push($this->queued, $event);
    }

    public function tagsUpdated($tag_id)
    {
        $event = (object) ['type' => 'TagsUpdated', 'tag_id' => $tag_id];
        array_push($this->queued, $event);
    }

    public function optionUpdated($option_name, $old_value, $value)
    {
        $event = (object) ['type' => 'OptionUpdated', 'option_name' => $option_name, 'old_value' => $old_value, 'value' => $value];
        array_push($this->queued, $event);
    }
}
