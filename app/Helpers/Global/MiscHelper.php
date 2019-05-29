<?php

if (! function_exists('camelcase_to_word')) {
    /**
     * @param $str
     *
     * @return string
     */
    function camelcase_to_word($str)
    {
        return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
    }
}

if (! function_exists('camelcase_to_hyphen_words')) {
    /**
     * @param $str
     *
     * @return string
     */
    function camelcase_to_hyphen_words($str)
    {
        return implode('-', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
    }
}

if (! function_exists('get_model_alias')) {
    /**
     * @param $str
     *
     * @return string
     */
    function get_model_alias($str)
    {
        return strtolower(camelcase_to_hyphen_words($str));
    }
}
