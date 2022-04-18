        // define the transformer method over image
        $column_{FIELD_NAME}->setTransformer( function($value, $object, $row) {
            $bar = new TProgressBar;
            $bar->setMask('<b>{value}</b>%');
            $bar->setValue($value);
            
            if ($value == 100) {
                $bar->setClass('success');
            }
            else if ($value >= 75) {
                $bar->setClass('info');
            }
            else if ($value >= 50) {
                $bar->setClass('warning');
            }
            else {
                $bar->setClass('danger');
            }
            return $bar;
        });