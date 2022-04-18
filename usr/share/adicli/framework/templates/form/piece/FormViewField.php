            $label_{FIELD_NAME} = new TLabel('{FIELD_LABEL}:', '#333333', '', 'B');
            $text_{FIELD_NAME}  = new TTextDisplay($object->{FIELD_NAME}, '#333333', '', '');
            $this->form->addFields([$label_{FIELD_NAME}],[$text_{FIELD_NAME}]);