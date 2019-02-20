<?php
declare (strict_types = 1);

namespace Pushy;

interface DataAccess
{
    public function getCategories();
    public function getTags();
    public function getMenu($id);
}
