<?php


namespace TNO\ContactForm7\Tests\Stubs;

use TNO\ContactForm7\Utilities\Contracts\BaseUtility;
use TNO\ContactForm7\Utilities\Helpers\CF7Helper;

class Utility extends BaseUtility
{
    private $history = [];

    function insertHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->insert("hook", [$slug => $title]);
    }

    function insertTarget(int $id, string $title, string $hookSlug = self::SLUG)
    {
        $this->insert("target", [$id => $title], $hookSlug);
    }

    function insertInput(string $slug, string $title, int $targetId)
    {
        $this->insert("input", [$slug => $title], $targetId);
    }

    private function insert($suffix, ...$params)
    {
        $histObj = new History("insert" . ucfirst($suffix), $params );
        array_push($this->history, $histObj);
    }

    function deleteHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->delete("hook", [$slug => $title]);
    }

    function deleteTarget(int $id, string $title, string $hookSlug = self::SLUG)
    {
        $this->delete("target", [$id => $title], $hookSlug);
    }

    function deleteInput(string $slug, string $title, int $targetId)
    {
        $this->delete("input", [$slug => $title], $targetId);
    }

    private function delete($suffix, ...$params)
    {
        $histObj = new History("delete" . ucfirst($suffix), $params );
        array_push($this->history, $histObj);
    }

    function selectHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->select("hook", [$slug => $title]);
    }

    function selectTarget(array $items = [], string $hookSlug = self::SLUG)
    {
        $returnMock = [

        ];
        $this->select("target", $items, $hookSlug, $returnMock);
    }

    function selectInput(array $items = [], string $hookSlug = self::SLUG)
    {
        $this->select("input", $items, $hookSlug);
    }

    private function select($suffix, ...$params)
    {
        $histObj = new History("select" . ucfirst($suffix), $params );
        array_push($this->history, $histObj);
    }

    function addEssifLabButton()
    {
        $histObj = new History("addEssifLabButton");
        array_push($this->history, $histObj);
    }

    function loadCustomJs()
    {
        $histObj = new History("loadCustomJs");
        array_push($this->history, $histObj);
    }

    /**
     * @param string $funcName
     * @return History[]
     */
    function getHistoryByFuncName(string $funcName): array
    {
        return array_slice(array_filter($this->history, function (History $history) use ($funcName) {
            return $history->getFuncName() === $funcName;
        }), 0);
    }
}