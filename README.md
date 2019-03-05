# Pushy

## What is it?

Pushy is an open source Wordpress plugin that pushes data out of wordpress in the form of events. This enables using Wordpress as a headless CMS. That is rather than user requests for content hitting Wordpress for rendering etc you can create your own UI using whatever technology you want.

This pattern is proving somewhat popular for legacy systems like Wordpress and Magento. These systems provide amazing features but their API offerings are difficult to use if you wanted to use something like React (Native) & GraphQL.

This pattern is also useful if you need to scale beyond what Wordpress is capable of and have an optimised read model.

This is basically meant to be souped up webhooks.

## Why?

My work want to make Wordpress headless but we don't really have time to work on it. I thought it was an interesting idea so started this to see how it might work in terms of pushing data out.

I am not a PHP developer really so please forgive anything that sucks.

## What can I push the messages to?

At the moment you can push the messages to disk using the FilePublisher and AWS SNS using the SNSPublisher. The FilePublisher is only meant to be used for manual testing and messing around.

After you install Pushy as a wordpress plugin you will get a section added under options called `Pushy Options`. Under this you can set if you want to use the FilePublisher or SNSPublisher. The location is either the root path where you want the FilePublisher to write the messages e.g. `/var/www/html/data/` or the SNS topic arn prefix e.g. `arn:aws:sns:eu-west-1:940731442544:`. This is because Pushy will publish an event with a name to this location e.g. SNS it will publish to `arn:aws:sns:eu-west-1:940731442544:PostUpdated` when a post is updated or to `/var/www/html/data/PostUpdated-35c48bc8-348d-11e9-8e72-0242ac120003.json` using the FilePublisher. Note the guid here is just the messages id for uniqueness.

## What events are published?

- action save_post post_type post and post_status publish publishes PostUpdated event
- action save_post post_type post and post_status private publishes PostUpdated event
- action save_post post_type post and post_status trash publishes PostTrashed event
- action save_post post_type revision publishes Revision event
- action save_post post_type post and post_status draft publishes PostDraft event
- action save_post post_type post and post_status auto-draft publishes PostDraft event
- action save_post post_type page and post_status auto-draft publishes PageDraft event
- action save_post post_type page and post_status draft publishes PageDraft event
- action save_post post_type page and post_status publish publishes PageUpdated event
- action save_post post_type nav_menu_item and post_status publish publishes MenuItemPublished event
- action save_post post_type post and post_status future publishes FuturePostUpdated event
- action save_post post_type page and post_status future publishes FuturePageUpdated event
- action untrash_post publishes PostRestored event
- action delete_post publishes PostDeleted event
- action edit_category, delete_category, create_category publishes CategoriesUpdated event
- action wp_update_nav_menu publishes MenuUpdated event
- action wp_delete_nav_menu publishes MenuDeleted event
- filter wp_handle_upload_prefilter publishes MediaUploaded event
- action add_attachment publishes AttachmentUploaded event
- action delete_attachment publishes AttachmentDeleted event
- action update_attachment publishes AttachmentUpdated event
- action publish_page publishes PagePublished event
- action updated_postmeta publishes PostMetaUpdated event
- action edit_post_tag, delete_post_tag, create_post_tag publishes TagsUpdated event

These events all contain the data serialised as json that is passed into the hook by Wordpress. Some of them make additonal data fetches.

## Whats next?

Generally make everything better. At the moment not all hooks that are relavent are supported. Maybe we should fetch more data when doing say PostUpdated? Can we be more accurate with save PostCreated rather than just PostUpdated etc. Can we target specific post types better. Can we do better with media?

List of actions we can use [here](https://adambrown.info/p/wp_hooks/hook/actions)

## How do I run the tests

I do `./vendor/bin/phpunit --bootstrap tests/autoload.php tests/`

## Useful composer stuff I forget

`php composer.phar require package-name`
`php composer.phar install`