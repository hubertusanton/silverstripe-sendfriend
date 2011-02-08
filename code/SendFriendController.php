<?php 

class SendFriendController extends Page_Controller
{
        const URLSegment = 'sendfriend';

        public function getURLSegment() {
            return self::URLSegment;
        }

	static $allowed_actions = array(
		'index', 'doSendFriend', 'SendFriendForm'
	);


        public function checkSentUrl($senturl) {
            $pos =  strpos($senturl, Director::absoluteBaseURL());
            if ($pos === false) {
                print Director::absoluteBaseURL() . ' not in ' . $senturl;
                Director::redirect(Director::absoluteBaseURL());
            }
            else {
                return true;
            }
        }

        public function  init() {
		parent::init();
                Requirements::clear();
                Requirements::insertHeadTags('<meta http-equiv="Content-language" content="' . i18n::get_locale() . '" />');
                Requirements::themedCSS('sendfriend', 'screen');
        }

        public function index() {
            $data = array();
            return $this->customise($data)->renderWith(array('SendFriendController_index', 'SendFriendController'));
        }        


	function SendFriendForm()
	{
            $the_url = $this->request->getVar('sendurl');
            
	    $fields = new FieldSet(
			new TextField('YourName', _t('SendFriend.FORM_LABEL_YOURNAME', "Your name")),
			new EmailField('YourEmail', _t('SendFriend.FORM_LABEL_YOUREMAIL', "Your e-mail address")),
			new TextField('ToName', _t('SendFriend.FORM_LABEL_TONAME', "Name receiver")),
			new EmailField('ToEmail', _t('SendFriend.FORM_LABEL_TOMAIL', "E-mail receiver")),
                        new TextareaField('Remarks', _t('SendFriend.FORM_LABEL_REMARKS', "Remarks")),
                        new CheckboxField('CopySelf', _t('SendFriend.FORM_LABEL_COPYSELF', "Copy to self")),
                        new HiddenField('sendurl', 'sendurl', $the_url)
            );
	 
	    $actions = new FieldSet(
		new FormAction('doSendFriend', _t('SendFriend.FORM_LABEL_SENDBUTTON', "Send"))
	    );
            $validator = new RequiredFields('YourName', 'YourEmail', 'ToName', 'ToEmail');
            $Form = new Form($this, 'SendFriendForm', $fields, $actions, $validator);
            return $Form;
	}
	
	//send the email
	function doSendFriend($data, $form)
	{
            $the_url   = $data['sendurl'];
            $yourname  = $data['YourName'];
            $youremail = $data['YourEmail'];
            $toname    = $data['ToName'];
            $toemail   = $data['ToEmail'];
            $remarks   = $data['Remarks'];
            $copyself  = $data['CopySelf'];
           
            $this->checkSentUrl($the_url);

            $from = $yourname . '<' . $youremail . '>';
            $to = $toname . '<' . $toemail . '>';
            
            $subject = 'Interesting article on ' . SiteConfig::current_site_config()->getTitle();

            $body  = '';
            $body .= "Dear " . $toname . ",\n\n";
            $body .= $yourname . " would like to let you know about the following page: \n\n";
            $body .= $the_url . "\n\n";
            if (trim($remarks) != '')
                $body .= "Message from " . $yourname . ":\n " . $remarks . "\n\n";

            $email = new Email($from, $to, $subject, $body);
            $email->sendPlain();

            if ($copyself) {
                $body = "--- copy of message to " . $toname . " ---\n\n" . $body;
                $email = new Email($from, $from, $subject, $body);
                $email->sendPlain();
            }

            return $this->customise($data)->renderWith(array('SendFriendController_sent', 'SendFriendController'));
            
	}

}
