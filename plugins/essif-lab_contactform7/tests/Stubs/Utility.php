<?php

namespace TNO\ContactForm7\Tests\Stubs;

use TNO\ContactForm7\Utilities\Contracts\BaseUtility;

class Utility extends BaseUtility
{
    private $history = [];

    /**
     * @param string $funcName
     *
     * @return History[]
     */
    public function getHistoryByFuncName(string $funcName): array
    {
        return array_slice(array_filter($this->history, function (History $history) use ($funcName) {
            return $history->getFuncName() === $funcName;
        }), 0);
    }

    public function getAllForms()
    {
        $histObj = new History('getAllForms');
        array_push($this->history, $histObj);
    }

    public function getTargetsFromForms(array $cf7Forms, string $post_title, string $id)
    {
        $histObj = new History('getTargetsFromForms');
        array_push($this->history, $histObj);
    }

    public function insertHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->insert('hook', [$slug => $title]);
    }

    public function insertTarget(string $name, string $title, string $hookSlug = self::SLUG)
    {
        $this->insert('target', [$name => $title], $hookSlug);
    }

    public function insertInput(string $slug, string $title, int $targetId)
    {
        $this->insert('input', [$slug => $title], $targetId);
    }

    private function insert($suffix, ...$params)
    {
        $histObj = new History('insert'.ucfirst($suffix), $params);
        array_push($this->history, $histObj);
    }

    public function deleteHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->delete('hook', [$slug => $title]);
    }

    public function deleteTarget(int $id, string $title, string $hookSlug = self::SLUG)
    {
        $this->delete('target', [$id => $title], $hookSlug);
    }

    public function deleteInput(string $slug, string $title, int $targetId)
    {
        $this->delete('input', [$slug => $title], $targetId);
    }

    private function delete($suffix, ...$params)
    {
        $histObj = new History('delete'.ucfirst($suffix), $params);
        array_push($this->history, $histObj);
    }

    public function selectHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->select('hook', [$slug => $title]);
    }

    public function selectTarget(array $items = [], string $hookSlug = self::SLUG)
    {
        $mockHelper = new CF7Helper();
        $target = $mockHelper->getTestTarget();
        $this->select('target', $items, $hookSlug, $target);
    }

    public function selectInput(array $items = [], string $hookSlug = self::SLUG)
    {
        $mockHelper = new CF7Helper();
        $input = $mockHelper->getTestInput();
        $this->select('input', $items, $hookSlug, $input);
    }

    private function select($suffix, ...$params)
    {
        $histObj = new History('select'.ucfirst($suffix), $params);
        array_push($this->history, $histObj);
    }

    public function addEssifLabFormTag()
    {
        $histObj = new History('addEssifLabButton');
        array_push($this->history, $histObj);
    }

    public function loadCustomScripts()
    {
        $histObj = new History('loadCustomScripts');
        array_push($this->history, $histObj);
    }

    public function addActivateHook(\TNO\ContactForm7\Utilities\Helpers\CF7Helper $cf7Helper)
    {
        $histObj = new History('addActivateHook');
        array_push($this->history, $histObj);
    }

    public function addDeactivateHook(\TNO\ContactForm7\Utilities\Helpers\CF7Helper $cf7Helper)
    {
        $histObj = new History('addDeactivateHook');
        array_push($this->history, $histObj);
    }
}
