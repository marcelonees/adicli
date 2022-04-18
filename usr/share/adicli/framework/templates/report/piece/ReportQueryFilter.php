        ${FIELD_NAME}      = new TEntry('{FIELD_NAME}');
        $this->form->addFields( [new TLabel('{FIELD_LABEL}', 'red')],     [${FIELD_NAME}] );
        ${FIELD_NAME}->addValidation('{FIELD_LABEL}', new TRequiredValidator);
            $filters['{FIELD_NAME}'] = $data->{FIELD_NAME};