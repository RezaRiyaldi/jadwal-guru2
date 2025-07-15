<?php 

function addActions($rules, $actions)
{
    if (in_array(auth()->user()->role, $rules)) {
        return [$actions];
    }

    return [];
}
