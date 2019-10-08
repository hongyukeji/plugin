<?php

\Hongyukeji\Plugin\Event::forge('the.bootstrap.was.loaded')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyuvip\plugin\plugin.execute.hongyuvip/fake')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyuvip\plugin\plugin.install.hongyuvip/fake')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyuvip\plugin\plugin.uninstall.hongyuvip/fake')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyuvip\plugin\plugin.upgrade.hongyuvip/fake')
    ->setCall(function($result) {
        $result->set('success');
    });
    