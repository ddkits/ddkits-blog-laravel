<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        $this->command->info('DDKits Platform Installation!');
        $this->command->info('DDKits Platform Settings!');
        $this->call('DDKitsSettings');
        $this->command->info('DDKits Platform Roles!');
        $this->call('DDKitsRoles');
        $this->command->info('DDKits Platform Menus!');
        $this->call('DDKitsMenus');
        $this->command->info('DDKits Platform Users!');
        $this->call('DDKitsUsers');
        $this->command->info('DDKits Platform Main Admin!');
        $this->call('DDKitsAdmin');
    }
}

class DDKitsRoles extends Seeder
{
    public function run()
    {
        Model::unguard();
        $roles = [['title' => 'Guest', 'body' => 'Guest users role'],
            ['title' => 'Member', 'body' => 'Member users role'],
            ['title' => 'Admin', 'body' => 'Admin users role'],
        ];
        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
class DDKitsMenus extends Seeder
{
    public function run()
    {
        Model::unguard();
        // Adding main admin's and main's menu links
        $menus = [
        ['id' => 1, 'weight' => 1, 'description' => 'Admin page', 'menu' => 'adminmenu', 'menuparent' => null, 'name' => 'Admin', 'link' => '/admin', 'iconclass' => 'icon-screen', 'class' => 'menu'],

        ['id' => 2, 'weight' => 2, 'description' => 'Menu Admin page', 'menu' => 'adminmenu', 'menuparent' => 1, 'name' => 'Menus', 'link' => '/admin/menu', 'iconclass' => 'icon-screen', 'class' => 'menu'],

        ['id' => 3, 'weight' => 3, 'description' => 'Menu create page', 'menu' => 'adminmenu', 'menuparent' => 2, 'name' => 'New menu', 'link' => '/admin/menu/create', 'iconclass' => 'icon-screen', 'class' => 'menu'],

        ['id' => 4, 'weight' => 1, 'description' => 'Dashboard page', 'menu' => 'mainmenu', 'menuparent' => null, 'name' => 'Dashboard', 'link' => '/dashboard', 'iconclass' => 'icon-screen', 'class' => 'menu'],

        ['id' => 5, 'weight' => 2, 'description' => 'Blog page', 'menu' => 'mainmenu', 'menuparent' => null, 'name' => 'Blogs', 'link' => '/blog', 'iconclass' => 'icon-padnote', 'class' => 'menu'],

        ['id' => 6, 'weight' => 1, 'description' => 'Blog create page', 'menu' => 'mainmenu', 'menuparent' => 5, 'name' => 'New Article', 'link' => '/blog/create', 'iconclass' => 'icon-padnote', 'class' => 'menu'],

        // messages menu
        ['id' => 7, 'weight' => 3, 'description' => 'Messages', 'menu' => 'mainmenu', 'menuparent' => null, 'name' => 'Messages', 'link' => '/messages', 'iconclass' => 'fa fa-envelope-o', 'class' => 'menu'],
        ['id' => 8, 'weight' => 1, 'description' => 'New Message', 'menu' => 'mainmenu', 'menuparent' => 7, 'name' => 'New Message', 'link' => '/messages/create', 'iconclass' => '', 'class' => 'menu'],
        ['id' => 9, 'weight' => 2, 'description' => 'Inbox', 'menu' => 'mainmenu', 'menuparent' => 7, 'name' => 'Inbox', 'link' => '/messages', 'iconclass' => '', 'class' => 'menu'],
        ['id' => 10, 'weight' => 3, 'description' => 'Outbox', 'menu' => 'mainmenu', 'menuparent' => 7, 'name' => 'Outbox', 'link' => '/messages/outbox', 'iconclass' => '', 'class' => 'menu'],

        ['id' => 11, 'weight' => 4, 'description' => 'Settings', 'menu' => 'adminmenu', 'menuparent' => null, 'name' => 'Settings', 'link' => '/admin/private/settings', 'iconclass' => 'icon-settings', 'class' => 'menu'],
        ['id' => 12, 'weight' => 4, 'description' => 'Feeds', 'menu' => 'adminmenu', 'menuparent' => null, 'name' => 'Settings', 'link' => '/admin/feeds', 'iconclass' => 'icon-settings', 'class' => 'menu'],
        ['id' => 13, 'weight' => 4, 'description' => 'New Feed', 'menu' => 'adminmenu', 'menuparent' => 12, 'name' => 'Settings', 'link' => '/admin/feeds/create', 'iconclass' => 'icon-settings', 'class' => 'menu'],
        ];
        foreach ($menus as $menu) {
            DB::table('menus')->insert($menu);
        }
    }
}

// Users insert
class DDKitsUsers extends Seeder
{
    public function run()
    {
        Model::unguard();

        // Adding main admin's and main's user links
        $users = [
        ['username' => 'admin',
           'email' => 'melayyoub@outlook.com',
           'firstname' => 'Owner',
           'lastname' => 'Admin',
           'job_title' => 'Admin',
           'industry' => 'DDKits',
           'profile' => 1,
           'password' => bcrypt('123'),
           'ip' => Request::ip(),
           'role' => 0,
           'level' => 0,
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
        ];
        $profiles = [
            [
                'uid' => 1,
               'picture' => 'img/profileM.png',
           ],
        ];
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
        foreach ($profiles as $profile) {
            DB::table('profiles')->insert($profile);
        }
    }
}

// admins insert
class DDKitsAdmin extends Seeder
{
    public function run()
    {
        Model::unguard();

        // Adding main admin's and main's admin links
        $admins = [
        [
            'uid' => 1,
           'level' => 0,
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
        ];
        foreach ($admins as $admin) {
            DB::table('admins')->insert($admin);
        }
    }
}

// settings insert
class DDKitsSettings extends Seeder
{
    public function run()
    {
        Model::unguard();

        // Adding main setting's and main's configurations
        $settings = [
            [
            'id' => 1,
           'field_name' => 'sitename',
           'value' => 'WhyToPost',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
            'id' => 2,
           'field_name' => 'description',
           'value' => 'WhyToPost',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
            'id' => 3,
           'field_name' => 'main_keywords',
           'value' => 'WhyToPost',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
           'id' => 5,
           'field_name' => 'google_analytic',
           'value' => 'UA-XXXXX-X',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
           'id' => 6,
           'field_name' => 'github',
           'value' => 'https://github.com/',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
           'id' => 7,
           'field_name' => 'twitter',
           'value' => 'https://twitter.com/',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
           'id' => 8,
           'field_name' => 'facebook',
           'value' => 'https://facebook.com/',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
           'id' => 9,
           'field_name' => 'homepage_image',
           'value' => '/img/homeHeader.png',
           'type' => 'settings',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
           [
            'id' => 100,
           'field_name' => 'powered_by',
           'value' => 'DDKits.com',
           'type' => ' ',
           'created_at' => date('Y-m-d H:i:s'),
           'updated_at' => date('Y-m-d H:i:s'),
           ],
        ];
        foreach ($settings as $setting) {
            DB::table('settings')->insert($setting);
        }
    }
}
