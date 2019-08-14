<?php
declare (strict_types = 1);

namespace Pushy;

interface EventHandlers
{
    public function postUpdated($post_id, $post, $update);
    public function postTrashed($post_id);
    public function postRestored($post_id);
    public function postDeleted($post_id);
    public function categoriesUpdated($category_id);
    public function menuUpdated($menu_id);
    public function menuDeleted($menu_id);
    public function mediaUploaded($id);
    public function attachmentUploaded($id);
    public function attachmentDeleted($id);
    public function attachmentUpdated($id);
    public function pagePublished($id);
    public function postMetaUpdated($id, $object_id, $meta_key, $meta_value);
    public function tagsUpdated($tag_id);
    public function optionUpdated($option_name, $old_value, $value);
}
