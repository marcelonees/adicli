        // define the transformer method over image
        $column_{FIELD_NAME}->setTransformer( function($value, $object, $row) {
            if (file_exists($value)) {
                return new TImage($value);
            }
        });