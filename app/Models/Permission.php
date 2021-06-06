<?php


namespace App\Models;


use Mindscms\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $guarded = [];

    public function parent()
    {
        return $this->hasOne(Permission::class, 'id', 'parent');
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent', 'id');
    }

    public function appearedChildren()
    {
        return $this->hasMany(Permission::class, 'parent', 'id')->where('appear', 1);
    }

    public static function tree($level = 1)
    {
        /*
         * Join array elements with a string
         * @param string $glue [optional] Defaults to an empty string. This is not the preferred usage of implode as glue would be the second parameter and thus, the bad prototype would be used.
         * @param array $pieces The array of strings to implode.
         * @return string a string containing a string representation of all the array elements in the same order, with the glue string between each element.
         */
        /*
         * Fill an array with values
         * @param int $start_index The first index of the returned array. Supports non-negative indexes only.
         * @param int $num Number of elements to insert
         * @param mixed $value Value to use for filling
         * @return array the filled array
         */
        // echo implode(".",array_fill(0,1,"children")); output: children
        // echo implode(".",array_fill(0,2,"children")); output: children.children
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereParent(0)
            ->whereAppear(1)
            ->whereSidebarLink(1)
            ->orderBy('ordering', 'asc')
            ->get();
    }

    public function assign_children()
    {
        return $this->hasMany(Permission::class, 'parent_original', 'id');
    }

    public static function assign_permissions($level = 1)
    {
        return static::with(implode('.', array_fill(0, $level, 'assign_children')))
            ->whereParentOriginal(0)
            ->whereAppear(1)
            ->orderBy('ordering', 'asc')
            ->get();
    }
}
