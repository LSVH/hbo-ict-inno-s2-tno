<?php

<<<<<<< HEAD
namespace TNO\Essiflab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Application\Workflows\Constructors\CoreAbstract;
use TNO\EssifLab\Presentation\Views\FieldManager;
use TNO\EssifLab\Application\Controllers\NotAdmin;

class Admin extends CoreAbstract
{
    const SETTINGS_UPDATED = 'settings-updated';
    const STATUS = 'status';
    const MESSAGE = 'message';
    const ADMIN_NOTICE = '_admin_notice';
    private $fieldManager;
    private $notAdmin;

    public function __construct($plugin_data = [])
    {
        parent::__construct($plugin_data);

        $this->notAdmin = new NotAdmin($plugin_data);
        $this->fieldManager = FieldManager::getInstance();
    }

    public function init()
    {
        $domain = $this->get_domain();

        add_settings_section($domain, $this->get_name(), function() use ($domain) {
            echo '<p>'.__('Customize the configuration of the plugin below.', $domain).'</p>';
        }, $this->get_plugin_parent_page());

        $this->load_fields();

        $fields = $this->fieldManager->all();
        if (!empty($fields)) {
            foreach ($fields as $field) {
                add_settings_field($field->get_id(), $field->get_label(), [$field, 'render'], $this->get_plugin_parent_page(), $domain);
            }
        }
    }

    public function menu()
    {
        add_options_page(
            $this->get_name(),
            $this->get_name(),
            'administrator',
            $this->get_domain(),
            [$this, 'page']
        );
    }

