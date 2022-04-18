        // define the transformer method over image
        $column_{FIELD_NAME}->setTransformer( function($value, $object, $row) {
            return strtoupper($value);
        });