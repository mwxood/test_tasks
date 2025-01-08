<?php
// Take a look at the `hm_get_ninja_form_email_fields` function below and try to debug the problems.
//
// For some reason the output is not in the expected format. We need it to be in the format below and it should not include any empty values:
//
// array(4) {
//   [0]=>
//   array(3) {
//     ["type"]=>
//     string(4) "text"
//     ["value"]=>
//     string(4) "John"
//     ["id"]=>
//     int(28)
//   }
//   [1]=>
//   array(3) {
//     ["type"]=>
//     string(4) "text"
//     ["value"]=>
//     string(3) "Doe"
//     ["id"]=>
//     int(29)
//   }
//   [2]=>
//   array(3) {
//     ["type"]=>
//     string(5) "email"
//     ["value"]=>
//     string(18) "nobody@example.com"
//     ["id"]=>
//     int(30)
//   }
//   [3]=>
//   array(3) {
//     ["type"]=>
//     string(8) "repeater"
//     ["value"]=>
//     array(2) {
//       ["role_0"]=>
//       string(27) "Junior Full-Stack Developer"
//       ["start_date_0"]=>
//       string(10) "01/01/2016"
//       ["end_date_0"]=>
//       string(10) "07/18/2019"
//       ["responsibility_0"]=>
//       string(23) "Custom WordPress Themes"
//       ["role_1"]=>
//       string(27) "Senior Full-Stack Developer"
//       ["start_date_1"]=>
//       string(10) "07/20/2019"
//       ["end_date_1"]=>
//       string(10) "10/01/2022"
//       ["responsibility_1"]=>
//       string(24) "Custom WordPress Plugins"
//     }
//     ["id"]=>
//     int(31)
//   }
// }
 
$raw_json_data = '{"fields":{"28":{"type":"text","value":"John","id":28},"29":{"type":"text","value":"Doe","id":29},"30":{"type":"email","value":"nobody@example.com","id":30},"31":{"type":"repeater","value":{"31.1_0":{"key":"role","value":"Junior Full-Stack Developer","id":"31.1_0"},"31.2_0":{"key":"start_date","value":"01/01/2016","id":"31.2_0"},"31.3_0":{"key":"end_date","value":"07/18/2019","id":"31.3_0"},"31.4_0":{"key":"responsibility","value":"Custom WordPress Themes","id":"31.4_0"},"31.1_1":{"key":"role","value":"Senior Full-Stack Developer","id":"31.1_1"},"31.2_1":{"key":"start_date","value":"07/20/2019","id":"31.2_1"},"31.3_1":{"key":"end_date","value":"10/01/2022","id":"31.3_1"},"31.4_1":{"key":"responsibility","value":"Custom WordPress Plugins","id":"31.4_1"}},"id":31}}}';
 
$decoded_json = json_decode( $raw_json_data, true );
$response     = hm_get_ninja_form_email_fields( $decoded_json['fields'] );

// the function accepts a parameter
// $fields - an array of fields as an associative array containing information about the form's fields

function hm_get_ninja_form_email_fields(array $fields): array {
    $result = []; // result array

    foreach ($fields as $field) { // iterate through all fields
        if (empty($field['value'])) { // if the field value is empty
            continue; // skip it
        }

        if ($field['type'] === 'repeater') { // if the field type is repeater
            $repeater_values = []; // create an array for the repeater field values
            foreach ($field['value'] as $sub_field) { // iterate through all sub-fields of the repeater field
                $index = explode('_', $sub_field['id'])[1]; // extract the index of the sub-field
                $key = $sub_field['key'] . '_' . $index; // create the key for the sub-field
                $repeater_values[$key] = $sub_field['value']; // add the sub-field value to the repeater values array
            }
            $field['value'] = $repeater_values; // assign the repeater field values to the field
        }

        $result[] = [ // add the formatted field to the result
            'type' => $field['type'],
            'value' => $field['value'],
            'id' => $field['id'],
        ];
    }

    return $result; // return the result
}

 
echo "<pre><strong>Dumping on line " . __LINE__ . ' in ' . basename(__FILE__) . ':</strong></br>';
print_r($response);
echo "</pre>";
exit;