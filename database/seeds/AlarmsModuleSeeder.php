<?php

namespace Database\Seeders;

use App\Models\Core\Module;
use Illuminate\Support\Str;
use App\Models\Core\Permission;
use Illuminate\Database\Seeder;

class AlarmsModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
              'Alarms'              => ['sort_order' => 4, 'icon' => 'fas fa-exclamation-triangle fa-fw', 'url' => 'regions', 'show_menu' => 1, 'sub_items' => ['View', 'Edit', 'List', 'New', 'Delete']],
        ];

        foreach ($permissions as $name => $item) {
            $module = Module::create([
                'name' => $name,
                'icon' => $item["icon"],
                'url' => $item["url"],
                'show_menu' => $item["show_menu"],
                'sort_order' => $item["sort_order"],
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            foreach ($item['sub_items'] as $i => $sub_item) {
                Permission::create([
                    'module_id' => $module["id"],
                    'action' => $sub_item,
                    'slug' => Str::slug($module["name"] . ' ' . $sub_item, '-'),
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
    }
}
