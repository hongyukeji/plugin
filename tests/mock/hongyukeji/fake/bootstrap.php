<?php

\Hongyukeji\Plugin\Event::forge('the.bootstrap.was.loaded')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyukeji\plugin\plugin.execute.hongyukeji/fake')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyukeji\plugin\plugin.install.hongyukeji/fake')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyukeji\plugin\plugin.uninstall.hongyukeji/fake')
    ->setCall(function($result) {
        $result->set('success');
    });

\Hongyukeji\Plugin\Event::forge('hongyukeji\plugin\plugin.upgrade.hongyukeji/fake')
    ->setCall(function($result) {
        $result->set('success');
    });
    