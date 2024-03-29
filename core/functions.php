<?php

/**
 * @param $level
 * @param $message
 * @return void
 */
function logMessage($level, $message): void
{
    $file = fopen('application.log', "a");
    fwrite($file,"[$level] $message".PHP_EOL);
    fclose($file);
}

/**
 * @param $total
 * @param $currentPage
 * @param $size
 * @return string
 */
function paginate($total, $currentPage, $size): string
{
    $page = 0;
    $markup = "";
    if ($currentPage > 1){
        $previousPage = $currentPage - 1;
        $markup .=
            "<li class=\"page-item\">
                <a class=\"page-link\" href=\"?size=$size&page=$previousPage\">Previous</a>
            </li>";
    }
    for ($i = 0; $i < $total; $i += $size){
        $page++;
        $activeClass = $currentPage == $page ? 'active' : '';
        $markup .=
            "<li class=\"page-item $activeClass\">
                <a class=\"page-link\" href=\"?size=$size&page=$page\">$page</a>
            </li>";
    }
    if ($currentPage < $page){
        $nextPage = $currentPage + 1;
        $markup .=
            "<li class=\"page-item\">
                <a class=\"page-link\" href=\"?size=$size&page=$nextPage\">Next</a>
            </li>";
    }

    return $markup;
}

/**
 * @param $string
 * @return void
 */
function esc($string): void
{
    echo htmlspecialchars($string);
}

/**
 * @return array
 */
function createUser(): array
{
    $loggedIn = array_key_exists("user", $_SESSION);
    return [
        "loggedIn" => $loggedIn,
        "name" => $loggedIn ? $_SESSION["user"]["name"] : null
    ];
}
