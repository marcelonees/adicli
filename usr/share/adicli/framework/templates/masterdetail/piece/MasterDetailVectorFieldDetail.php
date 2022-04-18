        ${FIELD_NAME} = new {FIELD_CLASS}('list_{FIELD_NAME}[]'{FIELD_MODEL});
        ${FIELD_NAME}->setSize('{FIELD_SIZE}%');
        $this->fieldlist->addField( '<b>{FIELD_LABEL}</b>', ${FIELD_NAME});
        $this->form->addField(${FIELD_NAME});
                        $detail->{FIELD_NAME} = $param['list_{FIELD_NAME}'][$row];
                        $detail->list_{FIELD_NAME} = $item->{FIELD_NAME};