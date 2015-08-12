<?php
$I = new AcceptanceTester($scenario);

$I->am('Website Visitor');
$I->wantTo('ensure that frontpage loads without errors');
$I->amGoingTo('go to the homepage');
$I->lookForwardTo('logging in');
