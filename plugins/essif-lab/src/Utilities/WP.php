<?php

namespace TNO\EssifLab\Utilities;

use Firebase\JWT\JWT;
use TNO\EssifLab\Applications\Contracts\Application;
use TNO\EssifLab\Constants;
use TNO\EssifLab\Models\Contracts\Model;
use TNO\EssifLab\Utilities\Contracts\BaseUtility;
use WP_REST_Response;
use WP_REST_Server;

class WP extends BaseUtility
{
    const ADD_ACTION = 'add_action';

    const ADD_FILTER = 'add_filter';

    const DO_ACTION = 'do_action';

    const APPLY_FILTERS = 'apply_filters';

    const REMOVE_ALL_ACTIONS_AND_EXEC = 'remove_all_actions_and_exec';

    const ADD_NAV_ITEM = 'add_menu_page';

    const ADD_SUBMENU_PAGE = 'add_submenu_page';

    const ADD_META_BOX = 'add_meta_box';

    const POST_ID = Constants::TYPE_INSTANCE_IDENTIFIER_ATTR;

    const POST_NAME = 'post_name';

    const POST_TITLE = 'post_title';

    const POST_CONTENT = 'post_content';

    const REGISTER_SETTING = 'register_setting';

    const ADD_SETTINGS_SECTION = 'add_settings_section';

    const ADD_SETTINGS_FIELD = 'add_settings_field';

    const GET_OPTION = 'get_option';

    const ADD_SETTINGS_ERROR = 'add_settings_error';

    const SETTINGS_ERRORS = 'settings_errors';

    const SETTINGS_FIELDS = 'settings_fields';

    const DO_SETTINGS_SECTIONS = 'do_settings_sections';

    const SUBMIT_BUTTON = 'submit_button';

    const LOCALIZE_SCRIPT = 'wp_localize_script';

    const JWT_SUB = 'credential-verify-request';

    const JWT_AUD = 'ssi-service-provider';

    const JWT_ISS = 'iss';

    const JWT_KEY = 'shared_secret';

    private const ALG = 'HS256';

    private const JWT_V_1 = 'jwt/v1';

    private const METHODS = 'methods';

    private const CALLBACK = 'callback';

    private const POST_TYPE = 'post_type';

    private const POST_STATUS = 'post_status';

    protected $functions = [
        self::ADD_ACTION                  => [self::class, 'addAction'],
        self::ADD_FILTER                  => [self::class, 'addFilter'],
        self::DO_ACTION                   => [self::class, 'doAction'],
        self::APPLY_FILTERS               => [self::class, 'applyFilter'],
        self::REMOVE_ALL_ACTIONS_AND_EXEC => [self::class, 'removeAllActionsAndExecute'],
        self::ADD_META_BOX                => [self::class, 'addMetaBox'],
        self::ADD_NAV_ITEM                => [self::class, 'addAdminNav'],
        self::ADD_SUBMENU_PAGE            => [self::class, 'addSubmenuPage'],
        self::REGISTER_SETTING            => [self::class, 'registerSetting'],
        self::ADD_SETTINGS_SECTION        => [self::class, 'addSettingsSection'],
        self::ADD_SETTINGS_FIELD          => [self::class, 'addSettingsField'],
        self::GET_OPTION                  => [self::class, 'getOption'],
        self::ADD_SETTINGS_ERROR          => [self::class, 'addSettingsError'],
        self::SETTINGS_ERRORS             => [self::class, 'settingsErrors'],
        self::SETTINGS_FIELDS             => [self::class, 'settingsFields'],
        self::DO_SETTINGS_SECTIONS        => [self::class, 'doSettingsSections'],
        self::SUBMIT_BUTTON               => [self::class, 'submitButton'],
        self::LOCALIZE_SCRIPT             => [self::class, 'localizeScript'],
    ];

    public static function addAction(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): void
    {
        add_action($hook, $callback, $priority, $accepted_args);
    }

    public static function addFilter(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): void
    {
        add_filter($hook, $callback, $priority, $accepted_args);
    }

    public static function doAction(string $tag, ...$params): void
    {
        do_action($tag, ...$params);
    }

    public static function applyFilter(string $tag, $value, ...$params)
    {
        return apply_filters($tag, $value, ...$params);
    }

    public static function removeAllActionsAndExecute(string $tag, callable $callback)
    {
        // Backup all filters and remove all actions temporary
        global $wp_filter, $merged_filters;
        $backup_wp_filter = $wp_filter;
        $backup_merged_filters = $merged_filters;
        remove_all_actions($tag);

        // Execute the callback for the action once
        $callback();

        // Restore filters
        $wp_filter = $backup_wp_filter;
        $merged_filters = $backup_merged_filters;
    }

