            $label_{FIELD_NAME} = new TLabel('{FIELD_LABEL}:', '#333333', '12px', '');
            $text_{FIELD_NAME}  = new TTextDisplay($master_object->{FIELD_NAME}, '#333333', '12px', '');
            $this->form->addFields([$label_{FIELD_NAME}],[$text_{FIELD_NAME}]);