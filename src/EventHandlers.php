<?php
declare (strict_types = 1);

namespace Pushy;

final class EventHandlers
{

    protected $publisher;
    protected $data_access;

    public function __construct(Publisher $publisher, DataAccess $data_access)
    {
        $this->publisher = $publisher;
        $this->data_access = $data_access;
    }

    public function postUpdated($post_id, $post, $update)
    {
        $post_meta = $this->data_access->getPostMeta($post_id);

        // todo - this seems to be the best way to do this?
        $post = (array)$post;
        $post['post_meta'] = $post_meta;
        $post = (object)$post;

        // todo - this is meh
        if ($post->post_type == 'post' && $post->post_status == 'publish') {
            $this->publisher->publish($post, 'PostUpdated');
        } else if ($post->post_type == 'post' && $post->post_status == 'private') {
            $this->publisher->publish($post, 'PostUpdated');
        } else if ($post->post_type == 'post' && $post->post_status == 'trash') {
            $this->publisher->publish($post, 'PostTrashed');
        } else if ($post->post_type == 'revision') {
            $this->publisher->publish($post, 'Revision');
        } else if ($post->post_type == 'post' && ($post->post_status == 'auto-draft' || $post->post_status == 'draft')) {
            $this->publisher->publish($post, 'PostDraft');
        } else if ($post->post_type == 'page' && $post->post_status == 'publish') {
            $this->publisher->publish($post, 'PageUpdated');
        } else if ($post->post_type == 'page' && ($post->post_status == 'auto-draft' || $post->post_status == 'draft')) {
            $this->publisher->publish($post, 'PageDraft');
        } else if ($post->post_type == 'nav_menu_item' && $post->post_status == 'publish') {
            $this->publisher->publish($post, 'MenuItemPublished');
        } else if ($post->post_type == 'page' && $post->post_status == 'future') {
            $this->publisher->publish($post, 'FuturePageUpdated');
        } else if ($post->post_type == 'post' && $post->post_status == 'future') {
            $this->publisher->publish($post, 'FuturePostUpdated');
        } else {
            $this->publisher->publish($post, 'UnknownPost');
        }
    }

    public function postTrashed($post_id)
    {
        $this->publisher->publish($post_id, 'PostTrashed');
    }

    public function postRestored($post_id)
    {
        $this->publisher->publish($post_id, 'PostRestored');
    }

    public function postDeleted($post_id)
    {
        $this->publisher->publish($post_id, 'PostDeleted');
    }

    public function categoriesUpdated($category_id)
    {
        $categories = $this->data_access->getCategories(array(
            'hide_empty' => 0,
        ));

        $this->publisher->publish($categories, 'CategoriesUpdated');
    }

    public function menuUpdated($menu_id)
    {
        $menu_items = $this->data_access->getMenu($menu_id);
        
        $this->publisher->publish($menu_items, 'MenuUpdated');
    }

    public function menuDeleted($menu_id)
    {
        $this->publisher->publish($menu_id, 'MenuDeleted');
    }

    public function mediaUploaded($id)
    {
        $this->publisher->publish($id, 'MediaUploaded');
    }

    public function attachmentUploaded($id)
    {
        $this->publisher->publish($id, 'AttachmentUploaded');
    }

    public function attachmentDeleted($id)
    {
        $this->publisher->publish($id, 'AttachmentDeleted');
    }

    public function attachmentUpdated($id)
    {
        $this->publisher->publish($id, 'AttachmentUpdated');
    }

    public function pagePublished($id)
    {
        $this->publisher->publish($id, 'PagePublished');
    }

    public function postMetaUpdated($id, $object_id, $meta_key, $meta_value)
    {
        $meta_data = (object) ['id' => $id, 'object_id' => $object_id, 'meta_key' => $meta_key, 'meta_value' => $meta_value];

        $this->publisher->publish($meta_data, 'PostMetaUpdated');
    }

    public function tagsUpdated($tag_id)
    {
        $tags = $this->data_access->getTags(array(
            'hide_empty' => 0,
        ));

        $this->publisher->publish($tags, 'TagsUpdated');
    }

    public function optionUpdated($option_name, $old_value, $value)
    {
        $option = (object) ['option_name' => $option_name, 'old_value' => $old_value, 'value' => $value];

        $this->publisher->publish($option, 'OptionUpdated');
    }
}
