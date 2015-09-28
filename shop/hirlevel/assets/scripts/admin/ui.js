YUI().use('node', function(Y) {

    Y.on('domready', function() {


        // Buton panel functionality
        
        Y.all('.button-panel a, a.button').on('click', function(e) {
            var button = e.currentTarget;
            
            if (button.hasClass('disabled-button')) {
                e.halt();
            } else {
                var confirmAction = button.hasClass('confirm-button') || button.hasClass('delete-button');
                var submitAction = button.hasClass('submit-button') || button.hasClass('delete-button');
                var toggleAction = button.hasClass('toggle-box-button');

                if (confirmAction) {
                    var confirmText = '';
                    if (button.get('title')) {
                        confirmText = button.get('title');
                    } else {
                        confirmText = button.get('innerText');
                    }
                    confirmText += ' - biztosan végrehajta?';
                    var result = confirm(confirmText);
                    if (!result) {
                        submitAction = false;
                        toggleAction = false;
                        e.preventDefault();
                    }
                }

                if (toggleAction) {
                    var boxHref = button.get('href');
                    if (-1 != boxHref.indexOf('#')) {
                        var box = Y.one(boxHref.substr(boxHref.indexOf('#')));
                        if (box) {
                            box.toggleClass('fu-hidden');
                            e.halt();
                        }
                    }
                }
                
                
                // Speical stuff for Mail Editor buttons
                
                if (submitAction) {
                    var submitTypeNode = Y.one('input#submit-type');
                    if (submitTypeNode) {
                        if (button.hasClass('trash-button')) {
                            submitTypeNode.set('value', 'trash');
                        } else if (button.hasClass('live-send-button')) {
                            Y.one('#message-area').set('innerHTML', '<div class="message">Címlista összeállítása folyamatban. Ez percekig is eltarthat. <strong>NE LÉPJEN EL AZ OLDALRÓL ÉS NE FRISSÍTSE AZ OLDALT</strong>, amíg az magától nem firssül.</div>');
                            submitTypeNode.set('value', 'live-send');
                        } else if (button.hasClass('test-send-button')) {
                            submitTypeNode.set('value', 'test-send');
                        }
                    }
                }

                // if the button has a submit action, you need to submit the form.
                // if the button has a href attribute with a #id, try to submit a form with that id.
                // if that fails, or the button doesn't have a href attribute, try to submit the form that contains the button.
                if (submitAction) {
                    var form = null;
                    var buttonHref = button.get('href');
                    if (-1 != buttonHref.indexOf('#')) {
                        form = Y.one(buttonHref.substr(buttonHref.indexOf('#')));
                    }
                    if (null == form) {
                        form = button.ancestor('form');
                    }
                    if (null != form) {
                        form.submit();
                    }
                    e.preventDefault();
                }
            }

        });
        
        // List view changers
        
        var listNode = Y.one('.fu-items');
        if (listNode) {
            Y.one('.fu-view-changer-details a').on('click', function(e) {
                listNode.removeClass('fu-items-icon-view').addClass('fu-items-detailed-view');
            });
            Y.one('.fu-view-changer-icons a').on('click', function(e) {
                listNode.removeClass('fu-items-detailed-view').addClass('fu-items-icon-view');
            });
        }
        
        // Controls on the navigation item editor page
        
        var linkTypeNode = Y.one('#editor-form select#link-type');
        if (linkTypeNode) {
           
            function showLinkNode(id) {
                if ('article' == id) {
                    Y.one('#article-id-panel').removeClass('fu-hidden');
                } else {
                    Y.one('#article-id-panel').addClass('fu-hidden');
                }
                if ('external' == id) {
                    Y.one('#external-url-panel').removeClass('fu-hidden');
                } else {
                    Y.one('#external-url-panel').addClass('fu-hidden');
                }
            }
            
            linkTypeNode.on('change', function(e) {
                showLinkNode(linkTypeNode.get('value'));
            });
            
            showLinkNode(linkTypeNode.get('value'));
        }
        
        // Document property box tab changers
        
        if (Y.one('#document-properties')) {
            Y.all('.document-properties-tabs a').on('click', function(e) {
                var button = e.currentTarget;
                var boxHref = button.get('href');
                if (-1 != boxHref.indexOf('#')) {
                    Y.all('#document-properties .panel').addClass('fu-hidden');
                    var box = Y.one(boxHref.substr(boxHref.indexOf('#')));
                    if (box) {
                        box.removeClass('fu-hidden');
                        e.halt();
                    }
                }
            });
        }
        
        // Saveable document
        
        if (Y.one('#document-save-status')) {
            var saved = true;
            
            Y.all('input.text, select, textarea').on('change', function(e) {
                if (saved) {
                    Y.all('#editor-form .save-button').set('innerHTML', 'Mentés').set('title', 'Cikk mentése.').removeClass('disabled-button');
                    Y.one('#message-area').set('innerHTML', '');
                    
                    saved = false;
                }
                
            });
            
            Y.all('#admin-navigation a, .fubar a, .editor-header-buttoms a').on('click', onBeforeLeavePage);

            function onBeforeLeavePage(e) {
                if (!e.currentTarget.hasClass('submit-button')) {
                    var saveNode = Y.one('.save-button');
                    if (saveNode && !saveNode.hasClass('disabled-button')) {
                        if (!confirm('Legutóbbi mentés óta végzett módosításokat elveti?')) {
                            e.halt();
                        }
                    }
                }
            }
        }
        
        
        
    });
});
