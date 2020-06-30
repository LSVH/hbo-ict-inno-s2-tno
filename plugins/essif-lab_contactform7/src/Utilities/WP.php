<?php

namespace TNO\ContactForm7\Utilities;

use TNO\ContactForm7\Utilities\Contracts\BaseUtility;
use TNO\ContactForm7\Utilities\Helpers\CF7Helper;
use TNO\ContactForm7\Views\Button;

class WP extends BaseUtility
{
    private const HOOK = 'hook';

    private const TARGET = 'target';

    private const INPUT = 'input';

    private $cf7helper;

    public function __construct(CF7Helper $cf7helper)
    {
        $this->cf7helper = $cf7helper;
    }

    const ACTION_PREFIX = 'essif-lab_';

    public function getAllForms()
    {
        $args = ['post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1];

        return get_posts($args);
    }

    public function getTargetsFromForms(array $cf7Forms)
    {
        return wp_list_pluck($cf7Forms, 'post_title', 'post_name');
    }

    public function insertHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->insert(self::HOOK, [$slug => $title]);
    }

    public function insertTarget(string $name, string $title, string $hookSlug = self::SLUG)
    {
        $this->insert(self::TARGET, [$name => $title], $hookSlug);
    }

    public function insertInput(string $slug, string $title, int $targetId)
    {
        $this->insert(self::INPUT, [$slug => $title], $targetId);
    }

    private function insert($suffix, ...$params)
    {
        do_action(self::ACTION_PREFIX.'insert_'.$suffix, ...$params);
    }

    public function deleteHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->delete(self::HOOK, [$slug => $title]);
    }

    public function deleteTarget(string $name, string $title)
    {
        $this->delete(self::TARGET, [$name => $title]);
    }

    public function deleteInput(string $slug, string $title, int $targetId)
    {
        $this->delete(self::INPUT, [$slug => $title], $targetId);
    }

    private function delete($suffix, ...$params)
    {
        do_action(self::ACTION_PREFIX.'delete_'.$suffix, ...$params);
    }

    public function selectHook(string $slug = self::SLUG): array
    {
        return $this->select(self::HOOK, null);
    }

    public function selectTarget(array $items = [], string $hookSlug = self::SLUG): array
    {
        return $this->select(self::TARGET, $items, $hookSlug);
    }

    public function selectInput(string $targetSlug, array $items = []): array
    {
        return $this->select(self::INPUT, $items, $targetSlug);
    }

    private function select($suffix, ...$params): array
    {
        return apply_filters(self::ACTION_PREFIX.'select_'.$suffix, ...$params);
    }

    public function addEssifLabFormTag()
    {
        $tag_name = 'essif_lab';
        add_action('wpcf7_init', function () use ($tag_name) {
            wpcf7_add_form_tag($tag_name,
                [Button::class, 'custom_essif_lab_form_tag_handler',],
                ['name-attr' => true,]);
        });
        add_action('wpcf7_admin_init', function () use ($tag_name) {
            $tag_generator = \WPCF7_TagGenerator::get_instance();
            $tag_generator->add($tag_name, 'eSSIF-Lab', function ($contact_form, $args = '') use ($tag_name) {
                $args = wp_parse_args($args, []);
                $description = __("Allow's users to load credentials from their wallet.");
                ?>
                <div class="control-box">
                    <fieldset>
                        <legend><?php echo $description ?></legend>
                    </fieldset>
                    <div class="insert-box">
                        <input title="result" type="text" name="<?php echo $tag_name; ?>" class="tag code"
                               readonly="readonly"
                               onfocus="this.select()"/>
                        <div class="submitbox">
                            <input type="button" class="button button-primary insert-tag"
                                   value="<?php echo esc_attr(__('Insert Tag', 'contact-form-7')); ?>"/>
                        </div>
                    </div>
                </div>
                <?php
            }, ['nameless' => 1]);
        });
    }

    public function loadCustomJs()
    {
        wp_enqueue_script(
            'EssifLab_ContactForm7-CustomJs',
            plugin_dir_url(__FILE__).'../js/script.js',
            ['jquery'],
            '',
            false
        );
    }

    public function loadCustomScripts()
    {
        add_action('wp_enqueue_scripts', [$this, 'loadCustomJs']);
    }

    public function addActivateHook(CF7Helper $cf7Helper)
    {
        register_activation_hook(PLUGIN_DIR, [$cf7Helper, 'addAllOnActivate']);
    }

    public function addDeactivateHook(CF7Helper $cf7Helper)
    {
        register_deactivation_hook(PLUGIN_DIR, [$cf7Helper, 'deleteAllOnDeactivate']);
    }
}
