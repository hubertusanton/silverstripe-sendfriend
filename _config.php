<?php

// directory which holds this module
define('SENDFRIEND_DIR', 'SendFriend');

// height and width of popup
define('SENDFRIEND_POPUP_WIDTH', 500);
define('SENDFRIEND_POPUP_HEIGHT', 500);

// add Rule
Director::addRules(100, array(
    'sendfriend' => 'SendFriendController'
));

// add decorator
Object::add_extension('Page_Controller', 'SendFriendDecorator');
