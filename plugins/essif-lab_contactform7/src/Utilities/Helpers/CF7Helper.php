<?php

namespace TNO\ContactForm7\Utilities\Helpers;

use TNO\ContactForm7\Utilities\WP;

class CF7Helper extends WP
{
    public function __construct()
    {
        parent::__construct($this);
    }

    private function extractInputsFromForm($post)
    {
        $res = [];
        if ($post->post_content != null) {
            $post_content = $post->post_content;
            $post_content = preg_split("/\s1\s/", $post_content)[0];
            $re = '/\[(?!.*(submit|essif_lab))(?:\w+\*?\s+)?([^][]+)]/';
            preg_match_all($re, $post_content, $fields);
            $slugs = array_unique($fields[2]);
            $titles = str_replace('-', ' ', $slugs);
            $res = [$slugs, $titles];
        }

        return $res;
    }

    public function getAllTargets()
    {
        $cf7Forms = parent::getAllForms();

        return parent::getTargetsFromForms($cf7Forms, 'post_title', 'ID');
    }

    public function getAllInputs()
    {
        $cf7Forms = parent::getAllForms();

        return array_map(function ($form) {
            return [$form->ID, $form->post_title, $this->extractInputsFromForm($form)];
        }, $cf7Forms);
    }

    public function addAllOnActivate()
    {
        $hook = [
            'contact-form-7' => 'Contact Form 7',
        ];

        /**
         *  Insert the hook.
         */
        $usedHook = parent::selectHook();
        if (!in_array($hook, $usedHook)) {
            parent::insertHook();
        }

        /**
         *  Insert the targets.
         */

        // TODO: fix selectTarget to actually get the targets :)
        $targets = parent::selectTarget();
        foreach ($this->getAllTargets() as $id => $title) {
            if (!in_array($title, $targets)) {
                parent::insertTarget($id, $title);
            }
        }

        /**
         *  Insert the inputs.
         */
        // TODO: make inputs not be inserted if they already exist
        $inputs = parent::selectInput();
        foreach ($this->getAllInputs() as $input) {
            $targetId = $input[0];

            $slugs = $input[2][0];
            $titles = $input[2][1];
            $inputs = [$slugs, $titles];

            for ($i = 0; $i < count($inputs[0]); $i++) {
                parent::insertInput($inputs[0][$i], $inputs[1][$i], $targetId);
            }
        }
    }

    public function deleteAllOnDeactivate()
    {
        $hook = [
            'contact-form-7' => 'Contact Form 7',
        ];

        /**
         *  Delete the inputs.
         */
        foreach ($this->getAllInputs() as $input) {
            $target = $input[0];
            $targetHook = parent::selectInput([$target[0] => $target[1]]);

            $slugs = $input[1][0];
            $titles = $input[1][1];
            $inputs = [$slugs, $titles];

            foreach ($inputs as $inp) {
                if (in_array($inp, $targetHook)) {
                    parent::deleteInput($inp[0], $inp[1], $target[0]);
                }
            }
        }

        /**
         *  Delete the targets.
         */
        $targets = parent::selectTarget();
        if (!empty($targets)) {
            foreach ($this->getAllTargets() as $key => $target) {
                if (in_array($target, $targets)) {
                    parent::deleteTarget($key, $target);
                }
            }
        }

        /**
         *  Delete the hook.
         */
        $usedHook = parent::selectHook();
        if (in_array($hook, $usedHook)) {
            parent::deleteHook();
        }
    }
}
