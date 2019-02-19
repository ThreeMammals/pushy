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
        $this->publisher->publish($post, 'PostUpdated');
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

    public function pageUpdated($id)
    {
        $this->publisher->publish($id, 'PageUpdated');
    }
}