    public static function addMetaBox(string $id, string $title, callable $callback, string $screen): void
    {
        add_meta_box($id, $title, $callback, $screen, 'normal');
    }

    public static function addAdminNav(string $title, string $capability, string $slug, string $icon): void
    {
        add_menu_page($title, $title, $capability, $slug, null, $icon);
    }

    public static function addSubmenuPage(
        string $parent_slug,
        string $page_title,
        string $menu_title,
        string $capability,
        string $menu_slug,
        $function = null,
        int $position = null
    ): void
    {
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function, $position);
    }

    public static function createModelType(string $postType, array $args = []): void
    {
        register_post_type($postType, $args);
    }

    public static function createModel(Model $model): int
    {
        $result = wp_insert_post(self::mapModelToPost($model), true);
        if (!is_int($result)) {
            throw $result;
        }

        return $result;
    }

    public static function updateModel(array $post): bool
    {
        $result = wp_update_post($post, true);
        if (!is_int($result)) {
            throw $result;
        }

        return $result;
    }

    public static function deleteModel(int $postId): bool
    {
        return !empty(wp_delete_post($postId, true));
    }

    public static function getModel(int $id): ?Model
    {
        return self::modelFactory(get_post($id)->to_array());
    }

    public static function getModels(array $args = []): array
    {
        return array_map(function ($post) {
            return self::modelFactory($post->to_array());
        }, get_posts(array_merge([
            'numberposts'                   => -1,
            Constants::MODEL_TYPE_INDICATOR => 'any',
        ], $args)));
    }

    public static function getCurrentModel(): ?Model
    {
        global $post;

        if (empty($post) && array_key_exists('post', $_GET)) {
            $post = get_post($_GET['post']);
        }

        if (empty($post) && array_key_exists(Constants::MODEL_TYPE_INDICATOR, $_GET)) {
            return self::modelFactory([Constants::MODEL_TYPE_INDICATOR => $_GET[Constants::MODEL_TYPE_INDICATOR]]);
        }

        if (empty($post)) {
            return null;
        }

        return self::modelFactory($post->to_array());
    }

    private static function modelFactory(array $postAttrs): ?Model
    {
        $type = array_key_exists(
            Constants::MODEL_TYPE_INDICATOR,
            $postAttrs
        ) ? $postAttrs[Constants::MODEL_TYPE_INDICATOR] : '';

        $className = implode('', array_map('ucfirst', explode(' ', str_replace('-', ' ', $type))));
        $FQN = Constants::TYPE_NAMESPACE . '\\' . $className;

        if (empty($type) || !class_exists($FQN) || !in_array(Model::class, class_implements($FQN))) {
            return null;
        }

        $modelAttrs = self::mapPostAttrsToModelAttrs($postAttrs);

        return new $FQN($modelAttrs);
    }

    private static function mapPostAttrsToModelAttrs(array $attrs): array
    {
        $content = array_key_exists(self::POST_CONTENT, $attrs) ? $attrs[self::POST_CONTENT] : '';
        $modelAttrs = self::mapPostContentToModelAttributes($content);

        if (array_key_exists(self::POST_ID, $attrs)) {
            $modelAttrs[Constants::TYPE_INSTANCE_IDENTIFIER_ATTR] = $attrs[self::POST_ID];
        }
        if (array_key_exists(self::POST_NAME, $attrs)) {
            $modelAttrs[Constants::TYPE_INSTANCE_SLUG_ATTR] = $attrs[self::POST_NAME];
        }
        if (array_key_exists(self::POST_TITLE, $attrs)) {
            $modelAttrs[Constants::TYPE_INSTANCE_TITLE_ATTR] = $attrs[self::POST_TITLE];
        }

        return $modelAttrs;
    }

    private static function mapPostContentToModelAttributes(string $content): array
    {
        $json = json_decode($content);
        $isValidJson = json_last_error() === JSON_ERROR_NONE;
        $isAssocArray = is_array($json) && array_keys($json) !== range(0, count($json) - 1);
        if ($isValidJson && $isAssocArray) {
            return $json;
        }

        return !empty($content) ? [
            Constants::TYPE_INSTANCE_DESCRIPTION_ATTR => $content,
        ] : [];
    }

    private static function mapModelToPost(Model $model): array
    {
        $modelAttrs = $model->getAttributes();

        $postAttrs = [
            self::POST_TYPE   => $model->getTypeName(),
            self::POST_STATUS => 'publish',
        ];
        if (array_key_exists(Constants::TYPE_INSTANCE_IDENTIFIER_ATTR, $modelAttrs)) {
            $postAttrs[self::POST_ID] = $modelAttrs[Constants::TYPE_INSTANCE_IDENTIFIER_ATTR];
        }
        if (array_key_exists(Constants::TYPE_INSTANCE_SLUG_ATTR, $modelAttrs)) {
            $postAttrs[self::POST_NAME] = $modelAttrs[Constants::TYPE_INSTANCE_SLUG_ATTR];
        }
        if (array_key_exists(Constants::TYPE_INSTANCE_TITLE_ATTR, $modelAttrs)) {
            $postAttrs[self::POST_TITLE] = $modelAttrs[Constants::TYPE_INSTANCE_TITLE_ATTR];
        }
        if (array_key_exists(Constants::TYPE_INSTANCE_DESCRIPTION_ATTR, $modelAttrs)) {
            $postAttrs[self::POST_CONTENT] = $modelAttrs[Constants::TYPE_INSTANCE_DESCRIPTION_ATTR];
        }

        return $postAttrs;
    }

    public static function createModelMeta(int $postId, string $key, $value): bool
    {
        return add_post_meta($postId, $key, $value, false);
    }

    public static function updateModelMeta(int $postId, string $key, $value): bool
    {
        return update_post_meta($postId, $key, $value);
    }

    public static function deleteModelMeta(int $postId, string $key, $value = ''): bool
    {
        return delete_post_meta($postId, $key, $value);
    }

    public static function getModelMeta(int $postId, string $key): array
    {
        $meta = get_post_meta($postId, $key, false);

        return is_array($meta) ? $meta : [];
    }

    public static function getEditModelLink(int $postId): string
    {
        return get_edit_post_link($postId);
    }

    public static function getCreateModelLink(string $postType): string
    {
        return add_query_arg([self::POST_TYPE => $postType], admin_url('post-new.php'));
    }

    public static function registerSetting(string $option_group, string $option_name, array $args = [])
    {
        register_setting($option_group, $option_name, $args);
    }

    public static function addSettingsSection(string $id, string $title, $callback, string $page)
    {
        add_settings_section($id, $title, $callback, $page);
    }

    public static function addSettingsField(
        string $id,
        string $title,
        $callback,
        string $page,
        string $section = 'default',
        array $args = []
    )
    {
        add_settings_field($id, $title, $callback, $page, $section, $args);
    }

    public static function getOption(string $option, $default = false)
    {
        return get_option($option, $default);
    }

    public static function addSettingsError(string $setting, string $code, string $message, string $type = 'error')
    {
        add_settings_error($setting, $code, $message, $type);
    }

    public static function settingsError(string $setting = '', bool $sanitize = false, bool $hide_on_update = false)
    {
        settings_errors($setting, $sanitize, $hide_on_update);
    }

    public static function settingsFields(string $option_group)
    {
        settings_fields($option_group);
    }

    public static function doSettingsSections(string $page)
    {
        do_settings_sections($page);
    }

    public static function submitButton(
        string $text = null,
        string $type = 'primary',
        string $name = 'submit',
        bool $wrap = true,
        $other_attributes = null
    )
    {
        submit_button($text, $type, $name, $wrap, $other_attributes);
    }

    public static function localizeScript(string $handle, string $object_name, array $data)
    {
        wp_localize_script($handle, $object_name, $data);
    }

    public static function registerGenerateJWTRoute(Application $application): bool
    {
        return register_rest_route(
            self::JWT_V_1,
            'callbackurl=(?P<callbackurl>.+)&inputslug=(?P<inputslug>.+)',
            [
                self::METHODS  => WP_REST_Server::READABLE,
                self::CALLBACK => function ($request) use ($application) { self::generateJWTToken($request, $application); },
            ]
        );
    }

    public static function generateJWTToken($request, Application $application)
    {
        $options = self::getOption($application->getNamespace());
        $options = is_array($options) ? $options : [];
        $issuer = array_key_exists(self::JWT_ISS, $options) ? $options[self::JWT_ISS] : '';
        $key = array_key_exists(self::JWT_KEY, $options) ? $options[self::JWT_KEY] : '';

        $payload = [
            'type'        => self::getCredentialType($request['inputslug']),
            'callbackUrl' => $request['callbackurl'],
            'sub'         => self::JWT_SUB,
            'iat'         => time(),
            'aud'         => self::JWT_AUD,
            'iss'         => $issuer,
            'jti'         => self::applyFilter(Constants::TRIGGER_PRE . 'generate_jti', []),
        ];

        $jwt = JWT::encode($payload, $key, self::ALG);

        var_dump($jwt);
        $response = new WP_REST_Response($jwt);
        $response->set_status(200);

        return $response;
    }

    private static function getCredentialType(string $slug)
    {
        $input = self::getModels(['name' => $slug])[0];

        $relationIds = self::getModelMeta(
            $input->getAttributes()[Constants::TYPE_INSTANCE_IDENTIFIER_ATTR],
            'essif-lab_relationcredential'
        );
        $credential = self::getModel($relationIds[0]);

        $credentialTypesIds = self::getModelMeta(
            $credential->getAttributes()[Constants::TYPE_INSTANCE_IDENTIFIER_ATTR],
            'essif-lab_relationcredential-type'
        );
        $credentialType = self::getModel($credentialTypesIds[0]);

        $credentialTypeArray = json_decode(
            $credentialType->getAttributes()[Constants::TYPE_INSTANCE_DESCRIPTION_ATTR],
            true
        );

        return $credentialTypeArray[Constants::FIELD_TYPE_CREDENTIAL_TYPE];
    }

    public static function registerReceiveJWTRoute(): bool
    {
        return register_rest_route(
            self::JWT_V_1,
            'page=(?P<page>.+)&inputslug=(?P<slug>.+)&jwt=(?P<jwtToken>.+)',
            [
                self::METHODS  => WP_REST_Server::READABLE,
                self::CALLBACK => [self::class, 'receiveJWTToken'],
            ]
        );
    }

    public static function receiveJWTToken($request)
    {
        $page = $request['page'];
        $slug = $request['slug'];
        $jwtToken = $request['jwtToken'];

        sleep(1); //Sleep to ensure the timestamp in the JWT has actually passed before decoding

        $jwt = JWT::decode($jwtToken, self::getSharedSecret(), [self::ALG]);
        $data = $jwt->data;

        [$credential, $inputs] = self::getInputs($slug);

        if (count($inputs) == 1) {
            $slugs = $slug . '=' . reset($data);
        } else {
            $inputTitles = array_map(function ($i) {
                return $i->getAttributes()[Constants::TYPE_INSTANCE_TITLE_ATTR];
            }, $inputs);

            $slugArray = [];
            foreach ($data as $slug => $value) {
                $re = preg_quote('/' . $slug . '/');
                $title = preg_grep($re, $inputTitles);
                $slugArray[] = reset($title) . '=' . $value;
            }

            $slugs = implode('&', $slugArray);
        }

        $description = $credential->getAttributes()[Constants::TYPE_INSTANCE_DESCRIPTION_ATTR];

        $re = "/(?<=\"immutable\":)[^},]+/";
        preg_match($re, $description, $immutableArray);

        header('Location: ' . $page . '?' . $slugs . '&immutable=' . $immutableArray[0]);
        die();
    }

    public static function registerReturnInputsRoute(): bool
    {
        return register_rest_route(
            self::JWT_V_1,
            'inputs/inputslug=(?P<inputslug>.+)',
            [
                self::METHODS  => WP_REST_Server::READABLE,
                self::CALLBACK => [self::class, 'returnInputs'],
            ]
        );
    }

    public static function returnInputs($request)
    {
        $inputslug = $request['inputslug'];

        [$credential, $inputs] = self::getInputs($inputslug);

        return array_map(function ($i) {
            return $i->getAttributes()[Constants::TYPE_INSTANCE_TITLE_ATTR];
        }, $inputs);
    }

    private static function getInputs($slug): array
    {
        $input = self::getModels(['name' => $slug])[0];

        $credentialRelationIds = self::getModelMeta(
            $input->getAttributes()[Constants::TYPE_INSTANCE_IDENTIFIER_ATTR],
            'essif-lab_relationcredential'
        );
        $credential = self::getModel($credentialRelationIds[0]);

        $inputRelationIds = self::getModelMeta(
            $credential->getAttributes()[Constants::TYPE_INSTANCE_IDENTIFIER_ATTR],
            'essif-lab_relationinput'
        );

        $inputs = self::getModels([self::POST_TYPE => 'input', 'post__in' => $inputRelationIds]);

        return [$credential, $inputs];
    }
}
