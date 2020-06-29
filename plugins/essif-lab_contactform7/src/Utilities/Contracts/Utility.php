<?php

namespace TNO\ContactForm7\Utilities\Contracts;

use TNO\ContactForm7\Utilities\Helpers\CF7Helper;

interface Utility
{
    const SLUG = 'contact-form-7';

    const TITLE = 'Contact Form 7';

    public function getAllForms();

    public function getTargetsFromForms(array $cf7Forms, string $post_title, string $id);

    public function insertHook(string $slug = self::SLUG, string $title = self::TITLE);

    public function insertTarget(int $id, string $title, string $hookSlug = self::SLUG);

    public function insertInput(string $slug, string $title, int $targetId);

    public function deleteHook(string $slug = self::SLUG, string $title = self::TITLE);

    public function deleteTarget(int $id, string $title, string $hookSlug = self::SLUG);

    public function deleteInput(string $slug, string $title, int $targetId);

    public function selectHook(string $slug = self::SLUG, string $title = self::TITLE);

    public function selectTarget(array $items = [], string $hookSlug = self::SLUG);

    public function selectInput(array $items = [], string $hookSlug = self::SLUG);

    public function addEssifLabFormTag();

    public function loadCustomScripts();

    public function addActivateHook(CF7Helper $cf7Helper);

    public function addDeactivateHook(CF7Helper $cf7Helper);
}
