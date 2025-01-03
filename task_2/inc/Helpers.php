<?php 

class Helpers {
    public static function escape_html($string): string {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    public static function load(array $fillable, bool $post = true): array {
        $load_data = $post ? $_POST : $_GET; 
        $data = []; 
     
        foreach($fillable as $field) { 
            $data[$field] = trim($load_data[$field]) ?? null; 
        }
     
        return $data; 
    }

    public static function dump(array | object $data): void {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    public static function get_errors (array $errors): string {
        $html = '<ul class="list-unstyled">';
        foreach($errors as $error_group) {
            foreach($error_group as $error) {
                $html .= "<li>$error</li>";
            }
        }
        $html .= '</ul>';
        return $html;
    }
}