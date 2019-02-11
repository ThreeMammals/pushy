<?php
declare(strict_types=1);

namespace Pushy;

interface DataAccess
{
    public function getCategories();
	public function getMenu($menu_id);
}