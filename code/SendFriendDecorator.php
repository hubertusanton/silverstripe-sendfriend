<?php

class SendFriendDecorator extends Extension {

	public static $JSMode = 'AWS';

	// creates the Link on pages to send page-link to friend
	function SendFriendLink() {

		if (self::$JSMode == 'Jquery') {
			Requirements::javascript(SENDFRIEND_DIR . '/thirdparty/jquery.simplemodal/jquery.simplemodal.1.4.2.min.js');
			Requirements::javascript(SENDFRIEND_DIR . '/thirdparty/jquery.simplemodal/popup.js');
			Requirements::css(SENDFRIEND_DIR . '/thirdparty/jquery.simplemodal/css/basic.css', 'screen');
			return '<a href="' . Director::absoluteBaseURL() . 'sendfriend?sendurl=' . Director::absoluteBaseURL() . $this->owner->URLSegment . '" id="tellafriend">' . _t('SendFriend.SENDFRIENDLINK', "Send to a friend") . '</a>';
		} else {
			//default mode
			Requirements::insertHeadTags('<script type="text/javascript">var GB_ROOT_DIR = "' . Director::absoluteBaseURL() . SENDFRIEND_DIR . '/thirdparty/greybox/";</script>');
			Requirements::javascript(SENDFRIEND_DIR . '/thirdparty/greybox/AJS.js');
			Requirements::javascript(SENDFRIEND_DIR . '/thirdparty/greybox/AJS_fx.js');
			Requirements::javascript(SENDFRIEND_DIR . '/thirdparty/greybox/gb_scripts.js');
			Requirements::css(SENDFRIEND_DIR . '/thirdparty/greybox/gb_styles.css', 'screen');
			return '<a href="' . Director::absoluteBaseURL() . 'sendfriend?sendurl=' . Director::absoluteBaseURL() . $this->owner->URLSegment . '" rel="gb_page_center[' . SENDFRIEND_POPUP_WIDTH . ', ' . SENDFRIEND_POPUP_HEIGHT . ']">' . _t('SendFriend.SENDFRIENDLINK', "Send to a friend") . '</a>';
		}
		
	}
	
	public function JSMode() {
		return self::$JSMode;
	}

}