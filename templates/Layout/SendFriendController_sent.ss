
                        <h3><% _t('SendFriend.THANKYOU', 'Thank you') %></h3>

                        <p><% _t('SendFriend.SENT_TEXT', 'Your Message has been sent') %></p>

                        <p><a href="#" onclick="<% if JSMode = Jquery %>parent.parent.$.modal.close();<% else %>parent.parent.GB_hide();<% end_if %>"><% _t('SendFriend.BACKTO_PAGE', 'Go back to the page.') %></a></p>

