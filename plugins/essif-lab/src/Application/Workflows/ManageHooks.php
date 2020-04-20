<?php

namespace TNO\EssifLab\Application\Workflows;

use Exception;
use TNO\EssifLab\Contracts\Abstracts\Workflow;
use TNO\EssifLab\Services\PostUtil;

class ManageHooks extends Workflow {

	public static function options(): array {
		// TODO: load all selectable options to be displayed in the select lists.
		return [self::CONTEXT => ['hello' => 'hello', 'world' => 'world'], self::TARGET => ['foo' => 'foo', 'bar' => 'bar']];
	}

	public function add($request) {
        if(!empty($this->getJsonPostContentAsArray()["hook"])) {
            $equal = false;
            foreach ($this->getJsonPostContentAsArray()["hook"] as $post_content_hook_array) {
                if ($post_content_hook_array["context"] != $request["context"] || $post_content_hook_array["target"] != $request["target"]) {
                    //hook is not linked to this validation policy yet
                } else {
                    $equal = true;
                    //hook is already linked to this validation policy
                }
            }
            if(!$equal){
                $merged_array = array_merge($this->getJsonPostContentAsArray()["hook"], array($request));
                $merged_array[array_key_last($merged_array)]["ID"] = array_key_last($merged_array);
                $this->post->post_content = json_encode(array("hook" => $merged_array));
            }
        }
        else{
            $this->post->post_content = json_encode(array("hook" => array($request)));
        }
        wp_update_post($this->post, true);
		$data = PostUtil::getJsonPostContentAsArray();
		$hooks = array_key_exists('hook', $data) ? $data['hook'] : null;

		if ($this->requestIsEmpty($request)) {
			// TODO: add custom exception (request is empty)
			throw new Exception('request is empty');
		}

		if (!empty($hooks)) {
			if ($this->doesHookAlreadyExists($hooks, $request)) {
				// TODO: add custom exception (request already exists)
				throw new Exception('request already exists');
			}
			$request = $this->generateHookRecord($hooks, $request);
            $hooks[self::MAX_ID] = $request["ID"];
			$hooks[] = $request;
		} else {
            $request = $this->generateHookRecord($hooks, $request);
            $hooks = [];
            $hooks[self::MAX_ID] = $request["ID"];
            $hooks[] = $request;
		}

		$this->post->post_content = json_encode(array_merge($data, ['hook' => $hooks]));
		wp_update_post($this->post, true);
	}

	private function requestIsEmpty($request): bool {
		return empty(array_filter($request));
	}

	private function doesHookAlreadyExists($hooks, $request): bool {
		return count(array_filter($hooks, function ($v) use ($request) {
				return $v[self::CONTEXT] !== $request[self::CONTEXT] || $v[self::TARGET] !== $request[self::TARGET];
			})) !== count($hooks);
	}

	private function generateHookRecord($hooks, $request): array {
	    $request["ID"] = $this->generateID($hooks);
		return $request;
	}

	private function generateHookRecord($hooks, $request): array {
		return array_merge(['ID' => $this->generateID($hooks)], $request);
	}

	public function edit($request) {
		// TODO: edit a hook of a validation policy
	}

	public function delete($request) {
        $array_deleted = $this->getJsonPostContentAsArray($this->post);
        unset($array_deleted["hook"][$request["id"]]);
        $this->post->post_content = json_encode($array_deleted);
        wp_update_post($this->post, true);
        wp_redirect($_SERVER['HTTP_REFERER']);
	}

    private function getJsonPostContentAsArray($post = null): array {
        $post_content = 'post_content';
        $post = empty($post) ? get_post() : $post;
        $content = is_array($post) && array_key_exists($post_content, $post) ? $post[$post_content] : null;
        $content = empty($content) && is_object($post) && property_exists($post, $post_content) ? $post->{$post_content} : $content;
        $content = json_decode($content, true);

        return empty($content) || ! is_array($content) ? [] : $content;
    }
}
