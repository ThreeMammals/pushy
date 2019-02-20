<?php
declare (strict_types = 1);

namespace Pushy;

final class WPDataAccess implements DataAccess
{

    public function getCategories()
    {
        $categories = get_categories(array(
            'hide_empty' => 0,
        ));
        return $categories;
    }

    public function getMenu($id)
    {
        $menu_items = wp_get_nav_menu_items($id);
        return $menu_items;
    }
}