    public function page()
    {
        $this->submit_form();
        ?>
        <div class="wrap">
            <form method="post" action="">
                <?php
                settings_fields($this->get_plugin_parent_page());
                do_settings_sections($this->get_plugin_parent_page());
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function submit_form() {
        if (
            !empty($_POST) &&
            is_array($_POST) &&
            array_key_exists('_wpnonce', $_POST) &&
            array_key_exists($this->get_domain(), $_POST) &&
            wp_verify_nonce($_POST['_wpnonce'], $this->get_plugin_parent_page() . '-options')
        ) {
            $options = $_POST[$this->get_domain()];

            // Sanitize submitted options
            array_walk($options, function(&$v, $k) {
                $v = apply_filters($this->get_domain() . '_save_option_' . $k, $this->fieldManager->get($k)->sanitize($v));
            });

            // Validate submitted options
            $options = array_filter($options, function($v, $k) {
                return $this->fieldManager->get($k)->validate($v);
            }, ARRAY_FILTER_USE_BOTH);

            $this->update_options($options);

            if (!empty($options) && empty($this->get_admin_notice(get_current_user_id()))) {
                $this->set_admin_notice(get_current_user_id(), '<p>' .__('Settings saved.') . '</p>');
            }

            wp_redirect(add_query_arg(self::SETTINGS_UPDATED, 'true',  wp_get_referer()));
            exit;
        }
    }

    public function admin_notice() {
        $notice = $this->get_admin_notice(get_current_user_id());
        if (!empty($notice) && is_array($notice)) {
            $status = array_key_exists(self::STATUS, $notice) ? $notice[self::STATUS] : 'success';
            $message = array_key_exists(self::MESSAGE, $notice) ? $notice[self::MESSAGE] : '';
            print '<div class="notice notice-'.$status.' is-dismissible">'.$message.'</div>';
        }
    }

    private function load_fields() {
        $domain = $this->get_domain();

        $this->fieldManager->add([
            'id' => self::FIELD_MESSAGE,
            'type' => 'textarea',
            'name' => $this->get_domain().'['.self::FIELD_MESSAGE.']',
            'label' => __('Define message to be displayed.', $domain),
            'value' => $this->get_option(self::FIELD_MESSAGE),
        ]);
    }

    private function set_admin_notice($id, $message, $status = 'success') {
        set_transient($this->get_domain() . '_' . $id . self::ADMIN_NOTICE, [
            self::MESSAGE => $message,
            self::STATUS => $status
        ], 30);
    }

    private function get_admin_notice($id) {
        $transient = get_transient( $this->get_domain() . '_' . $id . self::ADMIN_NOTICE);
        if ( isset( $_GET[self::SETTINGS_UPDATED] ) && $_GET[self::SETTINGS_UPDATED] && $transient ) {
            delete_transient( $this->get_domain() . '_' . $id . self::ADMIN_NOTICE);
        }
        return $transient;
    }
=======
namespace TNO\EssifLab\Application\Controllers;

defined('ABSPATH') or die();

use TNO\EssifLab\Application\Workflows\ManageCredentials;
use TNO\EssifLab\Application\Workflows\ManageHooks;
use TNO\EssifLab\Application\Workflows\ManageInputs;
use TNO\EssifLab\Application\Workflows\ManageIssuers;
use TNO\EssifLab\Application\Workflows\ManageSchemas;
use TNO\EssifLab\Contracts\Abstracts\Controller;
use TNO\EssifLab\Contracts\Interfaces\RegistersPostTypes;
use TNO\EssifLab\Presentation\Views\ListWithAddAndUse;
use TNO\EssifLab\Presentation\Views\ListWithCustomAdd;

class Admin extends Controller implements RegistersPostTypes {
	private $icon = 'dashicons-lock';

	private $capability = 'manage_options';

	private $types = [
		'validation-policy' => [
			'postType' => true,
			'related' => ['hook', 'credential'],
		],
		'hook' => [
			'workflow' => ManageHooks::class,
			'args' => [
				'headings' => ['context', 'target'],
			],
		],
		'credential' => [
			'postType' => true,
			'workflow' => ManageCredentials::class,
			'related' => ['input', 'issuer', 'schema'],
			'args' => [
				'headings' => ['title', 'inputs'],
			],
		],
		'input' => [
			'workflow' => ManageInputs::class,
			'args' => ['headings' => ['context', 'name']],
		],
		'issuer' => [
			'postType' => true,
			'workflow' => ManageIssuers::class,
			'args' => ['headings' => ['title', 'signature']],
		],
		'schema' => [
			'postType' => true,
			'workflow' => ManageSchemas::class,
			'args' => ['headings' => ['title', 'URL']],
		],
	];

    private $manageHooks;

    public function getActions(): array {
		$this->addAction('init', $this, 'registerPostTypes');
		$this->registerAdminMenuItem();
		$this->registerMetaBoxes();
		$this->registerWorkflowsHandler();

        $this->addAction('wp_ajax_essif_delete_hooks', $this, 'essif_ajax_delete_hooks_handler');

		return $this->actions;
	}

	private function typeHasPostType($type) {
		$attr = 'postType';

		return array_key_exists($attr, $type) && is_bool($type[$attr]) && $type[$attr] === true;
	}

	private function typesWithPostType() {
		return array_filter($this->types, function ($type) {
			return $this->typeHasPostType($type);
		});
	}

	public function registerPostTypes(): void {
		foreach ($this->typesWithPostType() as $postType => $attrs) {
			$this->addPostType($postType);
		}
	}

	private function getPluralFromSingular($str): string {
		switch (substr($str, -1)) {
			case 'y':
				$str = substr($str, 0, -1).'ies';
				break;
			case 'f':
				$str = substr($str, 0, -1).'ves';
				break;
			case 's':
				$str = $str.'es';
				break;
			default:
				$str = $str.'s';
				break;
		}

		return $str;
	}

	private function addPostType($name): void {
		$singular = ucfirst(str_replace('-', ' ', $name));
		$plural = $this->getPluralFromSingular($singular);
		register_post_type($name, [
			'labels' => [
				'name' => $plural,
				'singular_name' => $singular,
			],
			'supports' => ['title'],
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => $this->getDomain(),
		]);
	}

	private function registerAdminMenuItem(): void {
		add_action('admin_menu', function () {
			add_menu_page($this->getName(), $this->getName(), $this->capability, $this->getDomain(), null, $this->icon);
		});
	}

	private function typesWithRelations() {
		return array_filter($this->types, function ($type) {
			$attr = 'related';

			return array_key_exists($attr, $type) && is_array($type[$attr]) && count($type[$attr]);
		});
	}

	private function defaultSavePostChecks($post_id) {
		$onAutoSave = defined('DOING_AUTOSAVE') && DOING_AUTOSAVE;
		$onNoPermissions = ! current_user_can('edit_post', $post_id);

		if ($onAutoSave || $onNoPermissions) {
			return null;
		}
	}

	private function removeAllBeforeActionExecution($action, $callback) {
		// Backup all filters and remove all actions temporary
		global $wp_filter, $merged_filters;
		$backup_wp_filter = $wp_filter;
		$backup_merged_filters = $merged_filters;
		remove_all_actions($action);

		// Execute the callback for the action once
		$callback();

		// Restore filters
		$wp_filter = $backup_wp_filter;
		$merged_filters = $backup_merged_filters;
	}

	private function registerWorkflowsHandler(): void {
		foreach ($this->typesWithRelations() as $type => $attrs) {
			add_action('save_post_'.$type, function ($post_id, $post) use ($type) {
//                var_dump("_POST", $_POST);
//                die();
				$this->defaultSavePostChecks($post_id);
				$this->removeAllBeforeActionExecution('save_post_'.$type, function () use ($type, $post) {
					$this->addWorkflows($type, $post);
				});
//                var_dump("post_id", $post_id, "post", $post, "this", $this, "_POST", $_POST);
//                die();
			}, 10, 2);
//            var_dump("type", $type, "attrs", $attrs, "post_id");
//            die();
		}
	}

	private function getRelatedTypes($type) {
		$relations = array_key_exists($type, $this->types) && array_key_exists('related', $this->types[$type]) ? $this->types[$type]['related'] : [];

		$output = [];

		foreach ($relations as $relation) {
			if (array_key_exists($relation, $this->types)) {
				$output[$relation] = $this->types[$relation];
			}
		}

		return $output;
	}

	private function getBaseName($subject) {
		return $this->getDomain().'_'.$subject;
	}

	private function getCallableWorkflowFunc($typeAttr, $funcName): string {
		$func = array_key_exists('workflow', $typeAttr) ? $typeAttr['workflow'].'::'.$funcName : $funcName;

		return is_callable($func) ? $func : false;
	}

	private function addWorkflows($type, $post) {
		$relations = $this->getRelatedTypes($type);
		foreach ($relations as $k => $v) {
			$func = $this->getCallableWorkflowFunc($v, 'register');
			if ($func !== false) {
				call_user_func($func, $this, $post, $this->getBaseName($k));
			}
<<<<<<< HEAD
=======
//            var_dump("relations", $relations, "k", $k, "v", $v, "func", $func, "this", $this, "post", $post, "basename", $this->getBaseName($k), "_POST", $_POST);
//            die();
>>>>>>> 7f13ec8... working on delete
		}
	}

	private function getMetaBoxArgs($v) {
		$func = $this->getCallableWorkflowFunc($v, 'options');
		$args = array_key_exists('args', $v) ? $v['args'] : [];
		$args['options'] = $func !== false ? call_user_func($func) : [];

		return $args;
	}

	private function registerMetaBoxes(): void {
		add_action('add_meta_boxes', function () {
			foreach (array_keys($this->typesWithRelations()) as $type) {
				$relations = $this->getRelatedTypes($type);
				foreach ($relations as $k => $v) {
					$args = $this->getMetaBoxArgs($v);
					if ($this->typeHasPostType($v)) {
						$this->addListWithAddAndUseMetaBox($type, $k, $args);
					} else {
						$this->addListWithCustomAddMetaBox($type, $k, $args);
					}
				}
			}
		});
	}

	private function addListWithCustomAddMetaBox($postType, $subject, $args): void {
		$data = $this->getPluginData();
		$args = array_merge($this->getJsonPostContentAsArray(), [
			'subject' => $subject,
			'baseName' => $this->getBaseName($subject),
		], $args);
		$this->addMetaBox($postType, $subject, new ListWithCustomAdd($data, $args));
	}

	private function addListWithAddAndUseMetaBox($postType, $subject, $args): void {
		$data = $this->getPluginData();
		$args = array_merge($this->getJsonPostContentAsArray(), [
			'subject' => $subject,
			'baseName' => $this->getBaseName($subject),
		], $args);
		$this->addMetaBox($postType, $subject, new ListWithAddAndUse($data, $args));
	}

	private function getJsonPostContentAsArray($post = null): array {
		$post_content = 'post_content';
		$post = empty($post) ? get_post() : $post;
		$content = is_array($post) && array_key_exists($post_content, $post) ? $post[$post_content] : null;
		$content = empty($content) && is_object($post) && property_exists($post, $post_content) ? $post->{$post_content} : $content;
		$content = json_decode($content, true);

		return empty($content) || ! is_array($content) ? [] : $content;
	}

	private function addMetaBox($screen, $title, $component): void {
		$name = strtolower(str_replace(' ', '-', $title));
		$title = ucfirst($this->getPluralFromSingular($title));
		add_meta_box("$screen-$name", $title, [$component, 'display'], $screen, 'normal');
	}

	public function getFilters(): array {
		return $this->filters;
	}
<<<<<<< HEAD
>>>>>>> 20c58e7... Fixed merge conflict issue
=======

	public function essif_ajax_delete_hooks_handler() {
        $this->manageHooks = new ManageHooks($this->getPluginData(), get_post(52));

        // TODO: fix request
        $request = ['id' => 3];

        $this->manageHooks->delete($request);

        return "test";
    }
>>>>>>> 7f13ec8... working on delete
}