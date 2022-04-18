        ${FIELD_NAME} = new {FIELD_CLASS}('{FIELD_NAME}'{FIELD_MODEL});
        ${FIELD_NAME}->exitOnEnter();
        ${FIELD_NAME}->setSize('100%');
        ${FIELD_NAME}->tabindex = -1;
        ${FIELD_NAME}->{CHANGE_ACTION}( new TAction([$this, 'onSearch'], ['static'=>'1']) );
        $tr->add( TElement::tag('td', ${FIELD_NAME}));
        $this->form->addField(${FIELD_NAME});