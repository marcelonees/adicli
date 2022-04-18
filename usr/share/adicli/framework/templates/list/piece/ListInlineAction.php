        ${FIELD_NAME}_edit = new TDataGridAction(array($this, 'onInlineEdit'));
        ${FIELD_NAME}_edit->setField('{PRIMARY_KEY}');
        $column_{FIELD_NAME}->setEditAction(${FIELD_NAME}_edit);
        