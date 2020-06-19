<?php

namespace TNO\ContactForm7\Utilities\Contracts;

use TNO\ContactForm7\Views\Button;

interface Utility {
    CONST SLUG = "contact-form-7";
    CONST TITLE = "Contact Form 7";

    function getAllForms();
    function getTargetsFromForms(array $cf7Forms, string $post_title, string $id);

	function insertHook(string $slug = self::SLUG, string $title = self::TITLE);
    function insertTarget(int $id, string $title, string $hookSlug = self::SLUG);
    function insertInput(string $slug, string $title, int $targetId);

    function deleteHook(string $slug = self::SLUG, string $title = self::TITLE);
    function deleteTarget(int $id, string $title, string $hookSlug = self::SLUG);
    function deleteInput(string $slug, string $title, int $targetId);

    function selectHook(string $slug = self::SLUG, string $title = self::TITLE);
    function selectTarget(array $items = [], string $hookSlug = self::SLUG);
    function selectInput(array $items = [], string $hookSlug = self::SLUG);

    function addEssifLabButton();
    function addFormTag(Button $button);
    function loadCustomScripts();

    function addActivateHook();
    function addDeactivateHook();
}