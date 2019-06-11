<?php

if (!function_exists('generate_code')) {
    /**
     * 随机获取指定位数的数字
     *
     * @param int $length
     * @return int
     * @throws
     */
    function generate_code($length = 4)
    {
        return random_int(pow(10, ($length - 1)), pow(10, $length) - 1);
    }
}
