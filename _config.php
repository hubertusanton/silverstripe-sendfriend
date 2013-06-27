<?php

define('SENDFRIEND_DIR',basename(dirname(__FILE__)));

// height and width of popup
define('SENDFRIEND_POPUP_WIDTH', 500);
define('SENDFRIEND_POPUP_HEIGHT', 500);

// add Rule
Director::addRules(100, array(
    'sendfriend' => 'SendFriendController'
));

// add decorator
Object::add_extension('Page_Controller', 'SendFriendDecorator');
//

// if you would like to use a jquery functionality, uncomment this in your config
// SendFriendDecorator::$JSMode = 'Jquery';
