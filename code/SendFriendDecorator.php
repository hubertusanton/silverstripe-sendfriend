<?php

class SendFriendDecorator extends Extension {

    // creates the Link on pages to send page-link to friend
    function SendFriendLink()
    {
        Requirements::insertHeadTags('<script type="text/javascript">var GB_ROOT_DIR = "' . Director::absoluteBaseURL() . 'SendFriend/thirdparty/greybox/";</script>');
        Requirements::javascript(SENDFRIEND_DIR . '/thirdparty/greybox/AJS.js');
        Requirements::javascript(SENDFRIEND_DIR . '/thirdparty/greybox/AJS_fx.js');
        Requirements::javascript(SENDFRIEND_DIR. '/thirdparty/greybox/gb_scripts.js');
        Requirements::css(SENDFRIEND_DIR . '/thirdparty/greybox/gb_styles.css', 'screen');
        return '<a href="' . Director::absoluteBaseURL() . 'sendfriend?sendurl=' . Director::absoluteBaseURL() . $this->owner->URLSegment . '" rel="gb_page_center[' . SENDFRIEND_POPUP_WIDTH . ', ' . SENDFRIEND_POPUP_HEIGHT . ']">' . _t('SendFriend.SENDFRIENDLINK', "Send to a friend") . '</a>';
    }


}