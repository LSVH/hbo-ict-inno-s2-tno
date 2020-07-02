<?php

namespace TNO\ContactForm7\Utilities;

use TNO\ContactForm7\Utilities\Contracts\BaseUtility;
use TNO\ContactForm7\Utilities\Helpers\CF7Helper;
use TNO\ContactForm7\Views\Button;
use WPCF7_TagGenerator;

class WP extends BaseUtility
{
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
	private const TARGET = "target";

	private const INPUT = "input";

	private $cf7helper;

	public function __construct(CF7Helper $cf7helper)
	{
		$this->cf7helper = $cf7helper;
	}

	const ACTION_PREFIX = "essif-lab_";

	function getAllForms()
	{
		$args = ['post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1];

		return get_posts($args);
	}

	function getTargetsFromForms(array $cf7Forms, string $post_title, string $id)
	{
		return wp_list_pluck($cf7Forms, 'post_title', 'ID');
	}

	function insertHook(string $slug = self::SLUG, string $title = self::TITLE)
	{
		$this->insert("hook", [$slug => $title]);
	}

	function insertTarget(int $id, string $title, string $hookSlug = self::SLUG)
	{
		$this->insert(self::TARGET, [$id => $title], $hookSlug);
	}

	function insertInput(string $slug, string $title, int $targetId)
	{
		$this->insert(self::INPUT, [$slug => $title], $targetId);
	}

	private function insert($suffix, ...$params)
	{
		do_action(self::ACTION_PREFIX."insert_".$suffix, ... $params);
	}

	function deleteHook(string $slug = self::SLUG, string $title = self::TITLE)
	{
		$this->delete("hook", [$slug => $title]);
	}

	function deleteTarget(int $id, string $title, string $hookSlug = self::SLUG)
	{
		$this->delete(self::TARGET, [$id => $title], $hookSlug);
	}

	function deleteInput(string $slug, string $title, int $targetId)
	{
		$this->delete(self::INPUT, [$slug => $title], $targetId);
	}

	private function delete($suffix, ...$params)
	{
		do_action(self::ACTION_PREFIX."delete_".$suffix, ... $params);
	}

	function selectHook(string $slug = self::SLUG, string $title = self::TITLE): array
	{
		return $this->select("hook", [$slug => $title]);
	}

	function selectTarget(array $items = [], string $hookSlug = self::SLUG): array
	{
		return $this->select(self::TARGET, $items, $hookSlug);
	}

	function selectInput(array $items = [], string $hookSlug = self::SLUG): array
	{
		return $this->select(self::INPUT, $items, $hookSlug);
	}

	private function select($suffix, ...$params): array
	{
		return apply_filters(self::ACTION_PREFIX."select_".$suffix, ... $params);
	}

	function addEssifLabFormTag()
	{
		add_action('wpcf7_init',
			wpcf7_add_form_tag('essif_lab', [Button::class, 'custom_essif_lab_form_tag_handler'])
		);
	}

	function loadCustomJs()
	{
		wp_enqueue_script("EssifLab_ContactForm7-CustomJs", plugin_dir_url(__FILE__).'../js/script.js', ['jquery'], "",
			false);
	}

	function loadCustomScripts()
	{
		add_action('wp_enqueue_scripts', [$this, 'loadCustomJs']);
	}

	function addActivateHook(CF7Helper $cf7Helper, string $appDir)
	{
		register_deactivation_hook($appDir, [$cf7Helper, 'addAllOnActivate']);
	}

	function addDeactivateHook(CF7Helper $cf7Helper, string $appDir)
	{
		register_deactivation_hook($appDir, [$cf7Helper, 'deleteAllOnDeactivate']);
	}
=======
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
        $tagName = 'essif_lab';
        add_action('wpcf7_init', function () use ($tagName) {
            wpcf7_add_form_tag(
                $tagName,
                [Button::class, 'custom_essif_lab_form_tag_handler'],
                ['name-attr' => true]
            );
        });
        add_action('wpcf7_admin_init', function () use ($tagName) {
            $tag_generator = WPCF7_TagGenerator::get_instance();
            $tag_generator->add($tagName, 'eSSIF-Lab', function ($contact_form, $args = '') use ($tagName) {
                $args = wp_parse_args($args, []);
                $names = array_map(function ($tag) use ($tagName) {
                    $label = $tag->name . ' (' . $tag->type . ')';

                    return '<option value="' . $tagName . ' ' . $tag->name . '">' . $label . '</option>';
                }, array_filter($contact_form->form_scan_shortcode(), function ($tag) use ($tagName) {
                    return !empty($tag->name) && $tag->type != $tagName;
                }));

                self::getTagGeneratorView($tagName, $names, $args);
            });
        });
    }

