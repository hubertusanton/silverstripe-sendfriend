<?php

define('SENDFRIEND_DIR', 'SendFriend');

define('SENDFRIEND_POPUP_WIDTH', 500);
define('SENDFRIEND_POPUP_HEIGHT', 500);


Director::addRules(100, array(
    'sendfriend' => 'SendFriendController'
));


Object::add_extension('Page_Controller', 'SendFriendDecorator');
