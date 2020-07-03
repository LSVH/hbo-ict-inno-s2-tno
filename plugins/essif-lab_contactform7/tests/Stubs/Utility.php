<?php

namespace TNO\ContactForm7\Tests\Stubs;

use TNO\ContactForm7\Utilities\Contracts\BaseUtility;

class Utility extends BaseUtility
{
<<<<<<< HEAD
<<<<<<< HEAD
	private $history = [];

	/**
	 * @param string $funcName
	 *
	 * @return History[]
	 */
	function getHistoryByFuncName(string $funcName): array
	{
		return array_slice(array_filter($this->history, function (History $history) use ($funcName) {
			return $history->getFuncName() === $funcName;
		}), 0);
	}

	function getAllForms()
	{
		$histObj = new History("getAllForms");
		array_push($this->history, $histObj);
	}

	public function getTargetsFromForms(array $cf7Forms, string $post_title, string $id)
	{
		$histObj = new History("getTargetsFromForms");
		array_push($this->history, $histObj);
	}

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
		$histObj = new History("insert".ucfirst($suffix), $params);
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
		$histObj = new History("delete".ucfirst($suffix), $params);
		array_push($this->history, $histObj);
	}

	function selectHook(string $slug = self::SLUG, string $title = self::TITLE)
	{
		$this->select("hook", [$slug => $title]);
	}

	function selectTarget(array $items = [], string $hookSlug = self::SLUG)
	{
		$mockHelper = new CF7Helper();
		$target = $mockHelper->getTestTarget();
		$this->select("target", $items, $hookSlug, $target);
	}

	function selectInput(array $items = [], string $hookSlug = self::SLUG)
	{
		$mockHelper = new CF7Helper();
		$input = $mockHelper->getTestInput();
		$this->select("input", $items, $hookSlug, $input);
	}

	private function select($suffix, ...$params)
	{
		$histObj = new History("select".ucfirst($suffix), $params);
		array_push($this->history, $histObj);
	}

	function addEssifLabFormTag()
	{
		$histObj = new History("addEssifLabButton");
		array_push($this->history, $histObj);
	}

	function loadCustomScripts()
	{
		$histObj = new History("loadCustomScripts");
		array_push($this->history, $histObj);
	}

	function addActivateHook(\TNO\ContactForm7\Utilities\Helpers\CF7Helper $cf7Helper, string $appDir)
	{
		$histObj = new History("addActivateHook");
		array_push($this->history, $histObj);
	}

	function addDeactivateHook(\TNO\ContactForm7\Utilities\Helpers\CF7Helper $cf7Helper, string $appDir)
	{
		$histObj = new History("addDeactivateHook");
		array_push($this->history, $histObj);
	}
}
=======
=======
>>>>>>> 44a9692... Applying patch StyleCI
    private $history = [];

    /**
     * @param string $funcName
<<<<<<< HEAD
     * @return History[]
     */
    function getHistoryByFuncName(string $funcName): array
=======
     *
     * @return History[]
     */
    public function getHistoryByFuncName(string $funcName): array
>>>>>>> 44a9692... Applying patch StyleCI
    {
        return array_slice(array_filter($this->history, function (History $history) use ($funcName) {
            return $history->getFuncName() === $funcName;
        }), 0);
    }

<<<<<<< HEAD
    function getAllForms()
    {
        $histObj = new History("getAllForms");
=======
    public function getAllForms()
    {
        $histObj = new History('getAllForms');
>>>>>>> 44a9692... Applying patch StyleCI
        array_push($this->history, $histObj);
    }

    public function getTargetsFromForms(array $cf7Forms)
    {
<<<<<<< HEAD
        $histObj = new History("getTargetsFromForms");
        array_push($this->history, $histObj);
    }

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
=======
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
>>>>>>> 44a9692... Applying patch StyleCI
    }

    private function insert($suffix, ...$params)
    {
<<<<<<< HEAD
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
=======
        $histObj = new History('insert'.ucfirst($suffix), $params);
        array_push($this->history, $histObj);
    }

    public function deleteHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->delete('hook', [$slug => $title]);
    }

    public function deleteTarget(string $name, string $title)
    {
        $this->delete('target', [$name => $title]);
    }

    public function deleteInput(string $slug, string $title, int $targetId)
    {
        $this->delete('input', [$slug => $title], $targetId);
>>>>>>> 44a9692... Applying patch StyleCI
    }

    private function delete($suffix, ...$params)
    {
<<<<<<< HEAD
        $histObj = new History("delete" . ucfirst($suffix), $params );
        array_push($this->history, $histObj);
    }

    function selectHook(string $slug = self::SLUG, string $title = self::TITLE)
    {
        $this->select("hook", [$slug => $title]);
    }

    function selectTarget(array $items = [], string $hookSlug = self::SLUG)
    {
        $mockHelper = new CF7Helper();
        $target = $mockHelper->getTestTarget();
        $this->select("target", $items, $hookSlug, $target);
    }

    function selectInput(array $items = [], string $hookSlug = self::SLUG)
    {
        $mockHelper = new CF7Helper();
        $input = $mockHelper->getTestInput();
        $this->select("input", $items, $hookSlug, $input);
=======
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

    public function selectInput(string $targetSlug, array $items = [])
    {
        $mockHelper = new CF7Helper();
        $input = $mockHelper->getTestInput();
<<<<<<< HEAD
        $this->select('input', $items, $hookSlug, $input);
>>>>>>> 44a9692... Applying patch StyleCI
=======
        $this->select('input', $items, $targetSlug, $input);
>>>>>>> 1896a46... fixed insert inputs
    }

    private function select($suffix, ...$params)
    {
<<<<<<< HEAD
        $histObj = new History("select" . ucfirst($suffix), $params );
        array_push($this->history, $histObj);
    }

    function addEssifLabFormTag()
    {
        $histObj = new History("addEssifLabButton");
        array_push($this->history, $histObj);
    }

    function loadCustomScripts()
    {
        $histObj = new History("loadCustomScripts");
        array_push($this->history, $histObj);
    }

    function addActivateHook(\TNO\ContactForm7\Utilities\Helpers\CF7Helper $cf7Helper)
    {
        $histObj = new History("addActivateHook");
=======
        $histObj = new History('select'.ucfirst($suffix), $params);
        array_push($this->history, $histObj);
    }

    public function addEssifLabFormTag()
    {
        $histObj = new History('addEssifLabButton');
        array_push($this->history, $histObj);
    }

    public function loadCustomScripts(\TNO\ContactForm7\Applications\Contracts\Application $application)
    {
        $histObj = new History('loadCustomScripts');
        array_push($this->history, $histObj);
    }

    public function addActivateHook(\TNO\ContactForm7\Utilities\Helpers\CF7Helper $cf7Helper)
    {
        $histObj = new History('addActivateHook');
>>>>>>> 44a9692... Applying patch StyleCI
        array_push($this->history, $histObj);
    }

    public function addDeactivateHook(\TNO\ContactForm7\Utilities\Helpers\CF7Helper $cf7Helper)
    {
        $histObj = new History('addDeactivateHook');
        array_push($this->history, $histObj);
    }
}
>>>>>>> 8dceff8... fixed select hook by name