    private static function getTagGeneratorView(string $tagName, array $names, array $args)
    {
        $nameLabel = esc_html(__('Name', 'contact-form-7'));
        $nameId = esc_attr($args['content'].'-name');
        $submitLabel = esc_attr(__('Insert Tag', 'contact-form-7')); ?>
        <div class="control-box">
            <table class="form-table">
                <caption>Generate a form-tag what allows the user to load data from a wallet.</caption>
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="<?php echo $nameId; ?>"><?php echo $nameLabel ?></label>
                    </th>
                    <td>
                        <select name="tagtype" class="tg-name oneline" id="<?php echo $nameId; ?>">
                            <?php echo implode('', $names) ?>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="insert-box">
                <input title="result" type="text" name="<?php echo $tagName; ?>" class="tag code" readonly="readonly"
                       onfocus="this.select()"/>
                <div class="submitbox">
                    <input type="button" class="button button-primary insert-tag" value="<?php echo $submitLabel ?>"/>
                </div>
            </div>
        </div>
        <?php
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
>>>>>>> 44a9692... Applying patch StyleCI
}
=======
=======
    private const HOOK = "hook";
>>>>>>> 3cb823f... fixed saving of inputs (still need to fix deactivation hook)
    private const TARGET = "target";
    private const INPUT = "input";
    private $cf7helper;

    public function __construct(CF7Helper $cf7helper)
    {
        $this->cf7helper = $cf7helper;
    }

    CONST ACTION_PREFIX = "essif-lab_";

    function getAllForms()
    {
        $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
        return get_posts($args);
    }

    function getTargetsFromForms(array $cf7Forms, string $post_title, string $id)
    {
        return wp_list_pluck($cf7Forms, 'post_title', 'ID');
    }

    function insertHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->insert(self::HOOK, [$slug => $title]);
    }

    function insertTarget(int $id, string $title, string $hookSlug = self::SLUG)
    {
        $this->insert(self::TARGET, [$id => $title], $hookSlug);
    }

    function insertInput(string $slug, string $title, int $targetId)
    {
        $this->insert(self::INPUT, [$slug => $title], $targetId);
    }

    private function insert($suffix, ...$params)
    {
        do_action(self::ACTION_PREFIX . "insert_" . $suffix, ... $params);
    }

    function deleteHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->delete(self::HOOK, [$slug => $title]);
    }

    function deleteTarget(int $id, string $title, string $hookSlug = self::SLUG)
    {
        $this->delete(self::TARGET, [$id => $title], $hookSlug);
    }

    function deleteInput(string $slug, string $title, int $targetId)
    {
        $this->delete(self::INPUT, [$slug => $title], $targetId);
    }

    private function delete($suffix, ...$params)
    {
        do_action(self::ACTION_PREFIX . "delete_" . $suffix, ... $params);
    }

    function selectHook(string $slug = self::SLUG, string $title = self::TITLE) : array  {
        return $this->select(self::HOOK, [$slug => $title]);
    }

    function selectTarget(array $items = [], string $hookSlug = self::SLUG) : array  {
        return $this->select(self::TARGET, $items, $hookSlug);
    }

    function selectInput(array $items = [], string $hookSlug = self::SLUG) : array {
        return $this->select(self::INPUT, $items, $hookSlug);
    }

    private function select($suffix, ...$params) : array {
        return apply_filters(self::ACTION_PREFIX . "select_" . $suffix, ... $params);
    }

    function addEssifLabFormTag () {
        add_action('wpcf7_init',
            wpcf7_add_form_tag('essif_lab', array( Button::class, 'custom_essif_lab_form_tag_handler' ), array( 'name-attr' => true ) )
        );
    }

    function loadCustomJs () {
        wp_enqueue_script( "EssifLab_ContactForm7-CustomJs", plugin_dir_url( __FILE__ ) . '../js/script.js', array( 'jquery' ), "", false );
    }

    function loadCustomScripts() {
        add_action( 'wp_enqueue_scripts', array( $this , 'loadCustomJs' ) );
    }

    function addActivateHook(CF7Helper $cf7Helper)
    {
        register_activation_hook( PLUGIN_DIR, array( $cf7Helper, 'addAllOnActivate' ) );
    }

    function addDeactivateHook(CF7Helper $cf7Helper)
    {
        register_deactivation_hook( PLUGIN_DIR, array( $cf7Helper, 'deleteAllOnDeactivate' ) );
    }
}
>>>>>>> 521d457... Changed hook to target, adjusted View for name/id
