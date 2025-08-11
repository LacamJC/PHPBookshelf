<?php

namespace App\widgets\Form;

class Checkbox
{
    public static function show($label, )
    {
        echo <<<HTML
         <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Default checkbox
                </label>
            </div>
        HTML;
    }
}
