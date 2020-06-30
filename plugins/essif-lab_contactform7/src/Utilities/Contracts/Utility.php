<?php

namespace TNO\ContactForm7\Utilities\Contracts;

use TNO\ContactForm7\Utilities\Helpers\CF7Helper;

interface Utility
{
    const SLUG = 'contact-form-7';

    const TITLE = 'Contact Form 7';

    public function getAllForms();

    public function getTargetsFromForms(array $cf7Forms);

    public function insertHook(string $slug = self::SLUG, string $title = self::TITLE);

    public function insertTarget(string $name, string $title, string $hookSlug = self::SLUG);

    public function insertInput(string $slug, string $title, int $targetId);

    public function deleteHook(string $slug = self::SLUG, string $title = self::TITLE);

    public function deleteTarget(int $id, string $title, string $hookSlug = self::SLUG);

    public function deleteInput(string $slug, string $title, int $targetId);

    public function selectHook(string $slug = self::SLUG);

    public function selectTarget(array $items = [], string $hookSlug = self::SLUG);

    public function selectInput(string $targetSlug, array $items = []);

    public function addEssifLabFormTag();

    public function loadCustomScripts();

<<<<<<< HEAD
	function addActivateHook(CF7Helper $cf7Helper, string $appDir);

<<<<<<< HEAD
	function addDeactivateHook(CF7Helper $cf7Helper, string $appDir);
}
=======
    function addActivateHook(CF7Helper $cf7Helper);
    function addDeactivateHook(CF7Helper $cf7Helper);
=======
    public function addActivateHook(CF7Helper $cf7Helper);

    public function addDeactivateHook(CF7Helper $cf7Helper);
>>>>>>> 44a9692... Applying patch StyleCI
}
>>>>>>> a4f0582... fixed activation hook
