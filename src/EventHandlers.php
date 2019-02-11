<?php
declare(strict_types=1);

namespace Pushy;

final class EventHandlers {

	protected $publisher;
	protected $data_access;

	public function __construct(Publisher $publisher, DataAccess $data_access)
    {
		$this->publisher = $publisher;
		$this->data_access = $data_access;
	}
	
	public function postUpdated( $post_ID, $post, $update ) {
		$this->publisher->publish($post);
	}

	public function postTrashed( $post_id ) {
		$this->publisher->publish($post_id);
	}

	public function postRestored( $post_id ) {
		$this->publisher->publish($post_id);
	}

	public function postDeleted( $post_id ) {
		$this->publisher->publish($post_id);
	}

	public function categoriesUpdated($category_id) {
		$categories = $this->data_access->getCategories(array(
			'hide_empty' => 0
		));

		$this->publisher->publish($categories);
	}

	public function menuUpdated($menu_id) {
		$menu_items = $this->data_access->getMenu($menu_id);
		$this->publisher->publish($menu_items);
	}

	public function menuDeleted($menu_id) {
		$this->publisher->publish($menu_id);
	}
}

