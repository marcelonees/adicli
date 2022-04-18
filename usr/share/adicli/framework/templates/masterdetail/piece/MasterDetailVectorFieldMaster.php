        ${FIELD_NAME} = new {FIELD_CLASS}('{FIELD_NAME}'{FIELD_MODEL});
        ${FIELD_NAME}->setSize('{FIELD_SIZE}%');
        $this->form->addFields( [new TLabel('{FIELD_LABEL}')], [${FIELD_NAME}] );