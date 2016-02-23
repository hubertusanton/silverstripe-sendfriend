<?php 

class SendFriendController extends Page_Controller
{
    
    const URLSegment = SENDFRIEND_DIR;

    public function getURLSegment()
    {
        return self::URLSegment;
    }

    public static $allowed_actions = array(
        'index', 'doSendFriend', 'SendFriendForm'
    );

    public function checkSentUrl($senturl)
    {
        $pos =  strpos($senturl, Director::absoluteBaseURL());
        if ($pos === false) {
            //print Director::absoluteBaseURL() . ' not in ' . $senturl;
            Director::redirect(Director::absoluteBaseURL());
        } else {
            return true;
        }
    }

    public function init()
    {
        parent::init();
        Requirements::clear();
        Requirements::insertHeadTags('<meta http-equiv="Content-language" content="' . i18n::get_locale() . '" />');
        Requirements::themedCSS('sendfriend', 'screen');
    }

    public function index()
    {
        $data = array();
        return $this->customise($data)->renderWith(array('SendFriendController_index', 'SendFriendController'));
    }

    public function SendFriendForm()
    {
        $the_url = $this->request->getVar('sendurl');
            
        $fields = new FieldList(
            new TextField('YourName', _t('SendFriend.FORM_LABEL_YOURNAME', "Your name")),
            new EmailField('YourEmail', _t('SendFriend.FORM_LABEL_YOUREMAIL', "Your e-mail address")),
            new TextField('ToName', _t('SendFriend.FORM_LABEL_TONAME', "Name receiver")),
            new EmailField('ToEmail', _t('SendFriend.FORM_LABEL_TOMAIL', "E-mail receiver")),
            new TextareaField('Remarks', _t('SendFriend.FORM_LABEL_REMARKS', "Remarks")),
            new CheckboxField('CopySelf', _t('SendFriend.FORM_LABEL_COPYSELF', "Copy to self")),
            new HiddenField('sendurl', 'sendurl', $the_url)
        );
     
        $actions = new FieldList(
            new FormAction('doSendFriend', _t('SendFriend.FORM_LABEL_SENDBUTTON', "Send"))
        );

        $validator = new RequiredFields('YourName', 'YourEmail', 'ToName', 'ToEmail');

        $Form = new Form($this, 'SendFriendForm', $fields, $actions, $validator);

        return $Form;
    }

    public function spamCheck($field)
    {

        //filter_var() sanitizes the e-mail
        //address using FILTER_SANITIZE_EMAIL
        $field = filter_var($field, FILTER_SANITIZE_EMAIL);

        //filter_var() validates the e-mail
        //address using FILTER_VALIDATE_EMAIL
        if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            Director::redirect(Director::absoluteBaseURL());
            return false;
        }
    }
    
    //send the email
    public function doSendFriend($data, $form)
    {
        $copyself = false;
        $the_url   = $data['sendurl'];
        $yourname  = trim($data['YourName']);
        $youremail = trim($data['YourEmail']);
        $toname    = trim($data['ToName']);
        $toemail   = trim($data['ToEmail']);
        $remarks   = trim($data['Remarks']);
        if (isset($data['CopySelf'])) {
            $copyself  = $data['CopySelf'];
        }

        // do a check on the sent url and email addresses
        $this->checkSentUrl($the_url);
        $this->spamCheck($toemail);
        $this->spamCheck($youremail);

        $from = $yourname . '<' . $youremail . '>';
        $to = $toname . '<' . $toemail . '>';
        
        $subject = _t('SendFriend.SUBJECT', 'Interesting article on ') . SiteConfig::current_site_config()->getTitle();

        $body  = '';
        $body .=  _t('SendFriend.DEAR', 'Dear ') . $toname . ",\n\n";
        $body .= $yourname . _t('SendFriend.TEXT', ' would like to let you know about the following page: ')."\n\n";
        $body .= $the_url . "\n\n";
        if (trim($remarks) != '') {
            $body .= _t('SendFriend.MESSAGEFROM', 'Message from ') . $yourname . ":\n " . $remarks . "\n\n";
        }

        $email = new Email($from, $to, $subject, $body);
        $email->sendPlain();

        if ($copyself) {
            $body =  _t('SendFriend.COPYOFMESSAGE', '--- copy of message to ') . $toname . " ---\n\n" . $body;
            $email = new Email($from, $from, $subject, $body);
            $email->sendPlain();
        }

        return $this->customise($data)->renderWith(array('SendFriendController_sent', 'SendFriendController'));
    }
}
