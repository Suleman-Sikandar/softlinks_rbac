<?php

function validatePermissions($slug)
{
    return App\Traits\HasPermissionsTrait::getModulesPremissionsBySlug($slug);
}
