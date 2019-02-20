<?php
/*
Plugin Name: Pushy
Plugin URI: http://www.threemammals.com/
Description: TBC...
Author: Tom Pallister
Version: 0.0.0
Author URI: http://github.com/TomPallister/
 */

require __DIR__ . '/vendor/autoload.php';

final class Pushy
{
    protected $eventHandlers;
    protected $data_access;
    protected $publisher;

    public function __construct()
    {
        $publisherFactory = new \Pushy\PublisherFactory(new \Pushy\UUIDProvider());
        $config = $this->getConfig();
        $this->publisher = $publisherFactory->get($config);
        $this->data_access = new \Pushy\WPDataAccess();
        $this->eventHandlers = new \Pushy\EventHandlers($this->publisher, $this->data_access);
    }

    public function run()
    {
        // This hook runs on every post save, update etc
        add_action('save_post', array($this, 'postUpdated'), 10, 3);

        // This hook runs when a post is trashed
        add_action('wp_trash_post', array($this, 'postTrashed'), 10);

        // This hook runs when a post is restored
        add_action('untrash_post', array($this, 'postRestored'), 10);

        // This hook runs when a trashed post is deleted
        add_action('delete_post', array($this, 'postDeleted'), 10);

        // This hook runs whenever a CRUD action happens on categories
        add_action('add_category_form_pre', array($this, 'categoriesUpdated'), 10, 1);
        add_action('edit_category', array($this, 'categoriesUpdated'), 10, 1);
        add_action('delete_category', array($this, 'categoriesUpdated'), 10, 1);
        add_action('create_category', array($this, 'categoriesUpdated'), 10, 1);

        // This hook runs whenever a menu is updated
        add_action('wp_update_nav_menu', array($this, 'menuUpdated'), 10);

        // This hook runs whenever a menu is deleted
        add_action('wp_delete_nav_menu', array($this, 'menuDeleted'), 10);

        // This hook runs whenever a media is uploaded
        add_filter('wp_handle_upload_prefilter', array($this, 'mediaUploaded'));

        // This hook runs whenever a attachment is uploaded
        add_action('add_attachment', array($this, 'attachmentUploaded'));

        // This hook runs whenever a attachment is deleted
        add_action('delete_attachment', array($this, 'attachmentDeleted'));

        // This hook runs whenever a page is published
        add_action('publish_page', array($this, 'pageUpdated'));

        // This hook runs whenever post meta is updated
        add_action('updated_postmeta', array($this, 'postMetaUpdated'), 10, 4);
    }

    public function getConfig()
    {
        $options = get_option('pushy_sample');

        $location = $options['location'] != null ? $options['location'] : '.';

        if ($options['FilePublisher'] != null) {
            if ($options['FilePublisher'] == 1) {
                $config = (object) ['type' => 'FilePublisher', 'location' => $location];
                return $config;
            }
        }

        if ($options['SNSPublisher'] != null) {
            if ($options['SNSPublisher'] == 1) {
                $config = (object) ['type' => 'SNSPublisher', 'location' => $location];
                return $config;
            }
        }

        $config = (object) ['type' => 'NothingPublisher', 'location' => $location];
        return $config;
    }

    public function postUpdated($post_id, $post, $update)
    {
        $this->eventHandlers->postUpdated($post_id, $post, $update);
    }

    public function postTrashed($post_id)
    {
        $this->eventHandlers->postTrashed($post_id);
    }

    public function postRestored($post_id)
    {
        $this->eventHandlers->postRestored($post_id);
    }

    public function postDeleted($post_id)
    {
        $this->eventHandlers->postDeleted($post_id);
    }

    public function categoriesUpdated($category_id)
    {
        $this->eventHandlers->categoriesUpdated($category_id);
    }

    public function menuUpdated($menu_id)
    {
        $this->eventHandlers->menuUpdated($menu_id);
    }

    public function menuDeleted($menu_id)
    {
        $this->eventHandlers->menuDeleted($menu_id);
    }

    public function mediaUploaded($id)
    {
        $this->eventHandlers->mediaUploaded($id);
        return $id;
    }

    public function attachmentUploaded($id)
    {
        $this->eventHandlers->attachmentUploaded($id);
    }

    public function attachmentDeleted($id)
    {
        $this->eventHandlers->attachmentDeleted($id);
    }

    public function pageUpdated($id)
    {
        $this->eventHandlers->pageUpdated($id);
    }

    public function postMetaUpdated($id, $object_id, $meta_key, $meta_value)
    {
        $this->eventHandlers->postMetaUpdated($id, $object_id, $meta_key, $meta_value);
    }
}

function run_pushy()
{
    $pushy = new Pushy();
    $pushy->run();
}

run_pushy();

add_action('admin_init', 'pushy_sampleoptions_init');
add_action('admin_menu', 'pushy_sampleoptions_add_page');

// Init plugin options to white list our options
function pushy_sampleoptions_init()
{
    register_setting('pushy_sampleoptions_options', 'pushy_sample', 'pushy_sampleoptions_validate');
}

// Add menu page
function pushy_sampleoptions_add_page()
{
    add_options_page('Pushy Options', 'Pushy Options', 'manage_options', 'pushy_sampleoptions', 'pushy_sampleoptions_do_page');
}

// Draw the menu page itself
function pushy_sampleoptions_do_page()
{
    ?>
	<div class="wrap">
		<h2>Pushy Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('pushy_sampleoptions_options');?>
			<?php $options = get_option('pushy_sample');?>
			<table class="form-table">
				<tr valign="top"><th scope="row">FilePublisher</th>
					<td><input name="pushy_sample[FilePublisher]" type="checkbox" value="1" <?php checked('1', $options['FilePublisher']);?> /></td>
				</tr>
				<tr valign="top"><th scope="row">SNSPublisher</th>
					<td><input name="pushy_sample[SNSPublisher]" type="checkbox" value="1" <?php checked('1', $options['SNSPublisher']);?> /></td>
				</tr>
				<tr valign="top"><th scope="row">Location</th>
					<td><input type="text" name="pushy_sample[location]" value="<?php echo $options['location']; ?>" /></td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes')?>" />
			</p>
		</form>
	</div>
	<?php
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function pushy_sampleoptions_validate($input)
{
    // Our first value is either 0 or 1
    if (isset($input['FilePublisher'])) {
        $input['FilePublisher'] = ($input['FilePublisher'] == 1 ? 1 : 0);
    } else {
        $input['FilePublisher'] = 0;
    }

    if (isset($input['SNSPublisher'])) {
        $input['SNSPublisher'] = ($input['SNSPublisher'] == 1 ? 1 : 0);
    } else {
        $input['SNSPublisher'] = 0;
    }

    // Say our second option must be safe text with no HTML tags
    $input['location'] = wp_filter_nohtml_kses($input['location']);

    return $input;
}
