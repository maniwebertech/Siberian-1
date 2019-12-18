<?php

namespace Weblink\Form;

use Siberian_Form_Abstract as FormAbstract;

/**
 * Class Link
 * @package Weblink\Form
 */
class Link extends FormAbstract
{
    /**
     * @throws \Zend_Form_Exception
     */
    public function init()
    {
        parent::init();

        $this
            ->setAction(__path('/weblink/application/edit-post'))
            ->setAttrib('id', 'form-edit-settings');

        self::addClass('create', $this);

        $this->addSimpleHidden('link_id');
        $this->addSimpleHidden('value_id');
        $this->addSimpleHidden('weblink_id');

        $this->addSimpleImage(
            'picto',
            p__('weblink', 'Picture'),
            p__('weblink', 'Picture'), [
            'width' => 256,
            'height' => 256,
        ]);

        $title = $this->addSimpleText('title', p__('weblink', 'Label'));
        $title->setRequired(true);

        $url = $this->addSimpleText('url', p__('weblink', 'URL'));
        $url->setRequired(true);

        $this->addSimpleCheckbox('external_browser', p__('weblink', 'Open in external browser'));

        // Commented options are not yet supported/implemented!
        $options = [
            'location' => [
                'platforms' => ['android', 'ios', 'browser'],
                'hint' => p__('weblink', 'Show location bar'),
            ],
            //'hidden' => [],
            //'beforeload' => [],
            //'clearcache' => [],
            //'clearsessioncache' => [],
            //'closebuttoncolor' => [],
            'footer' => [
                'platforms' => ['android'],
                'hint' => p__('weblink', 'Show a close button similar to iOS'),
            ],
            //'footercolor' => [
            //    'platforms' => ['android'],
            //    'hint' => p__('weblink', 'Footer color, if `footer` is enabled'),
            //],
            'hardwareback' => [
                'platforms' => ['android'],
                'hint' => p__('weblink', 'Use hardware back button to navigate backwards instead of closing the browser'),
            ],
            'hidenavigationbuttons' => [
                'platforms' => ['android', 'ios'],
                'hint' => p__('weblink', 'Remove navigation buttons on the location toolbar (if `location` enabled)'),
            ],
            'hideurlbar' => [
                'platforms' => ['android'],
                'hint' => p__('weblink', 'Remove url on the location toolbar (if `location` enabled)'),
            ],
            //'navigationbuttoncolor' => [],
            //'lefttoright' => [],
            //'zoom' => [],
            //'mediaPlaybackRequiresUserAction' => [],
            //'shouldPauseOnSuspend' => [],
            //'useWideViewPort' => [],
            //'cleardata' => [],
            //'disallowoverscroll' => [],
            'toolbar' => [
                'platforms' => ['ios'],
                'hint' => p__('weblink', 'Show the toolbar'),
            ],
            //'toolbartranslucent' => [],
            //'enableViewportScale' => [],
            //'allowInlineMediaPlayback' => [],
            //'keyboardDisplayRequiresUserAction' => [],
            //'suppressesIncrementalRendering' => [],
            //'presentationstyle' => [],
            //'transitionstyle' => [ ],
            //'toolbarposition' => [],
            //'hidespinner' => [],
        ];

        // Android
        $androidKeys = [];
        foreach ($options as $key => $option) {
            if (in_array('android', $option['platforms'], true)) {
                $optKey = "android_{$key}";
                $_opt = $this->addSimpleCheckbox($optKey, $option['hint']);
                $_opt->setBelongsTo('options[android]');
                //$_opt->setDescription($option['hint']);
                $androidKeys[] = $optKey;
            }
        }

        $this->groupElements('android_options', array_values($androidKeys), p__('weblink', 'Android options'));

        // iOS
        $iosKeys = [];
        foreach ($options as $key => $option) {
            if (in_array('ios', $option['platforms'], true)) {
                $optKey = "ios_{$key}";
                $_opt = $this->addSimpleCheckbox($optKey, $option['hint']);
                $_opt->setBelongsTo('options[ios]');
                //$_opt->setDescription($option['hint']);
                $iosKeys[] = $optKey;
            }
        }

        $this->groupElements('ios_options', array_values($iosKeys), p__('weblink', 'iOS options'));

        $submit = $this->addSubmit(p__('weblink', 'Save'), 'save');
        $submit->addClass('pull-right');
    }
}