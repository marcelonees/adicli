        $detail_{FIELD_NAME} = new {FIELD_CLASS}('detail_{FIELD_NAME}'{FIELD_MODEL});
        $this->form->addFields( [new TLabel('{FIELD_LABEL}')], [$detail_{FIELD_NAME}] );
        $this->detail_list->addColumn( new TDataGridColumn('{FIELD_NAME}', '{FIELD_LABEL}', 'left', {FIELD_SIZE}) );
            $grid_data['{FIELD_NAME}'] = $data->detail_{FIELD_NAME};
            $data->detail_{FIELD_NAME} = '';
        $data->detail_{FIELD_NAME} = $param['{FIELD_NAME}'];
                $item->{FIELD_NAME} = $list_item['{FIELD_NAME}'];
                    $detail->{FIELD_NAME}  = $param['{ACTIVE_RECORD_DETAIL}_list_{FIELD_NAME}'][$key];
        $data->detail_{FIELD_NAME} = '';